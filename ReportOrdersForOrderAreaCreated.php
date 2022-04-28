<pre>
<?php
/**
 * Report Orders for 'order_area_created' - where was created Order. Get Report by Order list form CSV file.
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';
$app = Mage::app('admin');
umask(0);

$file = 'orders.csv';
$csv = new Varien_File_Csv();
$ordersId = array();
$ar = array();
$data = $csv->getData($file);
foreach ($data as $d) {
    if ($d[0] != '') {
        $ordersId[] = $d[0];
        $ar[$d[0]] = $d[0];
    }
}

$orders = Mage::getModel('sales/order')->getCollection()
    ->addAttributeToSelect('*')
    ->addAttributeToFilter('increment_id', array('in' => $ordersId));

$cr = array();
foreach ($orders as $o) {
    $cr[$o->getData('order_area_created')] = $o->getData('order_area_created');
}

/**
 * Skip filter
 */
$filterAreaCreatedSkip = array(
    'admin1',
    'admin2',
    'Rozetka',
    'manager1',
    'manager2'
);

$orders = Mage::getModel('sales/order')->getCollection()
    ->addAttributeToSelect('*')
    ->addAttributeToFilter('increment_id', array('in' => $ordersId))
    ->addAttributeToFilter('order_area_created', array('ni' => $filterAreaCreatedSkip));

foreach ($orders as $or) {
    echo $or->getData('increment_id');
    echo ',';
    echo $or->getData('order_area_created');
    echo '<br>';
}
