<?php
namespace Matryoshka\Scafolding\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
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
    public function generateConfigFolder($path)
    {
        return mkdir($path . "/module/" . $this->getModuleName() . "/config", 0777, true);
    }

    /**
     * @inheritdoc
     */
    public function generateSrcFolder($path)
    {
        return mkdir($path . "/module/" . $this->getModuleName() . "/src", 0777, true);
    }

    /**
     * @inheritdoc
     */
    public function generateModuleClass($path)
    {
        $module = new FileGenerator();
        $module->setName('Module');
        $module->setNamespaceName($this->getModuleName());

        $getConfigMethod = new MethodGenerator();
        $getConfigMethod->setName('getConfig');

        $getAutoloaderConfigMethod = new MethodGenerator();
        $getAutoloaderConfigMethod->setName('getAutoloaderConfig');

        return file_put_contents($path, $module->generate());
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