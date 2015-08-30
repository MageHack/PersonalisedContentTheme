<?php
/** @var $installer Meanbee_MagehackTheme_Model_Resource_Setup */
$installer = $this;

$websiteId = Mage::app()->getWebsite()->getId();
$store = Mage::app()->getStore();

// Enable payment and shipping methods
/** @var Mage_Core_Model_Config $config */
$config = Mage::getModel('core/config');

$config->saveConfig('payment/checkmo/active', 1);
$config->saveConfig('carriers/flatrate/active', 1);

// Assign simple products to category we want
$product = Mage::getModel('catalog/product')->load(382);
$product->setCategoryIds(array(7, 23));
$product->save();

$product = Mage::getModel('catalog/product')->load(373);
$product->setCategoryIds(array(5, 21));
$product->save();

// Create two demo customers and order
$customer = Mage::getModel("customer/customer")->setWebsiteId($websiteId)->setStore($store);
$customer->loadByEmail('tom@example.com');
if (!$customer->getId()) {

    $customer
        ->setFirstname('Tom')
        ->setLastname('Robertshaw')
        ->setEmail('tom@example.com')
        ->setPassword('password1')
        ->save();
}

$installer->createOrder($customer, 382);

$customer = Mage::getModel("customer/customer")->setWebsiteId($websiteId)->setStore($store);
$customer->loadByEmail('ash@example.com');
if (!$customer->getId()) {

    $customer->setWebsiteId($websiteId)
        ->setStore($store)
        ->setFirstname('Ash')
        ->setLastname('Smith')
        ->setEmail('ash@example.com')
        ->setPassword('password1')
        ->save();
}

$installer->createOrder($customer, 373);

try{
    $customer->save();
}
catch (Exception $e) {
    Zend_Debug::dump($e->getMessage());
}




