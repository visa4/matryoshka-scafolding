<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;

use Matryoshka\Scafolding\Code\Generator\ValueGenerator;
use Matryoshka\Scafolding\Exception\RuntimeException;
use Matryoshka\Scafolding\Service\ConfigExistingTrait;
use Matryoshka\Scafolding\Service\Model\Adapter\Connection\AdapterConnectionAwareTrait;
use Zend\Code\Generator\FileGenerator;
use Zend\Console\Prompt\Char;
use Zend\Console\Prompt\Line;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Stdlib\ArrayUtils;

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

    const DEFAULT_ACTIVE_RECORD_CRITERIA = 'Matryoshka\Model\Wrapper\Mongo\Criteria\ActiveRecord\ActiveRecordCriteria';
    const DEFAULT_PAGINATOR_CRITERIA = 'Matryoshka\Model\Wrapper\Mongo\Criteria\FindAllCriteria';
    const DEFAULT_RESULT_SET = 'Matryoshka\Model\Wrapper\Mongo\ResultSet\HydratingResultSet';

    protected $matryoshkaDefaultAbstractFactory = [
        'Matryoshka\Model\Wrapper\Mongo\Service\MongoDbAbstractServiceFactory',
        'Matryoshka\Model\Wrapper\Mongo\Service\MongoCollectionAbstractServiceFactory'
    ];

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

        if (is_file($path)) {
            $oldGlobalConfig = include $path;
            $newGlobalConfig = ArrayUtils::merge($oldGlobalConfig, $config);
            $file = new FileGenerator();

            $valueGenerator = new ValueGenerator();
            $valueGenerator->setValue($newGlobalConfig);
            $valueGenerator->setArrayDepth(0);

            $file->setBody("return " . $valueGenerator->generate() . ";");

            return file_put_contents($path, $file->generate());
        }

        throw new RuntimeException(sprintf('Wrong file config for module adapter %s', $path));
    }

    /**
     * @return ActiveRecordCriteria
     */
    public function getActiveRecordCriteria()
    {
        if (!$this->activeRecordCriteria) {
            $this->activeRecordCriteria = self::DEFAULT_ACTIVE_RECORD_CRITERIA;
        }
        return $this->activeRecordCriteria;
    }

    /**
     * @return string
     */
    public function getResultSet()
    {
        if (!$this->resultSet) {
            $this->resultSet = self::DEFAULT_RESULT_SET;
        }
        return $this->resultSet;
    }

    /**
     * @return string
     */
    public function getPaginatorCriteria()
    {
        if (!$this->paginatorCriteria) {
            $this->paginatorCriteria = self::DEFAULT_PAGINATOR_CRITERIA;
        }
        return $this->paginatorCriteria;
    }

    /**
     * @return array
     */
    public function getMatryoshkaDefaultAbstractFactory()
    {
        return $this->matryoshkaDefaultAbstractFactory;
    }
} 