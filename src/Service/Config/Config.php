<?php
namespace Matryoshka\Scafolding\Service\Config;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Hydrator\HydratorAwareInterface;
use Matryoshka\Scafolding\Service\Hydrator\HydratorAwareTrait;
use Matryoshka\Scafolding\Service\ObjectAwareTrait;
use Matryoshka\Scafolding\Service\ObjectInterface;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\ValueGenerator;
use Zend\Filter\StringToLower;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Config
 */
class Config implements ConfigInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    use HydratorAwareTrait;
    use ObjectAwareTrait;

    /**
     * @inheritdoc
     */
    public function generate($path)
    {
        $this->generateModelConfig($path);
        // TODO: Implement generate() method.
    }


    public function generateModelConfig($path)
    {
        $fileConfigName = $this->buildFileNameConfig($this->getObjectService());
        /*
        // TODO check if already exist
        $oldApplicationConfig = include $path . "/config/application.config.php";

        if (!in_array($this->getModuleName(), $oldApplicationConfig['modules'])) {
            $oldApplicationConfig['modules'][] = $this->getModuleName();
        }

        copy($path . "/config/application.config.php",
            $path . sprintf("/config/application.config.%s", (new \DateTime())->getTimestamp())
        );


        $file->setFilename("application.config.php");

        $docBlock = new DocBlockGenerator();
        $docBlock->setShortDescription('Test'); // TODO refactor
        $docBlock->setLongDescription('Test test'); // TODO refactor

        $file->setDocBlock($docBlock);

        $valueGenerator = new ValueGenerator();
        $valueGenerator->setValue($oldApplicationConfig);
        $valueGenerator->setArrayDepth(0);
        */
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


        return file_put_contents($path . DIRECTORY_SEPARATOR .  $fileConfigName, $file->generate());


    }

    /**
     * @param ObjectInterface $objectService
     * @return string
     */
    protected function buildFileNameConfig(ObjectInterface $objectService)
    {
        $StringToLowerFilter = new StringToLower();
        return sprintf(
            ConfigInterface::TEMPLATE_FILE_NAME_CONFIG,
            $StringToLowerFilter->filter($objectService->getName())
        );
    }

} 