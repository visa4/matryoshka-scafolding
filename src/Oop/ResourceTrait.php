<?php
/**
 * Created by visa
 * Date:  11/05/15 13.19
 * Class: ResourceInterface.php
 */

namespace Matryoshka\Scafolding\Oop;

use Matryoshka\Scafolding\Filter\UcFirst;

/**
 * Class ResourceTrait
 */
trait ResourceTrait
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $nameSpace;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $filter = new UcFirst();
        $this->name = $filter->filter($name);
        return $this;
    }

    /**
     * @return string
     */
    public function getNameSpace()
    {
        return $this->nameSpace;
    }

    /**
     * @param string $nameSpace
     * @return $this
     */
    public function setNameSpace($nameSpace)
    {
        $this->nameSpace = $nameSpace;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullQualifiedClassName()
    {
        return $this->getNameSpace() . '\\' . $this->getName();
    }
}
