# _Shopper

#### _A website to allow a user to shop online_

#### By _**Chris Martinez, Angela Smith, April Peng, Evan Stewart**_

## Description
_._


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



## Setup/Installation Requirements
* _Clone this repository to your desktop_
* _Run composer install from root_
* _Navigate to the web folder and begin your local server (php -S localhost:8000)_
 * _Begin MAMP_
* _Iinitialize new Database by doing the following:_
* _Begin MySql Shell by running $ /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot_
* _CREATE DATABASE shopper_
* _USE shopper_
* _CREATE TABLE products (id serial PRIMARY KEY, name VARCHAR(255), price FLOAT, purchase_quantity INT, inventory INT, category VARCHAR(255), photo BLOB)_
* _CREATE TABLE categories(id serial PRIMARY KEY, name VARCHAR(255))_
* _CREATE TABLE products_categories(id serial PRIMARY KEY, product_id INT, category_id INT)_
* _CREATE TABLE products (id serial PRIMARY KEY, name VARCHAR(255), price FLOAT, purchase_quantity INT, inventory INT, category VARCHAR(255), photo VARCHAR(255))_
* _CREATE TABLE customers (id serial PRIMARY KEY, name VARCHAR(255), email VARCHAR(255), address VARCHAR(255), password VARCHAR(255), funds INT)_


>>>>>>> f59e328331e696c2cdf36f4e6f484f9a587bb18d

* _Alternatively, unzip the database contained at the top level of this folder and import from phpmyadmin (http://localhost:8888/phpmyadmin/)_
* _in phpmyadmin, you may also  have to create another database for use with phpunit tests files by going to Operations> Copy Database To> and remaning database "shopper_test" and choosing "structure only"_

* _Change localhost routing in app.php (and php documents in tests folder) to localhost enabled for mySQL. ex mysql:...host=localhost:8889;dbname=....in MAMP, you can find this by going to  MAMP > Preferences > Ports> MySql Port_
* _In terminal, navigate to _
* _Open Browser and navigate to http://localhost:8000_
## Link
https://github.com/cmartinez84/hair_salon

## Known Bugs
_None yet_

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
