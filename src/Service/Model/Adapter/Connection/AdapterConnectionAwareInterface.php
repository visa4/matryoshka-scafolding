<?php
/**
 * Class: AdapeterConnectionInterface.php
 */

namespace Matryoshka\Scafolding\Service\Model\Adapter\Connection;

/**
 * Interface AdapterConnectionAwareInterface
 */
interface AdapterConnectionAwareInterface
{
    /**
     * @return AdapterConnectionInterface
     */
    public function getAdapterConnection();

    /**
     * @param AdapterConnectionInterface $adapterConnection
     * @return $this
     */
    public function setAdapterConnection(AdapterConnectionInterface $adapterConnection);
} 