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
            $GLOBALS['DB']->exec("INSERT INTO products (name, price, purchase_quantity, inventory, photo) VALUES ('{$this->getName()}', {$this->getPrice()}, {$this->getPurchaseQuantity()}, {$this->getInventory()}, '{$this->getPhoto()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $products = array();
            $returned_products = $GLOBALS['DB']->query("SELECT * FROM products;");
            foreach($returned_products as $product) {
                $name = $product['name'];
                $price = $product['price'];
                $purchase_quantity = $product['purchase_quantity'];
                $inventory = $product['inventory'];
                $photo = $product['photo'];
                $id = $product['id'];
                $new_product = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);
                array_push($products, $new_product);
            }
            return $products;
        }

        function updateProduct($new_name, $new_price, $new_purchase_quantity, $new_inventory, $new_photo)
        {
            $GLOBALS['DB']->exec("UPDATE products SET name = '{$new_name}', price = {$new_price}, purchase_quantity={$new_purchase_quantity}, inventory = {$new_inventory}, photo = '{$new_photo}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
            $this->setPrice($new_price);
            $this->setPurchaseQuantity($new_purchase_quantity);
            $this->setInventory($new_inventory);
            $this->setPhoto($new_photo);
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM products;");
        }

        static function find($search_id)
        {
            $found_product = null;
            $products = Product::getAll();
            foreach ($products as $product) {
                $product_id = $product->getId();
                if ($product_id  = $search_id)
                {
                    $found_product = $product;
                }
            }
            return $found_product;
        }

        static function searchProducts($search_string)
        {
            $products = array();
            $returned_products = $GLOBALS['DB']->query("SELECT * FROM products WHERE name LIKE '%{$search_string}%';");
            foreach($returned_products as $product) {
                $name = $product['name'];
                $price = $product['price'];
                $purchase_quantity = $product['purchase_quantity'];
                $inventory = $product['inventory'];
                $photo = $product['photo'];
                $id = $product['id'];
                $new_product = new Product($name, $price, $purchase_quantity, $inventory, $photo, $id);
                array_push($products, $new_product);
            }
            return $products;
        }

        function inStock($purchase_quantity)
        {
            if ($this->getInventory() < $purchase_quantity)
            {
                return false;
            } else {
                return true;
            }
        }

        function calculateProductPrice()
        {
            // if (inStock($purchase_quantity))
            // {
                return $this->getPrice() * $this->getPurchaseQuantity();
            // }
        }
    }

?>
