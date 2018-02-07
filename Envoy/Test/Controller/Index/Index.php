<?php
 /**Controller to auto add items to Cart**/
namespace Envoy\Test\Controller\Index;
 
 
class Index extends \Magento\Framework\App\Action\Action
{
    protected $_cart;
    protected $_product;
	protected $formKey; 
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Model\Product $product,
        \Magento\Checkout\Model\Cart $cart,
		\Magento\Framework\Data\Form\FormKey $formKey

        )
    {
        $this->_cart = $cart;
        $this->_product = $product;
		$this->_formKey = $formKey;

        return parent::__construct($context);
    }
  /**
     * Action to add product to cart and redirect to Shopping cart page
     *
     * @return checkout/cart
     */
    public function execute()
    {
        try { 					       

            $productId = (int)$this->getRequest()->getParam('id');
			
			if(is_numeric($productId)){ /** Validate the Product id*/
			    /**Below List of parameters will pass to Add to Cart function */
				$params = array(
                'form_key' => $this->_formKey->getFormKey(),
                'product' => $productId, //product Id
                'qty'   =>1 //Assuming quantity of product is 1               
                );  
                 /**Load Product By product ID */			
				$product = $this->_product->load($productId);
				/** Validate product status and inventory */	
                if($product && $product->getStatus()==1 && $product->getIsSalable()) {
					/** Add product to Cart */	
                    $this->_cart->addProduct($product, $params);
                    $this->_cart->save();
					$this->messageManager->addSuccessMessage('Product has been added to cart.');
                }else{
				$this->messageManager->addError('Product is not available.');
				}
			}else{
				$this->messageManager->addError('Invalid Product.');
			}
			  /** Below code will Redirect to Shopping Cart */
              return $this->resultRedirectFactory->create()->setPath('checkout/cart'); 
			  
  		}catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addException($e, __('%1', $e->getMessage()));
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('error.'));
        }
    }
}
/*Bonus Points*/
/*Assume id's are sent like id="1-2-3" and assume time stamp will be sent in url when it has been created. */
/** Execute function will be like below */
/*

 public function execute()
    {
		try { 	
			 //Start: code  for time stamp Validation
			 //Assuming both system uses same time Zone and system sends timestamp in URL,max url valid for 10 min.
			 $timestamp = $this->getRequest()->getParam('t');
			 $currenttime=time(); 
             $timeDiff=round(abs($to_time - $from_time) / 60,2);
			 if($timeDiff >10){
				$this->messageManager->addError('Sorry URL is invalid'); 
				//Below code will Redirect to Shopping Cart
              return $this->resultRedirectFactory->create()->setPath('checkout/cart'); 	
			 }
             //END: code  for time stamp Validation

			 $productIds = $this->getRequest()->getParam('id');
			 $productIdArray=explode("-",$productIds);
			 foreach($productIdArray as $productId){
				 if(is_numeric($productId)){ //Validate the Product id
			    //Below List of parameters will pass to Add to Cart
				$params = array(
                'form_key' => $this->_formKey->getFormKey(),
                'product' => $productId, //product Id
                'qty'   =>1 //Assuming quantity of product is 1               
                );  
                //Load Product By product ID		
				$product = $this->_product->load($productId);
				// Validate product status and inventory
					if($product && $product->getStatus()==1 && $product->getIsSalable()) {
						//Add product to Cart	
						$this->_cart->addProduct($product, $params);
						$this->_cart->save();
						$this->messageManager->addSuccessMessage('Product ID{$productId} has been added to cart.');
					}else{
				     $this->messageManager->addError('Product ID {$productId} is not available.');
				    } 
				 }else{
					 $this->messageManager->addError('Invalid Product ID {$productId}.');
				 }
			}
			//Below code will Redirect to Shopping Cart
              return $this->resultRedirectFactory->create()->setPath('checkout/cart'); 	 
			
		}catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addException($e, __('%1', $e->getMessage()));
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('error.'));
        }	 
		
	}
*/
