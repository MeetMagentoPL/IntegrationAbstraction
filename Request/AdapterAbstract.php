<?php

namespace MeetMagentoPL\IntegrationAbstraction\Request;

use MeetMagentoPL\IntegrationAbstraction\Exception;

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

    /**
     * @param \MeetMagentoPL\IntegrationAbstraction\Model\AbstractStructureFactory $abstractStructureFactory
     */
    public function __construct(
        \MeetMagentoPL\IntegrationAbstraction\Model\AbstractStructureFactory $abstractStructureFactory
    ) {
        $this->abstractStructureFactory = $abstractStructureFactory;
    }

    /**
     * Returns action field value for abstract structure.
     */
    abstract public function getAction();

    /**
     * Returns params field value for abstract structure.
     */
    abstract public function getParams();

    /**
     * 
     * @param \MeetMagentoPL\IntegrationAbstraction\Request\Entity $object
     */
    public function setBaseObject(Entity $object)
    {
        $this->baseObject = $object;
    }
    
    /**
     * 
     * @return Entity
     */
    public function getBaseObject()
    {
        return $this->baseObject;
    }

    /**
     * @return mixed
     * @throws Exception\BaseObjectNotSetException
     */
    final public function getAbstractStructure()
    {
        if (is_null($this->baseObject)) {
            $msg = 'Base object was\'t initialized.';
            throw new Exception\BaseObjectNotSetException($msg);
        }
        
        $abstractStructure = $this->abstractStructureFactory->create();

        $abstractStructure->setAction($this->getAction());

        $abstractStructure->setParams($this->getParams());

        $abstractStructure->validate();

        return $abstractStructure;
    }
}