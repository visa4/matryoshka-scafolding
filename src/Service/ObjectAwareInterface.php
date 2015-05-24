<?php

namespace Matryoshka\Scafolding\Service;

/**
 * Interface ObjectAwareInterface
 */
interface ObjectAwareInterface
{
    /**
     * @return null|ObjectInterface
     */
    public function getObjectService();

    /**
     * @param ObjectInterface $objectService
     * @return $this
     */
    public function setObjectService(ObjectInterface $objectService);
} 