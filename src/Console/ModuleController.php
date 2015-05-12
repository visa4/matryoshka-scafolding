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

    public function createModuleAction()
    {
        /* @var $request Request */
        $request = $this->getRequest();
        // To output detail to console
        $verbose = $request->getParam('verbose') || $request->getParam('v');
        $name = $request->getParam('name');
        $path = $request->getParam('path', '.');

        $this->getModelService()->setName($name);
        $this->getEntityService()->setNameSpace(
            Utils::generateNameSpace([
                $this->getSkeletonService()->getModuleName(),
                $this->getModelService()->getName(),
                'Entity'
            ])
        );
        $this->getEntityService()->setName($name);

        $this->getHydratorService()->setNameSpace(
            Utils::generateNameSpace([
                $this->getSkeletonService()->getModuleName(),
                $this->getModelService()->getName(),
                'Hydrator'
            ])
        );
        $this->getHydratorService()->setName($name);

        // Log
        ($verbose) ? $this->infoMessage('Start create skeleton') : '';

        // Is zf2 application
        if ($this->getSkeletonService()->isZf2Application($path)) {
            $this->errorMessage(sprintf('Path %s not contain a ZF2 application', $path));
            return 0;
        }
        // Module exist
        if ($this->moduleExist()) {
            return 0;
        }
        // Create folder
        if (!$this->createSkeletonFolders($path)) {
            return 0;
        }
        // Log
        ($verbose) ? $this->infoMessage('Folders created') : '';

        $this->getSkeletonService()->generateModuleClass($path);
        // Log
        ($verbose) ? $this->infoMessage('Module.php created') : '';

        $this->console->setColor(ColorInterface::BLUE);
        $this->getEntityService()->settingFromPrompt();
        $this->console->setColor(ColorInterface::RESET);
        $this->getEntityService()->generate($this->entityFolder);

        //$this->getHydratorService()->settingFromPrompt(); // TODO to add strategy
        $this->getHydratorService()->generate($this->hydratorFolder);

        $this->getConfigService()->generate($this->configFolder);
        die();
        /*
        $HydratorClass = Char::prompt( 'Do you what to use ClassMethod hydrate or ObjectPropriety hydrate? [c, o]',
            'co',
            true,
            false,
            false);

        $HydrateStrategy = Char::prompt( 'Do you what to use undescore hydrate strategy o camelcase hydrate strategy? [u, c]',
            'uc',
            true,
            false,
            false);
*/
        $this->getSkeletonService()->generateApplicationConfig($path);
    }

    /**
     * @return bool
     */
    protected function moduleExist()
    {
        // Module exist
        try{
            if ($this->getSkeletonService()->moduleExist()) {
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
        $isFoldersSkeletonCreated =
            ($this->configFolder = $this->getSkeletonService()->generateConfigFolder($path)) &&
            ($this->srcFolder = $this->getSkeletonService()->generateSrcFolder($path)) &&
            ($this->modelFolder = $this->getSkeletonService()->generateModelFolder($path, $this->getEntityService()->getName())) &&
            ($this->entityFolder = $this->getSkeletonService()->generateEntityFolder($path, $this->getEntityService()->getName())) &&
            ($this->hydratorFolder = $this->getSkeletonService()->generateHydratorFolder($path, $this->getEntityService()->getName()));

        if (!$isFoldersSkeletonCreated) {
            // FIXME remove folder
            $this->errorMessage('Error to create folders');
            return false;
        }
        return true;
    }
}