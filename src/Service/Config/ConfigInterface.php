<?php
namespace Matryoshka\Scafolding\Service\Config;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Hydrator\HydratorAwareInterface;
use Matryoshka\Scafolding\Service\Model\ModelAwareInterface;
use Matryoshka\Scafolding\Service\Model\ModelNameInterface;
use Matryoshka\Scafolding\Service\ObjectAwareInterface;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface extends
    ObjectAwareInterface,
    HydratorAwareInterface,
    ModelAwareInterface,
    ModelNameInterface
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
     * @param string $configModuleFolder
     * @return $this
     */
    public function setConfigModuleFolder($configModuleFolder);
} 