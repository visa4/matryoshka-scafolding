<?php
namespace Matryoshka\Scafolding\Service;

use Matryoshka\Scafolding\Filter\UcFirst;

/**
 * Class Model
 */
class Model implements ModelInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @inheritdoc
     */
    public function existModelFolder($path)
    {
        return is_dir($path . "/" . $this->getName());
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $filter = new UcFirst();
        $this->name = $filter->filter($name);
        return $this;
    }
}
