<?php
namespace Matryoshka\Scafolding\Service\Config;

use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Config
 */
class ConfigFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $configService = new Config();

        if (!$serviceLocator->has('Matryoshka\Scafolding\Service\Entity') ||
            !$serviceLocator->has('Matryoshka\Scafolding\Service\Hydrator\Hydrator')) {
            throw new ServiceNotCreatedException(
                sprintf(
                    'Services %s and %s must be set in service locator',
                    'Matryoshka\Scafolding\Service\Entity',
                    'Matryoshka\Scafolding\Service\Hydrator\Hydrator'
                )
            );
        }

        return $configService->setObjectService($serviceLocator->get('Matryoshka\Scafolding\Service\Entity'))
            ->setHydratorService($serviceLocator->get('Matryoshka\Scafolding\Service\Hydrator\Hydrator'));
    }
} 