<?php
use Magento\Framework\App\Bootstrap;

#require __DIR__ . '/../app/bootstrap.php';
require '/www/mag2.local/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();
#$objectManagerNew = \Magento\Framework\App\ObjectManager::getInstance();;

### Setting area code
### NOTE: more info http://devdocs.magento.com/guides/v2.1/architecture/archi_perspectives/components/modules/mod_and_areas.html
$state = $objectManager->get('Magento\Framework\App\State');
#$state->setAreaCode('frontend');
$state->setAreaCode('base');

#$quote = $obj->get('Magento\Checkout\Model\Session')->getQuote()->load(1);
#print_r($quote->getOrigData());

$storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
$storeId = $storeManager->getStore()->getId();

$baseURL = $storeManager->getStore($storeId)->getBaseUrl();
$mediaBaseURL = $storeManager->getStore($storeId)->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
$linkBaseURL = $storeManager->getStore($storeId)->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK);

$websiteId = $storeManager->getStore($storeId)->getWebsiteId();
$storeCode = $storeManager->getStore($storeId)->getCode();
$storeName = $storeManager->getStore($storeId)->getName();
$currentUrl = $storeManager->getStore($storeId)->getCurrentUrl();
$isActive = $storeManager->getStore($storeId)->isActive();
$isFrontUrlSecure = $storeManager->getStore($storeId)->isFrontUrlSecure();
$isCurrentlySecure = $storeManager->getStore($storeId)->isCurrentlySecure();

echo 'baseURL: ' . $baseURL . PHP_EOL;
echo 'mediaBaseURL: ' . $mediaBaseURL . PHP_EOL;
echo 'linkBaseURL: ' . $linkBaseURL . PHP_EOL;
echo 'websiteId: ' . $websiteId . PHP_EOL;
echo 'storeCode: ' . $storeCode . PHP_EOL;
echo 'storeName: ' . $storeName . PHP_EOL;
echo 'currentUrl: ' . $currentUrl . PHP_EOL;
echo 'isActive: ' . $isActive . PHP_EOL;
echo 'isFrontUrlSecure: ' . var_export($isFrontUrlSecure, true) . PHP_EOL;
echo 'isCurrentlySecure: ' . var_export($isCurrentlySecure, true) . PHP_EOL;
