<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

createCategory();
listCategory();

function createCategory() {
	global $objectManager;

	#$category = $objectManager->get('\Magento\Catalog\Model\CategoryFactory')->create();
	$category = $objectManager->get('\Magento\Catalog\Api\Data\CategoryInterfaceFactory')->create();

	$category->setName('Computer 3');
	$category->setParentId(1); // 1: root category.
	$category->setIsActive(true);
	$category->setCustomAttributes([
		'description' => 'Computer 3 desc',
	]);

	$objectManager->get('\Magento\Catalog\Api\CategoryRepositoryInterface')->save($category);
}

function listCategory() {
	global $objectManager;

	$categoryCollection = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory')->create();
	$categoryCollection->addAttributeToSelect('*');
	$categoryCollection->addIsActiveFilter();
	$categoryCollection->addLevelFilter(2);

	foreach ($categoryCollection as $category) {
		#print_r($category->getData());
		#print_r($category->getCustomAttributes());

		echo 'Id: ' . $category->getId() . PHP_EOL;
		echo 'Name: ' . $category->getName() . PHP_EOL;
		echo 'ParentId: ' . $category->getParentId() . PHP_EOL;
		echo 'Url: ' . $category->getUrl() . PHP_EOL;
		echo 'UrlKey: ' . $category->getUrlKey() . PHP_EOL;
		echo 'Path: ' . $category->getPath() . PHP_EOL;
		echo 'Position: ' . $category->getPosition() . PHP_EOL;
		echo 'Level: ' . $category->getLevel() . PHP_EOL;
		echo 'ChildrenCount: ' . $category->getChildrenCount() . PHP_EOL;
		echo 'Description: ' . $category->getDescription() . PHP_EOL;
		echo PHP_EOL;
	}
}

