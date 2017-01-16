<?php
use \Magento\Framework\App\Bootstrap;
include('/www/magento2.1/app/bootstrap.php');

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$url = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $url->get('\Magento\Store\Model\StoreManagerInterface');
$mediaurl= $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');

$websiteId = $storeManager->getWebsite()->getWebsiteId();

$productId = 1;
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$product_obj = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);

#getCustomerGroupId

getDefaultGroup($product_obj);
getAnyGroup($product_obj);

function getDefaultGroup($product_obj) {
	$tier_price = $product_obj->getTierPrice();

	if(count($tier_price) > 0){
		echo "price_id\tprice_qty\tprice\twebsite_price\n";

		foreach($tier_price as $price){
			echo $price['price_id'];
			echo "\t";
			echo $price['price_qty'];
			echo "\t";
			echo $price['price'];
			echo "\t";
			echo $price['website_price'];
			echo "\n";
		}
	} else {
		echo 'There is no tiering price for the default group.' . PHP_EOL;
	}
}

function getAnyGroup($product_obj) {
	$tier_price = $product_obj->getTierPrices();

	if(count($tier_price) > 0){
		echo "price_qty\tprice\tCustomerGroupId\n";

		foreach($tier_price as $price){
			echo $price->getQty();
			echo "\t";
			echo $price->getValue();
			echo "\t";
			echo $price->getCustomerGroupId();
			echo "\t";
			echo "\n";
			print_r($price->getData());
			echo "\t";
			echo "\n";
		}
	}
}

#print_r($tier_price);
#print_r(get_class_methods($price));
