<?php
/** @var $installer Meanbee_MagehackTheme_Model_Resource_Setup */
$installer = $this;

// Set the new logo
$installer->setConfigData('design/header/logo_src', 'images/logo.png');
$installer->setConfigData('design/package/name', 'magehack');

//
// Create our personalisation blocks
//

$installer->createPersonalisationCmsBlock(
    'personalisation-mens-accessories',
    'Personalisation: Mens Accessories',
    '<div class="slideshow-container">
        <ul class="slideshow">
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/men.html"><img src="{{skin url="images/media/accessories_men1.jpg"}}" alt="Accessories for Men" /></a></li>
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/men.html"><img src="{{skin url="images/media/accessories_men2.jpg"}}" alt="Accessories for Men" /></a></li>
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/men.html"><img src="{{skin url="images/media/accessories_men3.jpg"}}" alt="Accessories for Men" /></a></li>
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/men.html"><img src="{{skin url="images/media/accessories_men4.jpg"}}" alt="Accessories for Men" /></a></li>
        </ul>
        <div class="slideshow-pager"></div>
        <span class="slideshow-prev">&nbsp;</span>
        <span class="slideshow-next">&nbsp;</span>
    </div>',
    array(5)
);

$installer->createPersonalisationCmsBlock(
    'personalisation-home-decor',
    'Personalisation: Home Decor',
    '<div class="slideshow-container">
        <ul class="slideshow">
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/home-decor.html"><img src="{{skin url="images/media/forthehome1.jpg"}}" alt="For the Home" /></a></li>
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/home-decor.html"><img src="{{skin url="images/media/forthehome2.jpg"}}" alt="For the Home" /></a></li>
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/home-decor.html"><img src="{{skin url="images/media/forthehome3.jpg"}}" alt="For the Home" /></a></li>
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/home-decor.html"><img src="{{skin url="images/media/forthehome4.jpg"}}" alt="For the Home" /></a></li>
        </ul>
        <div class="slideshow-pager"></div>
        <span class="slideshow-prev">&nbsp;</span>
        <span class="slideshow-next">&nbsp;</span>
    </div>',
    array(7)
);
$installer->createPersonalisationCmsBlock(
    'personalisation-default',
    'Personalisation: Default',
    '<div class="slideshow-container">
        <ul class="slideshow">
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/home-decor.html"><img src="{{skin url="images/media/homepage_banner_1.jpg"}}" alt="For the Home" /></a></li>
            <li class="cycle-slide"><a href="{{config path="web/unsecure/url"}}/home-decor.html"><img src="{{skin url="images/media/homepage_banner_2.jpg"}}" alt="For the Home" /></a></li>
        </ul>
        <div class="slideshow-pager"></div>
        <span class="slideshow-prev">&nbsp;</span>
        <span class="slideshow-next">&nbsp;</span>
    </div>',
    array(2)
);

// Update the CMS pages to use our widget, and new layout.
$installer->updateCmsPage('home', array(
   'content' => '{{widget type="meanbee_personalisedcontent/widget_content" is_enabled="1" default_category="2"}}

<ul class="promos">
	<li>
		<a href="{{config path="web/secure/base_url"}}home-decor.html">
			<img src="{{skin url="images/womens-accessories.png"}}" alt="Physical &amp; Virtual Gift Cards" />
		</a>
	</li>
	<li>
		<a href="{{config path="web/secure/base_url"}}vip.html">
			<img src="{{skin url="images/private-sale.png"}}" alt="Shop Private Sales - Members Only" />
		</a>
	</li>
	<li>
		<a href="{{config path="web/secure/base_url"}}accessories/bags-luggage.html">
			<img src="{{skin url="images/mens-travel-bags.png"}}" alt="Travel Gear for Every Occasion" />
		</a>
	</li>
</ul>',
    'root_template' => 'one_column'
));
