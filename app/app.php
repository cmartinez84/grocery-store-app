<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Product.php";
    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;  Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=shoppR';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig');
    });

    $app->get("/products", function() use ($app) {
        return $app['twig']->render('products.html.twig', array('products' => Product::getAll()));
    });

    $app->post("/products_add", function() use ($app) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $inventory = $_POST['inventory'];
        $photo = $_POST['photo'];
        $product = new Product($name, $price, $purchase_quantity=0, $inventory, $photo);
        $product->save();
        
        return $app['twig']->render('products.html.twig', array('products' => Product::getAll()));
    });

    return $app;
?>
