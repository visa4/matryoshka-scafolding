<?php
namespace Matryoshka\Scafolding\Console;

use Matryoshka\Scafolding\Service\SkeletonInterface;
use Zend\Console\ColorInterface;
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
            $this->console->write('Create skeleton', ColorInterface::GREEN);
            $this->console->writeLine('', ColorInterface::RESET);
        }

        /* @var $serviceSkeleton SkeletonInterface */
        $serviceSkeleton = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\ServiceSkeleton');
        $moduleName = $serviceSkeleton->generateName($name);
        $viewFolder = $serviceSkeleton->getViewFolder($moduleName);

        if (!file_exists("$path/module") || !file_exists("$path/config/application.config.php")) {
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
            $this->errorMessage(sprintf('Module %s already exist', $name));
            return 0;
        }


        mkdir("$path/module/$moduleName/config", 0777, true);
        mkdir("$path/module/$moduleName/src/Controller", 0777, true);
        mkdir("$path/module/$moduleName/view/$viewFolder", 0777, true);


    }

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

    protected function createConfigFolder()
    {

    }
}