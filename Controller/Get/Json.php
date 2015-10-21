<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MeetMagentoPL\IntegrationAbstraction\Controller\Get;

use \Magento\Framework\App\Action\Action;
use \MeetMagentoPL\IntegrationAbstraction\Exception;


/**
 * Description of Json
 *
 * @author jakub
 */
class Json extends Action 
{
    /**
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    
    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\Json $resultJsonFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }
    
    /**
     * 
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $response = (array) $this->getResult();
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
    
    /**
     * 
     * @return array
     */
    protected function getResult() 
    {
        $result = [];
        $params = $this->_request->getParams();
        
        try {
            $dataManager = $this->_objectManager->get(
                    'MeetMagentoPL\IntegrationAbstraction\Model\DataManager'
                );
            $result = $dataManager->getResponseData($params);
        } catch (Exception\GenericIntegrationAbstractionException $exception) {
            $result['error'] = $exception->getMessage();
        } catch (\Exception $exception) {
            $result['error'] = $exception->getMessage();
        } finally {
            return $result;
        }
    }
}
