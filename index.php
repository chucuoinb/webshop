<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 31/01/2018
 * Time: 16:42
 */
define('DS', DIRECTORY_SEPARATOR);
define('_MODULE_DIR_', dirname(__FILE__));
define('_MODULE_APP_DIR_', _MODULE_DIR_ . DS . 'app');
define('WEB_URI','web_path');
//if(isset($_POST[WEB_URI])){
//    var_dump(1);exit;
//    echo json_encode(array(
//        'result' => 'success',
//    ));exit;
//}
require_once _MODULE_APP_DIR_ . DS . 'bootstrap.php';
$bootstrap = new Bootstrap();
$bootstrap->init()->run();

