<?php
/**
 * Created by visa
 * Date:  21/04/15 13.09
 * Class: SkeletonInterface.php
 */

namespace Matryoshka\Scafolding\Service;

/**
 * Interface SkeletonInterface
 */
interface SkeletonInterface
{
    /**
     * @return string
     */
    public function getModuleName();

    /**
     * @param $nameEntity
     * @return string
     */
    public function generateNameEntity($nameEntity);

    /**
     * @param $path
     * @return bool
     */
    public function generateConfigFolder($path);


    /**
     * @param $path
     * @return bool
     */
    public function generateSrcFolder($path);

    /**
     * @param $path
     * @return bool|int
     */
    public function generateModuleClass($path);

    /**
     * @param $path
     * @return bool|int
     */
    public function generateApplicationConfig($path);
} 