<pre>
<?php
/**
 * Report for Empty Value of Product Attribute Weight
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';
$app = Mage::app('admin');
umask(0);

$product = Mage::getModel('catalog/product')->getCollection()
    ->addAttributeToSelect('weight')
    ->addAttributeToSelect('name')
    ->addAttributeToSelect('sku');

$class = new Varien_File_Csv();
$newCsvData = array();
foreach ($product as $p) {
    if ($p->getTypeId() != 'simple') {
        continue;
    }
    if ($p->getData('weight') == '' || intval($p->getData('weight')) == 0) {
        $a = array();
        $a['sku'] = $p->getData('sku');
        $a['name'] = $p->getData('name');
        $newCsvData[] = $a;
        echo $a['sku'] . '<br>';
    }
}
$class->saveData(Mage::getBaseDir() . DS . 'weight' . '.csv', $newCsvData);
?>
</pre>
