<?php
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

$listBlock = $objectManager->get('\Magento\Catalog\Block\Product\ListProduct');

$productId = 1;

$product_obj = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);

$addToCartUrl =  $listBlock->getAddToCartUrl($product_obj);
?>

<form data-role="tocart-form" action="<?php echo $addToCartUrl; ?>" method="post">
    <?php echo $block->getBlockHtml('formkey')?>
       <button type="submit"
               title="Add to Cart"
               class="action tocart primary">
               <span>Add to Cart</span>
        </button>
 </form>

