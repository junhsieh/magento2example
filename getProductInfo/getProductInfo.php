<?php
use \Magento\Framework\App\Bootstrap;

include '/www/magento2.1/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('base');

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
