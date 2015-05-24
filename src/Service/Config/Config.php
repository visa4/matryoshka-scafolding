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
        $fileConfigName = Config::buildFileNameConfig($this->getObjectService());

        $this->checkMatryoshkaAbstractFactory();

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

    public function checkMatryoshkaAbstractFactory()
    {
        $config = $this->getServiceLocator()->get('Config');
        if ($config['service_manager'] && ($config['service_manager']['abstract_factories'])) {

        }

        // add factory
        var_dump(__METHOD__);
        var_dump($config);
        die();
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

} 