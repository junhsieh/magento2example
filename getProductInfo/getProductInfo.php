<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

$storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
$storeId = $storeManager->getStore()->getId();

$productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
$productCollection = $productCollectionFactory->create();
$productCollection->addAttributeToSelect('*');

foreach ($productCollection as $product) {
	echo 'Id: ' . $product->getId() . PHP_EOL;
	echo 'Sku: ' . $product->getSku() . PHP_EOL;
	echo 'Price: ' . $product->getPrice() . PHP_EOL;
	echo 'Weight: ' . $product->getWeight() . PHP_EOL;
	print_r($product->getData());
	echo PHP_EOL;
}
