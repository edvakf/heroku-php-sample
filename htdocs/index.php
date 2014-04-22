<?php
echo 1;
date_Default_timezone_set('Asia/Tokyo');
echo 2;
define('ROOT_DIR', dirname(__DIR__));
echo 3;

require ROOT_DIR.'/vendor/composer/autoload.php';
echo 4;

$app = new \Slim\Slim;
echo 5;

$app->get('/', function() use ($app) {
echo 8;
  phpinfo();
});
echo 6;

$app->run();
echo 7;
