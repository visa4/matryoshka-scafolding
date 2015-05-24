<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Model\Adapter\Connection\AdapterConnectionAwareInterface;
use Matryoshka\Scafolding\Service\PromptSettingInterface;

/**
 * Trait AdapterInterface
 */
trait AdapterTrait
{
    /**
     * @var string
     */
    protected $configGlobalFolder;

    /**
     * @return string
     */
    public function getConfigGlobalFolder()
    {
        return $this->configGlobalFolder;
    }

    /**
     * @param string $configGlobalFolder
     * @return $this
     */
    public function setConfigGlobalFolder($configGlobalFolder)
    {
        $this->configGlobalFolder = $configGlobalFolder;
        return $this;
    }
}
