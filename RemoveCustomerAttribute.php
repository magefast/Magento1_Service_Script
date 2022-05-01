<?php
/**
 * Remove Customer Attribute
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';

$app = Mage::app('default');

$attributeCode = 'test33';

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->removeAttribute('customer', $attributeCode);
