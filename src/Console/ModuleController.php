<?php
namespace Matryoshka\Scafolding\Console;

use Matryoshka\Scafolding\Service\SkeletonInterface;
use Zend\Console\ColorInterface;
use Zend\Console\Prompt\Char;
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
        $skeleton = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Skeleton');
        $moduleName = $skeleton->getModuleName();

        if ($this->isZf2Application($path)) {
            $this->errorMessage(sprintf('Path %s not contain a ZF2 application', $path));
            return 0;
        }

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

        $isFoldersSkeletonCreated = $skeleton->generateConfigFolder($path) &&
            $skeleton->generateSrcFolder($path)
        ;

        if (!$isFoldersSkeletonCreated) {
            // TODO remove folder
            $this->errorMessage('');
        } elseif ($verbose) {
            $this->infoMessage('Folders created');
        }

        $skeleton->generateModuleClass($path);
        if ($verbose) {
            $this->infoMessage('Modele.php created');
        }

        $propriety = Char::prompt( 'Do you what to add propriety? [y, n]',
            'yn',
            true,
            false,
            false);
var_dump($propriety); die();
//        while () {

  //      }


        $useInterfaceForGetterSetter = Char::prompt( 'Do you what to put setter and getter in Interface? [y, n]',
            'yn',
            true,
            false,
            false);

        $useTraitForGetterSetter = Char::prompt( 'Do you what to put setter and getter in Trait? [y, n]',
            'yn',
            true,
            false,
            false);

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

        $skeleton->generateApplicationConfig($path);
    }

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