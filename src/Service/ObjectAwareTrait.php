<?php

namespace Matryoshka\Scafolding\Service;

/**
 * Trait ObjectAwareInterface
 */
trait ObjectAwareTrait
{
    /**
     * @var
     */
    protected $objectService;
    /**
     * @return null|ObjectInterface
     */
    public function getObjectService()
    {
        return $this->objectService;
    }

    /**
     * @param ObjectInterface $objectService
     * @return $this
     */
    public function setObjectService(ObjectInterface $objectService)
    {
        $this->objectService = $objectService;
        return $this;
    }
} 