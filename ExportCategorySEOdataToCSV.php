<?php
/**
 * Export Category SEO data to CSV
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('time_limit', 1800);
ini_set('max_execution_time', 1800);
ini_set('memory_limit', '2000M');

require_once dirname(__FILE__) . './../app/Mage.php';

Mage::app()->setCurrentStore(1);

$collection = Mage::getModel('catalog/category')->getCollection()->addAttributeToSelect('*');
$csvClass = new Varien_File_Csv();

$dataCsv = array();
$data = array();
$data['URL'] = 'URL';
$data['Name'] = 'Name';
$data['Id'] = 'Id';
$data['Active'] = 'Active';
$data['Level'] = 'Level';
$data['Meta-title'] = 'Meta-title';
$data['Meta-description'] = 'Meta-description';
$data['Meta-keywords'] = 'Meta-keywords';
$data['Paging-meta-title-template'] = 'Paging-meta-title-template';
$data['Paging-meta-description-template'] = 'Paging-meta-description-template';
$data['Content'] = 'Content';

$dataCsv[] = $data;
foreach ($collection as $c):
    $category = Mage::getModel('catalog/category')->load($c->getId());
    $data = array();
    $data['URL'] = $category->getUrl();
    $data['Name'] = $category->getName();
    $data['Id'] = $category->getId();
    $data['Active'] = $category->getData('is_active');
    $data['Level'] = $category->getLevel();
    $data['Meta-title'] = $category->getData('meta_title');
    $data['Meta-description'] = $category->getData('meta_description');
    $data['Meta-keywords'] = $category->getData('meta_keywords');
    $data['Paging-meta-title-template'] = $category->getData('meta_title_paging_tmplt');
    $data['Paging-meta-description-template'] = $category->getData('meta_dscrptn_paging_tmplt');
    $data['Content'] = $category->getDescription();
    $dataCsv[] = $data;
endforeach;

$csvClass->saveData(Mage::getBaseDir() . DS . 'seo-report-cats' . '.csv', $dataCsv);
die('Done');
