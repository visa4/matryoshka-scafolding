<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;

use Matryoshka\Scafolding\Exception\RuntimeException;
use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\ConfigExistingTrait;
use Matryoshka\Scafolding\Service\Model\Adapter\Connection\AdapterConnectionAwareTrait;
use Matryoshka\Scafolding\Service\Model\Adapter\Connection\MongoConnectionAdapter;
use Zend\Console\Prompt\Char;
use Zend\Console\Prompt\Line;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class MongoAdapter
 */
class MongoAdapter implements AdapterInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    use AdapterConnectionAwareTrait;
    use ServiceNameTrait;
    use AdapterTrait;
    use ConfigExistingTrait;

    const CONFIG_KEY = 'mongocollection';
    const CONFIG_KEY_DATABASE = 'database';
    const CONFIG_KEY_COLLECTION = 'collection';

    /**
     * @var string
     */
    protected $collection;

    /**
     * @return string
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param string $collection
     * @return $this
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAdapterConnection()
    {
        if (!$this->adapterConnection) {
            if (!$this->getServiceLocator()->has('Model\Adapter\Connection\MongoConnectionAdapter')) {
                throw new RuntimeException(
                    sprintf(
                        'Service %s must be config in service locator',
                        'Matryoshka\Scafolding\Service\Model\Adapter\Connection\MongoConnectionAdapter'
                    )
                );
            }
            $this->adapterConnection = $this->getServiceLocator()->get('Model\Adapter\Connection\MongoConnectionAdapter');
        }
        return $this->adapterConnection;
    }

    /**
     * @return $this
     */
    public function settingFromPrompt()
    {
        $message = 'Do you want to use a connection already existing? [y,n]';
        $connectionExist = Char::prompt($message, 'yn', true, false, false);
        if ($connectionExist == 'y') {
            $nameService = Line::prompt('Enter name service:', true, 100);
            // TODO check if exist service
            $this->getAdapterConnection()->setConfigExisting(true);
            $this->getAdapterConnection()->setServiceName($nameService);
        } else {

            $this->getAdapterConnection()->settingFromPrompt();
        }

        $message = 'Do you want to use a data gateway already existing? [y,n]';
        $dataGatewayExist = Char::prompt($message, 'yn', true, false, false);

        $serviceName = Line::prompt('Enter name service:', false, 100);
        $this->setConfigExisting(true);
        $this->setServiceName($serviceName);

        if ($dataGatewayExist == 'n') {
            $this->setConfigExisting(false);
            $collection = Line::prompt('Enter name mongo collection:', false, 100);
            $this->setCollection($collection);
        }
    }

    /**
     * @inheritdoc
     */
    public function generate($path)
    {
        if ($this->isConfigExisting()) {
            return $this;
        }

        $config[self::CONFIG_KEY][ $this->getServiceName()][self::CONFIG_KEY_DATABASE] =
            $this->getAdapterConnection()->getServiceName();

        $config[self::CONFIG_KEY][ $this->getServiceName()][self::CONFIG_KEY_COLLECTION] =
            $this->getCollection();
    }


} 