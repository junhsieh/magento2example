<?php
use \Magento\Framework\App\Bootstrap;
include('/www/magento2.1/app/bootstrap.php');

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$url = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $url->get('\Magento\Store\Model\StoreManagerInterface');
$mediaurl= $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');

$websiteId = $storeManager->getWebsite()->getWebsiteId();

// Customer Factory to Create Customer
$customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory');
$customer = $customerFactory->create();
$customer->setWebsiteId($websiteId);
$customer->loadByEmail('test@example.com');  

$data = $customer->getData(); 
print_r($data);

$defaultBilling = $customer->getDefaultBillingAddress();
$defaultShipping = $customer->getDefaultShippingAddress();

foreach ($customer->getAddresses() as $address) {
	echo 'IsDefaultBillingAddress: ' . ($address->getId() == $defaultBilling->getId() ? 'Yes' : 'No') . PHP_EOL;
	echo 'IsDefaultShippingAddress: ' . ($address->getId() == $defaultShipping->getId() ? 'Yes' : 'No') . PHP_EOL;

	echo 'ID: ' . $address->getId() . PHP_EOL;
	echo 'First Name: ' . $address->getFirstname() . PHP_EOL;
	echo 'Last Name: ' . $address->getLastname() . PHP_EOL;
	echo 'Street: ' . implode("\n", $address->getStreet()) . PHP_EOL;
	echo 'City: ' . $address->getCity() . PHP_EOL;
	echo 'Country: ' . $address->getCountry() . PHP_EOL;
	echo 'Region: ' . $address->getRegion() . PHP_EOL;
	echo 'Postal Code: ' . $address->getPostcode() . PHP_EOL;
	echo 'Phone: ' . $address->getTelephone() . PHP_EOL;
	echo PHP_EOL;

	#print_r(get_class_methods($address));
	#break;
}

