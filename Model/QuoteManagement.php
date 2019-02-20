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

    public function __construct
    (
        \Magento\Quote\Model\QuoteManagementFactory $quoteManagement
    )
    {
        $this->_quoteManagement = $quoteManagement;
    }

    public function createEmptyCartForCustomer($id)
    {
        /** @var  $quoteManagementFactory */
        $quoteManagementFactory = $this->_quoteManagement->create();
        $quoteId                = $quoteManagementFactory->createEmptyCartForCustomer($id);

        return $quoteId;
    }

}