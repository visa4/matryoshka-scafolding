<?php
namespace Matryoshka\Scafolding\Service;

use Zend\Code\Generator\PropertyGenerator;
use Zend\Console\Prompt\Char;
use Zend\Console\Prompt\Select;

/**
 * Class Entity
 */
class Entity implements EntityInterface
{
    /**
     * @var bool
     */
    protected $generateTrait = true;

    /**
     * @var bool
     */
    protected $generateInterface = true;

    /**
     * @return boolean
     */
    public function isGenerateInterface()
    {
        return $this->generateInterface;
    }

    /**
     * @param boolean $generateInterface
     * @return $this
     */
    public function setGenerateInterface($generateInterface)
    {
        $this->generateInterface = $generateInterface;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isGenerateTrait()
    {
        return $this->generateTrait;
    }

    /**
     * @param boolean $generateTrait
     * @return $this
     */
    public function setGenerateTrait($generateTrait)
    {
        $this->generateTrait = $generateTrait;
        return $this;
    }

    public function generateEntity()
    {
        $useInterfaceForGetterSetter = Char::prompt( 'Do you what to put setter and getter in Interface? [y, n]',
            'yn',
            true,
            false,
            false);

        $this->setGenerateTrait($useInterfaceForGetterSetter = 'y' ? true : false);

        $useTraitForGetterSetter = Char::prompt( 'Do you what to put setter and getter in Trait? [y, n]',
            'yn',
            true,
            false,
            false);

        $this->setGenerateTrait($useTraitForGetterSetter = 'y' ? true : false);

        $addPropriety = Char::prompt( 'Do you what to add propriety? [y, n]', 'yn', true, false, false);
        $list = [];
        while ($addPropriety == 'y') {

            $propriety['name'] = Line::prompt('Enter name propriety (max 20):', false, 20);
            $propriety['const'] = Char::prompt( 'Enter const [y, n]', 'yn', true, false, false);
            $propriety['defaultvalue'] =  Line::prompt('Enter default value (max 20):', false, 20);

            if ($propriety['const'] == 'n') {

                $propriety['visibility'] = Select::prompt(
                    'Enter visibility:',
                    [PropertyGenerator::FLAG_PUBLIC, PropertyGenerator::FLAG_PROTECTED, PropertyGenerator::FLAG_PRIVATE],
                    false,
                    true
                );
                $propriety['static'] = Char::prompt( 'Enter static [y, n]', 'yn', true, false, false);
                $propriety['abstract'] = Char::prompt( 'Enter abstract [y, n]', 'yn', true, false, false);
            }

            $list[] = $propriety;
            $addPropriety = Char::prompt( 'Do you what to add propriety? [y, n]', 'yn', true, false, false);
        }

        var_dump($this);
        var_dump($list);
        die();

    }
} 