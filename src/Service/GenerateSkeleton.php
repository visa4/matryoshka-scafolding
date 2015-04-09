<?php
namespace Matryoshka\Scafolding\Service;

use Zend\Filter\UpperCaseWords;

/**
 * Class GenerateSkeleton
 */
class GenerateSkeleton
{
    const PREFIX_NAME_PATH = 'Matryoshka%sModule';

    /**
     * @var string
     */
    protected $wrapperNameModule;


    public function generate($name, $path = '.')
    {
        $nameSpace = $this->generateNameSpaceModule($name);
    }

    /**
     * @param $name
     * @return string
     */
    public function generateNameSpaceModule($name)
    {
        $filter = new UpperCaseWords(); // TODO change with Ucfirst filter
        $filterName =  $filter->filter($name);
        return sprintf($this->getWrapperNameModule(), $filterName);
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