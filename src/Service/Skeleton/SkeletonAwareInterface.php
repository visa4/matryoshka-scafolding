<?php
namespace Matryoshka\Scafolding\Service\Skeleton;

/**
 * Interface SkeletonAwareInterface
 */
interface SkeletonAwareInterface
{
    /**
     * @return SkeletonInterface
     */
    public function getSkeleton();

    /**
     * @param SkeletonInterface $skeletonService
     * @return mixed
     */
    public function setSkeleton(SkeletonInterface $skeletonService);
} 