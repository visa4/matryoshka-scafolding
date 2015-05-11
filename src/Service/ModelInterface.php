<?php
namespace Matryoshka\Scafolding\Service;

/**
 * Interface ModelInterface
 */
interface ModelInterface
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
