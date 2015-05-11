<?php
/**
 * Created by visa
 * Date:  11/05/15 13.19
 * Class: ResourceInterface.php
 */

namespace Matryoshka\Scafolding\Oop;

/***
 * Interface ResourceInterface
 */
interface ResourceInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getNameSpace();

    /**
     * @param string $nameSpace
     * @return $this
     */
    public function setNameSpace($nameSpace);
}
