<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

$tierPriceFactory = $objectManager->get('\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory');

$tierPrices = [
    // All groups
    $tierPriceFactory->create()->setCustomerGroupId(32000)->setQty(4)->setValue(10.0),
    $tierPriceFactory->create()->setCustomerGroupId(32000)->setQty(9)->setValue(9.0),
    // Not logged in
    $tierPriceFactory->create()->setCustomerGroupId(0)->setQty(5)->setValue(10.1),
    $tierPriceFactory->create()->setCustomerGroupId(0)->setQty(10)->setValue(9.1),
    // Wholesale
    $tierPriceFactory->create()->setCustomerGroupId(2)->setQty(6)->setValue(10.2),
    $tierPriceFactory->create()->setCustomerGroupId(2)->setQty(11)->setValue(9.2),
];

$prodInfoArr = [
	['AttributeSetId' => 4, 'TypeId' => 'simple', 'Name' => 'My Product 22', 'Price' => 99, 'Sku' => 'MP22', 'Weight' => 10, 'TierPrices' => $tierPrices],
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
	$product->setTierPrices($prodInfo['TierPrices']);
	$product->setSku($prodInfo['Sku']);
	#$product->setQty($prodInfo['Qty']); // will not work. Use "set stock data" instead.
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
