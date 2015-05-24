<?php
/**
 * Class: AdapeterConnectionInterface.php
 */

namespace Matryoshka\Scafolding\Service\Model\Adapter\Connection;

/**
 * Trait AdapterConnectionAwareTrait
 */
trait AdapterConnectionAwareTrait
{
    /**
     * @var AdapterConnectionInterface
     */
    protected $adapterConnection;

    /**
     * @return AdapterConnectionInterface
     */
    public function getAdapterConnection()
    {
        return $this->adapterConnection;
    }

    /**
     * @param AdapterConnectionInterface $adapterConnection
     * @return $this
     */
    public function setAdapterConnection(AdapterConnectionInterface $adapterConnection)
    {
        $this->adapterConnection = $adapterConnection;
        return $this;
    }
} 