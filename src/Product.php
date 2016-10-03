<?php
    Class Product
    {
        private $name;
        private $price;
        private $purchase_quantity;
        private $inventory;
        private $category;
        private $photo;
        private $id;

        function __construct($name, $price, $purchase_quantity=0, $inventory, $photo="", $id=null)
        {
            $this->name = $name;
            $this->price = $price;
            $this->purchase_quantity = $purchase_quantity;
            $this->inventory = $inventory;
            $this->photo = $photo;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string)ucwords($new_name);
        }

        function getName()
        {
            return $this->name;
        }

        function setPrice($new_price)
        {
            $this->price = (float)$new_price;
        }

        function getPrice()
        {
            return $this->price;
        }

        function setPurchaseQuantity($new_purchase_quantity)
        {
            $this->purchase_quantity = (int)$new_purchase_quantity;
        }

        function getPurchaseQuantity()
        {
            return $this->purchase_quantity;
        }

        function setInventory($new_inventory)
        {
            $this->inventory = (int)$new_inventory;
        }

        function getInventory()
        {
            return $this->inventory;
        }

        function setPhoto($new_photo)
        {
            $this->photo = (string)$new_photo;
        }

        function getPhoto()
        {
            return $this->photo;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO products (name, price, purchase_quantity, inventory, photo) VALUES ('{$this->getName()}', {$this->getPrice()}, {$this->getPurchaseQuantity()}, {$this->getInventory()}, {$this_getPhoto()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function getAll()
        {
            $products = array();
            $return_products = $GLOBALS['DB']->query("SELECT * FROM products;");
            foreach($return_products as $product) {
                $name = $product['name'];
                $price = $product['price'];
                $purchase_quantity = $product['purchase_quantity'];
                $inventory = $product['inventory'];
                $photo = $product['photo'];
                $id = $id['id'];
                $new_product = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);
                array_push($product, $new_product);
            }
            return $products;
        }
    }
 ?>
