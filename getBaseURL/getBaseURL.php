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

echo $baseURL . PHP_EOL;
echo $mediaBaseURL . PHP_EOL;
echo $linkBaseURL . PHP_EOL;
