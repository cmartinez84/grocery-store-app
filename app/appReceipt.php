<?php
    //this app handles receipt functionality only;
    require_once __DIR__."/../vendor/autoload.php";
    //dompdf
    // require_once __DIR__."/../vendor/dompdf/autoload.inc.php";


    require_once __DIR__."/../src/Customer.php";
    require_once __DIR__."/../src/Order.php";
    require_once __DIR__."/../src/Product.php";
    require_once __DIR__."/../src/Category.php";

    date_default_timezone_set('America/Los_Angeles');




    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;  Request::enableHttpMethodParameterOverride();
    use Dompdf\Dompdf;


    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost:8889;dbname=shoppr';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render('order.html.twig', array('orders' => Order::getAll()));
    });

    $app->post("/test/receipt", function() use ($app) {
        //new customer
        $new_customer = new Customer (null, "chester", "chester@email.com", "444 christopher st", "muffins",  34);
        $new_customer->save();
        //new order
        $new_order = new Order(null, $new_customer->getId(), $order_date="11-11-1999", $delivery_date_time="11:00 11-11-1999");
        //bunch of new producrs to buy
        $new_product = new Product("apples", "1.00", 3, 4, "", 333);
        $new_product2  = new Product("bananas", "2.00", 3, 6, "", 3);
        $new_product3  = new Product("cucumbers", "2.00", 3, 6, "", 44);
        $new_order->addProductToCart($new_product);
        $new_order->addProductToCart($new_product2);
        $new_order->addProductToCart($new_product3);

        $found_customer = Customer::find($new_order->getUserId());
        $_SESSION['new_order'] = $new_order;


        // $found_customer = Customer::find($new_order->getUserId());

        return $app['twig']->render('receipt.html.twig', array('new_order' => $new_order, 'found_customer' => $found_customer));
    });
    return $app;
?>
