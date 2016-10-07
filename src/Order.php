<?php
    class Order
    {
        private $id;
        private $user_id;
        private $cart;
        private $order_date;
        private $delivery_date_time;
        private $total;

        function __construct($id = null, $user_id, $order_date, $delivery_date_time)
        {
            $this->id = $id;
            $this->user_id = $user_id;
            $this->cart = array();
            $this->order_date = $order_date;
            $this->delivery_date_time = $delivery_date_time;
            $this->total = 0;
        }

        function getId()
        {
            return $this->id;
        }

        function getUserId()
        {
            return $this->user_id;
        }
        function getCart()
        {
            return $this->cart;
        }
        function setCart($new_cart)
        {
            $this->cart= $new_cart;
        }

        function getOrderDate()
        {
            return $this->order_date;
        }

        function setOrderDate($new_order_date)
        {
            $this->order_date = $new_order_date;
        }

        function getDeliveryDateTime()
        {
            return $this->delivery_date_time;
        }
        function getTotal()
        {
            return $this->total;
        }
        function setTotal($new_total)
        {
            $this->total = number_format((float)$new_total,2);
        }

        function setDeliveryDateTime($new_delivery_date_time)
        {
            $this->delivery_date_time = $new_delivery_date_time;
        }
//methods
    //essentially, this save function is only used when writing to database at checkout. it will have  the total and "cart" will be a link to a text file of the receipt/invoice, may be renamed "checkout"?
        function save()
        {
            $serialized_cart = serialize($this->cart);
            $GLOBALS['DB']->exec("INSERT INTO orders (user_id, order_date, cart, delivery_date_time, total) VALUES (
                {$this->getUserId()},
                '{$this->getOrderDate()}',
                '{$serialized_cart}',
                '{$this->getDeliveryDateTime()}',
                '{$this->getTotal()}'
                );");
                $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM orders WHERE id = {$this->getId()};");
        }

        // im thinking this function can add one item at a time, we can refactor it to take the whole order, or we can have two seperate functions.
        // product enters cart in object format


        function addProductToCart($product)
        {
            $this->deleteProductFromCart($product->getId());
            array_push($this->cart, $product);
        }

        function deleteProductFromCart($product_id)
        {
            foreach ($this->cart as $index => $product) {
                if($product->getId() == $product_id)
                {
                    unset($this->cart[$index]);
                }
            }
        }



        // this function will add together all contents of the cart, both returning the total and adding it to the Order instance. perhaps this function can also be called checkout? or can be woven into a checkout funciton which does many things, including changing inventory, and customer funds

        // cart total relies on calculateProductPrice total, adding them together with loop
        function getCartTotal()
        {
            $all_products = $this->cart;
            $total = 0;
            foreach($all_products as $product)
            {
                $total += ($product->calculateProductPrice());
            }
            $this->total = number_format((float)$total,2);

            return $total;
        }

        function checkOut(){
            //purchaseProduct will run database execution for us
            $_SESSION['customer']->pay($this->getCartTotal());
            foreach ($this->cart as $product) {
                $product->purchaseProduct();
            }
            //saves order to database with serailzed version of its own cart
            $this->save();
            $_SESSION['order'] = null;
            $customer_id = $_SESSION['customer']->getId();
            $_SESSION['order'] = new Order(null, $customer_id, date('Y-m-d'), $_POST['delivery_date_time']);
            // $this->sendReceiptEmail();
        }


//static methods
        static function getAll()
        {
            $returned_orders = $GLOBALS['DB']->query("SELECT * FROM orders");
            $orders= array();
            foreach ($returned_orders as $order) {
                $id = $order['id'];
                $user_id = $order['user_id'];
                $order_date = $order['order_date'];
                $delivery_date_time = $order['delivery_date_time'];
                $new_order = new Order($id, $user_id, $order_date, $delivery_date_time);
                array_push($orders, $new_order);
            }
            return $orders;
        }

        static function deleteAll()
        {
        $GLOBALS['DB']->exec("DELETE FROM orders;");
        }

        static function find($search_id)
        {
            $returned_orders = Order::getAll();
            foreach($returned_orders as $order) {
                if($order->getId() == $search_id) {
                    $found_order = $order;
                }
            }
            return $found_order;
        }


        function  sendReceiptEmail(){
            $customer = Customer::find($this->user_id);
            $email = $customer->getEmail();
            //email new customer with confirmation code:
            $to = $email;
            $subject = 'Shoppr.com confirmation code for shoppr.com';
            $message = "<html><body>";
            $message .= "<p>Thank you for shopping with us today. Here is your Receipt from Shoppr.com</p>";
            foreach($this->cart as $product) {
                $message .= "<p>" . $product->getPurchaseQuantity() . " " . $product->getName() . "</p>";
                $message .= "<p> @" . $product->calculateProductPrice() . " each </p>";
            }
            $message .= "$" . $this->total;
            $message .= "</body></html>";
            $headers = 'From: shoppr_admin@shoppr.com' . "\r\n" . 'Reply-To: shoppr_admin@shoppr.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            mail($to, $subject, $message, $headers, '-fwebmaster@example.com');
            //insert confirmation code with serialized information

        }


    }
?>
