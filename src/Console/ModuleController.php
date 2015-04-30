<?php
namespace Matryoshka\Scafolding\Console;

use Matryoshka\Scafolding\Service\EntityInterface;
use Matryoshka\Scafolding\Service\SkeletonInterface;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Console\ColorInterface;
use Zend\Console\Prompt\Char;
use Zend\Console\Prompt\Line;
use Zend\Console\Prompt\Select;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

/**
 * Class ModelController
 */
class ModuleController extends AbstractConsoleController
{
    public function createModuleAction()
    {
        $request = $this->getRequest();
        // To output detail to console
        $verbose = $request->getParam('verbose') || $request->getParam('v');
        $name = $request->getParam('name');
        $path = $request->getParam('path', '.');

        if ($verbose) {
            $this->infoMessage('Start create skeleton');
        }

        /* @var $skeleton SkeletonInterface */
        $skeletonService = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Skeleton');
        /* @var $entityService EntityInterface */
        $entityService = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Entity');

        $moduleName = $skeletonService->getModuleName();

        if ($this->isZf2Application($path)) {
            $this->errorMessage(sprintf('Path %s not contain a ZF2 application', $path));
            return 0;
        }
        // Module exist
        try{
            $moduleExist = $this->moduleExist($moduleName);
        } catch(\Exception $e) {
            $this->errorMessage($e->getMessage());
            return 0;
        }

        if ($moduleExist) {
            $this->errorMessage('Impossible create folders skeleton, please control permission');
            return 0;
        }

        // Create folder
        $isFoldersSkeletonCreated = $skeletonService->generateConfigFolder($path) &&
            $skeletonService->generateSrcFolder($path)
        ;

        if (!$isFoldersSkeletonCreated) {
            // TODO remove folder
            $this->errorMessage('');
        } elseif ($verbose) {
            $this->infoMessage('Folders created');
        }

        $skeletonService->generateModuleClass($path);
        if ($verbose) {
            $this->infoMessage('Modele.php created');
        }

        $entityService->generateEntity();

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
        $skeleton->generateApplicationConfig($path);
    }

    /**
     * @param $path
     * @return bool
     */
    protected function isZf2Application($path)
    {
        return !file_exists($path . "/module") || !file_exists($path . "/config/application.config.php");
    }

    /**
     * @param $name
     * @return bool
     */
    protected function moduleExist($name)
    {
        $sm = $this->getServiceLocator();
        try{
            /* @var $mm \Zend\ModuleManager\ModuleManager */
            $mm = $sm->get('modulemanager');
        } catch(ServiceNotFoundException $e) {
            throw new \RuntimeException('Cannot get Zend\ModuleManager\ModuleManager instance');
        }

        $moduleName = $mm->getModule($name);
        if ($moduleName) {
            return true;
        }
        return false;
    }
}