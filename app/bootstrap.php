<?php

// Debug functions
function dd($var) {
  die(var_dump($var));
}

// ORM config
ORM::configure('mysql:'.DB_HOST.'=;dbname='.DB_NAME);
ORM::configure('username', DB_USER);
ORM::configure('password', DB_PASSWORD);

// Twig
\Twig_Autoloader::register();
$loader = new \Twig_Loader_Filesystem(realpath(dirname(__FILE__)).'/views');

// Production behavior
if (ENV === 'prod') {

    $twig = new \Twig_Environment($loader, array(
        'cache' => '../cache/twig',
    ));

    // Developement behavior
} else {
    $twig = new \Twig_Environment($loader, array(
        // 'cache' => '../cache/twig',
    ));
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


// Slim config
$configuration = [
  'settings' => [
      'displayErrorDetails' => ENV === 'dev',
  ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

// Load endpoints
foreach (glob('app/endpoints/*.php') as $filename) {
    require $filename;
}

// Run!
$app->run();
