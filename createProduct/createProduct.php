<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

$prodInfoArr = [
	['AttributeSetId' => 4, 'Name' => 'My Product 1', 'Price' => 99.9, 'Sku' => 'MP1', 'Qty' => 55],
	['AttributeSetId' => 4, 'Name' => 'My Product 2', 'Price' => 98.9, 'Sku' => 'MP2', 'Qty' => 54],
];

foreach ($prodInfoArr as $prodInfo) {
	createProduct($prodInfo);
}

function createProduct($prodInfo = []) {
	global $objectManager;

	$product = $objectManager->get('\Magento\Catalog\Model\ProductFactory')->create();

	$product->setAttributeSetId($prodInfo['AttributeSetId']);
	$product->setName($prodInfo['Name']);
	$product->setPrice($prodInfo['Price']);
	$product->setSku($prodInfo['Sku']);
	$product->setQty($prodInfo['Qty']);

	$objectManager->get('\Magento\Catalog\Api\ProductRepositoryInterface')->save($product);
}
