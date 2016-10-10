# _Shopper

#### _A website to allow a user to shop online_

#### By _**Chris Martinez, Angela Smith, April Peng, Evan Stewart**_

## Description
_This app is a demo of an online grocery store for in-store pick up or delivery with customer accounts to pay for purchases, rather than direct payment with card. This app contains two discreet user interfaces for separate admin and customer experiences, using php session variables to control functionality for both types of users. An admin can log in using the email admin@shoppr.com and the password  "@dm1n", where they will be able to control inventory, enter new categories of products, edit associations between categories and product, and product descriptions. A customer or guest user will not have access to this page and will be directed to a warning page if an attempt to access this route  directly by typing the url. The user experience begins as a guest browsing the page beginning to shop. Without login, clicking an add-to-cart button will prompt the user to sign in, sign up for a membership, or enter a confirmation code to become a new user. A new user will be sent a confirmation email with a code to enter on the sign in prompt. Once the code is entered, the new user will be logged in and can begin shopping and adding products to their virtual cart. Upon checkout, the customer can review their items, and if funds are insufficient, they will not be able to finalize their purchase, but instead, be directed to add funds to their account(which is not currently linked to any payment processing) from the My Profile page, which allows them to edit and terminate their membership as well. With funds, the customer selects Finalize, delivery/pick up options, and an option to have their receipt emailed. The customer will then be directed to their profile page with a record of their last purchase, as well as purchase history. *This app is for demo purposes only and does not use encryption; please do not enter any sensitive information such a passwords used on other sites or real credit card information*.


## Specifications
| Behavior | Input Ex. | Output Ex. |
| --- | --- | --- |
| Application will return inputted product information, such as name, price, purchase_quantity, inventory, category and photo | "Apple" | "Apple" |
| Application will return all products entered | "Apple", "Orange" | "Apple", "Orange"  |
| Product information can be updated, such as name, price, purchase_quantity, inventory, category and photo | "apple" | "granny smith" |
| All products can be deleted |  "Apple", "Orange"  | "" |
| Application will return a product the user searches for | "Apple", "Orange" | "Apple" |
| The user will be informed that there is not enough inventory if the purchase_quantity is greater than the inventory |  "Apple", 3  | "Not enough inventory" |
| The price and purchase_quantity will be multiplied to return a price for an individual product |  "Apple", 1.00, 2 | 2.00 |
| Application will return inputted category | "fruit" | "fruit" |
| Application will return all categories entered | "fruit", "meat" | "fruit", "meat" |
| Product name can be updated | "fruit" | "produce" |
| All categories can be deleted | "fruit", "meat" | "" |
| Application will return a category the user searches for | "fruit", "meat" | "fruit" |
| A product can be added to a category | "fruit", "apple" | "apple" |
| All products will be returned for a category | "fruit", "apple", "banana" | "apple", "banana" |
| A category can be added to a product | "fruit", "apple" | "fruit" |
| All categories will be returned for a product | "apple", "fruit", "organic" |"fruit", "organic" |
|create customer account and send confirmation code| code : 8hj384| entering 8hj384 on confirmation code registers customer|
|each log in begins a new Order instance with all purchase info| login| records time, begins cart with empty array, and records user ID|
|entering quantity and clicking plug by prouct pushes product object to cart array in Order instance| quantity: 3, + clicked| product price, quantity, name, id, and methods to calculate subtotal are locked into cart record via Product instance|
|delete item from cart| "remove clicked"| all items that share Product id are destroyed|
|if a Prouct of the same id is pushed again to the cart, they cart will not conatain two like products| Product instance with 3 pushed to cart| order "remove" function removes like Product and replaces it with new Product instance|
|Each time an item is pushed, a new total is recorded in the order sesssion variable|3 apples added| calculate  method runs, and total is updated|
|Order class calculates total via foreach loop with Product clas method to calculate subtotal| finalize order clicked|all subtotals are added and become order total|
|on finalizing order, order cost is deducted from Customer funds| finalize for $50.00, customer has $200.00 in store credit| customer has new balance of $150.00|




## Setup/Installation Requirements
* _Clone this repository to your desktop_
* _Run composer install from root_
* _Navigate to the web folder and begin your local server (php -S localhost:8000)_
 * _Begin MAMP_
* _Iinitialize new Database by doing the following:_
* _Begin MySql Shell by running $ /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot_
* _CREATE DATABASE shoppr_
* _USE shoppr_
* _CREATE TABLE products (id serial PRIMARY KEY, name VARCHAR(255), price FLOAT, purchase_quantity INT, inventory INT, category VARCHAR(255), photo VARCHAR(255))_
* _CREATE TABLE categories(id serial PRIMARY KEY, name VARCHAR(255))_
* _CREATE TABLE products_categories(id serial PRIMARY KEY, product_id INT, category_id INT)_
* _CREATE TABLE customers (id serial PRIMARY KEY, name VARCHAR(255), email VARCHAR(255), address VARCHAR(255), password VARCHAR(255), funds INT)_
* _CREATE TABLE orders (id serial PRIMARY KEY, user_id INT, cart LONGTEXT,  order_date VARCHAR(255), delivery_date_time VARCHAR(255))_;
* _CREATE TABLE confirmation_staging(id serial PRIMARY KEY, customer_serialized LONGTEXT, confirmation_code VARCHAR(255))_;


* _Alternatively, unzip the database contained at the top level of this folder and import from phpmyadmin (http://localhost:8888/phpmyadmin/)_
* _in phpmyadmin, you may also  have to create another database for use with phpunit tests files by going to Operations> Copy Database To> and remaning database "shopper_test" and choosing "structure only"_

* _Change localhost routing in app.php (and php documents in tests folder) to localhost enabled for mySQL. ex mysql:...host=localhost:8889;dbname=....in MAMP, you can find this by going to  MAMP > Preferences > Ports> MySql Port_
* _In terminal, navigate to _
* _Open Browser and navigate to http://localhost:8000_
## Link
https://github.com/cmartinez84/grocery-store-app_
## Known Bugs
_In order to use this projects email feature (for both confirmation code and receipt functionality), you must have email enabled on your local server. If using MAMP PRO, you will need to go to MAMP PRO >  SERVER > Postfix to enable.
If using MAMP, you can configure your server to send email with instructions located here: http://www.blog.tripleroi.com/2012/05/solvedenabling-sendmail-on-localhost.html.
Based on its provinance, some email carriers may not accept or will classify emails from this app as Spam.
If email you are unable to access your personlitzed confirmation code via email, you may view your code in the shoppr database under the table "confirmation_staging". As instructions are in the email, navigate to any Sign Up and click "Enter Confirmation Code".

## Support and contact details
_cardamomclouds@yahoo.com_

## Technologies Used
_HTML,
CSS,
Bootstrap,
JS,
jQuery
PHP,
TWIG,
Silex,
mySQL_

### License
The MIT License (MIT)

Copyright (c) 2016 #### By _**Chris Martinez, Angela Smith, April Peng, Evan Stewart**_
