<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";
    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;  Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/", function() use ($app) {
        $new_Stylist = new Stylist(null, $_POST['name'], $_POST['date_began'], $_POST['specialty']);
        $new_Stylist->save();
      return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->patch("/{id}/edit", function($id) use ($app) {
        $found_stylist= Stylist::find($id);
        $found_stylist->update($_POST['name'], $_POST['date_began'], $_POST['specialty']);
      return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->delete("/delete/{id}", function($id) use ($app) {
        $found_stylist = Stylist::find($id);
        $found_stylist->delete();
      return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/stylist/{id}", function($id) use ($app) {
        $found_stylist = Stylist::find($id);
        $found_clients  = $found_stylist->getClients($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $found_stylist, 'clients' => $found_clients, 'stylists' => Stylist::getAll()));
    });

    $app->post("/stylist/{id}", function($id) use ($app) {
        $found_stylist = Stylist::find($id);
        $new_client = new Client (null, $_POST['name'], $_POST['last_appointment'], $_POST['next_appointment'], $_POST['stylist_id']);
        $new_client->save();
        $found_clients  = $found_stylist->getClients($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $found_stylist, 'clients' => $found_clients, 'stylists' => Stylist::getAll()));
    });

    $app->delete("/stylist/{id}/delete/{client_id}", function($id, $client_id) use ($app) {
        $found_stylist = Stylist::find($id);
        $new_client = Client::find($client_id);
        $new_client->delete();
        $found_clients =$found_stylist->getClients($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $found_stylist, 'clients' => $found_clients, 'stylists' => Stylist::getAll()));
    });

    $app->patch("/stylist/{id}/edit/", function($id) use ($app) {
        $found_stylist = Stylist::find($id);
        $stuff = $_POST['person'];
        $found_client = Client::find($stuff);
        $found_client->update($_POST['name'],$_POST['last_appointment'], $_POST['next_appointment']);
        $found_clients =$found_stylist->getClients($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $found_stylist, 'clients' => $found_clients, 'stylists' => Stylist::getAll()));
    });

    return $app;
?>
