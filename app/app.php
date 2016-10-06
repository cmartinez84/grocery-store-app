<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Product.php";
    require_once __DIR__."/../src/Category.php";
    require_once __DIR__."/../src/Order.php";
    require_once __DIR__."/../src/Customer.php";


    date_default_timezone_set('America/Los_Angeles');
    //these two are added to try the redirect on log in failures
    use Silex\Application;
    use Symfony\Component\HttpKernel\HttpKernelInterface;


    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;
     Request::enableHttpMethodParameterOverride();
    session_start();
    if(empty($_SESSION['order']))
    {
        $_SESSION['order'] = null;
    }
    if(empty($_SESSION['customer']))
    {
        $_SESSION['customer']=null;
    }
    if(empty($_SESSION['admin']))
    {
        $_SESSION['admin']=null;
    }


    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost:8889;dbname=shoppr';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));
    //home page

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer']));
    });



    //homepage & customer view (pre-log-in)
    // $app->get("/", function() use ($app) {
    //     return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null));
    // });

    $app->get("/category/{id}", function($id) use ($app) {
        $found_category = Category::find($id);
        return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'category' => $found_category, 'products' => $found_category->getProducts(), 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer']));
    });

    $app->post("/search_products", function() use ($app) {
        $product = Product::searchProducts($_POST['search_input']);

        return $app['twig']->render('home.html.twig', array('products' => $product, 'categories' => Category::getAll(), 'category' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer']));
    });

// Administration portion
    $app->get("/products", function() use ($app) {
        return $app['twig']->render('products.html.twig', array('products' => Product::getAll(), 'categories' => Category::getAll(), 'admin' => $_SESSION['admin']));
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

        return $app['twig']->render('products.html.twig', array('products' => Product::getAll(), 'categories' => Category::getAll(), 'admin' => $_SESSION['admin']));
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

        return $app['twig']->render('product_details.html.twig', array('product' => $product, 'categories' => $product->getCategories(), 'all_categories' => Category::getAll(), 'admin' => $_SESSION['admin']));
    });

    $app->get("/product_details/{id}", function($id) use ($app) {
        $product = Product::find($id);

        return $app['twig']->render('product_details.html.twig', array('product' => $product, 'categories' => $product->getCategories(), 'all_categories' => Category::getAll(), 'admin' => $_SESSION['admin']));
    });

   $app->get("/products_delete", function() use ($app) {
       Product::deleteAll();

       return $app['twig']->render('products.html.twig', array('products' => Product::getAll(), 'categories' => Category::getAll(), 'admin' => $_SESSION['admin']));
   });

   $app->delete("/product_delete/{id}", function($id) use ($app) {
       $product = Product::find($id);
       $product->delete();

       return $app['twig']->render('products.html.twig', array('products' => Product::getAll(), 'categories' => Category::getAll(), 'admin' => $_SESSION['admin']));
   });

   $app->get("/categories", function() use ($app) {
       return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll(), 'admin' => $_SESSION['admin']));
   });

   $app->post("/categories_add", function() use ($app) {
       $name = $_POST['name'];
       $category = new Category($name);
       $category->save();

       return $app->redirect("/categories");
   });

   $app->get("/categories_delete", function() use ($app) {
       Category::deleteAll();
       return $app->redirect("/categories");
   });
//end Administration portion




//////cart shit




    $app->post("/addToCart", function () use ($app){
        $new_product = Product::find($_POST['product_id']);
        $new_product->setPurchaseQuantity($_POST['purchase_quantity']);
        $_SESSION['order']->addProductToCart($new_product);
        $_SESSION['order']->getCartTotal();
        var_dump($_SESSION['order']);
        return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer']));
    });

    $app->delete("/deleteProductFromCart", function () use ($app){
        $_SESSION['order']->deleteProductFromCart($_POST['product_id']);
        $_SESSION['order']->getCartTotal();
        var_dump($_SESSION['order']);
        return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer']));
    });
    //checkout functionality
    $app->post("/checkOut", function () use ($app){
        $_SESSION['order']->checkout();
        var_dump($_SESSION['order']);
        return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer']));
    });


    //////////Customer Stuff
    //will log in customer and create new cart at same time
    $app->post("/logIn", function() use ($app) {
        $result = Customer::logIn($_POST['email'], $_POST['password']);
        if(($_POST['email'] == "admin@shoppr.com") && ($_POST['password'] == "@dm1n")) {
            $_SESSION['admin'] = "set";
            return $app->redirect('/products');
        } elseif($result == false) {
            //will redirect to bananas failure page. its really that simple! awesome
            return $app->redirect('/logIn/failure');
        } else {
            $customer_id = $_SESSION['customer']->getId();
            $new_order = new Order(null, $customer_id, "11-11-1999", "1-14-1999");
            $_SESSION['order'] = $new_order;
        }
        return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer']));
    });
    ////

    $app->get("/logIn/failure", function() use ($app) {
        return $app['twig']->render('failure.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer'], 'admin' => $_SESSION['admin']));
    });

    $app->post("/logOut", function() use ($app) {
        session_destroy();
        return $app->redirect('/');
    });



    ////////// profile
    $app->get("/profile", function() use ($app) {
        return $app['twig']->render('customer.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer'], 'histories'=> null));
    });

    $app->get("/profile/histories", function() use ($app) {
        $histories = $_SESSION['customer']->getHistory();
        return $app['twig']->render('customer.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'], 'customer'=> $_SESSION['customer'], 'histories' => $histories));
    });




    return $app;
?>
