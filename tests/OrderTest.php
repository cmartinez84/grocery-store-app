<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Order.php";

    $server = 'mysql:host=localhost:8889;dbname=shoppr';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class OrderTest extends PHPUnit_Framework_TestCase
    {
        protected function teardown()
        {
            Order::deleteAll();
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

            Order::deleteAll();
            $result = Order::getAll();

            $this->assertEquals([], $result);



        }

    }
?>
