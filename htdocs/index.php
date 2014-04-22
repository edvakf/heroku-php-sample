<?php
date_Default_timezone_set('Asia/Tokyo');
define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR.'/vendor/composer/autoload.php';

$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Smarty()
));

$view = $app->view();
$view->setTemplatesDirectory(ROOT_DIR.'/tpl');
$view->parserCompileDirectory = ROOT_DIR.'/tmp/tpl_c';

$app->get('/', function() use ($app) {
    $phpinfo = getPhpInfo();
    $app->render('index.tpl', array('phpinfo' => $phpinfo));
});

$app->run();

function getPhpInfo()
{
    ob_start();
    phpinfo();
    $phpinfo = ob_get_contents();
    ob_end_clean();
    return $phpinfo;
}
