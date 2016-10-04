<?php
// ./vendor/bin/phpunit tests
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Product.php";
    require_once "src/Category.php";


    $server = 'mysql:host=localhost;dbname=shoppr';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Product::deleteAll();
            Category::deleteAll();
        }

        function testSetName()
        {
            $test_name = "fruit";
            $test_id = 1;
            $test_category = new Category($test_name, $test_id);
            $test_category -> setName("produce");

            $result = $test_category->getName();

            $this->assertEquals("Produce", $result);
        }

        function testGetId()
        {
            $test_name = "fruit";
            $test_id = 1;
            $test_category = new Category($test_name, $test_id);

            $result = $test_category->getId();

            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            $test_name = "fruit";
            $test_id = null;
            $test_category = new Category($test_name, $test_id);
            $test_category->save();

            $result = Category::getAll();

            $this->assertEquals($test_category, $result[0]);
        }

        function testGetAll()
        {
            $test_name = "fruit";
            $test_id = null;
            $test_category = new Category($test_name, $test_id);
            $test_category->save();

            $test_name2 = "organic";
            $test_id2 = null;
            $test_category2 = new Category($test_name2, $test_id2);
            $test_category2->save();

            $result = Category::getAll();

            $this->assertEquals([$test_category, $test_category2], $result);
        }

        function testUpdateName()
        {
            $test_name = "fruit";
            $test_id = 1;
            $test_category = new Category($test_name, $test_id);
            $test_category->save();

            $new_test_name = "organic";

            $test_category -> updateCategory($new_test_name);

            $this->assertEquals("Organic", $test_category->getName());
        }

        function testDeleteAll()
        {
            $test_name = "fruit";
            $test_id = null;
            $test_category = new Category($test_name, $test_id);
            $test_category->save();

            $test_name2 = "organic";
            $test_id2 = null;
            $test_category2 = new Category($test_name2, $test_id2);
            $test_category2->save();

            Category::deleteAll();
            $result = Category::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $test_name = "fruit";
            $test_id = null;
            $test_category = new Category($test_name, $test_id);
            $test_category->save();

            $test_name2 = "organic";
            $test_id2 = null;
            $test_category2 = new Category($test_name2, $test_id2);
            $test_category2->save();

            $result = Category::find($test_category2->getId());

            $this->assertEquals($test_category2, $result);
        }

        function testSearchCategories()
        {
            $test_name = "organic apple";
            $test_id = null;
            $test_category = new Category($test_name, $test_id);
            $test_category->save();

            $test_name2 = "apples";
            $test_id2 = null;
            $test_category2 = new Category($test_name2, $test_id2);
            $test_category2->save();

            $result = Category::searchCategories("apple");

            $this->assertEquals([$test_category, $test_category2], $result);
        }

        function testAddProduct()
        {
            $test_name = "fruit";
            $test_id = null;
            $test_category = new Category($test_name, $test_id);
            $test_category->save();

            $test_name = "apple";
            $test_price = 1.00;
            $test_purchase_quantity = 2;
            $test_inventory = 5;
            $test_photo = "";
            $test_id = null;
            $test_product = new Product($test_name, $test_price, $test_purchase_quantity, $test_inventory, $test_photo, $test_id);
            $test_product->save();

            $test_category->addProduct($test_product);

            $this->assertEquals([$test_product], $test_category->getProducts());
        }

        function testGetProducts()
        {
            $test_name = "fruit";
            $test_id = null;
            $test_category = new Category($test_name, $test_id);
            $test_category->save();

            $test_name = "apple";
            $test_price = 1.00;
            $test_purchase_quantity = 2;
            $test_inventory = 5;
            $test_photo = "";
            $test_id = null;
            $test_product = new Product($test_name, $test_price, $test_purchase_quantity, $test_inventory, $test_photo, $test_id);
            $test_product->save();

            $test_name2 = "lettuce";
            $test_price2 = .75;
            $test_purchase_quantity2 = 1;
            $test_inventory2 = 5;
            $test_photo2 = "";
            $test_id2 = null;
            $test_product2 = new Product($test_name2, $test_price2, $test_purchase_quantity2, $test_inventory2, $test_photo2, $test_id2);
            $test_product2->save();

            $test_category->addProduct($test_product);
            $test_category->addProduct($test_product2);


            $this->assertEquals([$test_product, $test_product2], $test_category->getProducts());
        }
    }
?>
