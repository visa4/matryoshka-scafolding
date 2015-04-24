<?php
namespace Matryoshka\Scafolding\Service;

use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Filter\File\UpperCase;
use Zend\Filter\UpperCaseWords;
use Zend\Filter\Word\CamelCaseToDash;
use Zend\Form\Element\File;

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
        $class = new ClassGenerator();
        $class->setName('Module');
        $class->setNamespaceName($this->getModuleName());

        $getConfigMethod = new MethodGenerator();
        $getConfigMethod->setName('getConfig');
        $getConfigMethod->setBody("return include __DIR__ . '/config/module.config.php';");

        $getAutoloaderConfigMethod = new MethodGenerator();
        $getAutoloaderConfigMethod->setName('getAutoloaderConfig');
        $getAutoloaderConfigMethod->setBody("return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        );");

        $class->addMethods([$getConfigMethod, $getAutoloaderConfigMethod]);

        $file = new FileGenerator();
        $file->setClass($class);

        return file_put_contents($path . "/module/" . $this->getModuleName() . "/Module.php", $file->generate());
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