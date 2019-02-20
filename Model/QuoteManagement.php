<?php
/**
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 *
 * @copyright Copyright (c) 2019 ThdSolution
 *
 * @author    Tiago Daniel <tiagohdaniel@gmail.com>
 */

namespace ThdSolution\OrderApi\Model;

class QuoteManagement
{
    /**
     * @var \Magento\Quote\Model\QuoteManagement
     */
    private $_quoteManagement;

    /**
     * @var \Magento\Quote\Model\Quote\ItemFactory
     */
    private $_item;

    /**
     * @var \Magento\Quote\Model\Quote\Item\RepositoryFactory
     */
    private $_itemRepository;

    public function __construct
    (
        \Magento\Quote\Model\QuoteManagementFactory       $quoteManagement,
        \Magento\Quote\Model\Quote\ItemFactory            $item,
        \Magento\Quote\Model\Quote\Item\RepositoryFactory $itemRepository
    )
    {
        $this->_quoteManagement = $quoteManagement;
        $this->_item            = $item;
        $this->_itemRepository  = $itemRepository;
    }

    /**
     * Create empty cart
     *
     * @param $id
     * @return int|mixed
     */
    public function createEmptyCartForCustomer($id)
    {
        /** @var  $quoteManagementFactory */
        $quoteManagementFactory = $this->_quoteManagement->create();
        $quoteId                = $quoteManagementFactory->createEmptyCartForCustomer($id);

        return $quoteId;
    }

    /**
     * Add items to cart
     *
     * @param $items
     * @param $quoteId
     * @return \Magento\Quote\Api\Data\CartItemInterface
     */
    public function addProducts($items, $quoteId)
    {
        /** @var  $itemFactory */
        $itemFactory            = $this->_item->create();

        /** @var  $itemRepositoryFactory */
        $itemRepositoryFactory = $this->_itemRepository->create();

        foreach ($items as $item) {
            $itemFactory->setSku($item["sku"]);
            $itemFactory->setQty($item["qty"]);
            $itemFactory->setQuoteId($quoteId);
            $quoteItemObj = $itemRepositoryFactory->save($itemFactory);
        }

        return $quoteItemObj;
    }

}