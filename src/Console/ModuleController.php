<?php
namespace Matryoshka\Scafolding\Console;

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
        $skeleton = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Skeleton');
        $moduleName = $skeleton->getModuleName();

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

        $listPropriety = $this->addPropriety();
        var_dump($listPropriety);
        die();

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

    /**
     * @return array
     */
    protected function getProprietyList()
    {
        $addPropriety = Char::prompt( 'Do you what to add propriety? [y, n]', 'yn', true, false, false);
        $list = [];
        while ($addPropriety == 'y') {

            $propriety['name'] = Line::prompt('Enter name propriety (max 20):', false, 20);
            $propriety['const'] = Char::prompt( 'Enter abstract [y, n]', 'yn', true, false, false);
            $propriety['defaultvalue'] = Char::prompt( 'Enter abstract [y, n]', 'yn', true, false, false);

            if ($propriety['const'] == 'n') {

                $propriety['visibility'] = Select::prompt(
                    'Enter visibility:',
                    [PropertyGenerator::FLAG_PUBLIC, PropertyGenerator::FLAG_PROTECTED, PropertyGenerator::FLAG_PRIVATE],
                    false,
                    true
                );
                $propriety['static'] = Char::prompt( 'Enter static [y, n]', 'yn', true, false, false);
                $propriety['abstract'] = Char::prompt( 'Enter abstract [y, n]', 'yn', true, false, false);
            }

            $list[] = $propriety;
            $addPropriety = Char::prompt( 'Do you what to add propriety? [y, n]', 'yn', true, false, false);
        }

        return $list;
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