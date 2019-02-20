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

namespace ThdSolution\OrderApi\Api;

interface OrderPlaceInterface
{
    public function placeOrder();
}