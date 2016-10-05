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

    session_start();

    if(empty($_SESSION['customer']))
    {
        $_SESSION['customer']=null;
    }

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('login.html.twig', array('customer'=> $_SESSION['customer']));
    });

    $app->post("/member/add", function() use ($app) {
        $new_customer = new Customer (null, $_POST['name'], $_POST['email'], $_POST['address'], $_POST['password'], $funds=0);
        $new_customer->isNewMemberFree();//this will also run save function if not free
        var_dump($_SESSION['customer']);
        return $app['twig']->render('login.html.twig', array('customer'=> $_SESSION['customer']));
    });

    $app->post("/logIn", function() use ($app) {
        Customer::logIn($_POST['email'], $_POST['password']);
        return $app['twig']->render('login.html.twig', array('customer'=> $_SESSION['customer']));
    });

    $app->post("/logOut", function() use ($app) {
        session_destroy();
        return $app['twig']->render('login.html.twig', array('customer'=> null));
    });


    return $app;
?>
