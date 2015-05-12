<?php
/**
 * Created by visa
 * Date:  12/05/15 12.16
 * Class: HydratorAwareInterface.php
 */

namespace Matryoshka\Scafolding\Service\Hydrator;

/**
 * Interface HydratorAwareInterface
 */
trait HydratorAwareTrait
{
    /**
     * @var HydratorInterface
     */
    protected $hydratorService;

    /**
     * @return HydratorInterface
     */
    public function getHydratorService()
    {
        return $this->hydratorService;
    }

    /**
     * @param HydratorInterface $hydratorService
     * @return $this
     */
    public function setHydratorService(HydratorInterface $hydratorService)
    {
        $this->hydratorService = $hydratorService;
        return $this;
    }
} 