<?php
namespace Matryoshka\Scafolding\Service\Hydrator;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Oop\ResourceInterface;
use Matryoshka\Scafolding\Service\ObjectInterface;
use Matryoshka\Scafolding\Service\PromptSettingInterface;

/**
 * Interface HydratorInterface
 */
interface HydratorInterface extends ResourceInterface, GeneratorInterface, PromptSettingInterface
{
    const OBJECT_CLASS_SUFFIX = 'Hydrator';

    /**
     * @param ObjectInterface $objectService
     * @return $this
     */
    public function setObjectService(ObjectInterface $objectService);
} 