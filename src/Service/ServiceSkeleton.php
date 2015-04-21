<?php
namespace Matryoshka\Scafolding\Service;

use Zend\Filter\UpperCaseWords;
use Zend\Filter\Word\CamelCaseToDash;

/**
 * Class GenerateSkeleton
 */
class ServiceSkeleton implements SkeletonInterface
{
    const PREFIX_NAME_PATH = 'Matryoshka%sModule';

    /**
     * @var string
     */
    protected $wrapperNameModule;

    /**
     * @inheritdoc
     */
    public function generateName($nameModule)
    {
        $filter = new UpperCaseWords(); // TODO change with Ucfirst filter
        $filterName =  $filter->filter($nameModule);
        return sprintf($this->getWrapperNameModule(), $filterName);
    }

    /**
     * @inheritdoc
     */
    public function getViewFolder($nameModule)
    {
        $filter = new CamelCaseToDash();
        return strtolower($filter->filter($nameModule));
    }

    /**
     * @return string
     */
    public function getWrapperNameModule()
    {
        if (!$this->wrapperNameModule) {
            $this->wrapperNameModule = self::PREFIX_NAME_PATH;
        }
        return $this->wrapperNameModule;
    }

    /**
     * @param string $wrapperNameModule
     * @return $this
     */
    public function setWrapperNameModule($wrapperNameModule)
    {
        $this->wrapperNameModule = $wrapperNameModule;
        return $this;
    }
} 