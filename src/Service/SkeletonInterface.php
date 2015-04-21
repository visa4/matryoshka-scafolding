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
     * @param $nameModule
     * @param $path
     * @return bool
     */
    public function generateConfigFolder($nameModule, $path);

    /**
     * @param $nameModule
     * @param $path
     * @return bool
     */
    public function generateViewFolder($nameModule, $path);
} 