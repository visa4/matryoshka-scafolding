<?php
namespace Matryoshka\Scafolding\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Entity
 */
class Entity extends Object implements EntityInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function existEntityFolder($path)
    {
        return is_dir($path . "/" . $this->getName() . '/Entity');
    }
} 