<?php
namespace Matryoshka\Scafolding\Service;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Oop\ResourceInterface;

/**
 * Interface EntityInterface
 */
interface ObjectInterface extends
    ResourceInterface,
    GeneratorInterface,
    PromptSettingInterface
{
    const GET_METHOD = 'get';
    const SET_METHOD = 'set';

    const INTERFACE_SUFFIX = 'Interface';
    const OBJECT_CLASS_SUFFIX = 'Object';
    const TRAIT_SUFFIX = 'Trait';

    const PHP_SUFFIX = '.php';

    /**
     * @return bool
     */
    public function isGenerateSetterGetter();
}
