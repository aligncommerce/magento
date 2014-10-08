==== Align Commerce Payment Gateway for Magento ====

Plugin Name: Magento - Align Commerce Payment Gateway
Plugin URI: https://aligncommerce.com/docs/libraries-plugins-ecommerce-websites/#plugins-magento1900
Version: 1.0.0
Author: Align Commerce Corporation
Author URI: https://aligncommerce.com
License: GPLv2

== Description ==

The Align Commerce payment gateway for Magento will allow you to accept payments on your Magento installation in the form of local currency via bank transfers and/or via Bitcoin

== Installation ==

Getting Started:
You will need to generate your API keys - https://aligncommerce.com/dashboard/keys 
You will also need your Align Commerce dashboard email and password on your plugin settings

Step 1 - Check Permissions
Make sure the ‘‘app’’ and “lib” directories of your Magento installation and all subdirectories have full write permissions. If not, set permissions on the each directory to 777 or 0777.
Important! Change all permissions back after installation.
Read more info re permission at:
http://www.magentocommerce.com/wiki/magento_filesystem_permissions

Step 2 - Disable Compilation
Log into Magento Admin Panel and go to System - Tools - Compilation and disable the compilation.
After step 5 you can run the compilation process again.

Step 3 - Upload Files
Upload all folders from the extension package to the installation directory of your Magento software using any FTP client.

Step 4 - Clear cache
Go to System - Cache Management. Clear the store cache.

Step 5 - Re-login
Log out and log back into Magento Admin Panel.

Note:  In Magento, return URL and IPN URL should be in the format below.
Return URL: http://yoursite.com/index.php/bitcoin/
IPN URL: http://yoursite.com/index.php/bitcoin/ipn
