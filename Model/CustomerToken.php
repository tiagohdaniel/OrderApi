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

class CustomerToken
{
    /**
     * @var \Magento\Integration\Model\CustomerTokenService
     */
    private $_customerTokenService;

    public function __construct
    (
        \Magento\Integration\Model\CustomerTokenServiceFactory $CustomerTokenService
    )
    {
        $this->_customerTokenService = $CustomerTokenService;
    }

    public function createCustomerAccessToken($username, $password)
    {
        /** @var  $customerTokenFactory */
        $customerTokenFactory = $this->_customerTokenService->create();
        $customerToken        = $customerTokenFactory->createCustomerAccessToken($username, $password);

        return $customerToken;
    }

}