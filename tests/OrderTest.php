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
    class BookTest extends PHPUnit_Framework_TestCase
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
            $purchase_total = 40;
            $purchase_date = 2016-10-01;
            $quantity = 5;
            $test_order = new Order($user_id, $product_id, $purchase_total, $purchase_date, $quantity, $id);

            $result = $test_order->getId();
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_total = 40;
            $purchase_date = 2016-10-01;
            $quantity = 5;
            $test_order = new Order($user_id, $product_id, $purchase_total, $purchase_date, $quantity);

            $test_order->save();
            $result = Order::getAll();

            $this->assertEquals($test_order, $result[0]);
        }

        function test_getAll()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_total = 40;
            $purchase_date = 2016-10-01;
            $quantity = 5;
            $test_order = new Order($user_id, $product_id, $purchase_total, $purchase_date, $quantity);
            $user_id2 = 2;
            $product_id2 = 2;
            $purchase_total2 = 35;
            $purchase_date2 = 2016-09-30;
            $quantity2 = 7;
            $test_order2 = new Order($user_id2, $product_id2, $purchase_total2, $purchase_date2, $quantity2);

            $test_order->save();
            $test_order2->save();
            $result = Order::getAll();

            $this->assertEquals([$test_order, $test_order2], $result);
        }

        // function test_find()
        // {
        //     $title = "Prisoner of Azkaban";
        //     $test_book = new Book($title);
        //     $test_book->save();
        //     $title2 = "Sorcerer's Stone";
        //     $test_book2 = new Book($title);
        //     $test_book2->save();
        //     $search_id = $test_book->getId();
        //     $result = Book::find($search_id);
        //     $this->assertEquals($test_book, $result);
        // }
        // function test_delete()
        // {
        //     $title = "Prisoner of Azkaban";
        //     $test_book = new Book($title);
        //     $test_book->save();
        //     $title2 = "Sorcerer's Stone";
        //     $test_book2 = new Book($title);
        //     $test_book2->save();
        //     $test_book->delete();
        //     $result = Book::getAll();
        //     $this->assertEquals([$test_book2], $result);
        // }

        function test_deleteAll()
        {
            $user_id = 1;
            $product_id = 1;
            $purchase_total = 40;
            $purchase_date = 2016-10-01;
            $quantity = 5;
            $test_order = new Order($user_id, $product_id, $purchase_total, $purchase_date, $quantity);
            $user_id2 = 2;
            $product_id2 = 2;
            $purchase_total2 = 35;
            $purchase_date2 = 2016-09-30;
            $quantity2 = 7;
            $test_order2 = new Order($user_id2, $product_id2, $purchase_total2, $purchase_date2, $quantity2);

            $test_order->save();
            $test_order2->save();
            Order::deleteAll();
            $result = Order::getAll();

            $this->assertEquals([], $result);
        }

        // function test_update()
        // {
        //     $title = "Prisoner of Azkaban";
        //     $test_book = new Book($title);
        //     $test_book->save();
        //     $new_title = "Order of the Phoenix";
        //     $test_book->update($new_title);
        //     $result = $test_book->getTitle();
        //     $this->assertEquals($new_title, $result);
        // }
        // function test_addAuthor()
        // {
        //     $title = "Prisoner of Azkaban";
        //     $test_book = new Book($title);
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
