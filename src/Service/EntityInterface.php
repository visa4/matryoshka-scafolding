<?php
namespace Matryoshka\Scafolding\Service;

/**
 * Interface EntityInterface
 */
interface EntityInterface extends ObjectInterface
{
    const ENTITY_CLASS_SUFFIX = 'Entity';

    /**
     * @param $path
     * @return bool
     */
    public function existEntityFolder($path);
} 