<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 31/01/2018
 * Time: 16:39
 */
class Bootstrap
{
    protected static $_config;
    protected static $_dbConfig;

    public function init()
    {
        $this->_includeLibs();
        Session::init();

        return $this;
    }

    public function run()
    {
        $controller = $this->getUri() ? $this->getUri() : 'index';
//        if(isset($_POST[WEB_URI])){
//    var_dump($controller);exit;
//}
        $class      = self::getController($controller);
        $class->prepareProcess();
        $class->run();

        return;
    }

    protected function _includeLibs()
    {
        $libs = array(
            'Controller.php',
            'AbstractModel.php',
            'Db.php',
            'Db/Mysql.php',
            'Db/Mysqli.php',
            'Db/Sqlite.php',
            'Session.php',
            'Model.php'
        );
        foreach ($libs as $lib) {
            $lib_path =_MODULE_ROOT_.'libs' . DS . $lib;
            if (file_exists($lib_path)) {
                require_once $lib_path;
            }
        }

        return $this;
    }

    public static function getUrl($suffix = null, $params = null)
    {
        $base_url = Bootstrap::getBaseUrl();
        $url      = $base_url;
        if ($suffix) {
            $url .= '/' . $suffix;
        }
        if ($params) {
            if ($url == $base_url) {
                $url .= '/';
            }
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    public static function getLayout($name = null)
    {
        if (!$name) {
            $name = 'home.tpl';
        }
        $layout_path = self::getView() . 'layouts' . DS . $name . '.php';

        return $layout_path;
    }

    public static function getTemplate($name = null)
    {
        if (!$name) {
            return false;
        }
        $template_path = self::getView() . 'templates' . DS . $name . '.php';

        return $template_path;
    }

    public static function getView($name = null)
    {
        $view_path = _MODULE_APP_DIR_ . DS . 'views' . DS;
        if (!$name) {
            return $view_path;
        }

        return $view_path . $name;
    }

    public static function isSetup()
    {
        $config_file  = _MODULE_APP_DIR_ . DS . 'etc' . DS . 'config.json';

        return file_exists($config_file) && self::getConfig('version');
    }


    public static function getController($controller_name)
    {
        $controller_explode = explode('/', $controller_name);
        $len                = count($controller_explode);
        if ($len == 1) {
            $controller_path = ucfirst($controller_name);
        } else {

            $controller_path = '';
            foreach ($controller_explode as $path) {
                if ($controller_path) {
                    $controller_path .= ucfirst($path) . DS;
                }
            }
        }
        $controller_path = _MODULE_APP_DIR_ . DS . 'controllers' . DS . $controller_path . '.php';
        $controller_name = ucfirst($controller_explode[$len - 1]);
        if (file_exists($controller_path)) {
            require_once $controller_path;
            $class_name = 'Controller_' . $controller_name;
            $class      = new $class_name();

            return $class;
        }

        return null;
    }

    public function getUri()
    {
        if (isset($_REQUEST[WEB_URI]) && $_REQUEST[WEB_URI]) {
            $web_uri = $_REQUEST[WEB_URI];
            while (substr($web_uri, -1) == '/') {
                $web_uri = substr($web_uri, strlen($web_uri) - 1);
            }

            return $web_uri;
        }

        return null;
    }

    public static function getConfigIni($key = null)
    {
        if (!static::$_config) {
            $config_path     = _MODULE_DIR_ . DS . 'config.ini';
            static::$_config = parse_ini_file($config_path);
        }
        if ($key) {
            return isset(static::$_config[$key]) ? static::$_config[$key] : null;
        }

        return null;
    }

    public static function getDbConfig()
    {
        if (!static::$_dbConfig) {
            static::$_dbConfig = array(
                'db_host'     => self::getConfig('db_host'),
                'db_username' => self::getConfig('db_username'),
                'db_password' => self::getConfig('db_password'),
                'db_name'     => self::getConfig('db_name'),
                'db_prefix'   => self::getConfig('db_prefix'),
            );
        }

        return static::$_dbConfig;
    }

    public static function getConfig($key, $default = '')
    {
        $config_file = _MODULE_APP_DIR_ . DS . 'etc/config.json';
        if (file_exists($config_file)) {

            $config_string = file_get_contents($config_file);
            $config_data   = @json_decode($config_string,true);
            if ($config_data) {
                return isset($config_data[$key]) ? $config_data[$key] : $default;
            }
        }
        return $default;
    }
    public static function setConfig($key, $value = '')
    {
        $config_file = _MODULE_APP_DIR_ . DS . 'etc/config.json';
        $success = false;
        if (file_exists($config_file)) {

            $config_string = file_get_contents($config_file);
            $config_data   = @json_decode($config_string,true);
            if ($config_data) {
                $config_data[$key] = $value;
                $config = json_encode($config_data);
                try{
                    $success = file_put_contents($config_file, $config);
                } catch(Exception $e){
                    self::log($e->getMessage());
                }
            }
        }
        return $success;
    }

    public static function unsetConfig($key)
    {
        $config_file = _MODULE_APP_DIR_ . DS . 'etc/config.json';
        $success = true;
        if (file_exists($config_file)) {

            $config_string = file_get_contents($config_file);
            $config_data   = @json_decode($config_string,true);
            if ($config_data && isset($config_data[$key])) {
                unset($config_data[$key]);
                $config = json_encode($config_data);
                try{
                    $success = file_put_contents($config_file, $config);
                } catch(Exception $e){
                    $success = false;
                    self::log($e->getMessage());
                }
            }
        }
        return $success;
    }

    public static function getVersionInstall()
    {
        $version_file = _MODULE_APP_DIR_ . DS . 'etc' . DS . 'version';
        if (!file_exists($version_file)) {
            return '0.0.0';
        }
        $version = file_get_contents($version_file);
        $version = trim($version);

        return $version;
    }

    public static function setVersionInstall($version)
    {
        $version_file = _MODULE_APP_DIR_ . DS . 'etc' . DS . 'version';
        @file_put_contents($version_file, $version);

        return;
    }

    public static function log($msg, $log_type = 'exception')
    {
        $log_file = _MODULE_APP_DIR_ . DS . 'log' . DS . $log_type . '.log';
        if (is_array($msg)) {
            $msg = print_r($msg, true);
        }
        $msg       .= "\r\n";
        $date_time = date('Y-m-d H:i:s');
        @file_put_contents($log_file, $date_time . ' : ' . $msg, FILE_APPEND);
    }
    public static function isConnectDb(){
        $dbConfig = self::getDbConfig();
        $db = Libs_Db::getInstance($dbConfig);
        if($db){
            $connect = $db->getConnect();
            return $connect?true:false;
        }
        return false;
    }
    public static function getBaseUrl()
    {
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL = "https://";
        } else
            $pageURL = "http://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . dirname($_SERVER["SCRIPT_NAME"]);
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . dirname($_SERVER["SCRIPT_NAME"]);
        }
        return $pageURL;
    }
    public static function getModel($name = null)
    {
        if(!$name){
            return null;
        }
        $model_folder = _MODULE_APP_DIR_ . DS . 'models';
        $name = self::convertPathUppercase($name);
        $model_path = str_replace('_', DS, $name);
        $model_file = $model_folder . DS . $model_path . '.php';
        if(file_exists($model_file)){
            require_once $model_file;
        }
        $model_name = 'Model_' . $name;
        $model = new $model_name();
        return $model;
    }
    public static function convertPathUppercase($name, $char = '/')
    {
        $split = explode($char, $name);
        $upper = array_map('ucfirst', $split);
        $new_name = implode($char, $upper);
        return $new_name;
    }
}