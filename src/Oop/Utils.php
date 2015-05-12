<?php
namespace Matryoshka\Scafolding\Oop;

use Matryoshka\Scafolding\Exception\RuntimeException;
use Matryoshka\Scafolding\Filter\LcFirst;
use Matryoshka\Scafolding\Filter\UcFirst;
use Matryoshka\Scafolding\Service\Hydrator\HydratorInterface;
use Matryoshka\Scafolding\Service\ObjectInterface;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToUpper;
use Zend\Filter\UpperCaseWords;
use Zend\Filter\Word\SeparatorToSeparator;

/**
 * Class Utils
 */
class Utils
{
    /**
     * @var string
     */
    static public $bodyTemplateSet =  '$this->%s = $%s; return $this;'; // TODO how to add new line

    /**
     * @var string
     */
    static public $bodyTemplateGet = 'return $this->%s;';

    /**
     * @param $name
     * @param $type
     * @param bool $phpSuffix
     * @return string
     */
    static public function buildName($name, $type, $phpSuffix = false)
    {
        if (!is_string($type)) {
            throw new RuntimeException(
                sprintf(
                    'Invalid type parameter: %s',
                    is_object($type) ? get_class($type) : gettype($type)
                )
            );
        }

        switch ($type) {
            case ObjectInterface::TRAIT_SUFFIX:
                break;
            case ObjectInterface::INTERFACE_SUFFIX:
                break;
            case ObjectInterface::OBJECT_CLASS_SUFFIX:
                break;
            case HydratorInterface::OBJECT_CLASS_SUFFIX:
                break;
            default:
                throw new RuntimeException(sprintf('Invalid string type given: %s', $type));
        }
        return sprintf(
            '%s%s%s',
            $name,
            $type,
            $phpSuffix ? ObjectInterface::PHP_SUFFIX : ''
        );
    }

    /**
     * @param array $parts
     * @return string
     */
    static public function generateNameSpace(array $parts)
    {
        $nameSpace = '';
        foreach ($parts as $part) {
            if ($nameSpace == '') {
                $nameSpace = $part;
            } else {
                $nameSpace .=  '\\' . $part;
            }
        }
        return $nameSpace;
    }

    /**
     * @param $name
     * @return string
     */
    static public function generateNameConstant($name)
    {
        // Filters
        $toUpperFilter = new StringToUpper();
        $underscoreFilter = new SeparatorToSeparator(' ', '_');
        // Filter chain
        $filterChain = new FilterChain();
        $filterChain->attach($toUpperFilter);
        $filterChain->attach($underscoreFilter);

        $name  = $filterChain->filter($name);

        return $name;
    }

    /**
     * @param $name
     * @return string
     */
    static public function generateNameProperty($name)
    {
        // Filters
        $toUpperWordFilter = new UpperCaseWords();
        $underscoreFilter = new SeparatorToSeparator(' ', '');
        $lcFirstFilter = new LcFirst();
        // Filter chain
        $filterChain = new FilterChain();
        $filterChain->attach($toUpperWordFilter);
        $filterChain->attach($underscoreFilter);
        $filterChain->attach($lcFirstFilter);

        $name  = $filterChain->filter($name);

        return $name;
    }

    /**
     * @param $name
     * @return string
     */
    static  public function generateNameVariable($name)
    {
        $name = Utils::generateNameProperty($name);
        return '$' . $name;
    }

    /**
     * @param $name
     * @param null $type
     * @return string
     */
    static public function generateNameMethod($name, $type = null)
    {
        $name = Utils::generateNameProperty($name);
        if ($type == ObjectInterface::GET_METHOD || $type == ObjectInterface::SET_METHOD) {
            $ucFirstFilter = new UcFirst();
            $name = $type . $ucFirstFilter->filter($name);
        }
        return $name;
    }

    /**
     * @param array $constant
     * @return PropertyGenerator
     */
    public static function createConstantFromArray(array $constant)
    {
        // TODO check format

        $constantClass = new PropertyGenerator(
            Utils::generateNameConstant($constant['name']),
            $constant['defaultvalue']
        );

        $constantClass->setConst(true);

        return $constantClass;
    }


    /**
     * @param array $property
     * @return PropertyGenerator
     */
    public static function createPropertyFromArray(array $property)
    {
        // TODO check format array $name, $type, $defaultvalue

        $propertyClass = new PropertyGenerator(
            Utils::generateNameProperty($property['name']),
            empty($property['defaultvalue']) ? null : $property['defaultvalue'],
            $property['visibility']
        );

        $docBlock = DocBlockGenerator::fromArray(
            [
                'tags' => [
                    ['name' => 'var', 'content' => $property['type']],
                ]
            ]
        );
        $propertyClass->setDocBlock($docBlock);

        return $propertyClass;
    }

    /**
     * @param array $property
     * @return array[MethodGenerator]
     */
    public static function createSetterGetterFromArray(array $property)
    {
        $return = [];
        // FIXME check format array $name, $type

        $nameProperty = Utils::generateNameProperty($property['name']);

        $getMethodClass = new MethodGenerator(
            Utils::generateNameMethod($property['name'], ObjectInterface::GET_METHOD)
        );
        // Body method
        $getMethodClass->setBody(sprintf(Utils::$bodyTemplateGet, $nameProperty));
        // Doc block
        $docBlock = DocBlockGenerator::fromArray(
            [
                'tags' => [
                    ['name' => 'return', 'content' => $property['type']],
                ]
            ]
        );
        $getMethodClass->setDocBlock($docBlock);
        $return[$getMethodClass->getName()] = $getMethodClass;

        $setMethodClass = new MethodGenerator(
            Utils::generateNameMethod($property['name'], ObjectInterface::SET_METHOD),
            [$nameProperty]
        );
        // Body method
        $setMethodClass->setBody(sprintf(Utils::$bodyTemplateSet, $nameProperty, $nameProperty));
        // Doc block
        $docBlock = DocBlockGenerator::fromArray(
            [
                'tags' => [
                    ['name' => 'param', 'content' => '$' . $nameProperty],
                    ['name' => 'return', 'content' => '$this'],
                ]
            ]
        );
        $setMethodClass->setDocBlock($docBlock);
        $return[$setMethodClass->getName()] = $setMethodClass;
        return $return;
    }
}
