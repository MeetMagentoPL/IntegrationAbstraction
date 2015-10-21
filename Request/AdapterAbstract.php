<?php

namespace MeetMagentoPL\IntegrationAbstraction\Request;

use MeetMagentoPL\IntegrationAbstraction\Model\AbstractStructure;

abstract class AdapterAbstract implements AdapterInterface
{
    /**
     * @var Entity
     */
    protected $baseObject;

    /**
     * @var AbstractStructureFactory
     */
    protected $abstractStructureFactory;

    public function __construct(
        AbstractStructureFactory $abstractStructureFactory
    )
    {
        $this->abstractStructureFactory = $abstractStructureFactory;
    }

    abstract public function getAction();

    abstract public function getParams();

    final public function setBaseObject(Entity $object)
    {
        $this->baseObject = $object;
    }

    /**
     * @return AbstractStructure
     */
    final public function getAbstractStructure()
    {
        $abstractStructure = $this->abstractStructureFactory->create();

        $abstractStructure->setAction($this->getAction());

        $abstractStructure->setParams($this->getParams());

        $abstractStructure->validate();

        return $abstractStructure;
    }
}