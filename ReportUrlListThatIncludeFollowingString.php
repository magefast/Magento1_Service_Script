<pre>
<?php
/**
 * Report Url List that include following String
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';
Mage::app()->setCurrentStore(1);

$search = 'shampuni';

$collection = Mage::getModel('seo4url/seo4url')
    ->getCollection()
    ->addFieldToSelect('entity_id')
    ->addFieldToSelect('url')
    ->addFieldToSelect('url_filter')
    ->addFieldToFilter('url', array(array('like' => '%' . $search . '%')));

foreach ($collection as $c):
    echo $c->getData('url');
    echo "<br>";
endforeach;
?>
</pre>
