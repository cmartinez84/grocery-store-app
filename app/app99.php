<?php
    //this app previously delt with customer info and CRUD. slowly phasin out. keep for now.
    require_once __DIR__."/../vendor/autoload.php";
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
    //new customer sign up methods
    // $app->get("/", function() use ($app) {
    //     return $app['twig']->render('customer.html.twig', array('selected_customer' => null,  'all_customers' => Customer::getAll()));
    // });
    // //make new customer
    // $app->post("/", function() use ($app) {
    //     $new_customer = new Customer (null, $_POST['name'], $_POST['email'], $_POST['address'], $_POST['password'], $_POST['funds']);
    //     $new_customer->save();
    //     return $app['twig']->render('customer.html.twig', array('selected_customer' =>$new_customer, 'all_customers' => Customer::getAll()));
    // });
    // //view customer by id
        //may be needed for admin, but currently stored in sesssion variable
    // $app->get("/{id}", function($id) use ($app) {
    //     echo $id;
    //
    //     $found_customer = Customer::find($id);
    //
    //     var_dump($found_customer);
    //     return $app['twig']->render('customer.html.twig', array('selected_customer' => $found_customer, 'all_customers' => Customer::getAll()));
    // });
    //edit customer
    

    return $app;
?>
