<?php
namespace Matryoshka\Scafolding\Service;

use Zend\Code\Generator\PropertyGenerator;
use Zend\Console\Prompt\Char;
use Zend\Console\Prompt\Line;
use Zend\Console\Prompt\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Entity
 */
class Entity implements EntityInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var bool
     */
    protected $generateTrait = true;

    /**
     * @var bool
     */
    protected $generateInterface = true;

    /**
     * @var array
     */
    protected $proprietyList;

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

    /**
     * @return array
     */
    public function getProprietyList()
    {
        return $this->proprietyList;
    }

    /**
     * @param array $proprietyList
     * @return $this
     */
    public function setProprietyList(array $proprietyList)
    {
        $this->proprietyList = $proprietyList;
        return $this;
    }



    public function generateEntity()
    {
        $useInterfaceForGetterSetter = Char::prompt( 'Do you what to put setter and getter in Interface? [y, n]',
            'yn',
            true,
            false,
            false);

        $this->setGenerateTrait($useInterfaceForGetterSetter == 'y' ? true : false);

        $useTraitForGetterSetter = Char::prompt( 'Do you what to put setter and getter in Trait? [y, n]',
            'yn',
            true,
            false,
            false);

        $this->setGenerateTrait($useTraitForGetterSetter == 'y' ? true : false);

        $addPropriety = Char::prompt( 'Do you what to add propriety? [y, n]', 'yn', true, false, false);
        $list = [];
        while ($addPropriety == 'y') {

            $propriety['const'] = Char::prompt( 'Enter const [y, n]', 'yn', true, false, false);
            $propriety['name'] = Line::prompt('Enter name propriety (max 20):', false, 20);
            $propriety['defaultvalue'] =  Line::prompt('Enter default value (max 20):', false, 20);

            if ($propriety['const'] == 'n') {

                $propriety['visibility'] = Select::prompt(
                    'Enter visibility:',
                    [
                        PropertyGenerator::VISIBILITY_PUBLIC,
                        PropertyGenerator::VISIBILITY_PROTECTED,
                        PropertyGenerator::VISIBILITY_PRIVATE
                    ],
                    false,
                    true
                );
                $propriety['static'] = Char::prompt( 'Enter static [y, n]', 'yn', true, false, false);
                $propriety['abstract'] = Char::prompt( 'Enter abstract [y, n]', 'yn', true, false, false);
            }

            $list[] = $propriety;
            $addPropriety = Char::prompt( 'Do you what to add propriety? [y, n]', 'yn', true, false, false);
        }

        $this->setProprietyList($list);
    }
} 