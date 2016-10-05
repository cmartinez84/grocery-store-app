<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Product.php";
    require_once __DIR__."/../src/Category.php";
    require_once __DIR__."/../src/Order.php";
    require_once __DIR__."/../src/Customer.php";


    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;  Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=shoppr';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

// Administration portion
    $app->get("/products", function() use ($app) {
        return $app['twig']->render('products.html.twig', array('products' => Product::getAll(), 'categories' => Category::getAll()));
    });

    $app->post("/products_add", function() use ($app) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $inventory = $_POST['inventory'];
        $product = new Product($name, $price, $purchase_quantity=0, $inventory);
        $product->save();

        if ($_POST['category_id'] != "")
        {
            $category = Category::find($_POST['category_id']);
            $product->addCategory($category);
        }

        if ($_FILES['file']['name'] != "" || $_FILES['file']['name'] != null)
        {
            $file = rand(1000,100000)."-".$_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder="uploads/";
            move_uploaded_file($file_loc,$folder.$file);
            $GLOBALS['DB']->exec("INSERT INTO tbl_uploads(file,type,size) VALUES('{$file}','{$file_type}','{$file_size}')");
            $GLOBALS['DB']->exec("UPDATE products SET photo = '{$file}' WHERE id = {$product->getId()};");
        }

        return $app['twig']->render('products.html.twig', array('products' => Product::getAll(), 'categories' => Category::getAll()));
    });

    $app->patch("/product_update/{id}", function($id) use ($app) {
        $product = Product::find($id);
        $name = $_POST['name'];
        $price = $_POST['price'];
        $inventory = $_POST['inventory'];
        $product -> updateProduct($name, $price, $purchase_quantity=0, $inventory);

        if ($_POST['category_id'] != "")
        {
            $category = Category::find($_POST['category_id']);
            $product->addCategory($category);
        }

        if ($_FILES['file']['name'] != "" || $_FILES['file']['name'] != null)
        {
            $file = rand(1000,100000)."-".$_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder="uploads/";
            move_uploaded_file($file_loc,$folder.$file);
            $GLOBALS['DB']->exec("INSERT INTO tbl_uploads(file,type,size) VALUES('{$file}','{$file_type}','{$file_size}')");
            $GLOBALS['DB']->exec("UPDATE products SET photo = '{$file}' WHERE id = {$id};");
        }

        return $app['twig']->render('product_details.html.twig', array('product' => $product, 'categories' => $product->getCategories(), 'all_categories' => Category::getAll()));
    });

    $app->get("/product_details/{id}", function($id) use ($app) {
        $product = Product::find($id);

        return $app['twig']->render('product_details.html.twig', array('product' => $product, 'categories' => $product->getCategories(), 'all_categories' => Category::getAll()));
    });

   $app->get("/products_delete", function() use ($app) {
       Product::deleteAll();

       return $app['twig']->render('products.html.twig', array('products' => Product::getAll(), 'categories' => Category::getAll()));
   });

   $app->delete("/product_delete/{id}", function($id) use ($app) {
       $product = Product::find($id);
       $product->delete();

       return $app['twig']->render('products.html.twig', array('products' => Product::getAll(), 'categories' => Category::getAll()));
   });

   $app->get("/categories", function() use ($app) {
       return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
   });

   $app->post("/categories_add", function() use ($app) {
       $name = $_POST['name'];
       $category = new Category($name);
       $category->save();

       return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
   });

   $app->get("/categories_delete", function() use ($app) {
       Category::deleteAll();

       return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
   });
//end Administration portion





//homepage & customer view (pre-log-in)
$app->get("/", function() use ($app) {
    return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null));
});

$app->get("/category/{id}", function($id) use ($app) {
    $found_category = Category::find($id);
    return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => $found_category, 'categoryProducts' => $found_category->getProducts()));
});

$app->post("/search_products", function() use ($app) {
    $product = Product::searchProducts($_POST['search_input']);

    return $app['twig']->render('home.html.twig', array('products' => $product, 'categories' => Category::getAll(), 'category' => null, 'categoryProducts' => null));
});

    return $app;
?>
