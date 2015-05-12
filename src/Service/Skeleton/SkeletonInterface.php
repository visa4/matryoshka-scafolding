<?php

namespace Matryoshka\Scafolding\Service\Skeleton;

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
     * Return string path in create the folder false if cant create folder
     *
     * @param $path
     * @return string|bool
     */
    public function generateConfigFolder($path);

    /**
     * Return string path in create the folder false if cant create folder
     *
     * @param $path
     * @return string|bool
     */
    public function generateSrcFolder($path);

    /**
     * Return string path in create the folder false if cant create folder
     *
     * @param $path
     * @param $entityName
     * @return string|bool
     */
    public function generateModelFolder($path, $entityName);

    /**
     * Return string path in create the folder false if cant create folder
     *
     * @param $path
     * @param $entityName
     * @return string|bool
     */
    public function generateEntityFolder($path, $entityName);

    /**
     * Return string path in create the folder false if cant create folder
     *
     * @param $path
     * @param $entityName
     * @return string|bool
     */
    public function generateHydratorFolder($path, $entityName);

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

    /**
     * @return bool
     */
    public function moduleExist();

    /**
     * @param $path
     * @return bool
     */
    public function isZf2Application($path);

} 