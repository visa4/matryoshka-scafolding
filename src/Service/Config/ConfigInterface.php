<?php
namespace Matryoshka\Scafolding\Service\Config;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Hydrator\HydratorAwareInterface;
use Matryoshka\Scafolding\Service\ObjectAwareInterface;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface extends
    ObjectAwareInterface,
    HydratorAwareInterface,
    GeneratorInterface
{
    const TEMPLATE_FILE_NAME_CONFIG = '%s.config.php';
} 