<?php
    class Order
    {
        private $id;
        private $user_id;
        private $product_id;
        // private $receipt;
        private $item;
        private $purchase_quantity;
        private $purchase_price;
        private $purchase_subtotal;
        private $order_date;
        private $delivery_date_time;

        function __construct($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time, $id = null)
        {
            $this->user_id = $user_id;
            $this->product_id = $product_id;
            $this->purchase_quantity = $purchase_quantity;
            $this->purchase_price = $purchase_price;
            $this->purchase_subtotal = $purchase_subtotal;
            $this->order_date = $order_date;
            $this->delivery_date_time = $delivery_date_time;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getUserId()
        {
            return $this->user_id;
        }

        function getProductId()
        {
            return $this->user_id;
        }

        function getPurchaseQuantity()
        {
            return $this->purchase_quantity;
        }

        function setPurchaseQuantity($new_purchase_quantity)
        {
            $this->purchase_quantity = $new_purchase_quantity;
        }

        function getPurchasePrice()
        {
            return $this->purchase_price;
        }

        function setPurchasePrice($new_purchase_price)
        {
            $this->purchase_price = $new_purchase_price;
        }

        function getPurchaseSubtotal()
        {
            return $this->purchase_subtotal;
        }

        function setPurchaseSubtotal($new_purchase_subtotal)
        {
            $this->purchase_subtotal = $new_purchase_subtotal;
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

        function setDeliveryDateTime($new_delivery_date_time)
        {
            $this->delivery_date_time = $new_delivery_date_time;
        }
//methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO orders (user_id, product_id, purchase_quantity, purchase_price, purchase_subtotal, order_date, delivery_date_time) VALUES ({$this->getUserId()}, '{$this->getProductId()}',
            '{$this->getPurchaseQuantity()}',
            '{$this->getPurchasePrice()}',
            '{$this->getPurchaseSubtotal()}', '{$this->getOrderDate()}', '{$this->getDeliveryDateTime()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM orders WHERE id = {$this->getId()};");
        }

        function userUpdate($new_purchase_quantity, $new_order_date, $new_delivery_date_time)
        {
            $GLOBALS['DB']->exec("UPDATE orders SET purchase_quantity = '{$new_purchase_quantity}',
            order_date = '{$new_order_date}',
            delivery_date_time = '{$new_delivery_date_time}'
            WHERE id = {$this->getId()};");
            $this->setPurchaseQuantity($new_);
            $this->setPurchaseSubtotal($new_purchase_subtotal);
            $this->setQuantity($new_quantity);
        }

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
                $user_id = $order['user_id'];
                $product_id = $order['product_id'];
                $purchase_price = $order['purchase_price'];
                $purchase_quantity = $order['purchase_quantity'];
                $purchase_subtotal = $order['purchase_subtotal'];
                $order_date = $order['order_date'];
                $delivery_date_time = $order['delivery_date_time'];
                $id = $order['id'];
                $new_order = new Order($user_id, $product_id, $purchase_quantity, $purchase_price, $purchase_subtotal, $order_date, $delivery_date_time, $id);
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
            // $found_order = $GLOBALS['DB']->query("SELECT * FROM orders WHERE $id = {$search_id};");

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
