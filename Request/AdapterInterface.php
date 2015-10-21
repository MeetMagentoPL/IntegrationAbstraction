<?php

namespace MeetMagentoPL\IntegrationAbstraction\Request;

use MeetMagentoPL\IntegrationAbstraction\Model\AbstractStructure;

interface AdapterInterface
{
    public function setBaseObject(Entity $baseObject);

    /**
     * @return AbstractStructure
     */
    public function getAbstractStructure();
}