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


$app->get("/cart", function () use ($app){
    $newOrder = Order::find($_SESSION['order']);

    if($newOrder) $cart = $newOrder->getCart();
      else $cart = null;
    return $app['twig']->render('cart.html.twig', array('cart' => $cart));
  });

   $app->post("/cart", function () use ($app){
     $product = Product::find($_POST['product_id']);
     $product->setPurchaseQuantity($_POST['quantity']);

     if(!empty($_SESSION['order'])) $newOrder = Order::find($_SESSION['order']);
        else $newOrder = new Order(null, $_SESSION['user_id']);

     $newOrder->addProductToCart($product);
     $newOrder->save();

     $_SESSION['order'] = $newOder->id;

     return $app['twig']->render('cart.html.twig', array('cart' => $cart));
   });

    $app->patch("/cart/edit", function() use ($app) {
        $order = Order::find($_SESSION['order']);
        $product = $order->getProduct($_POST['product_id']);
        $product->setPurchaseQuantity($_POST['purchase_quantity']);
        $order->save();

        return $app['twig']->render('cart.html.twig', array('cart' => $order->cart));


   });

   $app->delete("/cart/delete/{product_id}", function($product_id) use ($app) {
       $order = Order::find($_SESSION['order']);
       $order->deleteProductFromCart($product_id);
       $order->save();

       return $app['twig']->render('cart.html.twig', array('cart' => $order->cart));
   });

   $app->post('login/', function () use ($app){
       $row = ['DB']->query("SELECT * FROM users WHERE email = {$_POST['email']} AND password = '{$_POST['password']}';");
       if($row) {
           // Store logged in user in session
           $_SESSION['user_id'] = $row->id;
           return $app['twig']->render('home.html.twig', array('orders' => Order::getAll()));
       }
   });

   return $app;
  ?>
