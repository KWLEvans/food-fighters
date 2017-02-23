<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Review.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;dbname=restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);

    $app->get('/', function() use($app) {
        return $app["twig"]->render("home.html.twig", ['cuisines' => Cuisine::getAll(), 'restaurants' => Restaurant::getAll()]);
    });

    $app->post('/add_cuisine', function() use ($app) {
        $new_cuisine = new Cuisine($_POST['name']);
        $new_cuisine->save();
        return $app->redirect('/');
    });

    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', ['cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()]);
    });

    $app->post("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $neighborhood = $_POST['neighborhood'];
        $new_Restaurant = new Restaurant($name, $description, $price, $neighborhood, $id);
        $new_Restaurant->save();
        return $app['twig']->render('cuisine.html.twig', ['cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()]);


    });

    $app->get("/restaurants/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        return $app['twig']->render('restaurant.html.twig', ['restaurant' => $restaurant, 'reviews' => $restaurant->getReviews()]);
    });

    $app->post('/add_review/{id}', function($id) use ($app) {
        $user_id = 1;
        $restaurant_id = $id;
        $rating = $_POST['rating'];
        $review = $_POST['review'];
        $new_Review = new Review($user_id, $restaurant_id, $rating, $review);
        $new_Review->save();
        return $app->redirect('/restaurants/'.$id);
    });

    return $app;
?>
