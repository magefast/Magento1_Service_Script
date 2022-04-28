<?php
/**
 * Fill Customer attribute 'Mobile', with data from Billing Address Telephone
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';
$app = Mage::app('admin');
umask(0);

$collection = Mage::getModel('customer/customer')->getCollection();

foreach ($collection as $c) {
    $id = $c->getEntityId();
    $customer = Mage::getModel('customer/customer')->load($id);
    $address = $customer->getPrimaryBillingAddress();
    if ($address) {
        $mobile = $address->getTelephone();
        echo '+';
        if (empty($customer->getMobile()) && !empty($mobile)) {
            try {
                $customer->setData('mobile', $mobile);
                $customer->save();
            } catch (Exception $e) {

            }
        }
    }
    unset($customer);
}
