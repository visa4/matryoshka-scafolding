<?php

namespace Matryoshka\Scafolding\Service\Model\Adapter;

/**
 * Trait ServiceNameInterface
 */
trait ServiceNameTrait
{
    protected $serviceName;
    /**
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param string
     * @return $this
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
        return $this;
    }
} 