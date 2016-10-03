<?php
    Class Category
    {
        private $name;
        private $id;

        function __construct($name, $id=null)
        {
            $this->name = $name;
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

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO categories (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $categories = array();
            $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories;");
            foreach($returned_categories as $category) {
                $name = $category['name'];
                $id = $category['id'];
                $new_category = new Category($name, $id);
                array_push($categories, $new_category);
            }
            return $categories;
        }

        function updateCategory($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE categories SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM categories;");
        }

        static function find($search_id)
        {
            $found_category = null;
            $categories = Category::getAll();
            foreach ($categories as $category) {
                $category_id = $category->getId();
                if ($category_id  = $search_id)
                {
                    $found_category = $category;
                }
            }
            return $found_category;
        }

        static function searchCategories($search_string)
        {
            $categories = array();
            $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories WHERE name LIKE '%{$search_string}%';");
            foreach($returned_categories as $category) {
                $name = $category['name'];
                $id = $category['id'];
                $new_category = new Category($name, $id);
                array_push($categories, $new_category);
            }
            return $categories;
        }

        function addProduct($product)
        {
            $GLOBALS['DB']->exec("INSERT INTO products_categories (product_id, category_id) VALUES ({$product->getId()}, {$this->getId()});");
        }

        function getProducts()
        {
            $products = array();
            $returned_products = $GLOBALS['DB']->query("SELECT products.* FROM categories JOIN products_categories ON (products_categories.category_id = categories.id) JOIN products ON (products.id = products_categories.product_id) WHERE categories.id = {$this->getId()};");
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

        function deleteCategory()
        {
            $GLOBALS['DB']->exec("DELETE FROM categories WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM products_categories WHERE category_id = {$this->getId()};");
        }
    }

?>
