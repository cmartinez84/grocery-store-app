<?php
    ////this app is for esting out the receipt function. do not delete;
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
    // session_start();
    // if (empty($_SESSION['current_user'])) {
    //     $_SESSION['current_user'] = null;
    // }
    //
    // $total = 0;
    // $b = 0;
    // foreach ($_SESSION['cart_items'] as $item) {
    //     $product_id = $cart_item['product_id'];
    //     $purchase_quantity = $cart_item['purchase_quantity'];
    //     $purchase_price = $cart_item['price'];
    //     $purchase_subtotal = $purchase_quantity * $purchase_price;
    // }

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=shoppr';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render('order.html.twig', array('orders' => Order::getAll()));
    });

    $app->post("/test/receipt", function() use ($app) {
        $new_order = new Order(null, $user_id=34, $order_date="11-11-1999", $delivery_date_time="11:00 11-11-1999");
        $new_product = new Product("apples", "1.00", 3, 4, "", 333);
        $new_product2  = new Product("bananas", "2.00", 3, 6, "", 3);
        $new_product3  = new Product("cucumbers", "2.00", 3, 6, "", 44);
        $new_order->addProductToCart($new_product);
        $new_order->addProductToCart($new_product2);
        $new_order->addProductToCart($new_product3);
        $_SESSION['new_order'] = $new_order;

        $found_customer = Customer::($new_order->getUserId());

      return $app['twig']->render('receipt.html.twig', array('new_order' => $_SESSION['new_order'], $found_customer->getUser()));
    });

    $app->post("/", function() use ($app) {
      return $app['twig']->render('order.html.twig', array('orders' => Order::getAll()));
    });
    // $app->patch("/{id}/edit", function($id) use ($app) {
    //     $found_stylist= Stylist::find($id);
    //     $found_stylist->update($_POST['name'], $_POST['date_began'], $_POST['specialty']);
    //   return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    // });
    //
    // $app->delete("/delete/{id}", function($id) use ($app) {
    //     $found_stylist = Stylist::find($id);
    //     $found_stylist->delete();
    //   return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    // });
    //
    // $app->get("/stylist/{id}", function($id) use ($app) {
    //     $found_stylist = Stylist::find($id);
    //     $found_clients  = $found_stylist->getClients($id);
    //     return $app['twig']->render('stylist.html.twig', array('stylist' => $found_stylist, 'clients' => $found_clients, 'stylists' => Stylist::getAll()));
    // });
    //
    // $app->post("/stylist/{id}", function($id) use ($app) {
    //     $found_stylist = Stylist::find($id);
    //     $new_client = new Client (null, $_POST['name'], $_POST['last_appointment'], $_POST['next_appointment'], $_POST['stylist_id']);
    //     $new_client->save();
    //     $found_clients  = $found_stylist->getClients($id);
    //     return $app['twig']->render('stylist.html.twig', array('stylist' => $found_stylist, 'clients' => $found_clients, 'stylists' => Stylist::getAll()));
    // });
    //
    // $app->delete("/stylist/{id}/delete/{client_id}", function($id, $client_id) use ($app) {
    //     $found_stylist = Stylist::find($id);
    //     $new_client = Client::find($client_id);
    //     $new_client->delete();
    //     $found_clients =$found_stylist->getClients($id);
    //     return $app['twig']->render('stylist.html.twig', array('stylist' => $found_stylist, 'clients' => $found_clients, 'stylists' => Stylist::getAll()));
    // });
    //
    // $app->patch("/stylist/{id}/edit/", function($id) use ($app) {
    //     $found_stylist = Stylist::find($id);
    //     $stuff = $_POST['person'];
    //     $found_client = Client::find($stuff);
    //     $found_client->update($_POST['name'],$_POST['last_appointment'], $_POST['next_appointment']);
    //     $found_clients =$found_stylist->getClients($id);
    //     return $app['twig']->render('stylist.html.twig', array('stylist' => $found_stylist, 'clients' => $found_clients, 'stylists' => Stylist::getAll()));
    // });

    return $app;
?>
