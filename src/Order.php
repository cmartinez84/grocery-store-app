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

        function setDeliveryDateTime($new_delivery_date_time)
        {
            $this->delivery_date_time = $new_delivery_date_time;
        }
//methods
    //essentially, this save function is only used when writing to database at checkout. it will have  the total and "cart" will be a link to a text file of the receipt/invoice, may be renamed "checkout"?
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO orders (user_id, order_date, delivery_date_time, total) VALUES (
                {$this->getUserId()},
                '{$this->getOrderDate()}',
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
        function addProductToCart($product){
            array_push($this->cart, $product);
        }

        // this function will add together all contents of the cart, both returning the total and adding it to the Order instance. perhaps this function can also be called checkout? or can be woven into a checkout funciton which does many things, including changing inventory, and customer funds

        // cart total relies on calculateProductPrice total, adding them together with loop
        function getCartTotal()
        {
            $all_products = $this->cart;
            foreach($all_products as $product)
            {
                $this->total += ($product->calculateProductPrice());
            }
            return $this->total;
        }
        //commented out by chris
        // function userUpdate($new_purchase_quantity, $new_order_date, $new_delivery_date_time)
        // {
        //     $GLOBALS['DB']->exec("UPDATE orders SET purchase_quantity = '{$new_purchase_quantity}',
        //     order_date = '{$new_order_date}',
        //     delivery_date_time = '{$new_delivery_date_time}'
        //     WHERE id = {$this->getId()};");
        //     $this->setPurchaseQuantity($new_);
        //     $this->setPurchaseSubtotal($new_purchase_subtotal);
        //     $this->setQuantity($new_quantity);
        // }

        // function addPurchase($product_id, $purchase_quantity, $purchase_price, $purchase_subtotal)
        // {
        //     $GLOBALS['DB']->exec("UPDATE orders SET product_id = CONCAT(product_id, ','+'{$product_id}'), purchase_quantity = CONCAT(purchase_quantity, ','+'{$purchase_quantity}'), purchase_price = CONCAT(purchase_price, ','+'{$purchase_price}'), purchase_subtotal = CONCAT(purchase_subtotal, ','+'{$purchase_subtotal}');");
        // }

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


    }
?>
