# _Shopper

#### _A website to allow a user to shop online_

#### By _**Chris Martinez, Angela Smith, April Peng, Evan Stewart**_

## Description
_._


## Specifications
| Behavior | Input Ex. | Output Ex. |
| Application will return inputted product information, such as name, price, purchase_quantity, inventory, category and photo | "Apple" | "Apple" |
| Application will show all products entered | "Apple", "Orange" | "Apple", "Orange"  |
| Product information can be updated, such as name, price, purchase_quantity, inventory, category and photo | "apple" | "granny smith" |
| All products can be deleted |  "Apple", "Orange"  | "" |
| The price and purchase_quantity will be multiplied to return a price for an individual product |  "Apple", 1.00, 2 | 2.00 |
| The price derived for each product will be added together to return a total price for the customer |  2.00, 3.95 | 5.95 |



## Setup/Installation Requirements
* _Clone this repository to your desktop_
* _Run composer install from root_
* _Navigate to the web folder and begin your local server (php -S localhost:8000)_
 * _Begin MAMP_
* _Iinitialize new Database by doing the following:_
* _Begin MySql Shell by running $ /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot_
* _CREATE DATABASE shopper_
* _USE shopper_
* _CREATE TABLE products (id serial PRIMARY KEY, name VARCHAR(255), price FLOAT, purchase_quantity INT, inventory INT, category VARCHAR(255), photo VARCHAR(255))_
<!-- * _CREATE TABLE clients(id, serial PRIMARY KEY, name VARCHAR(255), last_appointment VARCHAR(255), next_appointment VARCHAR(255))_ -->
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
