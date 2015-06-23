<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;



/**
 * Trait AdapterInterface
 */
trait AdapterTrait
{
    /**
     * @var string
     */
    protected $activeRecordCriteria;

    /**
     * @var string
     */
    protected $resultSet;

    /**
     * @var string
     */
    protected $paginatorCriteria;

    /**
     * @return string
     */
    public function getActiveRecordCriteria()
    {
        return $this->activeRecordCriteria;
    }

    /**
     * @param string $activeRecordCriteria
     * @return $this
     */
    public function setActiveRecordCriteria($activeRecordCriteria)
    {
        $this->activeRecordCriteria = $activeRecordCriteria;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaginatorCriteria()
    {
        return $this->paginatorCriteria;
    }

    /**
     * @param string $paginatorCriteria
     * @return $this
     */
    public function setPaginatorCriteria($paginatorCriteria)
    {
        $this->paginatorCriteria = $paginatorCriteria;
        return $this;
    }

    /**
     * @return string
     */
    public function getResultSet()
    {
        return $this->resultSet;
    }

    /**
     * @param string $resultSet
     * @return $this
     */
    public function setResultSet($resultSet)
    {
        $this->resultSet = $resultSet;
        return $this;
    }
}
