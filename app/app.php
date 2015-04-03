<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes;');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

      use Symfony\Component\HttpFoundation\Request;
      Request::enableHttpMethodParameterOverride();


//Main page
    $app->get('/', function() use ($app) {
         $stores = Store::getAll();
         return $app['twig']->render('home.html.twig', array('stores' => $stores));
    });

    $app->post('/add_store', function() use ($app) {
         $new_store = new Store($_POST['store_name']);
         $new_store->save();
         $stores = Store::getAll();
         return $app['twig']->render('home.html.twig', array('stores' => $stores));
     });

//store page
    $app->post('/add_brand', function() use ($app) {
         $new_brand = new Brand($_POST['brand_name']);
         $new_brand->save();

         $store = Store::find($_POST['id']);
         $store->addBrand($new_brand);

         return $app['twig']->render('store.html.twig', array('store' => $store, 'brands'=>$store->getBrand()));
     });

      $app->get("/store/{id}", function($id) use ($app){
          $store = Store::find($id);

          return $app['twig']->render('store.html.twig', array('store'=>$store,'brands'=>$store->getBrand()));
        });

    $app->get('/store/{id}/edit', function($id) use ($app){
      $store = Store::find($id);
      return $app['twig']->render('store_edit.html.twig', array('store'=>$store));
    });

    $app->patch("/store/{id}", function($id) use ($app) {
        $store_name = $_POST['store_name'];
        $store = Store::find($id);
        $store->update($store_name);

        return $app['twig']->render('store.html.twig', array('store' => $store,'brands' => $store->getBrand()));
    });

    $app->delete("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
            return $app['twig']->render('home.html.twig', array('stores'=>Store::getAll()));
    });



//brand page

      $app->get('/brands', function() use ($app) {
        $brands = Brand::getAll();
        return $app['twig']->render('brands.html.twig', array('brands' => $brands));
    });



  return $app;
?>
