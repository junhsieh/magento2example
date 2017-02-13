<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

### Reference:
### http://magento.stackexchange.com/questions/96519/magento-2-programmatically-updating-inventory
$sku = 'WWW1';
$stockQty = 55;

$productRepository = $objectManager->create('Magento\Catalog\Api\ProductRepositoryInterface');
$stockRegistry = $objectManager->create('Magento\CatalogInventory\Api\StockRegistryInterface');

### Load product by SKU
$product = $productRepository->get($sku);

### Load stock item
$stockItem = $stockRegistry->getStockItem($product->getId());

$stockItem->setQty($stockQty);
#$stockItem->setData('qty', $stockQty);

#$stockItem->setData('manage_stock', $stockData['manage_stock']);
#$stockItem->setData('is_in_stock', $stockData['is_in_stock']);
#$stockItem->setData('use_config_notify_stock_qty', 1);

print_r($stockItem->getData());

$stockRegistry->updateStockItemBySku($sku, $stockItem);
