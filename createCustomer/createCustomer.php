<?php
include __DIR__ . '/../common.php';

$state->setAreaCode('base');

### Reference:
### https://vinothkumaarr.wordpress.com/2016/05/13/add-customer-and-address-programmatically-magento2/

createCustomer();

function createCustomer() {
	global $objectManager;

	$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
	$storeId = $storeManager->getStore()->getId();

	#$websiteId = $storeManager->getWebsite()->getWebsiteId();
	$websiteId = $storeManager->getStore($storeId)->getWebsiteId();

	### Instantiate object (this is the most important part)
	$customer = null;

	try{
		#$customer = $objectManager->get('\Magento\Customer\Model\CustomerFactory')->create();
		$customer = $objectManager->get('\Magento\Customer\Api\Data\CustomerInterfaceFactory')->create();
		$customer->setWebsiteId($websiteId);

		### Preparing data for new customer
		$email = 'test14@example.com';
		$customer->setEmail($email);
		$customer->setFirstname("test first");
		$customer->setLastname("test last");
		#$customer->setPassword("test123");
		$hashedPassword = $objectManager->get('\Magento\Framework\Encryption\EncryptorInterface')->getHash('MyNewPass', true);

		### Save data
		#$customer->save();
		$objectManager->get('\Magento\Customer\Api\CustomerRepositoryInterface')->save($customer, $hashedPassword);

		### Reload customer data
		$customer = $objectManager->get('\Magento\Customer\Model\CustomerFactory')->create();
		$customer->setWebsiteId($websiteId)->loadByEmail($email);
	}
	catch(Exception $e)
	{
		// stored in var/log/debug.log
		#$objectManager->get('\Psr\Log\LoggerInterface')->addDebug($e->getMessage());

		// stored in var/log/exception.log
		$objectManager->get('\Psr\Log\LoggerInterface')->addCritical($e);

		Zend_Debug::dump($e->getMessage());
	}

	if ($customer->getId()) {
		echo 'Succesfully Saved. Customer ID: ' . $customer->getId();
		echo PHP_EOL;

		### Add Address For created customer
		$address = $objectManager->get('\Magento\Customer\Api\Data\AddressInterfaceFactory')->create();

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
			->setStreet(['test street'])
			#->setSaveInAddressBook('1')
			->setIsDefaultBilling('1')
			->setIsDefaultShipping('1');

		try{
			$objectManager->get('\Magento\Customer\Api\AddressRepositoryInterface')->save($address);
		}
		catch (Exception $e) {
			Zend_Debug::dump($e->getMessage());
		}
	}
}
