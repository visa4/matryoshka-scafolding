<?php
namespace Matryoshka\Scafolding\Console;

use Matryoshka\Scafolding\Service\GenerateSkeleton;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Console\ColorInterface;
use Zend\Mvc\Controller\AbstractConsoleController;

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
        $rootPath = $request->getParam('rootPath');


        if ($verbose) {
            $this->console->write('Create skeleton', ColorInterface::GREEN);
            $this->console->writeLine('', ColorInterface::RESET);
        }

        $generateSkeleton = new GenerateSkeleton();
        $generateSkeleton->generate($name, $rootPath);

        /*
        $dataPath = realpath(__DIR__ . '/../../data');
        $arrayConfig = include realpath(__DIR__ . '/../../config/user.php');  // TODO recuperare da fuori
        var_dump($arrayConfig);

        $entityConfig = $arrayConfig['entity'];
        $obj = new ClassGenerator(ucfirst($arrayConfig['name']) . 'Entity');
        $file = new FileGenerator();

        $file->setClass($obj);

        file_put_contents($dataPath . '/UserEntity.php' , $file->generate());
        */

    }


} 