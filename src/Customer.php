<?php

    Class Customer {
        private $id;
        private $name;
        private $email;
        private $address;
        private $password;
        private $funds;

        function __construct($id=null, $name, $email, $address, $password, $funds=0)
        {
            $this->id = $id;
            $this->name  = $name;
            $this->email = $email;
            $this->address = $address;
            $this->password = $password;
            $this->funds = $funds;
        }
        function getId()
        {
            return $this->id;
        }
        function getName()
        {
            return $this->name;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        function getEmail()
        {
            return $this->email;
        }
        function setEmail($new_email)
        {
            $this->email = $new_email;
        }
        function getAddress()
        {
            return $this->address;
        }
        function setAddress($new_address)
        {
            $this->address = $new_address;
        }
        function getPassword()
        {
            return $this->password;
        }
        function setPassword($new_password)
        {
            $this->password = $new_password;
        }
        function getFunds()
        {
            return $this->funds;
        }
        function setFunds($new_funds)
        {
            $this->funds = $new_funds;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO customers (name, email, address, password, funds) VALUES
            ('{$this->getName()}',
            '{$this->getEmail()}',
            '{$this->getAddress()}',
            '{$this->getEmail()}',
            '{$this->getFunds()}'
            );");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        //this will update all customer info at one time. this should only be used to update funds due to an error. for adding funds to customer, please use "addFunds" function
        function update($new_name, $new_email, $new_address, $new_password, $new_funds)
        {
        $GLOBALS['DB']-exec("UPDATE customers SET
            name= '{$new_name}',
            email = '{$new_email}',
            address = '{$new_address}',
            password = '{$new_passwprd}',
            funds = '{$new_funds}'
            WHERE id={$this->getId()};
             ");
        }
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM customers WHERE id='{$this->getID}';");
        }
        function pay($purchase_total)
        {
            $new_funds = $this->funds - $purchase_total;
            $this->funds = $new_funds;
            $GLOBALS['DB']-exec("UPDATE customers SET funds={$this->getFunds()} WHERE id={$this->getId()};");
        }
        function addFunds($new_funds)
        {
            $this->funds +=$new_funds;
            $GLOBALS['DB']->exec("UPDATE customers SET funds ={$this->getFunds()} WHERE
             id={$this-getFunds};");
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec('DELETE FROM customers');
        }
        static function getAll()
        {
            $returned_customers = $GLOBALS['DB']->query("SELECT * FROM customers");
            $customers = array();
            foreach($returned_customers as $customer)
            {
                $id = $customer['id'];
                $name = $customer['name'];
                $email = $customer['email'];
                $address = $customer['address'];
                $password = $customer['password'];
                $funds = $customer['funds'];
                $new_customer = Customer($id, $name, $email, $address, $password, $funds);
                $array_push($customers, $new_customer);
            }
            return $customers;
        }
        static function find($search_id)
        {
            $all_customers = Customer::getAll();
            foreach($all_customers as $customer)
            {
                if($customer->getId() == $search_id)
                {
                    $found_customer = $customer;
                }
            }
            return $customer;
        }
        //this will be used to both search by letter to display customer convienitly and to search for a customer name
        static function searchNameBystring($beginsWith){
            $found_customer = $GLOBALS['DB']->query("SELECT * FROM customer WHERE name LIKE '{$beginsWith}%';");
        }
        static function searchEmailBystring($beginsWith){
            $found_customer = $GLOBALS['DB']->query("SELECT * FROM customer WHERE email LIKE '{$beginsWith}%';");
        }









    }
 ?>
