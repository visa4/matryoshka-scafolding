<?php

namespace Matryoshka\Scafolding\Service\Model\Adapter;

/**
 * Interface ServiceNameInterface
 */
interface ServiceNameInterface
{
    /**
     * @return string
     */
    public function getServiceName();

    /**
     * @param string
     * @return $this
     */
    public function setServiceName($serviceName);
} 