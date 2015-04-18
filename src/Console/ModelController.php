<?php
namespace Matryoshka\Scafolding\Console;

use Zend\Console\ColorInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

/**
 * Class ModelController
 */
class ModelController extends AbstractConsoleController
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

        $generateSkeleton = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\ServiceSkeleton');
        $generatedName = $generateSkeleton->generateName($name);

        if (!file_exists("$path/module") || !file_exists("$path/config/application.config.php")) {
            $this->errorMessage(sprintf('Path %s not contain a ZF2 application', $path));
            return 0;
        }

        try{
            $moduleExist = $this->moduleExist($generatedName);
        } catch(\Exception $e) {
            $this->errorMessage($e->getMessage());
            return 0;
        }

        if ($moduleExist) {
            $this->errorMessage(sprintf('Module %s already exist', $name));
            return 0;
        }

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
}