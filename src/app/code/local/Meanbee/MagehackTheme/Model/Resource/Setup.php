<?php

class Meanbee_MagehackTheme_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup
{
    /**
     * Update an existing CMS block.
     *
     * @param string $identifier
     * @param string $title
     * @param string $content
     * @param array  $personalisation_tags  array of category ids
     * @param array  $stores  Store the block is currently assigned to
     *
     * @return $this
     */
    public function createPersonalisationCmsBlock($identifier, $title, $content, $personalisation_tags = array(), $stores = array(0))
    {
        $current_store = Mage::app()->getStore();
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        $block = Mage::getModel('cms/block')->load($identifier, 'identifier');
        if ($block->getId()) {
            return $this; // Block already exists.
        }

        Mage::getModel("cms/block")
            ->setData(array(
                "identifier" => $identifier,
                "title"      => $title,
                "content"    => $content,
                "personalisation_tags" => $personalisation_tags,
                "is_active"  => 1,
                "stores"     => $stores
            ))
            ->save();
        Mage::app()->setCurrentStore($current_store);
        return $this;
    }

    /**
     * @See http://www.devinrolsen.com/creating-magento-orders-programmatically/
     *
     * @param Mage_Customer_Model_Customer $customer
     * @param int $productId
     *
     * @throws Exception
     */
    public function createOrder($customer, $productId) {

        // Enable payment and shipping methods
        /** @var Mage_Core_Model_Config $config */
        $config = Mage::getModel('core/config');

        $config->saveConfig('payment/checkmo/active', 1);
        $config->saveConfig('carriers/flatrate/active', 1);

        //Start a new order quote and assign current customer to it.
        $quote = Mage::getModel('sales/quote');
        $quote->assignCustomer($customer);

        $product = Mage::getModel('catalog/product')->load($productId);
        $quote->addProduct($product,new Varien_Object(array('qty' => 1)));

        //Low lets setup a shipping / billing array of current customer's session
        $addressData = array(
            'firstname' => $customer->getFirstname(),
            'lastname' => $customer->getLastname(),
            'street' => '1 House, The Street',
            'city' => 'The City',
            'postcode'=> 'CI71',
            'telephone' => '080000000000',
            'country_id' => 'GB'
        );

        //Add address array to both billing AND shipping address objects.
        $billingAddress = $quote->getBillingAddress()->addData($addressData);
        $shippingAddress = $quote->getShippingAddress()->addData($addressData);

        //Set shipping objects rates to true to then gather any accrued shipping method costs a product main contain
        $shippingAddress->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod('flatrate_flatrate')
            ->setPaymentMethod('checkmo');

        //Set quote object's payment method to check / money order to allow progromatic entries of orders
        //(kind of hard to programmatically guess and enter a customer's credit/debit cart so only money orders are allowed to be entered via api)
        $quote->getPayment()->importData(array('method' => 'checkmo'));

        //Save collected totals to quote object
        $quote->collectTotals()->save();


        //Feed quote object into sales model
        $service = Mage::getModel('sales/service_quote', $quote);

        //submit all orders to MAGE
        $service->submitAll();

        //Setup order object and gather newly entered order
        $order = $service->getOrder();

        //Finally we save our order after setting it's status to complete.
        $order->save();
    }

    /**
     * Update an existing CMS page.
     *
     * @param string   $identifier
     * @param array    $data    A key => value list of new data to assign to the page.
     * @param int|null $storeId Store ID the page is currently assigned to.
     *
     * @return $this
     */
    public function updateCmsPage($identifier, $data, $storeId = null)
    {
        $current_store = Mage::app()->getStore();
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        $page = Mage::getModel("cms/page");
        if ($storeId) {
            $page->setStoreId($storeId);
        }
        $page->load($identifier);
        if ($page->getId()) {
            $page
                ->addData($data)
                ->save();
        } else {
            Mage::throwException(sprintf("Unable to update CMS page: CMS page '%s' does not exist.", $identifier));
        }
        Mage::app()->setCurrentStore($current_store);
        return $this;
    }
}
