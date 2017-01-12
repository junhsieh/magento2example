<?php
// Reference:
// https://vinothkumaarr.wordpress.com/2016/05/13/add-customer-and-address-programmatically-magento2/

use \Magento\Framework\App\Bootstrap;
include('/www/magento2.1/app/bootstrap.php');

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();
$url = \Magento\Framework\App\ObjectManager::getInstance();
$storeManager = $url->get('\Magento\Store\Model\StoreManagerInterface');
$mediaurl= $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
$state = $objectManager->get('\Magento\Framework\App\State');
$state->setAreaCode('frontend');

// Customer Factory to Create Customer
$customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory');
$websiteId = $storeManager->getWebsite()->getWebsiteId();

/// Get Store ID
$store = $storeManager->getStore();
$storeId = $store->getStoreId();

// Instantiate object (this is the most important part)
$customer = $customerFactory->create();
$customer->setWebsiteId($websiteId);

// Preparing data for new customer
$customer->setEmail("test@example.com");
$customer->setFirstname("test first");
$customer->setLastname("test last");
$customer->setPassword("test123");

try{
  // Save data
  $customer->save();
  echo 'Succesfully Saved. Customer ID: '.$customer->getId() . PHP_EOL;

  // Add Address For created customer
  $addresss = $objectManager->get('\Magento\Customer\Model\AddressFactory');
  $address = $addresss->create();

  $address->setCustomerId($customer->getId())
    ->setFirstname('test first')
    ->setLastname('test last')
    ->setCountryId('US')
    ->setRegionId('62') //state/province, only needed if the country is USA
    ->setPostcode('98248')
    ->setCity('Ferndale')
    ->setTelephone('7781234567')
    ->setFax('7781234567')
    ->setCompany('test company')
    ->setStreet('test street')
    ->setIsDefaultBilling('1')
    ->setIsDefaultShipping('1')
    ->setSaveInAddressBook('1');
  try{
    $address->save();
  }
  catch (Exception $e) {
    Zend_Debug::dump($e->getMessage());
  }
}
catch(Exception $e)
{
  Mage::log($e->getMessage());
  print_r($e->getMessage());
}

