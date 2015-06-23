<?php
namespace Matryoshka\Scafolding\Service\Hydrator;

use Matryoshka\Scafolding\Oop\ResourceTrait;
use Matryoshka\Scafolding\Oop\Utils;
use Matryoshka\Scafolding\Service\ObjectAwareTrait;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\FileGenerator;

/**
 * Class Hydrator
 */
class Hydrator implements HydratorInterface
{
    use ResourceTrait;
    use ObjectAwareTrait;

    /**
     * @var ClassGenerator
     */
    protected $hydrator;

    /**
     * @inheritdoc
     */
    public function settingFromPrompt()
    {

    }

    /**
     * @inheritdoc
     */
    public function generate($path)
    {
        $this->hydrator = new ClassGenerator();
        $this->hydrator->setNamespaceName($this->getNameSpace());

        if ($this->objectService->isGenerateSetterGetter()) {
            $this->hydrator->addUse('Matryoshka\Model\Hydrator\ClassMethods');
            $this->hydrator->setExtendedClass('ClassMethods');
        } else {
            $this->hydrator->addUse('Zend\Stdlib\Hydrator\ObjectProperty');
            $this->hydrator->setExtendedClass('ObjectProperty');
        }

        $this->hydrator->setName(Utils::buildName($this->getName(), HydratorInterface::OBJECT_CLASS_SUFFIX));

        // TODO add strategy
        $file = new FileGenerator();
        $file->setClass($this->hydrator);

        $path = $path . '/' . Utils::buildName($this->getName(), HydratorInterface::OBJECT_CLASS_SUFFIX, true);
        return file_put_contents($path, $file->generate());
    }

    /**
     * @return string
     */
    public function getFullQualifiedClassName()
    {
        return $this->getNameSpace() . '\\' . $this->hydrator->getName();
    }
}