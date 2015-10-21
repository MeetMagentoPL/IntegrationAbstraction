<?php

namespace MeetMagentoPL\IntegrationAbstraction\Response;
/**
 * Description of ProductList
 *
 * @author jakub
 */
class ProductList implements ResponseInterface
{
    /**
     * 
     * @param array $params
     * @return array|mixed
     */    
    public function execute(array $params)
    {
        /** @todo implementation */
        return [['produkt 1', 13.88],['produkt 2', 10.22]];
    }

}
