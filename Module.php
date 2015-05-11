<?php
namespace Matryoshka\Scafolding;

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\InputFilterProviderInterface;

class Module implements InputFilterProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/',
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * {@inheritdoc}
     */
    public function getConsoleUsage(AdapterInterface $console)
    {
        return [
            'Scafolding usage:',
            'create module [--verbose|-v] <name>' =>  'Create a new matryoshka model module'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getInputFilterConfig()
    {
        return include __DIR__ . '/config/filter.config.php';
    }
} 