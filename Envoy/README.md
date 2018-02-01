Steps to execute the PHP-Magento2 Module for Programmatically executing the functionality of Adding Products to Cart and re-directing to the Shopping Cart Page with valid success or error messages

1) Place the entire code / module in the app/code folder. Please create this folder in your system in case this folder does not exist

2) Execute the following commands
   
   bin/magento setup:upgrade
   
   bin/magento cache:clean

3) Verify in app/etc/config.php that the ENVOY_TEST module is set 1.
   
