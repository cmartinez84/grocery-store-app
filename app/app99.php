<?php

    require_once __DIR__."/../vendor/autoload.php";
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

    $app->get("/", function() use ($app) {
        return $app['twig']->render('customer.html.twig', array('selected_customer' => null,  'all_customers' => Customer::getAll()));
    });
    //make new customer
    $app->post("/", function() use ($app) {
        $new_customer = new Customer (null, $_POST['name'], $_POST['email'], $_POST['address'], $_POST['password'], $_POST['funds']);
        $new_customer->save();
        return $app['twig']->render('customer.html.twig', array('selected_customer' =>$new_customer, 'all_customers' => Customer::getAll()));
    });
    //view customer by id
    $app->get("/{id}", function($id) use ($app) {
        echo $id;

        $found_customer = Customer::find($id);

        var_dump($found_customer);
        return $app['twig']->render('customer.html.twig', array('selected_customer' => $found_customer, 'all_customers' => Customer::getAll()));
    });
    //edit customer
    $app->patch("/edit/{id}", function($id) use ($app) {
        $found_customer = Customer::find($id);
        $found_customer->update($_POST['name'], $_POST['email'], $_POST['address'], $_POST['password'], $_POST['funds']);
        return $app['twig']->render('customer.html.twig', array('selected_customer' =>$new_customer,'all_customers'=> Customer::getAll()));
    });
    // customer deletes their own account
    $app->delete("/delete", function() use ($app) {
        $found_customer = Customer::find($_POST['customer_id']);
        $found_customer->delete();
        return $app['twig']->render('customer.html.twig', array('selected_customer' => null, 'all_customers'=> Customer::getAll()));
    });

    return $app;
?>
