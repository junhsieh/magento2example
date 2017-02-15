<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

$config = $objectManager->get('\Magento\Config\Model\ResourceModel\Config');

$config->saveConfig('dev/static/sign', 0, 'default', 0);

