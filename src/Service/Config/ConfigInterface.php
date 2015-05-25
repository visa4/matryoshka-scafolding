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
    HydratorAwareInterface
{
    const TEMPLATE_FILE_NAME_CONFIG = '%s.config.php';

    /**
     * @return $this
     */
    public function generate();

    /**
     * @param string $rootApplicationFolder
     * @return $this
     */
    public function setRootApplicationFolder($rootApplicationFolder);

    /**
     * @param string $rootModuleFolder
     * @return $this
     */
    public function setRootModuleFolder($rootModuleFolder);
} 