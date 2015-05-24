<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;

/**
 * Interface AdapterInterface
 */
interface AdapterAwareInterface
{
    /**
     * @return null|AdapterInterface
     */
    public function getAdapter();

    /**
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function setAdapter(AdapterInterface $adapter);
} 