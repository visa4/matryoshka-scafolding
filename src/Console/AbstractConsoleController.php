<?php
namespace Matryoshka\Scafolding\Console;

use Zend\Console\ColorInterface;
use Zend\Mvc\Controller\AbstractConsoleController as Zf2AbstractConsoleController;

/**
 * Class AbstractController
 */
class AbstractConsoleController extends Zf2AbstractConsoleController
{
    /**
     * @param $message
     */
    protected function errorMessage($message)
    {
        $this->console->write($message, ColorInterface::RED);
        $this->console->writeLine('', ColorInterface::RESET);
    }


    protected function infoMessage($message)
    {
        $this->console->write($message, ColorInterface::GREEN);
        $this->console->writeLine('', ColorInterface::RESET);
    }
} 