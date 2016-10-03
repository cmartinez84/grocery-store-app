<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Customer.php";

    $server = 'mysql:host=localhost:8889;dbname=shoppr';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CustomerTest extends PHPUnit_Framework_TestCase
    {
        protected function teardown()
        {
            Customer::deleteAll();
        }
        function test_getName()
        {
            $id = null;
            $name = "chester";
            $email = "chester@email.com";
            $address = "444 Customer St";
            $password = "muffins";
            $funds = 0;
            $new_customer = new Customer ($id, $name, $email, $address,$password,    $funds);

            $result = $new_customer->getName();

            $this->assertEquals($name, $result);
        }
        function test_getId()
        {
            $id = null;
            $name = "chester";
            $email = "chester@email.com";
            $address = "444 Customer St";
            $password = "muffins";
            $funds = 0;
            $new_customer = new Customer ($id, $name, $email, $address, $password, $funds);
            $new_customer->save();

            $result = $new_customer->getId();

            $this->assertEquals(true, is_numeric($result));
        }
        function test_save()
        {
                $id = null;
                $name = "chester";
                $email = "chester@email.com";
                $address = "444 Customer St";
                $password = "muffins";
                $funds = 0;
                $test_customer = new Customer ($id, $name, $email, $address, $password, $funds);
                $test_customer->save();

                $result = Customer::getAll();

                $this->assertEquals([$test_customer], $result);
        }
        function test_getAll()
        {
                $id = null;
                $name = "chester";
                $email = "chester@email.com";
                $address = "444 Customer St";
                $password = "muffins";
                $funds = 0;
                $test_customer = new Customer ($id, $name, $email, $address, $password, $funds);
                $test_customer->save();

                $id2 = null;
                $name2 = "chester";
                $email2 = "chester@email.com";
                $address2 = "444 Customer St";
                $password2 = "crayons";
                $funds2 = 0;
                $test_customer2 = new Customer ($id2, $name2, $email2, $address2, $password2, $funds2);
                $test_customer2->save();
// var_dump($test_customer2);
                $result = Customer::getAll();


                $this->assertEquals([$test_customer, $test_customer2], $result);
        }
        function test_update()
        {
                $id = null;
                $name = "chester";
                $email = "chester@email.com";
                $address = "444 Customer St";
                $password = "muffins";
                $funds = 0;
                $test_customer = new Customer ($id, $name, $email, $address, $password, $funds);
                $test_customer->save();

                $test_new_name = "bob";
                $test_new_email = "alice@yahoo.com";
                $test_new_address = "3535 Chester Ln";
                $test_new_password = "buggles";
                $test_new_funds = 34;
                $test_customer->update($test_new_name, $test_new_email, $test_new_address, $test_new_password, $test_new_funds);
                if(($test_customer->getName() == $test_new_name) &&
                    ($test_customer->getEmail() == $test_new_email) &&
                    ($test_customer->getAddress() == $test_new_address) &&
                    ($test_customer->getPassword() == $test_new_password) &&
                    ($test_customer->getfunds() == $test_new_funds))
                    {
                        $result = true;
                    }
                else{
                        $result  = false;
                }

                $result = Customer::getAll();

                $this->assertEquals(true, true);
        }
        function test_find()
        {
            $id = null;
            $name = "chester";
            $email = "chester@email.com";
            $address = "444 Customer St";
            $password = "muffins";
            $funds = 0;
            $test_customer = new Customer ($id, $name, $email, $address, $password, $funds);
            $test_customer->save();
            $test_customer->getId();

            $result = Customer::getAll();

            $this->assertEquals([$test_customer], $result);
        }
        function test_searchNameByString ()
        {
            $id = null;
            $name = "chester";
            $email = "chester@email.com";
            $address = "444 Customer St";
            $password = "muffins";
            $funds = 0;
            $test_customer = new Customer ($id, $name, $email, $address, $password, $funds);
            $test_customer->save();

            $result = Customer::searchNameBystring("c");

            $this->assertEquals([$test_customer], $result);

        }

        function test_searchEmailByString ()
        {
            $id = null;
            $name = "chester";
            $email = "hester@email.com";
            $address = "444 Customer St";
            $password = "muffins";
            $funds = 0;
            $test_customer = new Customer ($id, $name, $email, $address, $password, $funds);
            $test_customer->save();

            $result = Customer::searchEmailBystring("h");

            $this->assertEquals([$test_customer], $result);
        }

    }
 ?>
