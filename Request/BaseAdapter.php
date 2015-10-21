<?php

namespace MeetMagentoPL\IntegrationAbstraction\Request;


class BaseAdapter extends AdapterAbstract
{
    /**
     * 
     * @return string
     */
    public function getAction()
    {
        return $this->getBaseObject()->getAction();
    }

    /**
     * 
     * @return mixed
     */
    public function getParams()
    {
        return $this->getBaseObject()->getParams();
    }
}