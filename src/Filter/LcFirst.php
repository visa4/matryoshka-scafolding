<?php
namespace Matryoshka\Scafolding\Filter;

use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;

/**
 * Class LcFirst
 */
class LcFirst extends AbstractFilter
{
    /**
     * @inheritdoc
     */
    public function filter($value)
    {
        // TODO controll in is string
        return lcfirst($value);
    }
}
