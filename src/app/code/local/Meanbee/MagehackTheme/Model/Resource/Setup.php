<?php

class Meanbee_MagehackTheme_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup
{
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
}
