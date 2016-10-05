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

    $server = 'mysql:host=localhost:8889;dbname=shoppr';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));
    session_start();
    if(empty($_SESSION['order']))
    {
        $_SESSION['order'] = null;
    }

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'] ));
    });

    $app->post("/cart", function () use ($app){
        $new_order = new Order(null, 3, "11-11-1999", "1-14-1999");
        $_SESSION['order'] = $new_order;
        var_dump( $_SESSION['order'] );
        return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => null, 'categoryProducts' => null, 'order' => $_SESSION['order'] ));
  });


   //
   // $app->post("/cart", function () use ($app){
   //   $product = Product::find($_POST['product_id']);
   //   $product->setPurchaseQuantity($_POST['quantity']);
   //   $newOrder->addProductToCart($product);
   //   $newOrder->save();
   //   $_SESSION['order'] = $newOder->id;
   //   return $app['twig']->render('cart.html.twig', array('order' => $_SESSSION['order']));
   // });


    $app->patch("/cart/edit", function() use ($app) {
        $order = Order::find($_SESSION['order']);
        $product = $order->getProduct($_POST['product_id']);
        $product->setPurchaseQuantity($_POST['purchase_quantity']);
        $order->save();

        return $app['twig']->render('cart.html.twig', array('cart' => $order->cart));
   });


   $app->get("/category/{id}", function($id) use ($app) {
       $found_category = Category::find($id);
       return $app['twig']->render('home.html.twig', array('categories' => Category::getAll(), 'products' => Product::getAll(), 'category' => $found_category, 'categoryProducts' => $found_category->getProducts()));
   });

   $app->post("/search_products", function() use ($app) {
       $product = Product::searchProducts($_POST['search_input']);

       return $app['twig']->render('home.html.twig', array('products' => $product, 'categories' => Category::getAll(), 'category' => null, 'categoryProducts' => null));
   });
   //delete an item from cart
   //keep
   // $app->delete("/cart/delete/{product_id}", function($product_id) use ($app) {
   //     $order = Order::find($_SESSION['order']);
   //     $order->deleteProductFromCart($product_id);
   //     $order->save();
   //
   //     return $app['twig']->render('cart.html.twig', array('cart' => $order->cart));
   // });



   return $app;
  ?>
