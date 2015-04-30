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

        // Log
        ($verbose) ? $this->infoMessage('Start create skeleton') : '';

        /* @var $skeletonService SkeletonInterface */
        $skeletonService = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Skeleton');
        /* @var $entityService EntityInterface */
        $entityService = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Entity');

        if ($skeletonService->isZf2Application($path)) {
            $this->errorMessage(sprintf('Path %s not contain a ZF2 application', $path));
            return 0;
        }
        // Module exist
        try{
            if ($skeletonService->moduleExist()) {
                $this->errorMessage('Impossible create folders skeleton, please control permission');
                return 0;
            }
        } catch(\Exception $e) {
            $this->errorMessage($e->getMessage());
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
        // Log
        ($verbose) ? $this->infoMessage('Modele.php created') : '';

        $this->console->setColor(ColorInterface::BLUE);
        $entityService->generateEntity();
        $this->console->setColor(ColorInterface::RESET);
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
        $skeletonService->generateApplicationConfig($path);
    }
}