<pre>
<?php
/**
 * Unset Categories for Product SKU List from CSV
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';

Mage::app('default');

$file = Mage::getBaseDir() . '/' . 'remove_all_cats.csv';
$csv = new Varien_File_Csv();
$data = $csv->getData($file);
foreach ($data as $d) {
    if ($d[0] != '') {
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $d[0]);
        if ($product && $product->getId() && $product->getCategoryIds() && is_array($product->getCategoryIds())) {
            $cats = $product->getCategoryIds();
            foreach ($cats as $catId) {
                Mage::getSingleton('catalog/category_api')->removeProduct($catId, $product->getId());
                echo $d[0] . ' - rm category id' . $catId;
                echo '<hr>';
            }
        }
    }
}
?>
</pre>
<hr/>
