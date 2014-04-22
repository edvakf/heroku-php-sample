<?php
date_Default_timezone_set('Asia/Tokyo');
define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR.'/vendor/composer/autoload.php';

$app = new \Slim\Slim;

$app->get('/', function() use ($app) {
  phpinfo();
});

$app->run();
