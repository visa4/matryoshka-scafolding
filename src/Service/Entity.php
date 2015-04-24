<?php
namespace Matryoshka\Scafolding\Service;

/**
 * Class Entity
 */
class Entity implements EntityInterface
{
    /**
     * @var bool
     */
    protected $generateTrait = true;

    /**
     * @var bool
     */
    protected $generateInterface = true;

    /**
     * @return boolean
     */
    public function isGenerateInterface()
    {
        return $this->generateInterface;
    }

    /**
     * @param boolean $generateInterface
     * @return $this
     */
    public function setGenerateInterface($generateInterface)
    {
        $this->generateInterface = $generateInterface;
        return $this;
    }

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
        $this->generateTrait = $generateTrait;
        return $this;
    }
} 