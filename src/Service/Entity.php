<?php
namespace Matryoshka\Scafolding\Service;

use Matryoshka\Scafolding\Oop\Utils;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\FileGenerator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Entity
 */
class Entity extends Object implements EntityInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @param $path
     * @return int The function returns the number of bytes that were written to the file, or false on failure.
     */
    protected function generateObject($path)
    {
        $this->object = new ClassGenerator();
        $this->object->setNamespaceName($this->getNameSpace());
        $this->object->addUse('Matryoshka\Model\Object\ActiveRecord\AbstractActiveRecord');
        $this->object->addUse('Matryoshka\Model\Object\IdentityAwareTrait');
        $this->object->setExtendedClass('AbstractActiveRecord');
        $this->object->addTrait('IdentityAwareTrait');
        $this->object->setImplementedInterfaces([Utils::buildName($this->getName(), ObjectInterface::INTERFACE_SUFFIX)]);
        $this->object->setName(Utils::buildName($this->getName(), ObjectInterface::OBJECT_CLASS_SUFFIX));

        if ($this->isGenerateTrait()) {
            $this->object->addTrait(Utils::buildName($this->getName(), ObjectInterface::TRAIT_SUFFIX));
        }

        if (!$this->isGenerateTrait()) {

            if ($this->getProperties()) {
                $this->object->addProperties($this->getProperties());
            }


            if ($this->isGenerateSetterGetter()) {
                $this->object->addMethods($this->getGetSetMethods());
            }
        }

        $file = new FileGenerator();
        $file->setClass($this->object);

        $path = $path . '/' . Utils::buildName($this->getName(), ObjectInterface::OBJECT_CLASS_SUFFIX, true);
        return file_put_contents($path, $file->generate());
    }

} 