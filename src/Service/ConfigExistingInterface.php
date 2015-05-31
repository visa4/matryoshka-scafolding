<?php

namespace Matryoshka\Scafolding\Service;

/**
 * Interface ConfigExistingInterface
 */
interface ConfigExistingInterface
{
    /**
     * @return bool
     */
    public function isConfigExisting();

    /**
     * @param $configExisting
     * @return $this
     */
    public function setConfigExisting($configExisting);
} 