<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

$prodInfoArr = [
	['AttributeSetId' => 4, 'TypeId' => 'simple', 'Name' => 'My Product 17', 'Price' => 99, 'Sku' => 'MP17', 'Qty' => 55, 'Weight' => 10],
];

foreach ($prodInfoArr as $prodInfo) {
	createProduct($prodInfo);
}

getProductCollection();

function createProduct($prodInfo = []) {
	global $objectManager;

	#$product = $objectManager->get('\Magento\Catalog\Model\ProductFactory')->create();
	$product = $objectManager->get('\Magento\Catalog\Api\Data\ProductInterfaceFactory')->create();

	$product->setAttributeSetId($prodInfo['AttributeSetId']); // importatnt
	$product->setTypeId($prodInfo['TypeId']); // important
	$product->setName($prodInfo['Name']);
	$product->setPrice($prodInfo['Price']);
	$product->setTierPrices([
		// All groups
		$objectManager->get('\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory')->create()
			->setCustomerGroupId(32000)->setQty(4)->setValue(10.0),
		$objectManager->get('\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory')->create()
			->setCustomerGroupId(32000)->setQty(9)->setValue(9.0),
		// Not logged in
		$objectManager->get('\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory')->create()
			->setCustomerGroupId(0)->setQty(5)->setValue(10.1),
		$objectManager->get('\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory')->create()
			->setCustomerGroupId(0)->setQty(10)->setValue(9.1),
		// Wholesale
		$objectManager->get('\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory')->create()
			->setCustomerGroupId(2)->setQty(6)->setValue(10.2),
		$objectManager->get('\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory')->create()
			->setCustomerGroupId(2)->setQty(11)->setValue(9.2),
	]);
	$product->setSku($prodInfo['Sku']);
	$product->setQty($prodInfo['Qty']);
	$product->setWeight($prodInfo['Weight']);
	$product->setTaxClassId(0); // (0: none, 1: default, 2: taxable, 4: shipping)
	$product->setStatus(1);
	$product->setVisibility(4);

	$objectManager->get('\Magento\Catalog\Api\ProductRepositoryInterface')->save($product);
}

function getProductCollection() {
	global $objectManager;

	$searchCriteria = $objectManager->get('\Magento\Framework\Api\SearchCriteriaBuilder')
		->addFilter('sku', '^MP', 'regexp')
		->addFilter('price', 90, 'gt')
		->create();
	$productCollection = $objectManager->get('\Magento\Catalog\Api\ProductRepositoryInterface')->getList($searchCriteria);

	foreach ($productCollection->getItems() as $product) {
		echo 'Id: ' . $product->getId() . PHP_EOL;
		echo 'AttributeSetId: ' . $product->getAttributeSetId() . PHP_EOL;
		echo 'TypeId: ' . $product->getTypeId() . PHP_EOL;
		echo 'Sku: ' . $product->getSku() . PHP_EOL;
		echo 'Price: ' . $product->getPrice() . PHP_EOL;
		echo 'Weight: ' . $product->getWeight() . PHP_EOL;

		print_r($product->getData());
		echo PHP_EOL;
	}
}
