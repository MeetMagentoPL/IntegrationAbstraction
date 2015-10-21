<?php

namespace MeetMagentoPL\IntegrationManager\Model;

use \MeetMagentoPL\IntegrationAbstraction\Exception;

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
     * @var \MeetMagentoPL\IntegrationAbstraction\Adapter\RequestFactory
     */
    protected $adapterRequestFactory;

    /**
     *
     * @var type 
     */
    protected $abstractStructure;

    /**
     * 
     * @param \MeetMagentoPL\IntegrationAbstraction\Request\EntityFactory $requestEntityFactory
     * @param \MeetMagentoPL\IntegrationAbstraction\Adapter\RequestFactory $adapterRequestFactory
     */
    protected function __construct(
        \MeetMagentoPL\IntegrationAbstraction\Request\EntityFactory $requestEntityFactory, 
        \MeetMagentoPL\IntegrationAbstraction\Adapter\RequestFactory $adapterRequestFactory
    )
    {
        $this->requestEntityFactory = $requestEntityFactory;
        $this->adapterRequestFactory = $adapterRequestFactory;
    }

    /**
     * 
     * @param array|mixed $data
     * @return array
     * @throws Exception\NotExistingEntryPointException
     */
    public function getResponseData($data)
    {
        $this->doThings((array) $data);

        $action = $this->abstractStructure->getAction();
        $params = $this->abstractStructure->getParams();
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
     */
    protected function doThings(array $requestData)
    {
        $requestEntity = $this->requestEntityFactory->create();
        $requestEntity->setData($requestData);

        $adapter = $this->adapterRequestFactory->create();
        $adapter->setBaseObject($requestEntity);

        $abstractStructure = $adapter->getAbstractStructure();

        $abstractStructure->validate();
        if (!$abstractStructure->hasAction()) {
            $msg = 'Empty action';
            throw new Exception\NotExistingEntryPointException($msg);
        }

        $this->abstractStructure = $abstractStructure;
    }

    /**
     * Returns product list.
     * 
     * @param array $params
     * @return array
     */
    public function getProductList($params = array())
    {
        return; // products array
    }

}
