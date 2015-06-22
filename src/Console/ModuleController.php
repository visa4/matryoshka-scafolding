<?php
namespace Matryoshka\Scafolding\Console;

use Matryoshka\Scafolding\Oop\GeneratorTrait;
use Matryoshka\Scafolding\Oop\Utils;
use Zend\Console\ColorInterface;
use Zend\Console\Request;

/**
 * Class ModelController
 */
class ModuleController extends AbstractConsoleController
{
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
    protected $modelFolder;

    /**
     * @var string
     */
    protected $entityFolder;

    /**
     * @var string
     */
    protected $hydratorFolder;

    public function createModelAction()
    {
        /* @var $request Request */
        $request = $this->getRequest();
        // To output detail to console
        $verbose = $request->getParam('verbose') || $request->getParam('v');
        $name = $request->getParam('name');
        $path = $request->getParam('path', '.');

        $this->getSkeletonService()->setRootPath($path);
        $this->getConfigService()->setModuleName($this->getSkeletonService()->getModuleName());
        $this->getEntityService()->setName($name);

        // Log
        ($verbose) ? $this->infoMessage('Start create skeleton') : '';

        // Is zf2 application
        if ($this->getSkeletonService()->isZf2Application($path)) {
            $this->errorMessage(sprintf('Path %s not contain a ZF2 application', $path));
            return 0;
        }
        // Module exist
        if ($this->existModule()) {
            return 0;
        }
        // Create folder
        if (!$this->createSkeletonFolders($path)) {
            return 0;
        }
        // Settings path
        $this->getConfigService()->setRootApplicationFolder($this->getSkeletonService()->getRootPath());
        $this->getConfigService()->setConfigModuleFolder($this->getSkeletonService()->getConfigFolder());

        // Log
        ($verbose) ? $this->infoMessage('Folders created') : '';

        $this->getModelService()->setName($name);
        $this->getEntityService()->setNameSpace(
            Utils::generateNameSpace([
                $this->getSkeletonService()->getModuleName(),
                $this->getModelService()->getName(),
                'Entity'
            ])
        );

        $this->getHydratorService()->setNameSpace(
            Utils::generateNameSpace([
                $this->getSkeletonService()->getModuleName(),
                $this->getModelService()->getName(),
                'Hydrator'
            ])
        );
        $this->getHydratorService()->setName($name);

        $this->getConfigService()->generateModuleClass($path);
        // Log
        ($verbose) ? $this->infoMessage('Module.php created') : '';

        $this->console->setColor(ColorInterface::BLUE);
        $this->getEntityService()->settingFromPrompt();
        $this->console->setColor(ColorInterface::RESET);
        $this->getEntityService()->generate($this->entityFolder);

        $this->getHydratorService()->settingFromPrompt(); // TODO to add strategy
        $this->getHydratorService()->generate($this->hydratorFolder);


        $this->getModelService()->settingFromPrompt();
        //$this->getModelService()->generate($this->configFolder);
        $this->getModelService()->getAdapter()->generate($this->configFolder);
        if ($this->getModelService()->getAdapter()->getAdapterConnection()) {
            $this->getModelService()->getAdapter()->getAdapterConnection()->generate($path);
        }

        $this->getConfigService()->generate($this->configFolder);
        $this->infoMessage('End');
        die();
    }

    /**
     * @return bool
     */
    protected function existModule()
    {
        // Module exist
        try{
            if ($this->getSkeletonService()->existModule()) {
                $this->errorMessage('Impossible create folders skeleton, please control permission');
                return true;
            }
        } catch(\Exception $e) {
            $this->errorMessage($e->getMessage());
            return true;
        }
        return false;
    }

    /**
     * @param $path
     * @return bool
     */
    protected function createSkeletonFolders($path)
    {
        var_dump($this->getEntityService()->getName());
        $isFoldersSkeletonCreated =
            ($this->configFolder = $this->getSkeletonService()->generateConfigFolder()) &&
            ($this->srcFolder = $this->getSkeletonService()->generateSrcFolder()) &&
            ($this->modelFolder = $this->getSkeletonService()->generateModelFolder($this->getEntityService()->getName())) &&
            ($this->entityFolder = $this->getSkeletonService()->generateEntityFolder($this->getEntityService()->getName())) &&
            ($this->hydratorFolder = $this->getSkeletonService()->generateHydratorFolder($this->getEntityService()->getName()));

        if (!$isFoldersSkeletonCreated) {
            // FIXME remove folder
            $this->errorMessage('Error to create folders');
            return false;
        }
        return true;
    }
}