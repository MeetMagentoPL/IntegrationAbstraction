<?php

namespace MeetMagentoPL\IntegrationAbstraction\Model;

use Magento\Framework\DataObject;
use MeetMagentoPL\IntegrationAbstraction\Exception\NoActionSetInDataStructureException;

class AbstractStructure extends DataObject
{

    public function validate()
    {
        if (!$this->getAction()) {
            $msg = 'No action set in request data structure';
            throw new NoActionSetInDataStructureException($msg);
        }
    }
}