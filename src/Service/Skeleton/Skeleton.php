<?php
namespace Matryoshka\Scafolding\Service\Skeleton;

use Matryoshka\Scafolding\Service\Model\ModelNameAwareTrait;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\ValueGenerator;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class GenerateSkeleton
 */
class Skeleton implements SkeletonInterface , ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    use SkeletonTrait;
    use ModelNameAwareTrait;
    const DEFAULT_MODULE_NAME = 'MatryoshkaModel';

    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @inheritdoc
     */
    public function generateConfigFolder()
    {
        $path = $this->getRootPath() . "/module/" . $this->getModuleName() . "/config";
        if (is_dir($path) || mkdir($path, 0777, true)) {
            $this->setConfigFolder($path);
            return $path;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function generateSrcFolder()
    {
        $path = $this->getRootPath() . "/module/" . $this->getModuleName() . "/src";

        if (is_dir($path) || mkdir($path, 0777, true)) {
            $this->setSrcFolder($path);
            return $path;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function generateModelFolder($entityName)
    {
        $path = $this->getRootPath() . "/module/" . $this->getModuleName() . "/src/" . $entityName;
        if (is_dir($path) || mkdir($path, 0777, true)) {
            $this->setModelFolder($path);
            return $path;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function generateEntityFolder($entityName)
    {
        $path = $this->getRootPath() . "/module/" . $this->getModuleName() . "/src/" . $entityName . '/Entity';
        if (is_dir($path) || mkdir($path, 0777, true)) {
            $this->setEntityFolder($path);
            return $path;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function generateHydratorFolder($entityName)
    {
        $path = $this->getRootPath() . "/module/" . $this->getModuleName() . "/src/" . $entityName . '/Hydrator';
        if (is_dir($path) || mkdir($path, 0777, true)) {
            $this->setHydratorFolder($path);
            return $path;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function existModule()
    {
        $sm = $this->getServiceLocator();
        try{
            /* @var $mm \Zend\ModuleManager\ModuleManager */
            $mm = $sm->get('modulemanager');
        } catch(ServiceNotFoundException $e) {
            throw new \RuntimeException('Cannot get Zend\ModuleManager\ModuleManager instance');
        }

        $moduleName = $mm->getModule($this->getModuleName());
        if ($moduleName) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function existConfigGlobalFile()
    {
        $file = $this->getRootPath() . DIRECTORY_SEPARATOR .
            'config' . DIRECTORY_SEPARATOR .
            'autoload' . DIRECTORY_SEPARATOR .
            'global.php';
        if (file_exists($file)) {
            return true;
        }

        $file = $this->getRootPath() . DIRECTORY_SEPARATOR . 'global.php';
        if (file_exists($file)) {
            return true;
        }

        return false;
    }

    /**
     * @return null|string
     */
    public function getConfigGlobalFile()
    {
        if ($this->configGlobalFile) {
            return $this->configGlobalFile;
        }

        $file = $this->getRootPath() . DIRECTORY_SEPARATOR .
            'config' . DIRECTORY_SEPARATOR .
            'autoload' . DIRECTORY_SEPARATOR .
            'global.php';
        if (file_exists($file)) {
            $this->configGlobalFile = $file;
            return $this->configGlobalFile;
        }

        $file =  $this->getRootPath() . DIRECTORY_SEPARATOR . 'global.php';
        if (file_exists($file)) {
            $this->configGlobalFile = $file;
            return $this->configGlobalFile;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function isZf2Application()
    {
        return !file_exists($this->getRootPath() . "/module") || !file_exists($this->getRootPath() . "/config/application.config.php");
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
} 