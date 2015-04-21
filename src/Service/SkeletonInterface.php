<?php
/**
 * Created by visa
 * Date:  21/04/15 13.09
 * Class: SkeletonInterface.php
 */

namespace Matryoshka\Scafolding\Service;


interface SkeletonInterface
{
    /**
     * @param $nameModule
     * @return string
     */
    public function generateName($nameModule);

    /**
     * @param string $nameModule
     * @return string
     */
    public function getViewFolder($nameModule);
} 