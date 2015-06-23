<?php
/**
 * Created by visa
 * Date:  30/04/15 15.30
 * Class: Object.php
 */

namespace Matryoshka\Scafolding\Service;

use Matryoshka\Scafolding\Code\Generator\InterfaceGenerator;
use Matryoshka\Scafolding\Oop\ResourceTrait;
use Matryoshka\Scafolding\Oop\Utils;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\TraitGenerator;
use Zend\Console\Prompt\Char;

/**
 * Class Object
 */
class Object implements ObjectInterface
{
    use ResourceTrait;
    use ObjectTrait;
    use ObjectPromptTrait;

    /**
     * @var InterfaceGenerator
     */
    protected $interface;

    /**
     * @var ClassGenerator
     */
    protected $object;

    /**
     * @var TraitGenerator
     */
    protected $trait;

    /**
     * @var bool
     */
    protected $generateTrait = true;

    /**
     * @var bool
     */
    protected $generateSetterGetter = false;

    /**
     * @return boolean
     */
    public function isGenerateTrait()
    {
        return $this->generateTrait;
    }

    /**
     * @param boolean $generateTrait
     * @return $this
     */
    public function setGenerateTrait($generateTrait)
    {
        $this->generateTrait = (bool) $generateTrait;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isGenerateSetterGetter()
    {
        return $this->generateSetterGetter;
    }

    /**
     * @param boolean $generateSetterGetter
     * @return $this
     */
    public function setGenerateSetterGetter($generateSetterGetter)
    {
        $this->generateSetterGetter = (bool) $generateSetterGetter;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function settingFromPrompt()
    {
        $generateTrait = Char::prompt('Do you what use Trait [y, n]',
            'yn',
            true,
            false,
            false);
        $this->setGenerateTrait($generateTrait == 'y' ? true : false);

        $generateSetterGetter = Char::prompt('Do you what to add setter and getter?? [y, n]',
            'yn',
            true,
            false,
            false);
        $this->setGenerateSetterGetter($generateSetterGetter == 'y' ? true : false);

        $arrayConstants = $this->getArrayConstantsFromPrompt();
        foreach ($arrayConstants as $constant) {
            $this->addConstant($constant);
        }

        $arrayProperties =  $this->getArrayProprietiesFromPrompt();
        foreach ($arrayProperties as $property) {
            $this->addProperty($property);
        }

        if ($this->isGenerateSetterGetter()) {
            foreach ($arrayProperties as $property) {
                $this->addSetterGetter($property);
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function generate($path)
    {
        $this->generateInterface($path);

        if ($this->isGenerateTrait()) {
            $this->generateTrait($path);
        }

        $this->generateObject($path);
    }

    /**
     * @param $path
     * @return int The function returns the number of bytes that were written to the file, or false on failure.
     */
    protected function generateInterface($path)
    {
        // FIXME InterfaceGenarator quisk and dirty solution
        $this->interface = new InterfaceGenerator();
        $this->interface->setNamespaceName($this->getNameSpace());
        $this->interface->setName(Utils::buildName($this->getName(), ObjectInterface::INTERFACE_SUFFIX));

        if ($this->getConstants()) {
            $this->interface->addConstants($this->getConstants());
        }

        $path = $path . '/' . Utils::buildName($this->getName(), ObjectInterface::INTERFACE_SUFFIX, true);
        return file_put_contents($path,   $this->interface->generate());
    }

    /**
     * @param $path
     * @return int The function returns the number of bytes that were written to the file, or false on failure.
     */
    protected function generateObject($path)
    {
        $this->object = new ClassGenerator();
        $this->object->setNamespaceName($this->getNameSpace());
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

    /**
     * @param $path
     * @return int The function returns the number of bytes that were written to the file, or false on failure.
     */
    protected function generateTrait($path)
    {
        $this->trait = new TraitGenerator();
        $this->trait->setNamespaceName($this->getNameSpace());
        $this->trait->setName(Utils::buildName($this->getName(), ObjectInterface::TRAIT_SUFFIX));


        if ($this->getProperties()) {
            $this->trait->addProperties($this->getProperties());
        }

        if ($this->isGenerateSetterGetter()) {
            $this->trait->addMethods($this->getGetSetMethods());
        }

        $file = new FileGenerator();
        $file->setClass($this->trait);

        $path = $path . '/' . Utils::buildName($this->getName(), ObjectInterface::TRAIT_SUFFIX, true);
        return file_put_contents($path, $file->generate());
    }

    /**
     * @return string
     */
    public function getFullQualifiedClassName()
    {
        return $this->getNameSpace() . '\\' . $this->object->getName();
    }
} 