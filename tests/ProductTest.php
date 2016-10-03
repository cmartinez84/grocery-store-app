<?php
// ./vendor/bin/phpunit tests
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Product.php";

    $server = 'mysql:host=localhost:8889;dbname=shopper_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class ProductTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Product::deleteAll();
        }

        function testSetName()
        {
            $name = "apple";
            $price = 1.00;
            $purchase_quantity = 2;
            $inventory = 5;
            $photo = "";
            $id = 1;
            $test_name = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);
            $test_name -> setName("granny smith");

            $result = $test_name->getName();

            $this->assertEquals("granny smith", $result);
        }

        function testSetPrice()
        {
            $name = "apple";
            $price = 1.00;
            $purchase_quantity = 2;
            $inventory = 5;
            $photo = "";
            $id = 1;
            $test_name = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);
            $test_name -> setPrice(1.89);

            $result = $test_name->getPrice();

            $this->assertEquals(1.89, $result);
        }

        function testSetPurchaseQuantity()
        {
            $name = "apple";
            $price = 1.00;
            $purchase_quantity = 2;
            $inventory = 5;
            $photo = "";
            $id = 1;
            $test_name = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);
            $test_name -> setPurchaseQuantity(3);

            $result = $test_name->getPurchaseQuantity();

            $this->assertEquals(3, $result);
        }

        function testSetInventory()
        {
            $name = "apple";
            $price = 1.00;
            $purchase_quantity = 2;
            $inventory = 5;
            $photo = "";
            $id = 1;
            $test_name = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);
            $test_name -> setInventory(4);

            $result = $test_name->getInventory();

            $this->assertEquals(4, $result);
        }

        function testSetPhoto()
        {
            $name = "apple";
            $price = 1.00;
            $purchase_quantity = 2;
            $inventory = 5;
            $photo = "";
            $id = 1;
            $test_name = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);
            $test_name -> setName("apple.jpeg");

            $result = $test_name->getPhoto();

            $this->assertEquals("apple.jpeg", $result);
        }

        function getId()
        {
            $name = "apple";
            $price = 1.00;
            $purchase_quantity = 2;
            $inventory = 5;
            $photo = "";
            $id = 1;
            $test_name = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);

            $result = $test_name->getId();

            $this->assertEquals(1, $result);
        }
    }
?>
