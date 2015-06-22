<?php
namespace Matryoshka\Scafolding\Service\Config;

use Matryoshka\Scafolding\Service\Hydrator\HydratorAwareTrait;
use Matryoshka\Scafolding\Service\Model\ModelAwareTrait;
use Matryoshka\Scafolding\Service\Model\ModelNameAwareTrait;
use Matryoshka\Scafolding\Service\ObjectAwareTrait;
use Matryoshka\Scafolding\Service\ObjectInterface;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Matryoshka\Scafolding\Code\Generator\ValueGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Filter\StringToLower;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Config
 */
class Config implements ConfigInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    use HydratorAwareTrait;
    use ObjectAwareTrait;
    use ModelNameAwareTrait;
    use ModelAwareTrait;

    /**
     * @var string
     */
    protected $rootApplicationFolder;

    /**
     * @var string
     */
    protected $configModuleFolder;

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $this->checkMatryoshkaAbstractFactory();
        $this->generateModuleClass();
        $this->generateModelConfig();
    }


    public function generateModelConfig()
    {
        $fileConfigName = Config::buildFileNameConfig($this->getObjectService());

        $config = [
            'matryoshka-objects' => [
                $this->getObjectService()->getFullQualifiedClassName() => [
                    'type' => $this->getObjectService()->getFullQualifiedClassName(),
                    'active_record_criteria' => 'Solo\Model\Criteria\ActiveRecordCriteria', // FIXME da model service
                ]
            ],
            'matryoshka-models' => [
                $this->getObjectService()->getName() => [
                    'datagateway'        =>  $this->getModelService()->getAdapter()->getServiceName(),
                    'resultset'          => 'Matryoshka\Model\Wrapper\Mongo\ResultSet\ServiceLocatorStrategyHydratingResultSet', // FIXME da model service
                    'paginator_criteria' => 'Matryoshka\Model\Wrapper\Mongo\Criteria\FindAllCriteria', // FIXME da model service
                    'hydrator'           => $this->getHydratorService()->getFullQualifiedClassName(),
                    'object'             => $this->getObjectService()->getFullQualifiedClassName(),
                ]
            ]
        ];

        $valueGenerator = new ValueGenerator();
        $valueGenerator->setValue($config);
        $valueGenerator->setArrayDepth(0);

        $file = new FileGenerator();
        $file->setBody("return " . $valueGenerator->generate() . ";");

        $path = $this->getConfigModuleFolder() . DIRECTORY_SEPARATOR .  $fileConfigName;

        file_put_contents($path, $file->generate());

        $this->getModelService()->getAdapter()->generate($path);
        if ($this->getModelService()->getAdapter()->getAdapterConnection()) {
            $this->getModelService()->getAdapter()->getAdapterConnection()->generate($this->getRootApplicationFolder());
        }

        return true;
    }

    /**
     * @return int
     */
    public function generateModuleClass()
    {
        // TODO check if already exist
        $class = new ClassGenerator();
        $class->setName('Module');
        $class->setNamespaceName($this->getModuleName());

        // TODO docBlock
        $getConfigMethod = new MethodGenerator();
        $getConfigMethod->setName('getConfig');
        $getConfigMethod->setBody("return include __DIR__ . '/config/module.config.php';");

        $getAutoloaderConfigMethod = new MethodGenerator();
        $getAutoloaderConfigMethod->setName('getAutoloaderConfig');
        $getAutoloaderConfigMethod->setBody("return ['Zend\Loader\StandardAutoloader' => [
    'namespaces' => [
        __NAMESPACE__ => __DIR__ . '/src/',
        ],
    ],
];"
        );


        $class->addMethods([$getConfigMethod, $getAutoloaderConfigMethod]);

        $file = new FileGenerator();
        $file->setClass($class);

        $path = $this->getConfigModuleFolder() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "Module.php";
        return file_put_contents($path, $file->generate());
    }

    public function generateApplicationConfig()
    {
        // TODO check if already exist
        $oldApplicationConfig = include $this->getRootApplicationFolder() . "/config/application.config.php";

        if (!in_array($this->getModuleName(), $oldApplicationConfig['modules'])) {
            $oldApplicationConfig['modules'][] = $this->getModuleName();
        }

        copy($this->getRootApplicationFolder() . "/config/application.config.php",
            $this->getRootApplicationFolder() . sprintf("/config/application.config.%s", (new \DateTime())->getTimestamp())
        );

        $file = new FileGenerator();
        $file->setFilename("application.config.php");

        $docBlock = new DocBlockGenerator();
        $docBlock->setShortDescription('Test'); // TODO refactor
        $docBlock->setLongDescription('Test test'); // TODO refactor

        $file->setDocBlock($docBlock);

        $valueGenerator = new ValueGenerator();
        $valueGenerator->setValue($oldApplicationConfig);
        $valueGenerator->setArrayDepth(0);

        $file->setBody("return " . $valueGenerator->generate() . ";");

        $path = $this->getRootApplicationFolder() . "/config/" . $file->getFilename();
        return file_put_contents($path, $file->generate());
    }

    /**
     * @return $this
     * @throws \Matryoshka\Scafolding\Code\Generator\Exception\RuntimeException
     */
    public function checkMatryoshkaAbstractFactory()
    {
        $config = $this->getServiceLocator()->get('Config');
        $factories = [
            'service_manager' => [
                'abstract_factories' => [

                ]
            ]
        ];
        if ($config['service_manager'] && ($config['service_manager']['abstract_factories'])) {
            $factory = $config['service_manager']['abstract_factories'];

            if(!in_array('Matryoshka\Model\Wrapper\Mongo\Service\MongoDbAbstractServiceFactory', $factory)) {
                $factories['service_manager']['abstract_factories'][] =
                    'Matryoshka\Model\Wrapper\Mongo\Service\MongoDbAbstractServiceFactory';
            }
            if(!in_array('Matryoshka\Model\Wrapper\Mongo\Service\MongoCollectionAbstractServiceFactory', $factory)) {
                $factories['service_manager']['abstract_factories'][] =
                    'Matryoshka\Model\Wrapper\Mongo\Service\MongoCollectionAbstractServiceFactory';
            }
            if(!in_array('Matryoshka\Service\Api\Service\HttpApiAbstractServiceFactory', $factory)) {
                $factories['service_manager']['abstract_factories'][] =
                    'Matryoshka\Service\Api\Service\HttpApiAbstractServiceFactory';
            }
            if(!in_array('Matryoshka\Model\Wrapper\Rest\Service\RestClientAbstractServiceFactory', $factory)) {
                $factories['service_manager']['abstract_factories'][] =
                    'Matryoshka\Model\Wrapper\Rest\Service\RestClientAbstractServiceFactory';
            }
        }

        if (!empty($factories)) {
            $pathApplicationFolder = $this->getRootApplicationFolder() . "/config/autoload/global.php";
            $oldGlobalConfig = include $pathApplicationFolder;

            copy($pathApplicationFolder,
                 $this->getRootApplicationFolder() . sprintf("/config/autoload/global.%s", (new \DateTime())->getTimestamp())
            );

            $newGlobalConfig = ArrayUtils::merge($oldGlobalConfig, $factories);


            $file = new FileGenerator();
            $file->setFilename("global.php");

            $docBlock = new DocBlockGenerator();
            $docBlock->setShortDescription('Test'); // TODO refactor
            $docBlock->setLongDescription('Test test'); // TODO refactor

            $file->setDocBlock($docBlock);

            $valueGenerator = new ValueGenerator();
            $valueGenerator->setValue($newGlobalConfig);
            $valueGenerator->setArrayDepth(0);

            $file->setBody("return " . $valueGenerator->generate() . ";");

            $path = $this->getRootApplicationFolder() . "/config/autoload/" . $file->getFilename();
            return file_put_contents($path, $file->generate());
        }

        return $this;
    }

    /**
     * @param ObjectInterface $objectService
     * @return string
     */
    static public function buildFileNameConfig(ObjectInterface $objectService)
    {
        $StringToLowerFilter = new StringToLower();
        return sprintf(
            ConfigInterface::TEMPLATE_FILE_NAME_CONFIG,
            $StringToLowerFilter->filter($objectService->getName())
        );
    }

    /**
     * @return string
     */
    public function getRootApplicationFolder()
    {
        return $this->rootApplicationFolder;
    }

    /**
     * @param string $rootApplicationFolder
     * @return $this
     */
    public function setRootApplicationFolder($rootApplicationFolder)
    {
        $this->rootApplicationFolder = $rootApplicationFolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfigModuleFolder()
    {
        return $this->configModuleFolder;
    }

    /**
     * @param string $configModuleFolder
     * @return $this
     */
    public function setConfigModuleFolder($configModuleFolder)
    {
        $this->configModuleFolder = $configModuleFolder;
        return $this;
    }
} 