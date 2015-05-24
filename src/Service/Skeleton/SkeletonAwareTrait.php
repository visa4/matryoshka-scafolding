<?php
namespace Matryoshka\Scafolding\Service\Skeleton;

/**
 * Class SkeletonAwareTrait
 */
trait SkeletonAwareTrait
{
    /**
     * @var SkeletonInterface
     */
    protected $skeletonService;

    /**
     * @return SkeletonInterface
     */
    public function getSkeletonService()
    {
        return $this->skeletonService;
    }

    /**
     * @param SkeletonInterface $skeletonService
     * @return $this
     */
    public function setSkeletonService($skeletonService)
    {
        $this->skeletonService = $skeletonService;
        return $this;
    }
}