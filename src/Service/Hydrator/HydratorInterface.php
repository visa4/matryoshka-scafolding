<?php
namespace Matryoshka\Scafolding\Service\Hydrator;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Oop\ResourceInterface;
use Matryoshka\Scafolding\Service\ObjectAwareInterface;
use Matryoshka\Scafolding\Service\PromptSettingInterface;

/**
 * Interface HydratorInterface
 */
interface HydratorInterface extends
    ResourceInterface,
    GeneratorInterface,
    PromptSettingInterface,
    ObjectAwareInterface
{
    const OBJECT_CLASS_SUFFIX = 'Hydrator';
} 