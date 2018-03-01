<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/02/2018
 * Time: 14:12
 */

class Controller_Index
    extends Controller
{
    public function run()
    {
        $this->addJs(array(
            'pub/js/jquery.validate.min.js',
            'pub/js/jquery.form.min.js',
            'pub/js/webshop.js',
        ));
        $this->_render('home.tpl');
    }
}