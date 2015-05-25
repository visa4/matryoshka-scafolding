<?php
namespace Matryoshka\Scafolding\Service\Model;

/**
 * Trait ModelNameInterface
 */
trait ModelNameAwareTrait
{
    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * @param $moduleName
     * @return $this
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
        return $this;
    }
} 