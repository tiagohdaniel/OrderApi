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

use Magento\Framework\Webapi\ServiceInputProcessor;
use Magento\Webapi\Controller\Rest;
use Magento\Framework\Webapi\Rest\Response\FieldsFilter;
use Magento\Framework\Webapi\Rest\Response as RestResponse;
use Magento\Framework\Webapi\ServiceOutputProcessor;

class OrderPlace
{
    /**
     * @var bodyparams
     */
    private $_bodyParams;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    private $_customerFactory;

    /**
     * @var Rest\RequestFactory
     */
    private $_requestFactory;

    /**
     * @var \Magento\Customer\Model\AccountManagementFactory
     */
    private $_accountManagementFactory;

    /**
     * @var ServiceInputProcessor
     */
    private $_serviceInputProcessor;

    /**
     * @var Rest\InputParamsResolverFactory
     */
    private $_rest;

    /**
     * @var \Magento\Customer\Model\AddressFactory
     */
    private $_addressFactory;

    /**
     * @var FieldsFilter
     */
    private $_fieldsFilter;

    /**
     * @var RestResponse
     */
    private $_response;

    /**
     * @var ServiceOutputProcessor
     */
    private $_serviceOutputProcessor;

    /**
     * @var CustomerTokenFactory
     */
    private $_customerTokenFactory;

    /**
     * @var QuoteManagement
     */
    private $_quoteManagement;

    public function __construct
    (
        \Magento\Customer\Model\CustomerFactory                    $customerFactory,
        \Magento\Framework\Webapi\Rest\RequestFactory              $requestFactory,
        \Magento\Customer\Model\AccountManagementFactory           $accountManagementFactory,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory        $customer,
        ServiceInputProcessor                                      $serviceInputProcessor,
        \Magento\Webapi\Controller\Rest\InputParamsResolver        $rest,
        \Magento\Customer\Model\AddressFactory                     $addressFactory,
        FieldsFilter                                               $fieldsFilter,
        RestResponse                                               $response,
        ServiceOutputProcessor                                     $serviceOutputProcessor,
        \ThdSolution\OrderApi\Model\CustomerToken                  $customerToken,
        QuoteManagementFactory                                     $quoteManagement

    )
    {
        $this->_customerFactory           = $customerFactory;
        $this->_requestFactory            = $requestFactory;
        $this->_accountManagementFactory  = $accountManagementFactory;
        $this->_customerInterfaceFactory  = $customer;
        $this->_serviceInputProcessor     = $serviceInputProcessor;
        $this->_rest                      = $rest;
        $this->_addressFactory            = $addressFactory;
        $this->_fieldsFilter              = $fieldsFilter;
        $this->_response                  = $response;
        $this->_serviceOutputProcessor    = $serviceOutputProcessor;
        $this->_customerTokenFactory      = $customerToken;
        $this->_quoteManagement           = $quoteManagement;
    }

    public function placeOrder()
    {
        $requestObj             =  $this->_requestFactory->create();
        $this->_bodyParams      = $requestObj->getBodyParams();
        $customer               = $this->setCustomerData($this->_bodyParams['customer'], $this->_bodyParams['password']);
        /*$customerToken          = $this->_customerTokenFactory->createCustomerAccessToken
                                    ($customer->getEmail(), $this->_bodyParams["password"]);*/

        /** @var  $quoteManagementFactory */
        $quoteManagementFactory = $this->_quoteManagement->create();

        $quoteId                = $quoteManagementFactory->createEmptyCartForCustomer($customer->getId());
    }

    public function setCustomerData($customerData, $password)
    {
        /** @var \Magento\Customer\Model\AccountManagement $accountManagement */
        $accountManagement  = $this->_accountManagementFactory->create();

        /** @var \Magento\Customer\Api\Data\CustomerInterfaceFactory $customer */
        $customer           = $this->_customerInterfaceFactory->create();

        $customer->setEmail($customerData['email']);
        $customer->setFirstname($customerData['firstname']);
        $customer->setLastname($customerData['lastname']);

        $addressData        = $this->_setCustomerAddressData($customerData['addresses']);

        $customer->setData('addresses', $addressData);
        $output             = $accountManagement->createAccount($customer, $password);
        return $output;
    }


    private function _setCustomerAddressData($addressData)
    {
        /** @var \Magento\Customer\Model\AddressFactory $address */
        $address            = $this->_addressFactory->create();

        foreach($addressData as $data){
            $address->setDefaultShipping($data['defaultShipping']);
            $address->setDefaultBilling($data['defaultBilling']);
            $address->setFirstName($data['firstname']);
            $address->setLastName($data['lastname']);
            $address->setRegionCode($data['region']['regionCode']);
            $address->setRegione($data['region']['region']);
            $address->setRegionId($data['region']['regionId']);
            $address->setPostcode($data['postcode']);
            $address->setStreet($data['street'][0]);
            $address->setCity($data['city']);
            $address->setTelephone($data['telephone']);
            $address->setCountryId($data['countryId']);
        }

        return $address;
    }

}