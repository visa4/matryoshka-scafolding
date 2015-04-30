<?php
namespace Matryoshka\Scafolding\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Config
 */
class Config implements ConfigInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
} 