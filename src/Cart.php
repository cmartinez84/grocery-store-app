<?php
    class Cart
    {
        private $id;
        private $user_id;
        private $product_id;
        private $purchase_total;
        private $date;
        private $quantity;

        function __construct($user_id, $product_id, $purchase_total, $date, $quantity, $id = null)
        {
            $this->user_id = $user_id;
            $this->product_id = $product_id;
            $this->purchase_total = $purchase_total;
            $this->date = $date;
            $this->quantity = $quantity;
            $this->id = $id;
        }

        function getUserId()
        {
            
        }
    }
?>
