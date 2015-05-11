<?php
/**
 * Created by visa
 * Date:  30/04/15 15.30
 * Class: Object.php
 */

namespace Matryoshka\Scafolding\Service;

use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Console\Prompt\Char;
use Zend\Console\Prompt\Line;
use Zend\Console\Prompt\Select;

/**
 * Trait ObjectTrait
 */
trait ObjectPromptTrait
{
    /**
     * @return array
     */
    protected function getArrayConstantsFromPrompt()
    {
        $addConstant = Char::prompt( 'Do you what to add constant? [y, n]', 'yn', true, false, false);
        $constants = [];
        while ($addConstant == 'y') {
            // TODO check if already insert a constant with the same name
            $constant['name'] = Line::prompt('Enter name propriety (max 20):', false, 20);
            $constant['defaultvalue'] =  Line::prompt('Enter default value (max 20):', false, 20);
            // Add constants
            $constants[] = $constant;
            $addConstant = Char::prompt( 'Do you what to add constant? [y, n]', 'yn', true, false, false);
        }

        return $constants;
    }

    /**
     * @return array
     */
    protected function getArrayProprietiesFromPrompt()
    {
        $addPropriety = Char::prompt( 'Do you what to add propriety? [y, n]', 'yn', true, false, false);
        $properties = [];
        while ($addPropriety == 'y') {

            $property['name'] = Line::prompt('Enter name propriety (max 20):', false, 20);
            $property['type'] = Line::prompt('Enter type propriety (max 20):', false, 20);
            $property['defaultvalue'] =  Line::prompt('Enter default value (max 20):', true, 20);
            $property['visibility'] = Select::prompt(
                'Enter visibility:',
                [
                    PropertyGenerator::VISIBILITY_PUBLIC,
                    PropertyGenerator::VISIBILITY_PROTECTED,
                    PropertyGenerator::VISIBILITY_PRIVATE
                ],
                false,
                true
            );

            $property['static'] = Char::prompt( 'Enter static [y, n]', 'yn', true, false, false);
            $property['abstract'] = Char::prompt( 'Enter abstract [y, n]', 'yn', true, false, false);
            // Add Properties
            $properties[] = $property;
            $addPropriety = Char::prompt( 'Do you what to add propriety? [y, n]', 'yn', true, false, false);
        }

        return $properties;
    }
}
