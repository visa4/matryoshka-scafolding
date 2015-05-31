<?php

namespace Matryoshka\Scafolding\Service;

/**
 * Class ConfigExistingTrait
 */
trait ConfigExistingTrait
{
    /**
     * @var bool
     */
    protected $configExisting = false;

    /**
     * @return bool
     */
    public function isConfigExisting()
    {
        return $this->configExisting;
    }

    /**
     * @param $configExisting
     * @return $this
     */
    public function setConfigExisting($configExisting)
    {
        $this->configExisting = (bool) $configExisting;
        return $this;
    }
} 