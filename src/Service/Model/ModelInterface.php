<?php
namespace Matryoshka\Scafolding\Service\Model;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Model\Adapter\AdapterAwareInterface;
use Matryoshka\Scafolding\Service\PromptSettingInterface;

/**
 * Interface ModelInterface
 */
interface ModelInterface extends
    GeneratorInterface,
    AdapterAwareInterface,
    PromptSettingInterface
{
    /**
     * @param $path
     * @return bool
     */
    public function existModelFolder($path);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);
}
