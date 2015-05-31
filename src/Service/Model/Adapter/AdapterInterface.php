<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\ConfigExistingInterface;
use Matryoshka\Scafolding\Service\Model\Adapter\Connection\AdapterConnectionAwareInterface;
use Matryoshka\Scafolding\Service\PromptSettingInterface;

/**
 * Interface AdapterInterface
 */
interface AdapterInterface extends
    PromptSettingInterface,
    ServiceNameInterface,
    AdapterConnectionAwareInterface,
    GeneratorInterface,
    ConfigExistingInterface
{
    /**
     * @return string
     */
    public function getConfigGlobalFolder();

    /**
     * @param string $configGlobalFolder
     * @return $this
     */
    public function setConfigGlobalFolder($configGlobalFolder);
} 