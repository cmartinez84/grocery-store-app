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
            $new_order = new Order($user_id, $product_id, $purchase_total, $purchase_date, $quantity, $id);
            array_push($orders, $new_order);
            }
            return $orders;
        }

        static function deleteAll()
        {
        $GLOBALS['DB']->exec("DELETE FROM orders;");
        }
    }
?>
