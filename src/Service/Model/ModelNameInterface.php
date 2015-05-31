<?php
namespace Matryoshka\Scafolding\Service\Model;

/**
 * Interface ModelNameInterface
 */
interface ModelNameInterface
{
    /**
     * @return string
     */
    public function getModuleName();

    /**
     * @param $modelName
     * @return mixed
     */
    public function setModuleName($modelName);
} 