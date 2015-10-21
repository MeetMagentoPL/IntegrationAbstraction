<?php

namespace MeetMagentoPL\IntegrationAbstraction\Response\Action;
/**
 * Description of ProductList
 *
 * @author jakub
 */
class ProductList implements ResponseInterface
{
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder

    )
    {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * 
     * @param array $params
     * @return array|mixed
     */    
    public function execute(array $params)
    {

        $searchCriteria = $this->searchCriteriaBuilder->create();

        $productList = $this->productRepository->getList($searchCriteria);

        foreach($productList->getItems() as $product) {
            
        }

        /** @todo implementation */
        return [['produkt 1', 13.88],['produkt 2', 10.22]];
    }

}
