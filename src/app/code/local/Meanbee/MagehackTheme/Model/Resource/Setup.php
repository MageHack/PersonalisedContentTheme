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
