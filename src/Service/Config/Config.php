<?php
namespace Matryoshka\Scafolding\Service\Config;

use Matryoshka\Scafolding\Service\Hydrator\HydratorAwareTrait;
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

    /**
     * @var string
     */
    protected $rootApplicationFolder;

    /**
     * @var string
     */
    protected $rootModuleFolder;

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
                'datagateway'        => 'Mongo\DataGateway\Wallet', // FIXME da model service
                'resultset'          => 'Matryoshka\Model\Wrapper\Mongo\ResultSet\ServiceLocatorStrategyHydratingResultSet', // FIXME da model service
                'paginator_criteria' => 'Matryoshka\Model\Wrapper\Mongo\Criteria\FindAllCriteria', // FIXME da model service
                'hydrator'           => $this->getHydratorService()->getFullQualifiedClassName(),
                'object'             => $this->getObjectService()->getFullQualifiedClassName(),
            ]
        ];

        $valueGenerator = new ValueGenerator();
        $valueGenerator->setValue($config);
        $valueGenerator->setArrayDepth(0);

        $file = new FileGenerator();
        $file->setBody("return " . $valueGenerator->generate() . ";");

        $path = $this->getRootModuleFolder() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR .  $fileConfigName;
        return file_put_contents($path, $file->generate());
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

        $path = $this->getRootApplicationFolder() . DIRECTORY_SEPARATOR . "/Module.php";
        return file_put_contents($path, $file->generate());
    }

    public function generateApplicationConfig()
    {
        // TODO check if already exist
        $oldApplicationConfig = include $this->getRootApplicationFolder() . "/config/application.config.php";

        if (!in_array($this->getModuleName(), $oldApplicationConfig['modules'])) {
            $oldApplicationConfig['modules'][] = $this->getModuleName();
        }

        copy($this->getRootPath() . "/config/application.config.php",
            $this->getRootPath() . sprintf("/config/application.config.%s", (new \DateTime())->getTimestamp())
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


        return file_put_contents($this->getRootPath() . "/config/" . $file->getFilename(), $file->generate());
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
            $oldGlobalConfig = include $path . "/config/autoload/global.php";

            copy($path . "/config/autoload/global.php",
                 $path . sprintf("/config/autoload/global.%s", (new \DateTime())->getTimestamp())
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
    public function getRootModuleFolder()
    {
        return $this->rootModuleFolder;
    }

    /**
     * @param string $rootModuleFolder
     * @return $this
     */
    public function setRootModuleFolder($rootModuleFolder)
    {
        $this->rootModuleFolder = $rootModuleFolder;
        return $this;
    }
} 