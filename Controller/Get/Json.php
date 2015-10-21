<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MeetMagentoPL\IntegrationAbstraction\Controller\Get;

use \Magento\Framework\App\Action\Action;

/**
 * Description of Json
 *
 * @author jakub
 */
class Json extends Action 
{
    /**
     *
     * @var \Magento\Framework\Controller\Result\Json
     */
    protected $resultJson;
    
    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\Json $resultJson
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\Json $resultJson
    ) {
        $this->resultJson = $resultJson;
        parent::__construct($context);
    }
    
    /**
     * 
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $response = (array) $this->getResult();
        return $this->resultJson->setData($response);
    }
    
    /**
     * 
     * @return array
     */
    protected function getResult() 
    {
        $token = $this->getRequest()->getParam('token');
        return ['success' => true];
    }
}
