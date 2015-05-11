<?php
namespace Matryoshka\Scafolding\Filter;

use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;

/**
 * Class UcFirst
 */
class UcFirst extends AbstractFilter
{
    /**
     * @inheritdoc
     */
    public function filter($value)
    {
        // TODO controll in is string
        return ucfirst($value);
    }
}
