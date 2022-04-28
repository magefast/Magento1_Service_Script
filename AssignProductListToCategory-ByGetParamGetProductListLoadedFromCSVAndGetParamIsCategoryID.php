<pre>
<?php
/**
 * Assign Product list to Category.
 * By Get param get Product list loaded from CSV, and Get param is Category ID.
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';
$app = Mage::app('default');
umask(0);

$catId = $_GET['cat_id'];
$file = $catId . '.csv';

$csv = new Varien_File_Csv();

$data = $csv->getData($file);
foreach ($data as $d) {
    if ($d[0] != '') {
        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $d[0]);
        if ($product && $product->getId()) {
            echo $d[0];
            echo '<hr>';
            Mage::getSingleton('catalog/category_api')->assignProduct($catId, $product->getId());
        }
    }
}
?>
</pre>
<hr/>
END
