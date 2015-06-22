<?php
namespace Matryoshka\Scafolding\Service\Model;

/**
 * Class ModelAwareTrait
 */
trait ModelAwareTrait
{
    /**
     * @var ModelInterface
     */
    protected $modelService;

    /**
     * @return ModelInterface
     */
    public function getModelService()
    {
        return $this->modelService;
    }

    /**
     * @param ModelInterface $modelService
     * @return $this
     */
    public function setModelService(ModelInterface $modelService)
    {
        $this->modelService = $modelService;
        return $this;
    }
} 