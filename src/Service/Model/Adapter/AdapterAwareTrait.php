<?php
namespace Matryoshka\Scafolding\Service\Model\Adapter;

/**
 * Class AdapterAwareTrait
 */
trait AdapterAwareTrait
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;
    /**
     * @return null|AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }
} 