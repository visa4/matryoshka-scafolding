<?php
/**
 * Created by visa
 * Date:  30/04/15 15.30
 * Class: Object.php
 */

namespace Matryoshka\Scafolding\Service;

use Matryoshka\Scafolding\Oop\Utils;
use Zend\Code\Generator\DocBlock\Tag;

/**
 * Trait ObjectTrait
 */
trait ObjectTrait
{
    /**
     * @var array
     */
    protected $constants = [];

    /**
     * @var array
     */
    protected $properties =  [];

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @var array
     */
    protected $getSetMethods = [];

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     * @return $this
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @return array
     */
    public function getConstants()
    {
        return $this->constants;
    }

    /**
     * @return array
     */
    public function getGetSetMethods()
    {
        return $this->getSetMethods;
    }

    /**
     * @param array $getSetMethods
     * @return $this
     */
    public function setGetSetMethods($getSetMethods)
    {
        $this->getSetMethods = $getSetMethods;
        return $this;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     * @return $this
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;
        return $this;
    }

    /**
     * @param array $constants
     * @return $this
     */
    public function setConstants($constants)
    {
        $this->constants = $constants;
        return $this;
    }


    /**
     * @param array $constant
     * @return $this
     */
    protected function addConstant(array $constant)
    {
        $constantClass = Utils::createConstantFromArray($constant);
        $this->constants[$constantClass->getName()] = $constantClass;
        return $this;
    }

    /**
     * @param array $property
     * @return $this
     */
    protected function addProperty(array $property)
    {
        $propertyClass = Utils::createPropertyFromArray($property);
        $this->properties[$propertyClass->getName()] = $propertyClass;
        return $this;
    }

    /**
     * @param array $property
     * @return $this
     */
    protected function addSetterGetter(array $property)
    {
        $getterSetter = Utils::createSetterGetterFromArray($property);
        $this->setGetSetMethods($getterSetter);
        return $this;
    }
}
