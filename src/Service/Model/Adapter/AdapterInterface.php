<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;

use Matryoshka\Scafolding\Oop\GeneratorInterface;
use Matryoshka\Scafolding\Service\ConfigExistingInterface;
use Matryoshka\Scafolding\Service\Model\Adapter\Connection\AdapterConnectionAwareInterface;
use Matryoshka\Scafolding\Service\PromptSettingInterface;

/**
 * Interface AdapterInterface
 */
interface AdapterInterface extends
    PromptSettingInterface,
    ServiceNameInterface,
    AdapterConnectionAwareInterface,
    GeneratorInterface,
    ConfigExistingInterface
{
    /**
     * @return string
     */
    public function getActiveRecordCriteria();

    /**
     * @param string $activeRecordCriteria
     * @return $this
     */
    public function setActiveRecordCriteria($activeRecordCriteria);

    /**
     * @return string
     */
    public function getPaginatorCriteria();

    /**
     * @param string $paginatorCriteria
     * @return $this
     */
    public function setPaginatorCriteria($paginatorCriteria);

    /**
     * @return string
     */
    public function getResultSet();

    /**
     * @param string $resultSet
     * @return $this
     */
    public function setResultSet($resultSet);

    /**
     * @return array
     */
    public function getMatryoshkaDefaultAbstractFactory();
} 