<?php
    class Order
    {
        private $id;
        private $user_id;
        private $product_id;
        private $purchase_total;
        private $purchase_date;
        private $quantity;

        function __construct($user_id, $product_id, $purchase_total, $purchase_date, $quantity, $id = null)
        {
            $this->user_id = $user_id;
            $this->product_id = $product_id;
            $this->purchase_total = $purchase_total;
            $this->purchase_date = $purchase_date;
            $this->quantity = $quantity;
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
            return $this->product_id;
        }

        function setProductId($new_product_id)
        {
            $this->product_id = $new_product_id;
        }

        function getPurchaseTotal()
        {
            return $this->purchase_total;
        }

        function setPurchaseTotal($new_purchase_total)
        {
            $this->purchase_total = $new_purchase_total;
        }

        function getPurchaseDate()
        {
            return $this->purchase_date;
        }

        function setPurchaseDate($new_purchase_date)
        {
            $this->purchase_date = $new_purchase_date;
        }

        function getQuantity()
        {
            return $this->quantity;
        }

        function setQuantity($new_quantity)
        {
            $this->quantity = $new_quantity;
        }
//methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO orders (user_id, product_id, purchase_total, purchase_date, quantity) VALUES ({$this->getUserId()}, {$this->getProductId()}, {$this->getPurchaseTotal()}, '{$this->getPurchaseDate()}', {$this->getQuantity()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM orders WHERE id = {$this->getId()};");
        }

        function update($new_product_id, $new_purchase_total, $new_quantity)
        {
            $GLOBALS['DB']->exec("UPDATE orders SET product_id = '{$new_product_id}', purchase_total = '{$new_purchase_total}', quantity = '{$new_quantity}' WHERE id = {$this->getId()};");
            $this->setProductId($new_product_id);
            $this->setPurchaseTotal($new_purchase_total);
            $this->setQuantity($new_quantity);
        }

//static methods
        static function getAll()
        {
            $returned_orders = $GLOBALS['DB']->query("SELECT * FROM orders");
            $orders= array();
            foreach ($returned_orders as $order) {
                $user_id = $order['user_id'];
                $product_id = $order['product_id'];
                $purchase_total = $order['purchase_total'];
                $purchase_date = $order['purchase_date'];
                $quantity = $order['quantity'];
                $id = $order['id'];
                $new_order = new Order($user_id, $product_id, $purchase_total, $purchase_date, $quantity, $id);
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
