<?php
namespace Matryoshka\Scafolding\Service\Model;

/**
 * Interface ModelAwareInterface
 */
interface ModelAwareInterface
{
    /**
     * @return ModelInterface
     */
    public function getModelService();

    /**
     * @param ModelInterface $modelService
     * @return $this
     */
    public function setModelService(ModelInterface $modelService);
} 