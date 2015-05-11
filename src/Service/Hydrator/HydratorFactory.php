<?php
namespace Matryoshka\Scafolding\Service\Hydrator;

use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class HydratorFactory
 */
class HydratorFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydratorService = new Hydrator();

        if (!$serviceLocator->has('Matryoshka\Scafolding\Service\Entity')) {
            throw new ServiceNotCreatedException(
                sprintf('Service %s must be set in service locator', 'Matryoshka\Scafolding\Service\Entity')
            );
        }
        return $hydratorService->setObjectService($serviceLocator->get('Matryoshka\Scafolding\Service\Entity'));
    }
}
