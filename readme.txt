=== WordForce Lead ===
Contributors: roushanbugendai234
Tags: WP Salesforce, WordPress Salesforce org, wordpress salesforce, wordpress salesforce integration, salesforce, wordpress salesforce form plugin, wordpress and salesforce integration, wordpress and Salesforce connection, Salesforce Contact Object, Contact Object
Requires at least: 4.7
Tested up to: 6.2
Requires PHP:  7.4.3
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordForce Lead Plugin is integration between WordPress and Salesforce CRM.

== Description ==


WordForce Lead Plugin is integration between WordPress and Salesforce CRM with Real Time Synchronization functionality.
WordForce Lead Plugin sends the form submissions from wordpress website to salesforce contact object wherein form is implemented in the plugin itself.


Users can add contact form using shortcode as [WF_LEAD] and After submission of form lead directly goes to the Salesforce contact object .


No more copy pasting of leads, Also Users can get rid of missing leads.

==Features==

You can configure all the different settings for the form, and then use a shortcode to insert the form into your posts or pages.
Real Time Synchronization functionality is available , users can just click on the “Click to Sync” button for the lead which is not submitted to salesforce org but appears in wordpress submission data.


==Installation==

Upload the plugin folder to the /wp-content/plugins/ directory or install via the Add New Plugin menu
Activate the plugin through the ‘Plugins’ menu in WordPress
Configure the plugin setting using WordForce Lead Menu.


== How to Set Up ==


* Go to "Credential Settings” Submenu and then enter the salesforce org details.
* Insert the Shortcode as [WF_LEAD]  to the page or post where form needs to be implemented 
* Send the lead entry by filling up the form
* Go to “Salesforce Org" Contact object and verify if entry was sent to Salesforce.

**Setup in Salesforce Org
Login to your Salesforce account or you can create a new account.
Create a custom field with name 'Address' from object manager in contact object as text type.
Switch to the classic mode of the org-> Setup from the right side top bar.
Create a connected app from left sidebar: Build-> Create -> Apps
Enable API (Enable OAuth Settings)
Add  OAuth Scopes “Access and manage your data (api)”
Click on Save
Security Token: 
Click on the down arrow appearing besides your profile name in top bar-> Click on “My settings”-> From left sidebar under Personal tab 
Click on “Reset My Security Token”/ Or search Token in Quick find box from left sidebar.
You will receive a security token on your email (we will need this token further for pursuing the connection )


** WordForce Lead Submenus

General Setting
Form customization like Changing button color, Label , placeholder, width, font-size, can be pursued from General Setting.

Credential Settings
Enter the mandatory details required for connecting to salesforce org 
Consumer Key, Consumer Secret will be available in connected app created in org
Enter Salesforce Org’s username and password and security token associated with your salesforce org.
Enter Login Base URL as “http://login.salesforce.com”

View Submitted Data
Lead submission entries would be available here
If any of the submission fails to send the data, we can manually send that entry to Salesforce Org’s Contact by clicking on “Click to Sync” button

 

== Frequently Asked Questions ==


== Screenshots ==

== Changelog ==



