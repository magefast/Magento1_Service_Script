<pre>
<?php
/**
 * Report Orders For Coupon Code
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';
$app = Mage::app('admin');
umask(0);

$coupon = 'ACADEMY-coupon';

$orders = Mage::getModel('sales/order')->getCollection()
    ->addAttributeToFilter('coupon_code', array('like' => $coupon));

foreach($orders as $s) {
    echo $s->getData('increment_id');
    echo ',';
    echo $s->getData('status');
    echo ',';
    echo $s->getData('base_grand_total');
    echo '<br>';
}
?>
</pre>
<hr>
