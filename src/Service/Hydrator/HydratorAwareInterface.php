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
interface HydratorAwareInterface
{
    /**
     * @return null|HydratorInterface
     */
    public function getHydratorService();

    /**
     * @param HydratorInterface $hydratorService
     * @return $this
     */
    public function setHydratorService(HydratorInterface $hydratorService);
} 