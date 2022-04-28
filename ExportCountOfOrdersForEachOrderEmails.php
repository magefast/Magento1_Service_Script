<?php
/**
 * Export Count of Orders for each Order Emails
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';
$app = Mage::app('admin');
umask(0);

$orders = Mage::getModel('sales/order')->getCollection();
$count = 1;
$ordersEmail = array();
foreach ($orders as $o) {
    if (isset($ordersEmail[$o->getData('customer_email')])) {
        $ordersEmail[$o->getData('customer_email')] = $ordersEmail[$o->getData('customer_email')] + $count;
    } else {
        $ordersEmail[$o->getData('customer_email')] = $count;
    }
}
unset($orders);

$classCSV = new Varien_File_Csv();
$newCsvData = array();
foreach ($ordersEmail as $key => $value) {
    $array = array();
    $array[] = $key;
    $array[] = $value;
    $newCsvData[] = $array;
}

$classCSV->saveData(Mage::getBaseDir() . DS . 'reportorderemail' . '.csv', $newCsvData);

die('Done');
