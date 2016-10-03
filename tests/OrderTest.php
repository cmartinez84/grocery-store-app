<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Order.php";

    $server = 'mysql:host=localhost;dbname=shoppr_test';
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
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time, $id);

            $result = $test_order->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_getUserId()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);

            $result = $test_order->getUserId();

            $this->assertEquals($user_id, $result);
        }

        function test_getProductId()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);

            $result = $test_order->getProductId();

            $this->assertEquals($product_id, $result);
        }

        function test_getPurchaseQuantity()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);

            $result = $test_order->getPurchaseQuantity();

            $this->assertEquals($purchase_quantity, $result);
        }

        function test_getPurchasePrice()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);

            $result = $test_order->getPurchasePrice();

            $this->assertEquals($purchase_price, $result);
        }

        function test_getOrderDate()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);

            $result = $test_order->getOrderDate();

            $this->assertEquals($order_date, $result);
        }

        function test_save()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);

            $test_order->save();
            $result = Order::getAll();

            $this->assertEquals($test_order, $result[0]);
        }

        function test_getAll()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);
            $user_id2 = 1;
            $product_id2 = 1;
            $purchase_quantity2 = "4";
            $purchase_price2 = "2.50";
            $purchase_subtotal2 = "10";
            $order_date2 = "2016-10-01";
            $delivery_date_time2 = "2016-10-02";
            $test_order2 = new Order($user_id2, $product_id2, $purchase_quantity2, $purchase_price2, $purchase_subtotal2, $order_date2, $delivery_date_time2);

            $test_order->save();
            $test_order2->save();
            $result = Order::getAll();

            $this->assertEquals([$test_order, $test_order2], $result);
        }

        function test_find()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);
            $user_id2 = 1;
            $product_id2 = 1;
            $purchase_quantity2 = "4";
            $purchase_price2 = "2.50";
            $purchase_subtotal2 = "10";
            $order_date2 = "2016-10-01";
            $delivery_date_time2 = "2016-10-02";
            $test_order2 = new Order($user_id2, $product_id2, $purchase_quantity2, $purchase_price2, $purchase_subtotal2, $order_date2, $delivery_date_time2);

            $test_order->save();
            $test_order2->save();
            $search_id = $test_order->getId();
            $result = Order::find($search_id);

            $this->assertEquals($test_order, $result);
        }

        function test_delete()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);
            $user_id2 = 1;
            $product_id2 = 1;
            $purchase_quantity2 = "4";
            $purchase_price2 = "2.50";
            $purchase_subtotal2 = "10";
            $order_date2 = "2016-10-01";
            $delivery_date_time2 = "2016-10-02";
            $test_order2 = new Order($user_id2, $product_id2, $purchase_quantity2, $purchase_price2, $purchase_subtotal2, $order_date2, $delivery_date_time2);

            $test_order->save();
            $test_order2->save();
            $test_order->delete();
            $result = Order::getAll();
            $this->assertEquals([$test_order2], $result);
        }

        function test_deleteAll()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_quantity = "4";
            $purchase_price = "2.50";
            $purchase_subtotal = "10";
            $order_date = "2016-10-01";
            $delivery_date_time = "2016-10-02";
            $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);
            $user_id2 = 1;
            $product_id2 = 1;
            $purchase_quantity2 = "4";
            $purchase_price2 = "2.50";
            $purchase_subtotal2 = "10";
            $order_date2 = "2016-10-01";
            $delivery_date_time2 = "2016-10-02";
            $test_order2 = new Order($user_id2, $product_id2, $purchase_quantity2, $purchase_price2, $purchase_subtotal2, $order_date2, $delivery_date_time2);

            $test_order->save();
            $test_order2->save();
            Order::deleteAll();
            $result = Order::getAll();

            $this->assertEquals([], $result);
        }

        // function test_addPurchase()
        // {
        //     $user_id = 1;
        //     $product_id = 1;
        //     $purchase_quantity = "4";
        //     $purchase_price = "2.50";
        //     $purchase_subtotal = "10";
        //     $order_date = "2016-10-01";
        //     $delivery_date_time = "2016-10-02";
        //     $test_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time);
        //     $test_order->save();
        //
        //     $new_product_id = 2;
        //     $new_purchase_quantity = "5";
        //     $new_purchase_price = "2.00";
        //     $test_order->addPurchase();
        //
        //     $result = array($test_order->getUserId, $test_order->getProductId, $test_order->getPurchaseQuantity, $test_order->getPurchasePrice, $test_order->getPurchaseSubtotal);
        //
        //     $this->assertEquals([1, "1, 2", "4, 5", "2.50, 2.00", "10, 10"], $result);
        //
        // }
        //
        // function test_updateAllFields()
        // {
        //     $user_id = 1;
        //     $product_id = 1;
        //     $purchase_total = 40;
        //     $purchase_date = "2016-10-01";
        //     $quantity = 5;
        //     $test_order = new Order($user_id, $product_id, $purchase_total, $purchase_date, $quantity);
        //     $test_order->save();
        //     $new_product_id = 2;
        //     $new_purchase_total = 46;
        //     $new_quantity = 7;
        //
        //     $test_order->userUpdate($new_product_id, $new_purchase_total, $new_quantity);
        //     $result = array($test_order->getProductId(), $test_order->getPurchaseTotal(), $test_order->getQuantity());
        //
        //     $this->assertEquals([$new_product_id, $new_purchase_total, $new_quantity], $result);
        // }

        // function test_addAuthor()
        // {
        //     $title = "Prisoner of Azkaban";
        //     $test_order = new Book($title);
        //     $test_book->save();
        //     $name = "JK Rowling";
        //     $test_author = new Author($name);
        //     $test_author->save();
        //     $test_book->addAuthor($test_author->getId());
        //     $this->assertEquals([$test_author], $test_book->getAuthors());
        // }

        // function test_getAuthors()
        // {
        //     $title = "Prisoner of Azkaban";
        //     $test_book = new Book($title);
        //     $test_book->save();
        //     $name = "JK Rowling";
        //     $test_author = new Author($name);
        //     $test_author->save();
        //     $name2 = "Shel Silverstein";
        //     $test_author2 = new Author($name2);
        //     $test_author2->save();
        //     $test_book->addAuthor($test_author->getId());
        //     $test_book->addAuthor($test_author2->getId());
        //     $this->assertEquals([$test_author, $test_author2], $test_book->getAuthors());
        // }

        // function test_searchBooks()
        // {
        //     $title = "Prisoner of Azkaban";
        //     $test_book = new Book($title);
        //     $test_book->save();
        //     $title2 = "Chamber of Secrets";
        //     $test_book2 = new Book($title2);
        //     $test_book2->save();
        //     $title3 = "Prisma Colored Stone";
        //     $test_book3 = new Book($title3);
        //     $test_book3->save();
        //     $name = "JK Rowling";
        //     $test_author = new Author($name);
        //     $test_author->save();
        //     $test_book->addAuthor($test_author->getId());
        //     $test_book2->addAuthor($test_author->getId());
        //     $search_input = "of";
        //     $result = Book::searchBooks($search_input);
        //     $this->assertEquals([[$test_book, [$test_author]],[$test_book2, [$test_author]]], $result);
        // }

        // function test_searchAuthors()
        // {
        //     $title = "Prisoner of Azkaban";
        //     $test_book = new Book($title);
        //     $test_book->save();
        //     $title2 = "Chamber of Secrets";
        //     $test_book2 = new Book($title2);
        //     $test_book2->save();
        //     $title3 = "Prisma Colored Stone";
        //     $test_book3 = new Book($title3);
        //     $test_book3->save();
        //     $name = "JK Rowling";
        //     $test_author = new Author($name);
        //     $test_author->save();
        //     $name2 = "Shel Silverstein";
        //     $test_author2 = new Author($name2);
        //     $test_author2->save();
        //     $test_book->addAuthor($test_author->getId());
        //     $test_book2->addAuthor($test_author->getId());
        //     $test_book3->addAuthor($test_author2->getId());
        //     $search_input = "rowl";
        //     $result = Book::searchBooks($search_input);
        //     $this->assertEquals([[$test_book, [$test_author]],[$test_book2, [$test_author]]], $result);
        // }
    }
?>
