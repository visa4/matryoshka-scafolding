<?php
namespace Matryoshka\Scafolding\Service;

use Zend\Filter\File\UpperCase;
use Zend\Filter\UpperCaseWords;
use Zend\Filter\Word\CamelCaseToDash;

/**
 * Class GenerateSkeleton
 */
class Skeleton implements SkeletonInterface
{
    const DEFAULT_MODULE_NAME = 'MatryoshkaModel';

    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @inheritdoc
     */
    public function generateNameEntity($nameEntity)
    {
        $filter = new UpperCaseWords();
        return $filter->filter($nameEntity);
    }

    /**
     * @inheritdoc
     */
    public function generateConfigFolder($nameModule, $path)
    {
        return mkdir($path . "/module/" . $this->getModuleName() . "/config", 0777, true);
    }

    /**
     * @inheritdoc
     */
    public function generateSrcFolder($nameModule, $path)
    {
        return mkdir($path . "/module/" . $this->getModuleName() . "/src", 0777, true);
    }

    /**
     * @inheritdoc
     * @deprecated
     */
    public function generateViewFolder($nameModule, $path)
    {
        $filter = new CamelCaseToDash();
        $viewFolder = strtolower($filter->filter($nameModule));
        return mkdir($path . "/module/" . $nameModule . "/view/" . $viewFolder, 0777, true);
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        if (!$this->moduleName) {
            $this->moduleName = self::DEFAULT_MODULE_NAME;
        }
        return $this->moduleName;
    }

    /**
     * @param $moduleName
     * @return $this
     */
    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
        return $this;
    }
} 