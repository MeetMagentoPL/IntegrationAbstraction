<?php

namespace MeetMagentoPL\IntegrationManager\Model;

use \MeetMagentoPL\IntegrationAbstraction\Exception;
use \MeetMagentoPL\IntegrationAbstraction\Request\AdapterAbstract;

/**
 * Description of DataManager
 *
 * @author jakub
 */
class DataManager
{

    /**
     *
     * @var \MeetMagentoPL\IntegrationAbstraction\Request\EntityFactory
     */
    protected $requestEntityFactory;

    /**
     *
     * @var \Magento\Framework\ObjectManager\ObjectManager
     */
    protected $objectManager;

    /**
     *
     * @var AdapterAbstract
     */
    protected $adapterRequest;

    /**
     * 
     * @param \MeetMagentoPL\IntegrationAbstraction\Request\EntityFactory $requestEntityFactory
     */
    protected function __construct(
        \MeetMagentoPL\IntegrationAbstraction\Request\EntityFactory $requestEntityFactory,
        \Magento\Framework\ObjectManager\ObjectManager $objectManager
    ) {
        $this->requestEntityFactory = $requestEntityFactory;
        $this->objectManager = $objectManager;
    }

    /**
     * 
     * @param array|mixed $data
     * @return array
     * @throws Exception\NotExistingEntryPointException
     */
    public function getResponseData($data)
    {
        $abstractStructure = $this->rawDataToAbstractStructure((array) $data);

        $action = $abstractStructure->getAction();
        $params = $abstractStructure->getParams();
        $method = 'get' . $action;

        if (!method_exists($this, $method)) {
            $msg = sprintf('Action "%s" doesn\'t exists.', $action);
            throw new Exception\NotExistingEntryPointException($msg);
        }

        return $this->$method($params);
    }

    /**
     * Does the magic.
     * 
     * @param array $requestData
     * @throws Exception\NotExistingEntryPointException
     * @return \MeetMagentoPL\IntegrationAbstraction\Model\AbstractStructure
     */
    protected function rawDataToAbstractStructure(array $requestData)
    {
        $requestEntity = $this->requestEntityFactory->create();
        $requestEntity->setData($requestData);

        $this->getAdapter()->setBaseObject($requestEntity);

        return $this->getAdapter()->getAbstractStructure();
    }
    
    /**
     * 
     * @param AdapterAbstract $adapterRequest
     */
    public function setAdapter(AdapterAbstract $adapterRequest)
    {
        $this->adapterRequest = $adapterRequest;
    }
    
    /**
     * 
     * @return AdapterAbstract
     */
    public function getAdapter()
    {
        if (is_null($this->adapterRequest)) {
            $this->adapterRequest = $this->objectManager->create(
                    ''
                    );
        }
        
        return $this->adapterRequest;
    }

}
