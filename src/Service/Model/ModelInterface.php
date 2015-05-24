<?php
namespace Matryoshka\Scafolding\Service\Model;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Model\Adapter\AdapterAwareInterface;

/**
 * Interface ModelInterface
 */
interface ModelInterface extends GeneratorInterface, AdapterAwareInterface
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
