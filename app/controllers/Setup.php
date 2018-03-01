<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/02/2018
 * Time: 11:50
 */

class Controller_Setup extends Controller
{
    protected $_install;
    protected $_notice;
    protected $_installAction = array(
        'core',
        'category',
        'product',
        'customer',
        'order',
        'media',
        'extend',
    );
    protected $_nextInstall = array(
        'core' => 'category',
        'category' => 'product',
        'product' => 'customer',
        'customer' => 'order',
        'order' => 'media',
        'media' => 'extend',
        'extend' => false,
    );
    public function prepareProcess()
    {
        if(Bootstrap::isSetup()){
            $this->_redirect();
            return;
        }
        $this->addCss($this->getCssDefault())
             ->addJs($this->getJsDefault());
    }
    public function run(){
//        $this->deleteNotice();exit;
        if(empty($_POST))   {
            $this->_render('setup.tpl');
            return;
        }
        $function = $this->getParam('action');
        if($function && method_exists($this,$function)){
            $this->$function();
        }else{
            $this->responseSuccess();
        }

    }
    function configDatabase(){
        $msg = '';
        $host = $this->getParam('host');
        $username = $this->getParam('username') ;
        $password = $this->getParam('password');
        $db_name = $this->getParam('database');
        $table_prefix = $this->getParam('prefix');
        $dbConfig = array(
            'db_host' => $host,
            'db_username' => $username,
            'db_password' => $password,
            'db_name' => $db_name,
            'db_prefix' => $table_prefix,
        );
        $db = Libs_Db::getInstance($dbConfig);
        if($db){
            $connect = $db->getConnect();
            if($connect){

                $file_config = _MODULE_APP_DIR_ . DS . 'etc/config.json';
                $string_config = json_encode($dbConfig);
                $success = false;
                try{
                    $success = file_put_contents($file_config, $string_config);
                } catch(Exception $e){
                    $msg = "Setup error: " . $e->getMessage();
                }
                if (!$success){
                    $this->responseError(null,$msg);
                }
                $template_path = Bootstrap::getTemplate('setup/install.tpl');
                ob_start();
                include $template_path;
                $html = ob_get_contents();
                ob_end_clean();
                $this->responseSuccess($html);
            }else{
                $msg = 'Not connect to database';
                $this->responseError(null,$msg);
            }
        }else{
            $msg = 'Not connect to database';
            $this->responseError(null,$msg);
        }
    }

    function installDatabase(){

        $notice = $this->getNotice();
        $class_install = $notice['class_install'];
        if($notice[$class_install]['status'] == 'process'){
            require_once _MODULE_APP_DIR_ . DS . 'setup' . DS . ucfirst($class_install).'.php';
            $class_name = 'Setup_Install_'.ucfirst($class_install);
            $install = new $class_name();
            $function_install = $notice[$class_install]['function'];
            $install_result = $install->install($function_install);
            if($install_result['result'] != 'success'){
                $this->responseAjaxJson($install_result);
            }
            $msg = $install_result['msg'];
            $install_data = $install_result['data'];
            if($install_data['status'] == 'process'){
                $function_install_next = $install_data['function'];
                $notice[$class_install]['status'] = 'process';
                $notice[$class_install]['function'] = $function_install_next;
                $this->saveNotice($notice);
                $this->responseAjaxJson(array(
                    'result' => 'process',
                    'msg' => $msg,
                ));
            }
            $next_install = $this->_nextInstall[$class_install];
            if(!$next_install){
                $this->responseSuccess();
            }
            $notice[$class_install]['status'] = 'success';
            $notice['class_install'] = $next_install;
            $this->saveNotice($notice);
            $this->responseAjaxJson(array(
                'result' => 'process',
                'msg' => $msg,
            ));
        }
        $next_install = $this->_nextInstall[$class_install];
        if(!$next_install){
            $this->responseSuccess();
        }
        $notice[$class_install]['status'] = 'success';
        $notice['class_install'] = $next_install;
        $this->saveNotice($notice);
        $this->responseAjaxJson(array(
            'result' => 'process',
            'msg' => '',
        ));
    }

    function getDefaultNotice(){
        return array(
            'class_install' => 'core',
            'core' => array(
                'status' => 'process',
                'function' => 'createSetupDatabaseTable',
            ),
            'category' => array(
                'status' => 'process',
                'function'=> 'createCategoryTable',
            ),
            'product' => array(
                'status' => 'process',
                'function'=> 'createAttributeTable',
            ),
            'customer' => array(
                'status' => 'process',
                'function'=> 'customer',
            ),
            'order' => array(
                'status' => 'process',
                'function'=> 'order',
            ),
            'media' => array(
                'status' => 'process',
                'function' => 'mediaGallery',
            ),
            'extend' => array(
                'status' => 'process',
                'function' => '',
            ),

        );
    }
    function getNotice(){
        $notice = Session::getKey('notice');
        if($notice){
            return json_decode($notice,true);
        }
        return $this->getDefaultNotice();

    }
    function saveNotice($notice){
        Session::setKey('notice',json_encode($notice));
    }
    function deleteNotice(){
        Session::unsetKey('notice');
    }
}