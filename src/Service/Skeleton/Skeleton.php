<?php
namespace Matryoshka\Scafolding\Service\Skeleton;

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
    public function generateModuleClass()
    {
        // TODO check if already exist
        $class = new ClassGenerator();
        $class->setName('Module');
        $class->setNamespaceName($this->getModuleName());

        // TODO docBlock
        $getConfigMethod = new MethodGenerator();
        $getConfigMethod->setName('getConfig');
        $getConfigMethod->setBody("return include __DIR__ . '/config/module.config.php';");

        $getAutoloaderConfigMethod = new MethodGenerator();
        $getAutoloaderConfigMethod->setName('getAutoloaderConfig');
        $getAutoloaderConfigMethod->setBody("return ['Zend\Loader\StandardAutoloader' => [
    'namespaces' => [
        __NAMESPACE__ => __DIR__ . '/src/',
        ],
    ],
];"
        );


        $class->addMethods([$getConfigMethod, $getAutoloaderConfigMethod]);

        $file = new FileGenerator();
        $file->setClass($class);

        return file_put_contents($this->getRootPath() . "/module/" . $this->getModuleName() . "/Module.php", $file->generate());
    }

    public function generateApplicationConfig()
    {
        // TODO check if already exist
        $oldApplicationConfig = include $this->getRootPath() . "/config/application.config.php";

        if (!in_array($this->getModuleName(), $oldApplicationConfig['modules'])) {
            $oldApplicationConfig['modules'][] = $this->getModuleName();
        }

        copy($this->getRootPath() . "/config/application.config.php",
            $this->getRootPath() . sprintf("/config/application.config.%s", (new \DateTime())->getTimestamp())
        );

        $file = new FileGenerator();
        $file->setFilename("application.config.php");

        $docBlock = new DocBlockGenerator();
        $docBlock->setShortDescription('Test'); // TODO refactor
        $docBlock->setLongDescription('Test test'); // TODO refactor

        $file->setDocBlock($docBlock);

        $valueGenerator = new ValueGenerator();
        $valueGenerator->setValue($oldApplicationConfig);
        $valueGenerator->setArrayDepth(0);

        $file->setBody("return " . $valueGenerator->generate() . ";");


        return file_put_contents($this->getRootPath() . "/config/" . $file->getFilename(), $file->generate());
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