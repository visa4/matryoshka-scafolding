<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;

use Matryoshka\Scafolding\Exception\RuntimeException;
use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Model\Adapter\Connection\AdapterConnectionAwareTrait;
use Matryoshka\Scafolding\Service\Model\Adapter\Connection\MongoConnectionAdapter;
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
        $serviceName = Line::prompt('Enter name service:', false, 100);
        $this->setServiceName($serviceName);

        $collection = Line::prompt('Enter name mongo collection:', false, 100);
        $this->setCollection($collection);
    }

    /**
     * @inheritdoc
     */
    public function generate($path)
    {

        $this->getAdapterConnection()->generate($path);

    }


} 