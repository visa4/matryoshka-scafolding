<?php
namespace Matryoshka\Scafolding\Console;

use Matryoshka\Scafolding\Exception\RuntimeException;
use Matryoshka\Scafolding\Service\EntityInterface;
use Matryoshka\Scafolding\Service\Hydrator\HydratorInterface;
use Matryoshka\Scafolding\Service\ModelInterface;
use Matryoshka\Scafolding\Service\SkeletonInterface;
use Zend\Console\ColorInterface;
use Zend\Mvc\Controller\AbstractConsoleController as Zf2AbstractConsoleController;

/**
 * Class AbstractController
 */
class AbstractConsoleController extends Zf2AbstractConsoleController
{
    /**
     * @var SkeletonInterface
     */
    protected $skeletonService;

    /**
     * @var SkeletonInterface
     */
    protected $entityService;

    /**
     * @var ModelInterface
     */
    protected $modelService;

    /**
     * @var HydratorInterface
     */
    protected $hydratorService;

    /**
     * @param $message
     */
    protected function errorMessage($message)
    {
        $this->getConsole()->setColor(ColorInterface::RED);
        $this->console->writeLine($message);
        $this->getConsole()->setColor(ColorInterface::RESET);
    }


    protected function infoMessage($message)
    {
        $this->getConsole()->setColor(ColorInterface::GREEN);
        $this->console->writeLine($message);
        $this->getConsole()->setColor(ColorInterface::RESET);
    }

    /**
     * @return SkeletonInterface
     */
    public function getSkeletonService()
    {
        if ($this->skeletonService) {
            return $this->skeletonService;
        }

        if ($this->getServiceLocator()->has('Matryoshka\Scafolding\Service\Skeleton')) {
            $this->skeletonService = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Skeleton');
            return $this->skeletonService;
        }

        throw new RuntimeException(
            sprintf('Service %s must be se on service locator', 'Matryoshka\Scafolding\Service\Skeleton')
        );
    }

    /**
     * @return EntityInterface
     */
    public function getEntityService()
    {
        if ($this->entityService) {
            return $this->entityService;
        }

        if ($this->getServiceLocator()->has('Matryoshka\Scafolding\Service\Entity')) {
            $this->entityService = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Entity');
            return $this->entityService;
        }

        throw new RuntimeException(
            sprintf('Service %s must be se on service locator', 'Matryoshka\Scafolding\Service\Entity')
        );
    }

    /**
     * @return EntityInterface
     */
    public function getModelService()
    {
        if ($this->entityService) {
            return $this->modelService;
        }

        if ($this->getServiceLocator()->has('Matryoshka\Scafolding\Service\Model')) {
            $this->modelService = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Model');
            return $this->modelService;
        }

        throw new RuntimeException(
            sprintf('Service %s must be se on service locator', 'Matryoshka\Scafolding\Service\Model')
        );
    }

    /**
     * @return HydratorInterface
     */
    public function getHydratorService()
    {
        if ($this->hydratorService) {
            return $this->hydratorService;
        }

        if ($this->getServiceLocator()->has('Matryoshka\Scafolding\Service\Hydrator\Hydrator')) {
            $this->hydratorService = $this->getServiceLocator()->get('Matryoshka\Scafolding\Service\Hydrator\Hydrator');
            return $this->hydratorService;
        }

        throw new RuntimeException(
            sprintf('Service %s must be se on service locator', 'Matryoshka\Scafolding\Service\Hydrator\Hydrator')
        );
    }
} 