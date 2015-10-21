<?php

namespace MeetMagentoPL\IntegrationAbstraction\Response\Action;
/**
 * Description of ResponseInterface
 *
 * @author jakub
 */
interface ResponseInterface
{
    /**
     * 
     * @param array $params
     */
    public function execute(array $params);
}
