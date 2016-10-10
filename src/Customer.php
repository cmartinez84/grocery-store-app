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
            '{$this->getPassword()}',
            {$this->getFunds()}
            );");
            $this->id = $GLOBALS['DB']->lastInsertId();
            return $this->getId();
        }
        //this will update all customer info at one time. this should only be used to update funds due to an error. for adding funds to customer, please use "addFunds" function
        function update($new_name, $new_email, $new_address, $new_password, $new_funds)
        {
            $GLOBALS['DB']->exec("UPDATE customers SET
                name= '{$new_name}',
                email = '{$new_email}',
                address = '{$new_address}',
                password = '{$new_password}',
                funds = '{$new_funds}'
                WHERE id= {$this->getId()};
                 ");

            $this->name = $new_name;
            $this->email = $new_email;
            $this->address = $new_address;
            $this->password = $new_password;
            $this->funds = $new_funds;
        }
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM customers WHERE id='{$this->getId()}';");
        }
        function pay($purchase_total)
        {
            $new_funds = $this->funds - $purchase_total;
            $this->funds = $new_funds;
            $GLOBALS['DB']->exec("UPDATE customers SET funds={$this->getFunds()} WHERE id={$this->getId()};");
        }
        function addFunds($new_funds)
        {
            $this->funds += $new_funds;
            $GLOBALS['DB']->exec("UPDATE customers SET funds ={$this->getFunds()} WHERE
             id={$this->getId()};");
         }

         //the follwoing block contains both instance and static methods, but they are grouped together by the process of registration
         ////////////////         ////////////////         ////////////////         ////////////////         ////////////////

         //returns false and will not be constructed, true sends confirmation email
         function isNewMemberFree(){
             $queryString = "SELECT * FROM customers WHERE email='{$this->getEmail()}';";
             $memberQuery = $GLOBALS['DB']->query($queryString);
                if($memberQuery->rowCount() >= 1)
                {
                    //notify member taken
                    return false;
                }
                else {
                    $email = $this->email;
                    // Generate Random Number sequence as confirmation code
                    $random= md5(uniqid(rand()));
                    $confirmation_code = substr($random,0, 6);
                    $serialized_new_customer = serialize($this);
                    //email new customer with confirmation code:
                    $to = $email; $subject = 'Shoppr.com confirmation code for shoppr.com'; $message = 'Thank you for signing up with Shoppr.com. In order to complete your registration, please go to our website, click "log in", and then "enter confirmation code" and enter your confirmation code exactly as written in this email. The code is case sensitive. confirmation code:' . $confirmation_code; $headers = 'From: shoppr_admin@shoppr.com' . "\r\n" . 'Reply-To: shoppr_admin@shoppr.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); mail($to, $subject, $message, $headers, '-fwebmaster@shoppr.com');
                    //insert confirmation code with serialized information
                    $GLOBALS['DB']->exec("INSERT INTO confirmation_staging (customer_serialized, confirmation_code) VALUES ('{$serialized_new_customer}', '{$confirmation_code}');");
                return true;
                }
         }
         function getHistory()
         {
            $returned_orders = $GLOBALS['DB']->query("SELECT * FROM orders WHERE user_id='{$this->getId()}' ORDER BY id DESC;");
            $histories = array();
            foreach($returned_orders as $order){
                $id = $order['id'];
                $user_id = $order['user_id'];
                $cart = unserialize($order['cart']);
                $order_date = $order['order_date'];
                $delivery_date_time = $order['delivery_date_time'];
                $total = $order['total'];
                $found_order = new Order($id, $user_id,$order_date, $delivery_date_time);
                $found_order->setCart($cart);
                $found_order->setTotal($total);
                array_push($histories, $found_order);
            }
            return $histories;
         }

         static function register_new_member($confirmation_code)
         {
            $confirm_query= $GLOBALS['DB']->query("SELECT * FROM confirmation_staging WHERE confirmation_code = '{$confirmation_code}';");
             $result = $confirm_query->fetch(PDO::FETCH_ASSOC);
             if($result == false)
             {
                 //tell customer their confirmation code was incorrect
                 //redirect to bananas failure page
                 return false;
             }
             else{
                 //unseriazlie customer and save it;
                 $unserialized_customer = unserialize($result['customer_serialized']);
                //save function both saves and returns that customers newly generated id (lastinsertid). we need to pass this along because our route will create an instance based on this id, and from info queried in the database
                 $new_id = $unserialized_customer->save();
                 return $new_id;
             }
         }

         //for login in
         static function logIn($email, $password)
         {
             $queryString = "SELECT * FROM customers WHERE email='{$email}' and password='{$password}';";
             $memberQuery = $GLOBALS['DB']->query($queryString);
             $result = $memberQuery->fetch(PDO::FETCH_ASSOC);
             if($result == false)
             {
                 //redirects in app to failure page
                 return false;
             }
             else {

                 $found_customer = Customer::find($result['id']);
                 $_SESSION['customer'] = $found_customer;
                 return true;
                }
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
                $new_customer = new Customer($id, $name, $email, $address, $password, $funds);
                array_push($customers, $new_customer);
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
            return $found_customer;
        }
        //this will be used to both search by letter to display customer convienitly and to search for a customer name
        static function searchNameBystring($beginsWith){
            $returned_customers = $GLOBALS['DB']->query("SELECT * FROM customers WHERE name LIKE '{$beginsWith}%';");
            $found_customers = array();
            foreach ($returned_customers as $customer) {
                $id = $customer['id'];
                $name = $customer['name'];
                $email = $customer['email'];
                $address = $customer['address'];
                $password = $customer['password'];
                $funds = $customer['funds'];
                $new_customer = new Customer($id, $name, $email, $address, $password, $funds);
                array_push($found_customers, $new_customer);
            }
            return $found_customers;
        }

        static function searchEmailBystring($beginsWith){
            $returned_customers = $GLOBALS['DB']->query("SELECT * FROM customers WHERE email LIKE '{$beginsWith}%';");
            $found_customers = array();
            foreach ($returned_customers as $customer) {
                $id = $customer['id'];
                $name = $customer['name'];
                $email = $customer['email'];
                $address = $customer['address'];
                $password = $customer['password'];
                $funds = $customer['funds'];
                $new_customer = new Customer($id, $name, $email, $address, $password, $funds);
                array_push($found_customers, $new_customer);
            }
            return $found_customers;
        }
    }
 ?>
