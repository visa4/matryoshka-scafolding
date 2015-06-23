<?php
namespace Matryoshka\Scafolding\Service\Model;

use Matryoshka\Scafolding\Exception\RuntimeException;
use Matryoshka\Scafolding\Filter\UcFirst;
use Matryoshka\Scafolding\Service\Model\Adapter\AdapterAwareTrait;
use Zend\Console\Prompt\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Model
 */
class Model implements
    ModelInterface,
    ServiceLocatorAwareInterface
{
    use AdapterAwareTrait;
    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @inheritdoc
     */
    public function existModelFolder($path)
    {
        return is_dir($path . "/" . $this->getName());
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $filter = new UcFirst();
        $this->name = $filter->filter($name);
        return $this;
    }

    /**
     * @return $this
     */
    public function settingFromPrompt()
    {
        $message = 'Choose model adapter type?';
        $options = ['Mongo'];
        $typeAdapter = Select::prompt($message, $options, false, true);

        $this->chooseAdapterFromPrompt($typeAdapter);

        $this->getAdapter()->settingFromPrompt();

        return $this;
    }

    protected function chooseAdapterFromPrompt($input)
    {
        switch ($input) {
            case '0':
                if (!$this->getServiceLocator()->has('Model\Adapter\MongoAdapter')) {
                    throw new RuntimeException(
                        sprintf(
                            'Service %s must be config in service locator',
                            'Matryoshka\Scafolding\Service\Model\Adapter\Connection\MongoConnectionAdapter'
                        )
                    );
                }
                $this->setAdapter($this->getServiceLocator()->get('Model\Adapter\MongoAdapter'));
                break;
            // TODO other adapter
            default:
                throw new RuntimeException(sprintf('Invalid type adapter input given: %', $input));
        }
        return $this;
    }
}

