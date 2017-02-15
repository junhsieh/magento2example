<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

$path = 'dev/static/sign';
$value = 0;
$scope = \Magento\Framework\App\Config\ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
$scopeId = 0;

#UseResourceModel($path, $value, $scope, $scopeId); // method 1
UseStorageWriter($path, $value, $scope, $scopeId); // method 2

function UseResourceModel($path, $value, $scope, $scopeId) {
	global $objectManager;

	$config = $objectManager->get('\Magento\Config\Model\ResourceModel\Config');
	$config->saveConfig($path, $value, $scope, $scopeId);
}

/*
 * This one is more high-level compared to \Magento\Config\Model\ResourceModel\Config, and should be used from client code.
 * Reference:
 * http://magento.stackexchange.com/questions/103024/how-can-i-set-configuration-values-in-magento-2
 */
function UseStorageWriter($path, $value, $scope, $scopeId) {
	global $objectManager;

	$config = $objectManager->get('\Magento\Framework\App\Config\Storage\WriterInterface');
	$config->save($path, $value, $scope, $scopeId);
}

