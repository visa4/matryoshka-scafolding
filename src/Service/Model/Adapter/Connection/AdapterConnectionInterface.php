<?php
/**
 * Class: AdapeterConnectionInterface.php
 */

namespace Matryoshka\Scafolding\Service\Model\Adapter\Connection;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\Model\Adapter\ServiceNameInterface;
use Matryoshka\Scafolding\Service\PromptSettingInterface;

/**
 * Interface AdapterConnectionInterface
 */
interface AdapterConnectionInterface extends
    PromptSettingInterface,
    ServiceNameInterface,
    GeneratorInterface
{

} 