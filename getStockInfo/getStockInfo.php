<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

$stockItemRepository = $objectManager->get('\Magento\CatalogInventory\Model\Stock\StockItemRepository');

$productId = 1;

$productStock = $stockItemRepository->get($productId);

echo 'Qty: ' . $productStock->getQty() . PHP_EOL;
echo 'getMinQty: ' . $productStock->getMinQty() . PHP_EOL;
echo 'getMinSaleQty: ' . $productStock->getMinSaleQty() . PHP_EOL;
echo 'getMaxSaleQty: ' . $productStock->getMaxSaleQty() . PHP_EOL;
echo 'getIsInStock: ' . $productStock->getIsInStock() . PHP_EOL;
