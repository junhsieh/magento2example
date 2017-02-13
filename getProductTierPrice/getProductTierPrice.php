<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

$productId = 1;
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$product_obj = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);

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
