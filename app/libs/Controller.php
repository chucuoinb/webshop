<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 31/01/2018
 * Time: 16:53
 */

class Controller
{
    protected $_cssFile = array();
    protected $_jsFile = array();
    public function prepareProcess()
    {
        if(!Bootstrap::isSetup()){
            if(empty($_POST)){

                $this->_redirect('setup');
                return;
            }
        }
        $this->addCss($this->getCssDefault())
             ->addJs($this->getJsDefault());
    }

    protected function _render($name = null)
    {
        if(!$name){
            $name = 'home';
        }
        $layout = Bootstrap::getLayout($name);
        include $layout;
    }

    protected function getCssDefault()
    {
        return array(
            'pub/css/bootstrap.min.css',
            'pub/css/bootstrap-theme.min.css',
            'pub/css/style.css',
            'pub/css/font-awesome.min.css'
        );
    }

    protected function addCss($file)
    {
        if(is_string($file)){
            $this->_cssFile[] = $file;
        } elseif(is_array($file)){
            $this->_cssFile = array_merge($this->_cssFile, $file);
        }
        $this->_cssFile = array_unique($this->_cssFile);
        return $this;
    }

    protected function getJsDefault()
    {
        return array(
            'pub/js/jquery.min.js',
            'pub/js/bootstrap.min.js',
            'pub/js/jquery.validate.min.js',
            'pub/js/jquery.form.min.js',
            'pub/js/webshop.js',
        );
    }

    protected function addJs($file)
    {
        if(is_string($file)){
            $this->_jsFile[] = $file;
        } elseif(is_array($file)) {
            $this->_jsFile = array_merge($this->_jsFile, $file);
        }
        $this->_jsFile = array_unique($this->_jsFile);
        return $this;
    }
    protected function _redirect($url = null){
        $base_url  = Bootstrap::getUrl();
        if(!$url){
            $url = $base_url;
        }else{
            $url = $base_url.'/'.$url;
        }
        header("Location: ".$url);
    }

    protected function getGlobal($key, $default = '')
    {
        $key = '_' . $key;
        $variable = isset($this->$key) ? $this->$key : $default;
        return $variable;
    }
    public function getParam($key, $default = null)
    {
        $value = $default;
        if (isset($_GET[$key])) {
            $value = $_GET[$key];
        }
        if (!$value && isset($_POST[$key])) {
            $value = $_POST[$key];
        }
        if (!$value && isset($_REQUEST[$key])) {
            $value = $_REQUEST[$key];
        }

        return $value;
    }
    protected function responseAjaxJson($data)
    {
        echo json_encode($data);
        exit();
    }
    protected function defaultResponse()
    {
        return array(
            'result'    => '',
            'msg'       => '',
            'data'      => '',
        );
    }
    protected function responseSuccess($data = '',$msg = ''){
        $response = array(
            'result' => 'success',
            'msg' => $msg,
            'data' => $data,
        );
        $this->responseAjaxJson($response);
    }
    protected function responseError($data = '',$msg = ''){
        $response = array(
            'result' => 'error',
            'msg' => $msg,
            'data' => $data,
        );
        $this->responseAjaxJson($response);
    }
    protected function responseWarning($data = '',$msg = ''){
        $response = array(
            'result' => 'warning',
            'msg' => $msg,
            'data' => $data,
        );
        $this->responseAjaxJson($response);
    }
}