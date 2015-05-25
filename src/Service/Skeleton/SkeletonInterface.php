<?php

namespace Matryoshka\Scafolding\Service\Skeleton;

use Matryoshka\Scafolding\Service\Model\ModelNameInterface;

/**
 * Interface SkeletonInterface
 */
interface SkeletonInterface extends ModelNameInterface
{
    /**
     * Return string path in create the folder false if cant create folder
     *
     * @return string|bool
     */
    public function generateConfigFolder();

    /**
     * Return string path in create the folder false if cant create folder
     *
     * @return string|bool
     */
    public function generateSrcFolder();

    /**
     * Return string path in create the folder false if cant create folder
     *
     * @param $entityName
     * @return string|bool
     */
    public function generateModelFolder($entityName);

    /**
     * Return string path in create the folder false if cant create folder
     *
     * @param $entityName
     * @return string|bool
     */
    public function generateEntityFolder($entityName);

    /**
     * Return string path in create the folder false if cant create folder
     *
     * @param $entityName
     * @return string|bool
     */
    public function generateHydratorFolder($entityName);

    /**
     * @return bool
     */
    public function existModule();

    /**
     * @return bool
     */
    public function existConfigGlobalFile();

    /**
     * @return null|string
     */
    public function getConfigGlobalFile();

    /**
     * @return bool
     */
    public function isZf2Application();

    /**
     * @return string
     */
    public function getRootPath();

    /**
     * @param string $rootPath
     * @return $this
     */
    public function setRootPath($rootPath);

    /**
     * @return string
     */
    public function getConfigFolder();

    /**
     * @return string
     */
    public function getEntityFolder();

    /**
     * @return string
     */
    public function getModelFolder();

    /**
     * @return string
     */
    public function getSrcFolder();

    /**
     * @return string
     */
    public function getHydratorFolder();
} 