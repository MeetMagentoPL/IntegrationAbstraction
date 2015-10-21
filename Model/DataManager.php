<?php

namespace MeetMagentoPL\IntegrationAbstraction\Model;

use \MeetMagentoPL\IntegrationAbstraction\Exception;
use \MeetMagentoPL\IntegrationAbstraction\Request\AdapterAbstract;
use \MeetMagentoPL\IntegrationAbstraction\Response\Action\ResponseInterface;

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
    public function __construct(
        \MeetMagentoPL\IntegrationAbstraction\Request\EntityFactory $requestEntityFactory,
        \Magento\Framework\ObjectManager\ObjectManager $objectManager
    ) {
        $this->requestEntityFactory = $requestEntityFactory;
        $this->objectManager = $objectManager;
    }

    /**
     * @param $data
     * @return mixed
     * @throws Exception\NotExistingEntryPointException
     * @throws Exception\WrongTypeOfObjectException
     */
    public function getResponseData($data)
    {
        $abstractStructure = $this->rawDataToAbstractStructure((array) $data);

        $action = $abstractStructure->getAction();
        $params = $abstractStructure->getParams();
        $actionMap = $this->getActionMap();

        if (!isset($actionMap[$action])) {
            $msg = sprintf('Action "%s" doesn\'t exists.', $action);
            throw new Exception\NotExistingEntryPointException($msg);
        }
        
        $actionObject = $this->objectManager->create($actionMap[$action]);
        if (!is_object($actionObject) || !($actionObject instanceof ResponseInterface)) {
            $msg = sprintf('Action class must be an instance of %s', ResponseInterface::class);
            throw new Exception\WrongTypeOfObjectException($msg);
        }

        return $actionObject->execute($params);
    }
    
    /**
     * Temporary solution.
     * 
     * @return array
     */
    protected function getActionMap()
    {
        return [
            'product' => 'MeetMagentoPL\IntegrationAbstraction\Response\Action\Product',
            'product-list' => 'MeetMagentoPL\IntegrationAbstraction\Response\Action\ProductList',
        ];
    }

    /**
     * Returns AbstractStructure from array.
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
                'MeetMagentoPL\IntegrationAbstraction\Request\BaseAdapter'
            );
        }

        return $this->adapterRequest;
    }

}
