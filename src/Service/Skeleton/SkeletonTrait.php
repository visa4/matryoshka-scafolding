<?php
namespace Matryoshka\Scafolding\Service\Skeleton;

/**
 * Trait GenerateSkeleton
 */
trait SkeletonTrait
{
    /**
     * @var string
     */
    protected $rootPath;

    /**
     * @var string
     */
    protected $applicationConfigPath;

    /**
     * @var string
     */
    protected $modelFolder;

    /**
     * @var string
     */
    protected $entityFolder;

    /**
     * @var string
     */
    protected $configFolder;

    /**
     * @var string
     */
    protected $srcFolder;

    /**
     * @var string
     */
    protected $hydratorFolder;

    /**
     * @var string
     */
    protected $configGlobalFile;


    /**
     * @return string
     */
    public function getRootPath()
    {
        return $this->rootPath;
    }

    /**
     * @param string $rootPath
     * @return $this
     */
    public function setRootPath($rootPath)
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfigFolder()
    {
        return $this->configFolder;
    }

    /**
     * @param string $configFolder
     * @return $this
     */
    public function setConfigFolder($configFolder)
    {
        $this->configFolder = $configFolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntityFolder()
    {
        return $this->entityFolder;
    }

    /**
     * @param string $entityFolder
     * @return $this
     */
    public function setEntityFolder($entityFolder)
    {
        $this->entityFolder = $entityFolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getModelFolder()
    {
        return $this->modelFolder;
    }

    /**
     * @param string $modelFolder
     * @return $this
     */
    public function setModelFolder($modelFolder)
    {
        $this->modelFolder = $modelFolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getSrcFolder()
    {
        return $this->srcFolder;
    }

    /**
     * @param string $srcFolder
     * @return $this
     */
    public function setSrcFolder($srcFolder)
    {
        $this->srcFolder = $srcFolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getHydratorFolder()
    {
        return $this->hydratorFolder;
    }

    /**
     * @param string $hydratorFolder
     * @return $this
     */
    public function setHydratorFolder($hydratorFolder)
    {
        $this->hydratorFolder = $hydratorFolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfigGlobalFile()
    {
        return $this->configGlobalFile;
    }

    /**
     * @param string $configGlobalFile
     * @return $this
     */
    public function setConfigGlobalFile($configGlobalFile)
    {
        $this->configGlobalFile = $configGlobalFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationConfigPath()
    {
        return $this->applicationConfigPath;
    }

    /**
     * @param string $applicationConfigPath
     * @return $this
     */
    public function setApplicationConfigPath($applicationConfigPath)
    {
        $this->applicationConfigPath = $applicationConfigPath;
        return $this;
    }
} 