<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Order.php";
    require_once "src/Product.php";


    $server = 'mysql:host=localhost:8889;dbname=shoppr_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class OrderTest extends PHPUnit_Framework_TestCase
    {
        protected function teardown()
        {
            Order::deleteAll();
            Product::deleteAll();
        }

        function test_getId()
        {
            $id = 1;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);

            $result = $test_order->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_getUserId()
        {
            $id = 1;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);

            $result = $test_order->getId();

            $this->assertEquals(1, $result);
        }

        function test_getOrderDate()
        {
            $id = 1;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);

            $result = $test_order->getOrderDate();

            $this->assertEquals($order_date, $result);
        }

        function test_save()
        {
            $id = null;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);
            $test_order->save();
            $result = Order::getAll();

            $this->assertEquals([$test_order], $result);
        }

        function test_getAll()
        {
            $id = null;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);
            $test_order->save();

            $id2 = null;
            $user_id2 = 1;
            $order_date2 = "2016-10-01";
            $delivery_date_time2 = "2016-10-02";
            $test_order2 = new Order($id2, $user_id2, $order_date2, $delivery_date_time2);
            $test_order2->save();
            $result = Order::getAll();

            $this->assertEquals([$test_order, $test_order2], $result);
        }

        function test_find()
        {
            $id = null;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);
            $test_order->save();

            $id2 = null;
            $user_id2 = 1;
            $order_date2 = "2016-10-01";
            $delivery_date_time2 = "2016-10-02";
            $test_order2 = new Order($id2, $user_id2, $order_date2, $delivery_date_time2);
            $test_order2->save();
            $test_order2_id = $test_order2->getId();
            $result = Order::find($test_order2_id);

            $this->assertEquals($test_order2, $result);

        }

        function test_delete()
        {
            $id = null;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);
            $test_order->save();

            $id2 = null;
            $user_id2 = 1;
            $order_date2 = "2016-10-01";
            $delivery_date_time2 = "2016-10-02";
            $test_order2 = new Order($id2, $user_id2, $order_date2, $delivery_date_time2);
            $test_order2->save();

            $test_order2->delete();
            $result = Order::getAll();

            $this->assertEquals([$test_order], $result);
        }

        function test_deleteAll()
        {
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);
            $test_order->save();

            $user_id2 = 1;
            $order_date2 = "2016-10-01";
            $delivery_date_time2 = "2016-10-02";
            $test_order2 = new Order($id, $user_id2, $order_date2, $delivery_date_time2);
            $test_order2->save();

            Order::deleteAll();
            $result = Order::getAll();

            $this->assertEquals([], $result);

        }

        function test_addProductToCart()
        {
            $id = null;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);
            $test_order->save();

            $test_name = "apple";
            $test_price = 1.00;
            $test_purchase_quantity = 3;
            $test_inventory = 5;
            $test_photo = "";
            $test_id = null;
            $test_product = new Product($test_name, $test_price, $test_purchase_quantity, $test_inventory, $test_photo, $test_id);

            //Act
            $test_order->addProductToCart($test_product);
            $result = $test_order->getCart();
            $this->assertEquals([$test_product], $result);
        }

        function test_getCartTotal()
        {
            $id = null;
            $user_id = 1;
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($id, $user_id, $order_date, $delivery_date_time);
            $test_order->save();


            $test_purchase_quantity = 3;
            $test_price = 1.00;
            $test_product = new Product("apple", $test_price, $test_purchase_quantity, 9, "", null);

            $test_purchase_quantity2 = 2;
            $test_price2 = 2.00;
            $test_product2 = new Product("apple", $test_price2, $test_purchase_quantity2, 9, "", null);

            //
            // //Act
            $test_order->addProductToCart($test_product);
            $test_order->addProductToCart($test_product2);
            $result =$test_order->getCartTotal();
            echo $result;
            $this->assertEquals(7, $result);
            }


    }
?>
