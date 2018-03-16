<?php

class LECM_Model_Cart
{
    protected $_type;
    protected $_notice;
    protected $_cart_url;
    protected $_db;

    const CONNECTOR_SUFFIX = '/cartmigration_connector/connector.php';

    const DEV_MODE = false;

    const TYPE_TAX = 'tax';
    const TYPE_TAX_PRODUCT = 'tax_product';
    const TYPE_TAX_CUSTOMER = 'tax_customer';
    const TYPE_TAX_RATE = 'tax_rate';
    const TYPE_TAX_CALCULATION = 'tax_calculation';

    //LDV94begin
    const TYPE_TAX_CLASS_DEFAULT = 'tax_class_default';
    const TYPE_TAX_CALCULATION_RULE_DEFAULT = 'tax_calculation_rule_default';
    //LDV94end

    const TYPE_TAX_ZONE = 'tax_zone';
    const TYPE_TAX_ZONE_COUNTRY = 'tax_zone_country';
    const TYPE_TAX_ZONE_STATE = 'tax_zone_state';
    const TYPE_TAX_ZONE_RATE = 'tax_zone_rate';
    const TYPE_MANUFACTURER = 'manufacturer';
    const TYPE_CATEGORY = 'category';
    const TYPE_PRODUCT = 'product';
    const TYPE_CHILD = 'product_child';
    const TYPE_ATTR = 'attr';
    const TYPE_ATTR_VALUE = 'attr_value';
    const TYPE_OPTION = 'option';
    const TYPE_OPTION_VALUE = 'option_value';
    const TYPE_CUSTOMER = 'customer';
    const TYPE_ADDRESS = 'address';
    const TYPE_ORDER = 'order';
    const TYPE_REVIEW = 'review';
    const TYPE_SHIPPING = 'shipping';
    const TYPE_PAGE = 'page';
    const TYPE_BLOCK = 'block';
    const TYPE_WIDGET = 'widget';
    const TYPE_POLL = 'poll';
    const TYPE_TRANSACTION = 'transaction';
    const TYPE_NEWSLETTER = 'newsletter';
    const TYPE_USER = 'user';
    const TYPE_RULE = 'rule';
    const TYPE_CART_RULE = 'cart_rule';
    const TYPE_POST = 'post';
    const TYPE_FORMAT = 'format';
    const TYPE_COMMENT = 'comment';
    const TYPE_TAG = 'tag';
    const TYPE_BUNDLE_OPTION = "bundle_option";
    const TYPE_ORDER_ITEM = "sales_order_item";
    const TYPE_CAT_URL = "category_url_key";
    const TYPE_PRO_URL = "product_url_key";
    const PRODUCT_SIMPLE = 'simple';
    const PRODUCT_CONFIG = 'configurable';
    const PRODUCT_VIRTUAL = 'virtual';
    const PRODUCT_DOWNLOAD = 'download';
    const PRODUCT_GROUP = 'grouped';
    const PRODUCT_BUNDLE = 'bundle';
    const OPTION_FIELD = 'field';
    const OPTION_TEXT = 'text';
    const OPTION_SELECT = 'select';
    const OPTION_DATE = 'date';
    const OPTION_DATETIME = 'datetime';
    const OPTION_RADIO = 'radio';
    const OPTION_CHECKBOX = 'checkbox';
    const OPTION_PRICE = 'price';
    const OPTION_BOOLEAN = 'boolean';
    const OPTION_FILE = 'file';
    const OPTION_MULTISELECT = 'multi_select';
    const OPTION_FRONTEND = 'frontend';
    const OPTION_BACKEND = 'backend';
    const GENDER_MALE = 'm';
    const GENDER_FEMALE = 'f';
    const GENDER_OTHER = 'o';
    const PRICE_POSITIVE = '+';
    const PRICE_NEGATIVE = '-';

    /**
     * TODO: INIT
     */

    public function getDb()
    {
        if (!$this->_db) {
            $dbConfig = Bootstrap::getDbConfig();
            $db       = LECM_Db::getInstance($dbConfig);
            if (!$db) {
                return null;
            }
            $connect = $db->getConnect();
            if ($connect) {
                $this->_db = $db;
            }
        }

        return $this->_db;
    }

    /**
     * TODO: NOTICE
     */

    public function setType($type)
    {
        $this->_type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setNotice($notice)
    {
        $this->_notice = $notice;
        $type          = $this->getType();
        if ($type) {
            $this->_cart_url = $notice[$type]['cart_url'];
        }

        return $this;
    }

    public function getNotice()
    {
        return $this->_notice;
    }

    public function getDefaultNotice()
    {
        return array(
            'src'              => array(
                'cart_type'        => '',
                'cart_url'         => '',
                'config'           => array(
                    'token'              => '',
                    'version'            => '',
                    'table_prefix'       => '',
                    'charset'            => '',
                    'image_category'     => '',
                    'image_product'      => '',
                    'image_manufacturer' => '',
                    'api'                => array(),
                    'folder'             => '',
                    'file'               => array(),
                    'extend'             => array(),
                ),
                'site'             => array(),
                'languages'        => array(),
                'language_default' => '',
                'categoryData'     => array(),
                'category_root'    => '',
                'attributes'       => array(),
                'order_status'     => array(),
                'currencies'       => array(),
                'currency_default' => '',
                'countries'        => array(),
                'customer_group'   => array(),
                'storage'          => array(
                    'result'   => 'process',
                    'function' => 'noStorageData',
                    'type'     => '',
                    'msg'      => $this->consoleSuccess("Preparing import data ..."),
                    'count'    => 0,
                ),
                'clear'            => array(
                    'result'      => 'process',
                    'function'    => '_noClear',
                    'table_index' => 0,
                    'msg'         => '',
                    'limit'       => 20
                ),
                'support'          => array(
                    'site_map'           => true,
                    'language_map'       => true,
                    'category_map'       => true,
                    'attribute_map'      => true,
                    'order_status_map'   => true,
                    'currency_map'       => true,
                    'country_map'        => true,
                    'customer_group_map' => true,
                    'taxes'              => true,
                    'manufacturers'      => true,
                    'categories'         => true,
                    'products'           => true,
                    'customers'          => true,
                    'orders'             => true,
                    'reviews'            => true,
                    'pages'              => false,
                    'blocks'             => false,
                    'widgets'            => false,
                    'polls'              => false,
                    'transactions'       => false,
                    'newsletters'        => false,
                    'users'              => false,
                    'rules'              => false,
                    'cartrules'          => false,
                    'add_new'            => true,
                    'clear_shop'         => true,
                    'img_des'            => true,
                    'pre_cus'            => true,
                    'pre_ord'            => true,
                    'pre_cat'            => true,
                    'pre_prd'            => true,
                    'seo'                => false,
                ),
                'extends'          => array(),
                'number_of_prd'    => 0,
                'number_of_cat'    => 0,
            ),
            'target'           => array(
                'cart_type'        => '',
                'cart_url'         => '',
                'config'           => array(
                    'token'              => '',
                    'version'            => '',
                    'table_prefix'       => '',
                    'charset'            => '',
                    'image_category'     => '',
                    'image_product'      => '',
                    'image_manufacturer' => '',
                    'api'                => array(),
                    'folder'             => '',
                    'file'               => array(),
                    'extend'             => array(),
                ),
                'site'             => array(),
                'languages'        => array(),
                'language_default' => '1',
                'categoryData'     => array(),
                'category_root'    => '1',
                'attributes'       => array(),
                'order_status'     => array(),
                'currencies'       => array(),
                'currency_default' => '',
                'countries'        => array(),
                'customer_group'   => array(),
                'storage'          => array(
                    'result'   => 'process',
                    'function' => 'noStorageData',
                    'type'     => '',
                    'msg'      => $this->consoleSuccess("Preparing import data ..."),
                    'count'    => 0,
                ),
                'clear'            => array(
                    'result'      => 'process',
                    'function'    => '_noClear',
                    'table_index' => 0,
                    'msg'         => '',
                    'limit'       => 20
                ),
                'support'          => array(
                    'site_map'           => false,
                    'language_map'       => false,
                    'category_map'       => false,
                    'attribute_map'      => false,
                    'order_status_map'   => false,
                    'currency_map'       => false,
                    'country_map'        => false,
                    'customer_group_map' => false,
                    'taxes'              => true,
                    'manufacturers'      => true,
                    'categories'         => true,
                    'products'           => true,
                    'customers'          => true,
                    'orders'             => true,
                    'reviews'            => true,
                    'pages'              => false,
                    'blocks'             => false,
                    'widgets'            => false,
                    'polls'              => false,
                    'transactions'       => false,
                    'newsletters'        => false,
                    'users'              => false,
                    'rules'              => false,
                    'cartrules'          => false,
                    'add_new'            => true,
                    'clear_shop'         => true,
                    'img_des'            => true,
                    'pre_cus'            => true,
                    'pre_ord'            => true,
                    'pre_cat'            => true,
                    'pre_prd'            => true,
                    'seo'                => true,
                ),
                'extends'          => array(),
                'number_of_prd'    => 0,
                'number_of_cat'    => 0,
            ),
            'support'          => array(
                'site_map'           => false,
                'language_map'       => false,
                'category_map'       => false,
                'attribute_map'      => false,
                'order_status_map'   => false,
                'currency_map'       => false,
                'country_map'        => false,
                'customer_group_map' => false,
                'taxes'              => true,
                'manufacturers'      => true,
                'categories'         => true,
                'products'           => true,
                'customers'          => true,
                'orders'             => true,
                'reviews'            => true,
                'pages'              => false,
                'blocks'             => false,
                'widgets'            => false,
                'polls'              => false,
                'transactions'       => false,
                'newsletters'        => false,
                'users'              => false,
                'rules'              => false,
                'cartrules'          => false,
                'add_new'            => false,
                'clear_shop'         => false,
                'img_des'            => false,
                'pre_cus'            => false,
                'pre_ord'            => false,
                'pre_cat'            => false,
                'pre_prd'            => false,
                'seo'                => false,
            ),
            'map'              => array(
                'site'           => array(),
                'languages'      => array(),
                'categoryData'   => array(),
                'attributes'     => array(),
                'currencies'     => array(),
                'order_status'   => array(),
                'countries'      => array(),
                'customer_group' => array(),
            ),
            'config'           => array(
                'taxes'         => false,
                'manufacturers' => false,
                'categories'    => false,
                'products'      => false,
                'customers'     => false,
                'orders'        => false,
                'reviews'       => false,
                'pages'         => false,
                'blocks'        => false,
                'widgets'       => false,
                'polls'         => false,
                'transactions'  => false,
                'newsletters'   => false,
                'users'         => false,
                'rules'         => false,
                'cartrules'     => false,
                'add_new'       => false,
                'clear_shop'    => false,
                'img_des'       => false,
                'pre_cus'       => false,
                'pre_ord'       => false,
                'pre_cat'       => false,
                'pre_prd'       => false,
                'real_pre_cat'  => false,
                'real_pre_prd'  => false,
                'seo'           => false,
                'seo_plugin'    => '',
            ),
            'init'             => array(
                'running' => false,
                'resume'  => array(
                    'process' => 'clear',
                    'type'    => ''
                ),
                'message' => '',
            ),
            'process'          => array(
                'taxes'         => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'manufacturers' => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'categories'    => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'products'      => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'customers'     => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'orders'        => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'reviews'       => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'pages'         => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'blocks'        => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'widgets'       => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'polls'         => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'transactions'  => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'newsletters'   => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'users'         => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'rules'         => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
                'cartrules'     => array(
                    'total'      => 0,
                    'imported'   => 0,
                    'id_src'     => 0,
                    'error'      => 0,
                    'point'      => 0,
                    'time_start' => 0,
                    'finish'     => false
                ),
            ),
            'setting'          => $this->getSettings(),
            'running'          => false,
            'resume'           => array(
                'process' => 'clear',
                'type'    => '',
            ),
            'start_msg'        => '',
            'limit'            => '',
            'position_support' => 2,
        );
    }

    public function getSettings()
    {
        $config = array(
            'storage'       => 200,
            'taxes'         => 4,
            'manufacturers' => 4,
            'categories'    => 4,
            'products'      => 4,
            'customers'     => 4,
            'orders'        => 4,
            'reviews'       => 4,
            'pages'         => 4,
            'blocks'        => 4,
            'widgets'       => 4,
            'polls'         => 4,
            'transactions'  => 4,
            'newsletters'   => 4,
            'users'         => 4,
            'rules'         => 4,
            'cartrules'     => 4,
            'delay'         => 0.01,
            'retry'         => 30,
            'src_prefix'    => '',
            'target_prefix' => '',
            'license'       => '',
        );
        foreach ($config as $key => $default_value) {
            $value = $this->getSetting($key, '');
            if ($value) {
                $config[$key] = $value;
            }
        }

        return $config;
    }

    public function getUserNotice($user_id)
    {
        if (!$user_id) {
            return null;
        }
        $db = $this->getDb();
        if (!$db) {
            return null;
        }
        $result = $db->selectObj(Bootstrap::TABLE_NOTICE, array('id' => $user_id));
        if ($result['result'] != 'success' || !$result['data']) {
            return null;
        }
        $notice = $result['data'][0]['notice'];

        return unserialize($notice);
    }

    public function saveUserNotice($user_id, $notice)
    {
        if (!$user_id) {
            return false;
        }
        $db     = $this->getDb();
        $notice = serialize($notice);
        $exists = $db->selectObj(Bootstrap::TABLE_NOTICE, array('id' => $user_id));
        if ($exists['result'] != 'success') {
            return false;
        }
        if ($exists['data']) {
            $result = $db->updateObj(Bootstrap::TABLE_NOTICE, array('notice' => $notice), array('id' => $user_id));
        } else {
            $result = $db->insertObj(Bootstrap::TABLE_NOTICE, array('id' => $user_id, 'notice' => $notice));
        }

        return ($result['result'] == 'success') ? $result['data'] : false;
    }

    public function deleteUserNotice($user_id)
    {
        if (!$user_id) {
            return true;
        }
        $db     = $this->getDb();
        $delete = $db->deleteObj(Bootstrap::TABLE_NOTICE, array('id' => $user_id));
        $result = false;
        if ($delete && $delete['result'] == 'success') {
            $result = $delete['data'];
        }

        return $result;
    }


    /**
     * TODO: ROUTER
     */

    public function sourceCartSetup($cart_type)
    {
        $setupType = array(
            // connector
            'oscommerce'   => 'connector',
            'virtuemart'   => 'connector',
            'zencart'      => 'connector',
            'woocommerce'  => 'connector',
            'jigoshop'     => 'connector',
            'interspire'   => 'connector',
            'wpecommerce'  => 'connector',

            // api
            'shopify'      => 'api',
            'bigcommerce'  => 'api',
            '3dcart'       => 'api',

            // file
            'nopcommerce'  => 'file',
            'volusion'     => 'file',
            'mivamerchant' => 'file',
            'bigcartel'    => 'file',
            'amazonstore'  => 'file',
            'yahoostore'   => 'file',
            'weebly'       => 'file',
            'squarespace'  => 'file',
        );

        return isset($setupType[$cart_type]) ? $setupType[$cart_type] : 'connector';
    }

    public function targetCartSetup($cart_type)
    {
        $setupType = array(
            // connector
            'oscommerce'   => 'connector',
            'virtuemart'   => 'connector',
            'zencart'      => 'connector',
            'woocommerce'  => 'connector',
            'webshop'  => 'connector',

            // api
            'shopify'      => 'api',
            'bigcommerce'  => 'api',
            'volusion'     => 'api',
            'mivamerchant' => 'api',
        );

        return isset($setupType[$cart_type]) ? $setupType[$cart_type] : 'connector';
    }

    public function getCart($cart_type, $cart_version = null)
    {
        if ($cart_type == 'webshop') {
            return 'cart_webshop';
        }
        if ($cart_type == 'oscommerce') {
            return 'cart_oscommerce';
        }

        if ($cart_type == 'zencart') {
            return 'cart_zencart';
        }

        if ($cart_type == 'virtuemart') {
            if ($this->convertVersion($cart_version, 2) < 200) {
                return 'cart_virtuemartv1';
            } else {
                return 'cart_virtuemartv2';
            }
        }

        if ($cart_type == 'interspire') {
            return 'cart_interspire';
        }

        if ($cart_type == 'shopify') {
            return 'cart_shopify';
        }

        if ($cart_type == 'bigcommerce') {
            return 'cart_bigcommerce';
        }

        if ($cart_type == 'volusion') {
            return 'cart_volusion';
        }

        if ($cart_type == 'mivamerchant') {
            return 'cart_mivamerchant';
        }

        if ($cart_type == 'woocommerce') {
            return 'cart_woocommerce';
        }

        if ($cart_type == 'prestashop') {
            $version = $this->convertVersion($cart_version, 2);
            if ($version > 149) {
                return 'cart_prestashop16';
            } elseif ($version > 139) {
                return 'cart_prestashop14';
            } else {
                return 'cart_prestashop13';
            }
        }

        if ($cart_type == 'opencart') {
            if ($this->convertVersion($cart_version, 2) >= 200) {
                return 'cart_opencart';
            } elseif ($this->convertVersion($cart_version, 2) < 200 && $this->convertVersion($cart_version, 2) > 149) {
                return 'cart_opencartv15';
            } else {
                return 'cart_opencart';
            }
        }
        if ($cart_type == '3dcart') {
            return 'cart_3dcart';
        }
        if ($cart_type == 'bigcartel') {
            return 'cart_bigcartel';
        }

        if ($cart_type == 'amazonstore') {
            return 'cart_amazonstore';
        }
        if ($cart_type == 'yahoostore') {
            return 'cart_yahoostore';
        }
        if ($cart_type == 'jigoshop') {
            if ($this->convertVersion($cart_version, 2) >= 20) {
                return 'cart_jigoshopv2';
            } else {
                return 'cart_jigoshop';
            }
        }
        if ($cart_type == 'weebly') {
            return 'cart_weebly';
        }
        if ($cart_type == 'squarespace') {
            return 'cart_squarespace';
        }

        if ($cart_type == 'magento') {
            if(strpos($cart_version,'1.14.') !== false){
                return 'cart_magento19';
            }
            if ($this->convertVersion($cart_version, 2) > 200) {
                return 'cart_magento2';
            } elseif ($this->convertVersion($cart_version, 2) > 149) {
                return 'cart_magento19';
            } elseif ($this->convertVersion($cart_version, 2) > 140) {
                return 'cart_magento14';
            } else {
                return 'cart_magento13';
            }
        }
        if ($cart_type == 'nopcommerce') {
            return 'cart_nopcommerce';
        }
        if ($cart_type == 'pinnaclecart') {
            return 'cart_pinnaclecart';
        }
        if ($cart_type == 'wpecommerce') {
            return 'cart_wpecommercev38';
        }
        if ($cart_type == 'cubecart') {
            if ($this->convertVersion($cart_version, 2) > 499) {
                return 'cart_cubecart6';
            } else {
                return 'cart_cubecart4';
            }
        }
        if ($cart_type == 'oxideshop') {
            if ($this->convertVersion($cart_version, 2) > 469) {
                return 'cart_oxideshop49';
            } else {
                return 'cart_oxideshop44';
            }
        }
        if ($cart_type == 'cscart') {
            if ($this->convertVersion($cart_version, 2) > 299) {
                return 'cart_cscart4';
            } else {
                return 'cart_cscart2';
            }
        }

        if ($cart_type == 'hikashop') {
            return 'cart_hikashop';
        }

        return 'cart';
    }

    public function getListSeo($desc_type, $src_type)
    {
        $seo      = array();
        $list     = array(
            'oscommerce' => array(
                'oscommerce' => array(
                    'seo_oscommerce_oscommerce_default' => 'Default SEO',
                    'seo_oscommerce_oscommerce_custom'  => 'Custom SEO',
                ),
                'zencart'    => array(
                    'seo_oscommerce_zencart_default' => 'Default SEO',
                    'seo_oscommerce_zencart_custom'  => 'Custom SEO',
                ),
            ),
            'opencart'   => array(
                'opencart'     => array(
                    'seo_opencart_opencart_default' => 'Default SEO',
                ),
                'mivamerchant' => array(
                    'seo_opencart_mivamerchant_default' => 'Default SEO',
                    'seo_opencart_mivamerchant_custom'  => 'Custom SEO',
                ),
                'zencart'      => array(
                    'seo_opencart_zencart_default' => 'Default SEO',
                    'seo_opencart_zencart_custom'  => 'Custom SEO',
                ),
                'bigcommerce'  => array(
                    'seo_opencart_bigcommerce_default' => 'Default SEO',
                ),
                'magento'      => array(
                    'seo_opencart_magento_default' => 'Default SEO',
                ),
                'oscommerce'   => array(
                    'seo_opencart_oscommerce_custom' => 'Custom SEO',
                ),
                'prestashop'   => array(
                    'seo_opencart_prestashop_default' => 'Default SEO',
                ),
                'squarespace'  => array(
                    'seo_opencart_squarespace_default' => 'Default SEO',
                ),
            ),
            'shopify'    => array(
                'bigcommerce' => array(
                    'seo_shopify_bigcommerce_default' => 'Default SEO',
                ),
                'squarespace' => array(
                    'seo_shopify_squarespace_default' => 'Default SEO',
                ),
                'volusion'    => array(
                    'seo_shopify_volusion_default' => 'Default SEO',
                ),
                'cscart'      => array(
                    'seo_shopify_cscart_default' => 'Default SEO',
                ),
                'woocommerce' => array(
                    'seo_shopify_woocommerce_default' => 'Default SEO',
                ),
                'prestashop'  => array(
                    'seo_shopify_prestashop_default' => 'Default SEO',
                ),
                'zencart'     => array(
                    'seo_shopify_zencart_default' => 'Default SEO',
                ),
            ),
            'magento'    => array(
                'magento' => array(
                    'seo_magento_magento_default' => 'Default SEO',
                ),
            ),
        );
        $desc_seo = isset($list[$desc_type]) ? $list[$desc_type] : false;
        if (!$desc_seo) {
            return $seo;
        }
        $src_seo = isset($desc_seo[$src_type]) ? $desc_seo[$src_type] : array();
        if (!$src_seo) {
            return $seo;
        }
        $model_folder = _MODULE_APP_DIR_ . DS . 'models';
        foreach ($src_seo as $seo_key => $seo_label) {
            $seo_path   = Bootstrap::convertPathUppercase($seo_key);
            $model_path = str_replace('_', DS, $seo_path);
            $model_file = $model_folder . DS . $model_path . '.php';
            if (file_exists($model_file)) {
                $seo[$seo_key] = $seo_label;
            }
        }

        return $seo;
    }


    public function isInitNotice($cart_type)
    {
        $setup_type = $this->sourceCartSetup($cart_type);

        return $setup_type == 'file';
    }

    public function getSourceCart()
    {
//        var_dump(1);exit;
        $cart_type    = $this->_notice['src']['cart_type'];
        $cart_version = $this->_notice['src']['config']['version'];
        $cart_name    = $this->getCart($cart_type, $cart_version);
        $sourceCart   = Bootstrap::getModel($cart_name);
        $sourceCart->setType('src')->setNotice($this->_notice);

        return $sourceCart;
    }

    public function getTargetCart()
    {
//        var_dump(1);exit;
        $cart_type    = $this->_notice['target']['cart_type'];
        $cart_version = $this->_notice['target']['config']['version'];
        $cart_name    = $this->getCart($cart_type, $cart_version);
        $targetCart   = Bootstrap::getModel($cart_name);
        $targetCart->setType('target')->setNotice($this->_notice);

        return $targetCart;
    }

    /**
     * TODO: DISPLAY
     */

    public function getApiInfo()
    {
        return array();
    }

    public function getFileInfo()
    {
        return array();
    }

    public function clearPreviousSection()
    {
        return $this;
    }

    public function formatUrl($url)
    {
        if (strpos($url, self::CONNECTOR_SUFFIX) !== false) {
            $url = str_replace(self::CONNECTOR_SUFFIX, '', $url);
        }
        $url = rtrim($url, '/');

        return $url;
    }

    public function prepareUpload()
    {
        return array(
            'result' => 'success',
        );
    }

    public function getAllowExtensions()
    {
        return null;
    }

    public function getUploadFileName($upload_name)
    {
        return null;
    }

    public function displayUpload($upload_msg)
    {
        return array(
            'result' => 'success',
            'msg'    => $upload_msg
        );
    }

    public function prepareDisplayResume()
    {
        $this->_notice['setting'] = $this->getSettings();

        return array(
            'result' => 'success',
        );
    }

    public function displayResumeSource()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayResumeTarget()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayResume()
    {
        return array(
            'result' => 'success',
        );
    }

    public function prepareDisplaySetupSource()
    {
        $response   = $this->_defaultResponse();
        $cart_type  = $this->_notice['src']['cart_type'];
        $setup_type = $this->sourceCartSetup($cart_type);
        $demo_mode  = Bootstrap::getConfig('demo_mode');
        if ($demo_mode != true) {
            $license = $this->_notice['setting']['license'];
            if (!$license) {
                $response['result'] = 'error';
                $response['msg']    = 'Please enter License Key (in Configuration)';

                return $response;
            }
            $check_license = $this->curlPost(
                chr(104) . chr(116) . chr(116) . chr(112) . chr(58) . chr(47) . chr(47) . chr(108) . chr(105) . chr(116) . chr(101) . chr(120) . chr(116) . chr(101) . chr(110) . chr(115) . chr(105) . chr(111) . chr(110) . chr(46) . chr(99) . chr(111) . chr(109) . chr(47) . chr(108) . chr(105) . chr(99) . chr(101) . chr(110) . chr(115) . chr(101) . chr(46) . chr(112) . chr(104) . chr(112),
                array(
                    'user'        => "bGl0ZXg=",
                    'pass'        => "YUExMjM0NTY=",
                    'action'      => "Y2hlY2s=",
                    'license'     => base64_encode($license),
                    'cart_type'   => base64_encode($this->_notice['src']['cart_type']),
                    'target_type' => base64_encode($this->_notice['target']['cart_type']),
                    'url'         => base64_encode($this->_notice['src']['cart_url']),
                )
            );
            if (!$check_license) {
                $response['result'] = 'error';
                $response['msg']    = 'Could not get your license info, please check network connection.';

                return $response;
            }
            $check_license = unserialize(base64_decode($check_license));
            if ($check_license['result'] != 'success') {
                return $check_license;
            }
        }
        if ($setup_type == 'connector') {
            $token         = $_POST['source_token'];
            $connector_url = $this->getConnectorUrl('check', $token);
            $check         = $this->getConnectorData($connector_url);


            if (!$check) {
                $response['result'] = "warning";
                $response['elm']    = "#error-url";
                $response['msg']    = "Cannot reach connector! It should be uploaded at: " . $this->getUrlSuffix(self::CONNECTOR_SUFFIX);

                return $response;
            }
            if ($check['result'] != "success") {
                $response['result'] = "warning";
                $response['elm']    = "#error-token";
                $response['msg']    = "Source Token not correct!";

                return $response;
            }
            $data = $check['data'];
            if (!$this->_checkCartTypeSync($data['cms'], $this->_notice['src']['cart_type'])) {
                $response['result'] = "warning";
                $response['elm']    = "#error-type";
                $response['msg']    = "Source Cart type not correct!";

                return $response;
            }
            $connect = $data['connect'];
            if (!$connect || $connect['result'] != "success") {
                $response['result'] = "warning";
                $response['elm']    = "#error-url";
                $response['msg']    = "Cannot reach database from connector!";

                return $response;
            }
            $configKey = array('version', 'table_prefix', 'charset', 'image_product', 'image_category', 'image_manufacturer', 'extend');
            foreach ($configKey as $config_key) {
                $config_value                                = isset($data[$config_key]) ? $data[$config_key] : '';
                $this->_notice['src']['config'][$config_key] = $config_value;
            }
        }

        return array(
            'result' => 'success',
        );
    }

    public function displaySetupSource()
    {
        $configs = array('token', 'api');
        foreach ($configs as $config) {
            $value = (isset($_POST[$config])) ? $_POST[$config] : '';
            if ($config == 'token') {
                $value = (isset($_POST['source_token'])) ? $_POST['source_token'] : '';

            }
            $this->_notice['src']['config'][$config] = $value;
        }

        return array(
            'result' => 'success',
        );
    }

    public function prepareDisplaySetupTarget()
    {
        $response = $this->_defaultResponse();
        $src_url  = $this->_notice['src']['cart_url'];
        if ($this->_cart_url == $src_url) {
            $response['result'] = "warning";
            $response['msg']    = "Source url and target url can't same.";

            return $response;
        }
        $cart_type  = $this->_notice['target']['cart_type'];
        $setup_type = $this->targetCartSetup($cart_type);
        if ($setup_type == 'connector') {
            $token         = $_POST['target_token'];
            $connector_url = $this->getConnectorUrl('check', $token);
            $check         = $this->getConnectorData($connector_url);

            //   var_dump($check);
            // var_dump($this->_notice['target']['cart_type']);
            // exit;
            if (!$check) {
                $response['result'] = "warning";
                $response['elm']    = "#error-url";
                $response['msg']    = "Cannot reach connector! It should be uploaded at: " . $this->getUrlSuffix(self::CONNECTOR_SUFFIX);

                return $response;
            }
            if ($check['result'] != "success") {
                $response['result'] = "warning";
                $response['elm']    = "#error-token";
                $response['msg']    = "Target Token not correct!";

                return $response;
            }
            $data = $check['data'];
            if (!$this->_checkCartTypeSync($data['cms'], $this->_notice['target']['cart_type'])) {
                $response['result'] = "warning";
                $response['elm']    = "#error-type";
                $response['msg']    = "Target Cart type not correct!";

                return $response;
            }
            $connect = $data['connect'];
            if (!$connect || $connect['result'] != "success") {
                $response['result'] = "warning";
                $response['elm']    = "#error-url";
                $response['msg']    = "Cannot reach database from connector!";

                return $response;
            }
            $configKey = array('version', 'table_prefix', 'charset', 'image_product', 'image_category', 'image_manufacturer', 'extend');
            foreach ($configKey as $config_key) {
                $config_value                                   = isset($data[$config_key]) ? $data[$config_key] : '';
                $this->_notice['target']['config'][$config_key] = $config_value;
            }
        }

        return array(
            'result' => 'success',
        );
    }

    public function displaySetupTarget()
    {
        $configs = array('token', 'api');
        foreach ($configs as $config) {
            $value = (isset($_POST[$config])) ? $_POST[$config] : '';
            if ($config == 'token') {
                $value = (isset($_POST['target_token'])) ? $_POST['target_token'] : '';

            }
            $this->_notice['target']['config'][$config] = $value;
        }

        return array(
            'result' => 'success',
        );
    }

    public function prepareDisplayStorage()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayStorageSource()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayStorageTarget()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayStorage()
    {
        return array(
            'result' => 'success',
        );
    }

    public function storageData()
    {
        $function      = $this->_notice['src']['storage']['function'];
        $method_exists = method_exists($this, $function);
        if ($method_exists) {
            return $this->$function();
        } else {
            return $this->noStorageData();
        }
    }

    public function prepareDisplayConfig()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayConfigSource()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayConfigTarget()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayConfig()
    {
        $supports = array('site_map', 'language_map', 'category_map', 'attribute_map', 'order_status_map', 'currency_map', 'country_map', 'customer_group_map', 'taxes', 'manufacturers', 'categories', 'products', 'customers', 'orders', 'reviews', 'add_new', 'clear_shop', 'img_des', 'pre_cus', 'pre_ord', 'pre_cat', 'pre_prd', 'seo');
        foreach ($supports as $support) {
            $this->_notice['support'][$support] = $this->_notice['src']['support'][$support] && $this->_notice['target']['support'][$support];
        }

        return array(
            'result' => 'success',
        );
    }

    public function prepareDisplayConfirm()
    {
        $mapKey = array('site', 'languages', 'categoryData', 'attributes', 'currencies', 'order_status', 'countries', 'customer_group');
        foreach ($mapKey as $map_key) {
            $map_value                      = isset($_POST[$map_key]) ? $_POST[$map_key] : array();
            $this->_notice['map'][$map_key] = $map_value;
            if ($map_key == 'languages') {
                if (count($map_value) > 0) {
                    foreach ($map_value as $key => $value) {
                        $site_src_id    = $this->_notice['src']['site'][$key];
                        $site_target_id = $this->_notice['target']['site'][$value];
                        if (!isset($this->_notice['map']['site'][$site_src_id])) {
                            $this->_notice['map']['site'][$site_src_id] = array();
                        }
                        if (!in_array($site_target_id, $this->_notice['map']['site'][$site_src_id])) {
                            $this->_notice['map']['site'][$site_src_id][] = $site_target_id;
                        }


                    }
                }
            }
        }
        $configKey = array('taxes', 'manufacturers', 'categories', 'products', 'customers', 'orders', 'reviews', 'pages', 'blocks', 'widgets', 'polls', 'transactions', 'newsletters', 'users', 'rules', 'cartrules', 'add_new', 'clear_shop', 'img_des', 'pre_cus', 'pre_ord', 'pre_cat', 'pre_prd', 'seo', 'seo_plugin');
        foreach ($configKey as $config_key) {
            if (in_array($config_key, array('seo_plugin'))) {
                $value = isset($_POST[$config_key]) ? $_POST[$config_key] : '';
            } else {
                $value = isset($_POST[$config_key]) ? true : false;
            }
            if ($config_key == 'pre_prd' && isset($_POST[$config_key])) {
                if($this->_notice['config']['add_new']){
                    $this->_notice['config']['real_pre_prd'] = $value;
                }else{
                    $this->_notice['config']['real_pre_prd'] = isset($_POST[$config_key]) && (!$this->_notice['target']['number_of_prd'] || isset($_POST['clear_shop']));
                }
            }
            if ($config_key == 'pre_cat' && isset($_POST[$config_key])) {
                $this->_notice['config']['real_pre_cat'] = isset($_POST[$config_key]) && (!$this->_notice['target']['number_of_cat'] || isset($_POST['clear_shop']));
            }
            $this->_notice['config'][$config_key] = $value;
        }

        return array(
            'result' => 'success',
        );
    }

    public function displayConfirmSource()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayConfirmTarget()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayConfirm()
    {
        return array(
            'result' => 'success',
        );
    }

    public function prepareDisplayImport()
    {
        if ($this->_notice['config']['add_new']) {
            $url_src  = $this->_notice['src']['cart_url'];
            $url_desc = $this->_notice['target']['cart_url'];
            $recent   = $this->getRecent($url_src, $url_desc);
            if ($recent) {
                $types = array('taxes', 'manufacturers', 'categories', 'products', 'customers', 'orders', 'reviews', 'pages');
                foreach ($types as $type) {
                    $this->_notice['process'][$type]['id_src']   = $recent['process'][$type]['id_src'];
                    $this->_notice['process'][$type]['imported'] = 0;
                    $this->_notice['process'][$type]['error']    = 0;
                    $this->_notice['process'][$type]['point']    = 0;
                    $this->_notice['process'][$type]['finish']   = 0;
                }
            }
        }

        return array(
            'result' => 'success',
        );
    }

    public function displayImportSource()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayImportTarget()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayImport()
    {
        $source_url = $this->_notice['src']['cart_url'];
        $target_url = $this->_notice['target']['cart_url'];
        if (!$this->_notice['config']['add_new']) {
            $delete = $this->getDb()->deleteObj(Bootstrap::TABLE_MAP, array(
                'url_src'  => $source_url,
                'url_desc' => $target_url,
            ));
            if (!$delete) {
                return $this->errorDatabase(false);
            }
        }
        $demo_mode = Bootstrap::getConfig('demo_mode');
        $limit     = 0;
        if ($demo_mode == true) {
            $limit = 10;
        } else {
            $license = $this->_notice['setting']['license'];
            if ($license) {
                $check_license = $this->curlPost(
                    chr(104) . chr(116) . chr(116) . chr(112) . chr(58) . chr(47) . chr(47) . chr(108) . chr(105) . chr(116) . chr(101) . chr(120) . chr(116) . chr(101) . chr(110) . chr(115) . chr(105) . chr(111) . chr(110) . chr(46) . chr(99) . chr(111) . chr(109) . chr(47) . chr(108) . chr(105) . chr(99) . chr(101) . chr(110) . chr(115) . chr(101) . chr(46) . chr(112) . chr(104) . chr(112),
                    array(
                        'user'        => "bGl0ZXg=",
                        'pass'        => "YUExMjM0NTY=",
                        'action'      => "Y2hlY2s=",
                        'license'     => base64_encode($license),
                        'cart_type'   => base64_encode($this->_notice['src']['cart_type']),
                        'target_type' => base64_encode($this->_notice['target']['cart_type']),
                        'url'         => base64_encode($this->_notice['src']['cart_url']),
                        'save'        => true
                    )
                );
                if ($check_license) {
                    $check_license = unserialize(base64_decode($check_license));
                    if ($check_license['result'] == 'success') {
                        $limit = $check_license['data']['limit'];
                    }
                }
            }
        }
        if (!$limit) {
            $limit = 0;
        }
        if ($limit === 'unlimit') {
            $limit = 'unlimited';
        }
        $this->_notice['limit'] = $limit;
        $types                  = array('taxes', 'manufacturers', 'categories', 'products', 'customers', 'orders', 'reviews', 'pages', 'blocks', 'transactions', 'rules', 'cartrules');
        foreach ($types as $type) {
            $count = 0;
            $total = $this->_notice['process'][$type]['total'];
            if ($limit === 'unlimited') {
                $count = $total;
            } else {
                $count = ($total < $limit) ? $total : $limit;
            }
            $this->_notice['process'][$type]['total'] = $count;
        }

        return array(
            'result' => 'success',
        );
    }

    public function prepareDisplayFinish()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayFinishSource()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayFinishTarget()
    {
        return array(
            'result' => 'success',
        );
    }

    public function displayFinish()
    {
        $demo_mode = Bootstrap::getConfig('demo_mode');
        if ($demo_mode != true) {
            $license = $this->_notice['setting']['license'];
            if ($license) {
                $check_license = $this->curlPost(
                    chr(104) . chr(116) . chr(116) . chr(112) . chr(58) . chr(47) . chr(47) . chr(108) . chr(105) . chr(116) . chr(101) . chr(120) . chr(116) . chr(101) . chr(110) . chr(115) . chr(105) . chr(111) . chr(110) . chr(46) . chr(99) . chr(111) . chr(109) . chr(47) . chr(108) . chr(105) . chr(99) . chr(101) . chr(110) . chr(115) . chr(101) . chr(46) . chr(112) . chr(104) . chr(112),
                    array(
                        'user'        => "bGl0ZXg=",
                        'pass'        => "YUExMjM0NTY=",
                        'action'      => "Y2hlY2s=",
                        'license'     => base64_encode($license),
                        'cart_type'   => base64_encode($this->_notice['src']['cart_type']),
                        'target_type' => base64_encode($this->_notice['target']['cart_type']),
                        'url'         => base64_encode($this->_notice['src']['cart_url']),
                        'base'        => base64_encode($this->_notice['target']['cart_url']),
                    )
                );
            }
        }
        $source_url    = $this->_notice['src']['cart_url'];
        $target_url    = $this->_notice['target']['cart_url'];
        $recent_exists = $this->getDb()->selectObj(Bootstrap::TABLE_RECENT, array(
            'url_src'  => $source_url,
            'url_desc' => $target_url,
        ));
        $notice        = serialize($this->_notice);
        if ($recent_exists) {
            $this->getDb()->updateObj(Bootstrap::TABLE_RECENT, array(
                'notice' => $notice
            ), array(
                'url_src'  => $source_url,
                'url_desc' => $target_url,
            ));
        } else {
            $this->getDb()->insertObj(Bootstrap::TABLE_RECENT, array(
                'notice'   => $notice,
                'url_src'  => $source_url,
                'url_desc' => $target_url,
            ));
        }

        return array(
            'result' => 'success',
        );
    }

    public function prepareImportSource()
    {
        return array(
            'result' => 'success',
        );
    }

    public function prepareImportTarget()
    {
        return array(
            'result' => 'success',
        );
    }

    public function prepareImport()
    {
        return array(
            'result' => 'success',
        );
    }

    public function clearData()
    {
        if (!$this->_notice['config']['clear_shop']) {
            return array(
                'result' => 'success',
                'msg'    => '',
            );
        }
        $fn_clear = $this->_notice['target']['clear']['function'];

        $clear = $this->$fn_clear();
        if ($clear['result'] == 'success') {
            $entities      = array('taxes', 'manufacturers', 'categories', 'products', 'customers', 'orders', 'reviews', 'pages', 'blocks', 'transactions', 'rules', 'cartrules');
            $entity_select = array();
            foreach ($entities as $entity) {
                if ($this->_notice['config'][$entity]) {
                    $entity_select[] = ucfirst($entity);
                }
            }
            if ($entity_select) {
                $msg          = "Current " . implode(', ', $entity_select) . " cleared.";
                $clear['msg'] .= $this->consoleSuccess($msg);
            }
            $clear['msg'] .= $this->getMsgStartImport('taxes');
        }

        return $clear;
    }

    protected function _noClear()
    {
        return array(
            'result' => 'success',
            'msg'    => ''
        );
    }

    /**
     * TODO: PROCESS
     */

    public function prepareTaxesImport()
    {
        return $this;
    }

    public function prepareTaxesExport()
    {
        return $this;
    }

    public function getTaxesMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array()
        );
    }

    public function getTaxesExtExport($taxes)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertTaxExport($tax, $taxesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getTaxIdImport($convert, $tax, $taxesExt)
    {
        return false;
    }

    public function checkTaxImport($convert, $tax, $taxesExt)
    {
        return false;
    }


    public function routerTaxImport($convert, $tax, $taxesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'taxImport', //taxImport - beforeTaxImport - additionTaxImport
        );
    }

    public function beforeTaxImport($convert, $tax, $taxesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function taxImport($convert, $tax, $taxesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0
        );
    }

    public function afterTaxImport($tax_id, $convert, $tax, $taxesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionTaxImport($tax_id, $convert, $tax, $taxesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareManufacturersImport()
    {
        return $this;
    }

    public function prepareManufacturersExport()
    {
        return $this;
    }

    public function getManufacturersMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getManufacturersExtExport($manufacturers)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertManufacturerExport($manufacturer, $manufacturersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getManufacturerIdImport($convert, $manufacturer, $manufacturersExt)
    {
        return false;
    }

    public function checkManufacturerImport($convert, $manufacturer, $manufacturersExt)
    {
        return false;
    }

    public function routerManufacturerImport($convert, $manufacturer, $manufacturersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'manufacturerImport',
        );
    }

    public function beforeManufacturerImport($convert, $manufacturer, $manufacturersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function manufacturerImport($convert, $manufacturer, $manufacturersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterManufacturerImport($manufacturer_id, $convert, $manufacturer, $manufacturersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionManufacturerImport($manufacturer_id, $convert, $manufacturer, $manufacturersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareCategoriesExport()
    {
        return $this;
    }

    public function prepareCategoriesImport()
    {
        return $this;
    }

    public function getCategoriesMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getCategoriesExtExport($categories)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertCategoryExport($category, $categoriesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getCategoryIdImport($convert, $category, $categoriesExt)
    {
        return false;
    }

    public function checkCategoryImport($convert, $category, $categoriesExt)
    {
        return false;
    }

    public function routerCategoryImport($convert, $category, $categoriesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'categoryImport',
        );
    }

    public function beforeCategoryImport($convert, $category, $categoriesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function categoryImport($convert, $category, $categoriesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterCategoryImport($category_id, $convert, $category, $categoriesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionCategoryImport($category_id, $convert, $category, $categoriesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareProductsExport()
    {
        return $this;
    }

    public function prepareProductsImport()
    {
        return $this;
    }

    public function getProductsMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getProductsExtExport($products)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertProductExport($product, $productsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getProductIdImport($convert, $product, $productsExt)
    {
        return false;
    }

    public function checkProductImport($convert, $product, $productsExt)
    {
        return false;
    }

    public function routerProductImport($convert, $product, $productsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'productImport',
        );
    }

    public function beforeProductImport($convert, $product, $productsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function productImport($convert, $product, $productsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterProductImport($product_id, $convert, $product, $productsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionProductImport($product_id, $convert, $product, $productsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareCustomersExport()
    {
        return $this;
    }

    public function prepareCustomersImport()
    {
        return $this;
    }

    public function getCustomersMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getCustomersExtExport($customers)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertCustomerExport($customer, $customersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getCustomerIdImport($convert, $customer, $customersExt)
    {
        return false;
    }

    public function checkCustomerImport($convert, $customer, $customersExt)
    {
        return false;
    }

    public function routerCustomerImport($convert, $customer, $customersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function beforeCustomerImport($convert, $customer, $customersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function customerImport($convert, $customer, $customersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterCustomerImport($customer_id, $convert, $customer, $customersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionCustomerImport($customer_id, $convert, $customer, $customersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareOrdersExport()
    {
        return $this;
    }

    public function prepareOrdersImport()
    {
        return $this;
    }

    public function getOrdersMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getOrdersExtExport($orders)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertOrderExport($order, $ordersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getOrderIdImport($convert, $order, $ordersExt)
    {
        return false;
    }

    public function checkOrderImport($convert, $order, $ordersExt)
    {
        return false;
    }

    public function routerOrderImport($convert, $order, $ordersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'orderImport',
        );
    }

    public function beforeOrderImport($convert, $order, $ordersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function orderImport($convert, $order, $ordersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterOrderImport($order_id, $convert, $order, $ordersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionOrderImport($order_id, $convert, $order, $ordersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareReviewsExport()
    {
        return $this;
    }

    public function prepareReviewsImport()
    {
        return $this;
    }

    public function getReviewsMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getReviewsExtExport($reviews)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertReviewExport($review, $reviewsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getReviewIdImport($convert, $review, $reviewsExt)
    {
        return false;
    }

    public function checkReviewImport($convert, $review, $reviewsExt)
    {
        return false;
    }

    public function routerReviewImport($convert, $review, $reviewsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'reviewImport',
        );
    }

    public function beforeReviewImport($convert, $review, $reviewsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function reviewImport($convert, $review, $reviewsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterReviewImport($review_id, $convert, $review, $reviewsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionReviewImport($review_id, $convert, $review, $reviewsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function preparePagesExport()
    {
        return $this;
    }

    public function preparePagesImport()
    {
        return $this;
    }

    public function getPagesMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getPagesExtExport($pages)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertPageExport($page, $pagesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getPageIdImport($convert, $page, $pagesExt)
    {
        return false;
    }

    public function checkPageImport($convert, $page, $pagesExt)
    {
        return false;
    }

    public function routerPageImport($convert, $page, $pagesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'pageImport',
        );
    }

    public function beforePageImport($convert, $page, $pagesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function pageImport($convert, $page, $pagesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterPageImport($page_id, $convert, $page, $pagesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionPageImport($page_id, $convert, $page, $pagesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareBlocksExport()
    {
        return $this;
    }

    public function prepareBlocksImport()
    {
        return $this;
    }

    public function getBlocksMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getBlocksExtExport($blocks)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertBlockExport($block, $blocksExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getBlockIdImport($convert, $block, $blocksExt)
    {
        return false;
    }

    public function checkBlockImport($convert, $block, $blocksExt)
    {
        return false;
    }

    public function routerBlockImport($convert, $block, $blocksExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'blockImport',
        );
    }

    public function beforeBlockImport($convert, $block, $blocksExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function blockImport($convert, $block, $blocksExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterBlockImport($block_id, $convert, $block, $blocksExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionBlockImport($block_id, $convert, $block, $blocksExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }


    public function prepareWidgetsExport()
    {
        return $this;
    }

    public function prepareWidgetsImport()
    {
        return $this;
    }

    public function getWidgetsMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getWidgetsExtExport($widgets)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertWidgetExport($widget, $widgetsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getWidgetIdImport($convert, $widget, $widgetsExt)
    {
        return false;
    }

    public function checkWidgetImport($convert, $widget, $widgetsExt)
    {
        return false;
    }

    public function routerWidgetImport($convert, $Widget, $widgetsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'WidgetImport',
        );
    }

    public function beforeWidgetImport($convert, $widget, $widgetsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function widgetImport($convert, $widget, $widgetsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterWidgetImport($widget_id, $convert, $widget, $widgetsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionWidgetImport($widget_id, $convert, $widget, $widgetsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function preparePollsExport()
    {
        return $this;
    }

    public function preparePollsImport()
    {
        return $this;
    }

    public function getPollsMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getPollsExtExport($polls)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertPollExport($poll, $pollsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getPollIdImport($convert, $poll, $pollsExt)
    {
        return false;
    }

    public function checkPollImport($convert, $poll, $pollsExt)
    {
        return false;
    }

    public function routerPollImport($convert, $poll, $pollsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'pollImport',
        );
    }

    public function beforePollImport($convert, $poll, $pollsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function pollImport($convert, $poll, $pollsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterPollImport($poll_id, $convert, $poll, $pollsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionPollImport($poll_id, $convert, $poll, $pollsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }


    public function prepareTransactionsExport()
    {
        return $this;
    }

    public function prepareTransactionsImport()
    {
        return $this;
    }

    public function getTransactionsMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getTransactionsExtExport($transactions)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertTransactionExport($transaction, $transactionsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getTransactionIdImport($convert, $transaction, $transactionsExt)
    {
        return false;
    }

    public function checkTransactionImport($convert, $transaction, $transactionsExt)
    {
        return false;
    }

    public function routerTransactionImport($convert, $transaction, $transactionsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'transactionImport',
        );
    }

    public function beforeTransactionImport($convert, $transaction, $transactionsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function transactionImport($convert, $transaction, $transactionsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterTransactionImport($transaction_id, $convert, $transaction, $transactionsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionTransactionImport($transaction_id, $convert, $transaction, $transactionsExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareNewslettersExport()
    {
        return $this;
    }

    public function prepareNewslettersImport()
    {
        return $this;
    }

    public function getNewslettersMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getNewslettersExtExport($newsletters)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertNewsletterExport($newsletter, $newslettersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getNewsletterIdImport($convert, $newsletter, $newslettersExt)
    {
        return false;
    }

    public function checkNewsletterImport($convert, $newsletter, $newslettersExt)
    {
        return false;
    }

    public function routerNewsletterImport($convert, $newsletter, $newslettersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'newsletterImport',
        );
    }

    public function beforeNewsletterImport($convert, $newsletter, $newslettersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function newsletterImport($convert, $newsletter, $newslettersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterNewsletterImport($newsletter_id, $convert, $newsletter, $newslettersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionNewsletterImport($newsletter_id, $convert, $newsletter, $newslettersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareUsersExport()
    {
        return $this;
    }

    public function prepareUsersImport()
    {
        return $this;
    }

    public function getUsersMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getUsersExtExport($users)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertUserExport($user, $usersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getUserIdImport($convert, $user, $usersExt)
    {
        return false;
    }

    public function checkUserImport($convert, $user, $usersExt)
    {
        return false;
    }

    public function routerUserImport($convert, $user, $usersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'UserImport',
        );
    }

    public function beforeUserImport($convert, $user, $usersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function userImport($convert, $user, $usersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterUserImport($user_id, $convert, $user, $usersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionUserImport($user_id, $convert, $user, $usersExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareRulesExport()
    {
        return $this;
    }

    public function prepareRulesImport()
    {
        return $this;
    }

    public function getRulesMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getRulesExtExport($rules)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertRuleExport($rule, $rulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getRuleIdImport($convert, $rule, $rulesExt)
    {
        return false;
    }

    public function checkRuleImport($convert, $rule, $rulesExt)
    {
        return false;
    }

    public function routerRuleImport($convert, $rule, $rulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'ruleImport',
        );
    }

    public function beforeRuleImport($convert, $rule, $rulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function ruleImport($convert, $rule, $rulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterRuleImport($rule_id, $convert, $rule, $rulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionRuleImport($rule_id, $convert, $rule, $rulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function prepareCartrulesExport()
    {
        return $this;
    }

    public function prepareCartrulesImport()
    {
        return $this;
    }

    public function getCartrulesMainExport()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getCartrulesExtExport($cartrules)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function convertCartruleExport($cartrule, $cartrulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function getCartruleIdImport($convert, $cartrule, $cartrulesExt)
    {
        return false;
    }

    public function checkCartruleImport($convert, $cartrule, $cartrulesExt)
    {
        return false;
    }

    public function routerCartruleImport($convert, $cartrule, $cartrulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 'cartruleImport',
        );
    }

    public function beforeCartruleImport($convert, $cartrule, $cartrulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function cartruleImport($convert, $cartrule, $cartrulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => 0,
        );
    }

    public function afterCartruleImport($cartrule_id, $convert, $cartrule, $cartrulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    public function additionCartruleImport($cartrule_id, $convert, $cartrule, $cartrulesExt)
    {
        return array(
            'result' => 'success',
            'msg'    => '',
            'data'   => array(),
        );
    }

    /**
     * TODO: DATABASE
     */

    public function selectTable($table, $where = null)
    {
        $result = array();
        $select = $this->getDb()->selectObj($table, $where);
        if ($select && $select['result'] == 'success') {
            $result = $select['data'];
        }

        return $result;
    }

    public function selectTableRow($table, $where = null)
    {
        $rows = $this->selectTable($table, $where);
        if (!$rows) {
            return false;
        }

        return isset($rows[0]) ? $rows[0] : false;
    }

    public function insertTable($table, $data, $insert_id = false)
    {
        $result = false;
        $insert = $this->getDb()->insertObj($table, $data, $insert_id);
        if ($insert && $insert['result'] == 'success') {
            $result = $insert['data'];
        }

        return $result;
    }

    public function updateTable($table, $data, $where = null)
    {
        $result = false;
        $update = $this->getDb()->updateObj($table, $data . $where);
        if ($update && $update['result'] == 'success') {
            $result = $update['data'];
        }

        return $result;
    }

    public function deleteTable($table, $where = null)
    {
        $result = false;
        $delete = $this->getDb()->deleteObj($table, $where);
        if ($delete && $delete['result'] == 'success') {
            $result = $delete['data'];
        }

        return $result;
    }

    public function escape($value)
    {
        return $this->getDb()->escape($value);
    }

    public function arrayToInCondition($array)
    {
        return $this->getDb()->arrayToInCondition($array);
    }

    public function arrayToSetCondition($array)
    {
        return $this->getDb()->arrayToSetCondition($array);
    }

    public function arrayToInsertCondition($array, $allow_keys = null)
    {
        return $this->getDb()->arrayToInsertCondition($array, $allow_keys);
    }

    public function arrayToWhereCondition($array)
    {
        return $this->getDb()->arrayToWhereCondition($array);
    }

    public function arrayToCreateTableSql($array)
    {
        return $this->getDb()->arrayToCreateTableSql($array);
    }

    public function getSetting($key, $default = null)
    {
        $value  = $default;
        $result = $this->getDb()->selectObj(Bootstrap::TABLE_SETTING, array(
            'key' => $key
        ));
        if (!$result || $result['result'] != 'success') {
            return $value;
        }
        $data = $result['data'];
        if (!$data) {
            return $value;
        }
        $value = isset($data[0]['value']) ? $data[0]['value'] : $default;

        return $value;
    }

    public function saveSetting($key, $value)
    {
        $exists = false;
        $check  = $this->getDb()->selectObj(Bootstrap::TABLE_SETTING, array(
            'key' => $key
        ));
        if ($check && $check['result'] == 'success' && $check['data']) {
            $exists = true;
        }
        $result = false;
        if ($exists) {
            $update = $this->getDb()->updateObj(Bootstrap::TABLE_SETTING, array(
                'value' => $value
            ), array(
                'key' => $key
            ));
            if ($update && $update['result'] == 'success') {
                $result = $update['data'];
            }
        } else {
            $insert = $this->getDb()->insertObj(Bootstrap::TABLE_SETTING, array(
                'key'   => $key,
                'value' => $value,
            ), false);
            if ($insert && $insert['result'] == 'success') {
                $result = $insert['data'];
            }
        }

        return $result;
    }

    public function selectMap($url_src = null, $url_desc = null, $type = null, $id_src = null, $id_desc = null,
        $code_src = null, $code_desc = null, $value = null)
    {
        $where = array();
        if ($url_src !== null) {
            $where['url_src'] = $url_src;
        }
        if ($url_desc !== null) {
            $where['url_desc'] = $url_desc;
        }
        if ($type !== null) {
            $where['type'] = $type;
        }
        if ($id_src !== null) {
            $where['id_src'] = $id_src;
        }
        if ($id_desc !== null) {
            $where['id_desc'] = $id_desc;
        }
        if ($code_src !== null) {
            $where['code_src'] = $code_src;
        }
        if ($code_desc !== null) {
            $where['code_desc'] = $code_desc;
        }
        if ($value !== null) {
            $where['value'] = $value;
        }
        if (!$where || empty($where)) {
            return null;
        }
        $result = $this->getDb()->selectObj(Bootstrap::TABLE_MAP, $where);
        if (!$result || $result['result'] != 'success') {
            return null;
        }
        $data = isset($result['data'][0]) ? $result['data'][0] : null;

        return $data;
    }

    public function getMapFieldBySource($type, $id_src = null, $code_src = null, $field = 'id_desc')
    {
        $url_src  = $this->_notice['src']['cart_url'];
        $url_desc = $this->_notice['target']['cart_url'];
        if ($code_src) {
            $id_src = null;
        } else {
            $code_src = null;
        }
        $map = $this->selectMap($url_src, $url_desc, $type, $id_src, null, $code_src);
        if (!$map) {
            return false;
        }

        return isset($map[$field]) ? $map[$field] : false;
    }

    public function insertMap($url_src = null, $url_desc = null, $type = null, $id_src = null, $id_desc = null,
        $code_src = null, $code_desc = null, $value = null)
    {
        $data   = array(
            'url_src'   => $url_src,
            'url_desc'  => $url_desc,
            'type'      => $type,
            'id_src'    => $id_src,
            'code_src'  => $code_src,
            'id_desc'   => $id_desc,
            'code_desc' => $code_desc,
            'value'     => $value,
        );
        $insert = $this->getDb()->insertObj(Bootstrap::TABLE_MAP, $data);
        if (!$insert || $insert['result'] != 'success') {
            return false;
        }

        return $insert['data'];
    }

    public function deleteMaps($url_src = null, $url_desc = null, $type = null, $id_src = null, $id_desc = null,
        $value = null)
    {
        $where = array();
        if ($url_src != null) {
            $where['url_src'] = $url_src;
        }
        if ($url_desc != null) {
            $where['url_desc'] = $url_desc;
        }
        if ($type != null) {
            $where['type'] = $type;
        }
        if ($id_src != null) {
            $where['id_src'] = $id_src;
        }
        if ($id_desc != null) {
            $where['id_desc'] = $id_desc;
        }
        if ($value != null) {
            $where['value'] = $value;
        }
        $delete = $this->getDb()->deleteObj(Bootstrap::TABLE_MAP, $where);
        if (!$delete || $delete['result'] != 'success') {
            return false;
        }

        return $delete['data'];
    }

    public function getRecent($url_src = null, $url_desc = null)
    {
        $where = array();
        if ($url_src != null) {
            $where['url_src'] = $url_src;
        }
        if ($url_desc != null) {
            $where['url_desc'] = $url_desc;
        }
        $result = $this->getDb()->selectObj(Bootstrap::TABLE_RECENT, $where);
        if (!$result || $result['result'] != 'success') {
            return null;
        }
        $data   = $result['data'];
        $recent = null;
        if ($data && isset($data[0]['notice'])) {
            $recent = $data[0]['notice'];
        }

        return unserialize($recent);
    }

    public function saveRecent($url_src, $url_desc, $notice)
    {
        $notice = serialize($notice);
        $exists = false;
        $check  = $this->getDb()->selectObj(Bootstrap::TABLE_RECENT, array(
            'url_src'  => $url_src,
            'url_desc' => $url_desc,
        ));
        if ($check && $check['result'] == 'success' && $check['data']) {
            $exists = true;
        }
        $result = false;
        if ($exists) {
            $update = $this->getDb()->updateObj(Bootstrap::TABLE_RECENT, array(
                'notice' => $notice
            ), array(
                'url_src'  => $url_src,
                'url_desc' => $url_desc,
            ));
            if ($update && $update['result'] == 'success') {
                $result = $update['data'];
            }
        } else {
            $insert = $this->getDb()->insertObj(Bootstrap::TABLE_RECENT, array(
                'url_src'  => $url_src,
                'url_desc' => $url_desc,
                'notice'   => $notice,
            ));
            if ($insert && $insert['result'] == 'success') {
                $result = $insert['data'];
            }
        }

        return $result;
    }

    public function deleteRecent($url_src, $url_desc)
    {
        $db     = $this->getDb();
        $delete = $db->deleteObj(Bootstrap::TABLE_RECENT, array(
            'url_src'  => $url_src,
            'url_desc' => $url_desc,
        ));
        $result = false;
        if ($delete && $delete['result'] == 'success') {
            $result = $delete['data'];
        }

        return $result;
    }

    function getMapStoreView($src_store)
    {
        if ($src_store == 0)
            return 0;
        $map = $this->_notice['map'];

        return (isset($map['languages'][$src_store])) ? $map['languages'][$src_store] : 0;
    }

    function getMapWebsite($src_website_id)
    {
        if ($src_website_id == 0) {
            return 0;
        }
    }

    /**
     * TODO: MAPPING CONSTRUCT
     */

    public function constructTax()
    {
        return array(
            'id'            => null,
            'code'          => null,
            'site_id'       => '',
            'language_id'   => '',
            'name'          => '',
            'created_at'    => null,
            'updated_at'    => null,
            'tax_products'  => array(),
            'tax_customers' => array(),
            'tax_zones'     => array(),
            'languages'     => array(),
        );
    }

    public function constructTaxProduct()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'name'        => '',
            'created_at'  => null,
            'updated_at'  => null,
            'languages'   => array(),
        );
    }

    public function constructTaxCustomer()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'name'        => '',
            'created_at'  => null,
            'updated_at'  => null,
            'languages'   => array(),
        );
    }

    public function constructTaxZone()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'name'        => '',
            'created_at'  => null,
            'updated_at'  => null,
            'country'     => array(),
            'state'       => array(),
            'rate'        => array(),
            'languages'   => array(),
        );
    }

    public function constructTaxZoneCountry()
    {
        return array(
            'id'           => null,
            'code'         => null,
            'site_id'      => '',
            'language_id'  => '',
            'name'         => '',
            'country_code' => '',
            'created_at'   => null,
            'updated_at'   => null,
            'languages'    => array(),
        );
    }

    public function constructTaxZoneState()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'name'        => '',
            'state_code'  => '',
            'created_at'  => null,
            'updated_at'  => null,
            'languages'   => array(),
        );
    }

    public function constructTaxZoneRate()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'name'        => '',
            'rate'        => '',
            'priority'    => 0,
            'created_at'  => null,
            'updated_at'  => null,
            'languages'   => array(),
        );
    }

    public function constructManufacturer()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'name'        => '',
            'url'         => '',
            'image'       => array(
                'label' => '',
                'url'   => '',
                'path'  => '',
            ),
            'created_at'  => null,
            'updated_at'  => null,
            'languages'   => array(),
        );
    }

    public function constructManufacturerLang()
    {
        return array(
            'name' => ''
        );
    }

    public function constructCategory()
    {
        return array(
            'id'                => null,
            'code'              => null,
            'site_id'           => '',
            'language_id'       => '',
            'parent'            => array(),
            'active'            => false,
            'image'             => array(
                'label' => '',
                'url'   => '',
                'path'  => '',
            ),
            'name'              => '',
            'description'       => '',
            'short_description' => '',
            'meta_title'        => '',
            'meta_keyword'      => '',
            'meta_description'  => '',
            'sort_order'        => 0,
            'created_at'        => null,
            'updated_at'        => null,
            'languages'         => array(),
            'category'          => array(),
            'categoriesExt'     => array(),
        );
    }

    public function constructCategoryParent()
    {
        return array(
            'id'                => null,
            'code'              => null,
            'site_id'           => '',
            'language_id'       => '',
            'parent'            => array(),
            'active'            => false,
            'image'             => array(
                'label' => '',
                'url'   => '',
                'path'  => '',
            ),
            'name'              => '',
            'description'       => '',
            'short_description' => '',
            'meta_title'        => '',
            'meta_keyword'      => '',
            'meta_description'  => '',
            'sort_order'        => 0,
            'created_at'        => null,
            'updated_at'        => null,
            'languages'         => array(),
            'category'          => array(),
            'categoriesExt'     => array(),
        );
    }

    public function constructCategoryLang()
    {
        return array(
            'name'              => '',
            'description'       => '',
            'short_description' => '',
            'meta_title'        => '',
            'meta_keyword'      => '',
            'meta_description'  => '',
        );
    }

    public function constructProduct()
    {
        return array(
            'id'                => null,
            'code'              => null,
            'site_id'           => '',
            'language_id'       => '',
            'type'              => '',
            'image'             => array(
                'label' => '',
                'url'   => '',
                'path'  => '',
            ),
            'images'            => array(),
            'name'              => '',
            'sku'               => '',
            'description'       => '',
            'short_description' => '',
            'meta_title'        => '',
            'meta_keyword'      => '',
            'meta_description'  => '',
            'tags'              => '',
            'price'             => '',
            'special_price'     => array(
                'price'      => '',
                'start_date' => '',
                'end_date'   => '',
            ),
            'group_prices'      => array(),
            'tier_prices'       => array(),
            'weight'            => '',
            'length'            => '',
            'width'             => '',
            'height'            => '',
            'status'            => false,
            'manage_stock'      => false,
            'qty'               => 0,
            'tax'               => array(
                'id'   => null,
                'code' => null,
            ),
            'manufacturer'      => array(
                'id'   => null,
                'code' => null,
                'name' => null
            ),
            'created_at'        => null,
            'updated_at'        => null,
            'categories'        => array(),
            'languages'         => array(),
            'options'           => array(),
            'attributes'        => array(),
            'children'          => array(),
            'group_products'    => array(),
        );
    }

    public function constructProductImage()
    {
        return array(
            'label' => '',
            'url'   => '',
            'path'  => '',
        );
    }

    public function constructProductGroupPrice()
    {
        return array(
            'id'         => null,
            'code'       => null,
            'sites'      => array(),
            'languages'  => array(),
            'name'       => '',
            'group_code' => '',
            'group'      => array(),
            'price'      => '',
            'start_date' => '',
            'end_date'   => '',
        );
    }

    public function constructProductTierPrice()
    {
        return array(
            'id'         => null,
            'code'       => null,
            'sites'      => array(),
            'languages'  => array(),
            'name'       => '',
            'tier_code'  => '',
            'group'      => array(),
            'qty'        => 0,
            'price'      => '',
            'start_date' => '',
            'end_date'   => '',
        );
    }

    public function constructProductCategory()
    {
        return array(
            'id'   => null,
            'code' => null,
        );
    }

    public function constructProductLang()
    {
        return array(
            'name'              => '',
            'description'       => '',
            'short_description' => '',
            'meta_title'        => '',
            'meta_keyword'      => '',
            'meta_description'  => '',
        );
    }

    public function constructProductAttribute()
    {
        return array(
            'option_id'              => null,
            'option_code_save'       => null,
            'option_set'             => '',
            'option_group'           => '',
            'option_mode'            => self::OPTION_BACKEND,
            'option_type'            => '',
            'option_code'            => '',
            'option_name'            => '',
            'option_languages'       => array(),
            'option_value_id'        => null,
            'option_value_code_save' => null,
            'option_value_code'      => '',
            'option_value_name'      => '',
            'option_value_languages' => array(),
            'price'                  => '0.0000',
            'price_prefix'           => '+',
        );
    }

    public function constructProductOption()
    {
        return array(
            'id'               => null,
            'code'             => null,
            'option_set'       => '',
            'option_group'     => '',
            'option_mode'      => self::OPTION_BACKEND,
            'option_type'      => '',
            'option_code'      => null,
            'option_name'      => '',
            'option_languages' => array(),
            'required'         => false,
            'values'           => array(),
        );
    }

    public function constructProductOptionLang()
    {
        return array(
            'option_name' => '',
        );
    }

    public function constructProductOptionValue()
    {
        return array(
            'id'                     => null,
            'code'                   => null,
            'option_value_code'      => null,
            'option_value_name'      => '',
            'option_value_languages' => array(),
            'price'                  => '0.0000',
            'price_prefix'           => '+',
        );
    }

    public function constructProductOptionValueLang()
    {
        return array(
            'option_value_name' => '',
        );
    }

    public function constructChildProduct()
    {
        return array(
            'id'                => null,
            'code'              => null,
            'site_id'           => '',
            'language_id'       => '',
            'type'              => '',
            'image'             => array(
                'label' => '',
                'path'  => '',
            ),
            'images'            => array(),
            'name'              => '',
            'sku'               => '',
            'description'       => '',
            'short_description' => '',
            'meta_title'        => '',
            'meta_keyword'      => '',
            'meta_description'  => '',
            'price'             => '',
            'special_price'     => array(
                'price'      => '',
                'start_date' => '',
                'end_date'   => '',
            ),
            'weight'            => '',
            'length'            => '',
            'width'             => '',
            'height'            => '',
            'status'            => false,
            'manage_stock'      => false,
            'qty'               => 0,
            'tax'               => array(
                'id'   => null,
                'code' => null,
            ),
            'manufacturer'      => array(
                'id'   => null,
                'code' => null
            ),
            'created_at'        => null,
            'updated_at'        => null,
            'categories'        => array(),
            'languages'         => array(),
            'attributes'        => array(),
        );
    }

    public function constructChildProductLang()
    {
        return array(
            'name'              => '',
            'description'       => '',
            'short_description' => '',
            'meta_title'        => '',
            'meta_keyword'      => '',
            'meta_description'  => '',
        );
    }

    public function constructChildProductAttribute()
    {
        return array(
            'option_id'              => null,
            'option_code_save'       => null,
            'option_set'             => '',
            'option_group'           => '',
            'option_mode'            => '',
            'option_type'            => '',
            'option_code'            => null,
            'option_name'            => '',
            'option_languages'       => array(),
            'option_value_id'        => null,
            'option_value_code_save' => null,
            'option_value_code'      => null,
            'option_value_name'      => '',
            'option_value_languages' => array(),
            'price'                  => '0.0000',
            'price_prefix'           => '+',
        );
    }

    public function constructProductGroupProduct()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'type'        => '',
            'name'        => '',
            'sku'         => '',
            'price'       => '',
            'qty'         => '',
            'sort_order'  => '',
        );
    }

    public function constructCustomer()
    {
        return array(
            'id'            => null,
            'code'          => null,
            'site_id'       => '',
            'language_id'   => '',
            'username'      => '',
            'email'         => '',
            'password'      => '',
            'first_name'    => '',
            'middle_name'   => '',
            'last_name'     => '',
            'gender'        => '',
            'dob'           => '',
            'is_subscribed' => false,
            'active'        => true,
            'capabilities'  => array(),
            'created_at'    => null,
            'updated_at'    => null,
            'address'       => array(),
            'groups'        => array(),
        );
    }

    public function constructCustomerAddress()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'first_name'  => '',
            'middle_name' => '',
            'last_name'   => '',
            'gender'      => '',
            'address_1'   => '',
            'address_2'   => '',
            'city'        => '',
            'country'     => array(
                'id'           => null,
                'code'         => null,
                'country_code' => '',
                'name'         => '',
            ),
            'state'       => array(
                'id'         => null,
                'code'       => null,
                'state_code' => '',
                'name'       => '',
            ),
            'postcode'    => '',
            'telephone'   => '',
            'company'     => '',
            'fax'         => '',
            'default'     => array(
                'billing'  => false,
                'shipping' => false,
            ),
            'billing'     => false,
            'shipping'    => false,
            'created_at'  => null,
            'updated_at'  => null,
        );
    }

    public function constructCustomerGroup()
    {
        return array(
            'id'   => null,
            'code' => null,
        );
    }

    public function constructOrder()
    {
        return array(
            'id'               => null,
            'code'             => null,
            'site_id'          => '',
            'language_id'      => '',
            'status'           => '',
            'tax'              => array(
                'title'   => '',
                'amount'  => '',
                'percent' => '',
            ),
            'discount'         => array(
                'code'    => '',
                'title'   => '',
                'amount'  => '',
                'percent' => '',
            ),
            'shipping'         => array(
                'title'   => '',
                'amount'  => '',
                'percent' => '',
            ),
            'subtotal'         => array(
                'title'  => '',
                'amount' => '',
            ),
            'total'            => array(
                'title'  => '',
                'amount' => '',
            ),
            'currency'         => '',
            'created_at'       => null,
            'updated_at'       => null,
            'customer'         => array(),
            'customer_address' => array(),
            'billing_address'  => array(),
            'shipping_address' => array(),
            'payment'          => array(),
            'items'            => array(),
            'histories'        => array(),
        );
    }

    public function constructOrderCustomer()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'username'    => '',
            'email'       => '',
            'first_name'  => '',
            'middle_name' => '',
            'last_name'   => '',
        );
    }

    public function constructInvoiceItem()
    {
        return array(
            'parent_id'                             => null,
            'base_price'                            => null,
            'tax_amount'                            => null,
            'base_row_total'                        => null,
            'discount_amount'                       => null,
            'row_total'                             => null,
            'base_discount_amount'                  => null,
            'price_incl_tax'                        => null,
            'base_tax_amount'                       => null,
            'base_price_incl_tax'                   => null,
            'qty'                                   => null,
            'base_cost'                             => null,
            'price'                                 => null,
            'base_row_total_incl_tax'               => null,
            'row_total_incl_tax'                    => null,
            'product_id'                            => null,
            'order_item_id'                         => null,
            'additional_data'                       => null,
            'description'                           => null,
            'sku'                                   => null,
            'name'                                  => null,
            'discount_tax_compensation_amount'      => null,
            'base_discount_tax_compensation_amount' => null,
            'tax_ratio'                             => null,
            'weee_tax_applied'                      => null,
            'weee_tax_applied_amount'               => null,
            'weee_tax_applied_row_amount'           => null,
            'weee_tax_disposition'                  => null,
            'weee_tax_row_disposition'              => null,
            'base_weee_tax_applied_amount'          => null,
            'base_weee_tax_applied_row_amnt'        => null,
            'base_weee_tax_disposition'             => null,
            'base_weee_tax_row_disposition'         => null,
        );
    }

    public function constructInvoiceGrid()
    {
        return array(
            'entity_id'             => null,
            'increment_id'          => null,
            'state'                 => null,
            'store_id'              => null,
            'store_name'            => null,
            'order_id'              => null,
            'order_increment_id'    => null,
            'order_created_at'      => null,
            'customer_name'         => null,
            'customer_email'        => null,
            'customer_group_id'     => null,
            'payment_method'        => null,
            'store_currency_code'   => null,
            'order_currency_code'   => null,
            'base_currency_code'    => null,
            'global_currency_code'  => null,
            'billing_name'          => null,
            'billing_address'       => null,
            'shipping_address'      => null,
            'shipping_information'  => null,
            'subtotal'              => null,
            'shipping_and_handling' => null,
            'grand_total'           => null,
            'base_grand_total'      => null,
            'created_at'            => null,
            'updated_at'            => null,
        );
    }

    public function constructOrderInvoice()
    {
        return array(
            'store_id'                                     => 1,
            'base_grand_total'                             => null,
            'shipping_tax_amount'                          => null,
            'tax_amount'                                   => null,
            'base_tax_amount'                              => null,
            'store_to_order_rate'                          => null,
            'base_shipping_tax_amount'                     => null,
            'base_discount_amount'                         => null,
            'base_to_order_rate'                           => null,
            'grand_total'                                  => null,
            'shipping_amount'                              => null,
            'subtotal_incl_tax'                            => null,
            'base_subtotal_incl_tax'                       => null,
            'store_to_base_rate'                           => null,
            'base_shipping_amount'                         => null,
            'total_qty'                                    => null,
            'base_to_global_rate'                          => null,
            'subtotal'                                     => null,
            'base_subtotal'                                => null,
            'discount_amount'                              => null,
            'billing_address_id'                           => null,
            'is_used_for_refund'                           => null,
            'order_id'                                     => null,
            'email_sent'                                   => null,
            'send_email'                                   => null,
            'can_void_flag'                                => null,
            'state'                                        => null,
            'shipping_address_id'                          => null,
            'store_currency_code'                          => null,
            'transaction_id'                               => null,
            'order_currency_code'                          => null,
            'base_currency_code'                           => null,
            'global_currency_code'                         => null,
            'increment_id'                                 => null,
            'created_at'                                   => null,
            'updated_at'                                   => null,
            'discount_tax_compensation_amount'             => null,
            'base_discount_tax_compensation_amount'        => null,
            'shipping_discount_tax_compensation_amount'    => null,
            'base_shipping_discount_tax_compensation_amnt' => null,
            'shipping_incl_tax'                            => null,
            'base_shipping_incl_tax'                       => null,
            'base_total_refunded'                          => null,
            'discount_description'                         => null,
            'customer_note'                                => null,
            'customer_note_notify'                         => null,
        );
    }

    public function constructOrderAddress()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'first_name'  => '',
            'middle_name' => '',
            'last_name'   => '',
            'address_1'   => '',
            'address_2'   => '',
            'city'        => '',
            'country'     => array(
                'id'           => null,
                'code'         => null,
                'country_code' => '',
                'name'         => '',
            ),
            'state'       => array(
                'id'         => null,
                'code'       => null,
                'state_code' => '',
                'name'       => '',
            ),
            'postcode'    => '',
            'telephone'   => '',
            'company'     => '',
            'fax'         => '',
        );
    }

    public function constructOrderPayment()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'method'      => '',
            'title'       => '',
        );
    }

    public function constructOrderItem()
    {
        return array(
            'id'                     => null,
            'code'                   => null,
            'site_id'                => '',
            'language_id'            => '',
            'product'                => array(
                'id'   => null,
                'code' => null,
                'name' => '',
                'sku'  => '',
            ),
            'qty'                    => 0,
            'price'                  => '',
            'original_price'         => '',
            'tax_amount'             => '',
            'tax_percent'            => '',
            'discount_amount'        => '',
            'discount_percent'       => '',
            'subtotal'               => '',
            'total'                  => '',
            'options'                => array(),
            'created_at'             => null,
            'updated_at'             => null,
            /**
             * Start Namlv
             */
            'weight'                 => '0.0000',
            'quote_item_id'          => '0.0000',
            'parent_item_id'         => '0.0000',
            'qty_canceled'           => '0.0000',
            'qty_invoiced'           => '0.0000',
            'qty_refunded'           => '0.0000',
            'qty_shipped'            => '0.0000',
            'base_discount_refunded' => null,
            /**
             * End Namlv
             */
        );
    }

    public function constructOrderItemOption()
    {
        return array(
            'option_id'              => '',
            'option_code_save'       => '',
            'option_set'             => '',
            'option_group'           => '',
            'option_type'            => '',
            'option_code'            => '',
            'option_name'            => '',
            'option_value_id'        => '',
            'option_value_code_save' => '',
            'option_value_code'      => '',
            'option_value_name'      => '',
            'price'                  => '0.0000',
            'price_prefix'           => '+',
        );
    }

    public function constructOrderHistory()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'status'      => '',
            'comment'     => '',
            'notified'    => false,
            'created_at'  => null,
            'updated_at'  => null,
        );
    }

    public function constructReview()
    {
        return array(
            'id'          => null,
            'code'        => null,
            'site_id'     => '',
            'language_id' => '',
            'product'     => array(
                'id'   => null,
                'code' => null,
                'name' => '',
            ),
            'customer'    => array(
                'id'   => null,
                'code' => null,
                'name' => '',
            ),
            'title'       => '',
            'content'     => '',
            'status'      => '',
            'created_at'  => null,
            'updated_at'  => null,
            'rating'      => array(),
        );
    }

    public function constructReviewRating()
    {
        return array(
            'id'        => null,
            'code'      => null,
            'rate_code' => '',
            'rate'      => '',
        );
    }

    public function getCountryNameByCode($iso_code)
    {
        $countries = json_decode(file_get_contents("http://country.io/names.json"), true);
        if (isset($countries[$iso_code])) {
            return $countries[$iso_code];
        }

        return null;
    }

    /**
     * TODO: CURL
     */

    public function curlPost($url, $data = null, $headers = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_POST, true);
        if (is_array($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
        }
        curl_close($ch);

        return $response;
    }

    public function curlGet($url, $data = null, $headers = null)
    {
        if ($data) {
            if (is_array($data)) {
                $url .= '?' . http_build_query($data);
            } else {
                $url .= '?' . $data;
            }
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            Bootstrap::log(curl_error($ch), 'curl');
        }
        curl_close($ch);

        return $response;
    }

    public function curlPut($url, $data = null, $headers = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        if ($data) {
            if (is_array($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            Bootstrap::log(curl_error($ch), 'curl');
        }
        curl_close($ch);

        return $response;
    }

    public function curlDelete($url, $data = null, $headers = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        if ($data) {
            if (is_array($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            Bootstrap::log(curl_error($ch), 'curl');
        }
        curl_close($ch);

        return $response;
    }

    /**
     * TODO: IMAGE
     */

    public function processImageBeforeImport($url, $path = null)
    {
        $file = new LECM_File();
        if (!$path) {
            $full_url = $url;
            $path     = $file->stripDomainFromUrl($url);
        } else {
            $full_url = $file->joinUrlPath($url, $path);
        }
        if (!$file->isUrlEncode($path)) {
            $full_url = $file->getRawUrl($full_url);
        }
        if ($file->isVirtualUrl($full_url)) {
            $path = $file->getFileNameFromVirtualUrl($full_url, $path);
        }
        $path = $file->changeSpecialCharInPath($path);

        return array(
            'url'  => $full_url,
            'path' => $path,
        );
    }

    public function changeImgSrcInText($html, $img_des, $prefix = '')
    {
        if (!$img_des) {
            return $html;
        }
        $links = array();
        preg_match_all('/<img[^>]+>/i', $html, $img_tags);
        foreach ($img_tags[0] as $img) {
            preg_match('/(src=["\'](.*?)["\'])/', $img, $src);
            if (!isset($src[0])) {
                continue;
            }
            $split   = preg_split('/["\']/', $src[0]);
            $links[] = $split[1];
        }
        $links = $this->filterArrayValueDuplicate($links);
        if ($links) {
            $image_data = $image_save = array();
            foreach ($links as $key => $link) {
                $image_key              = 'i' . $key;
                $image                  = $this->processImageBeforeImport($link);
                $image_save[$image_key] = $link;
                $image_data[$image_key] = array(
                    'type'   => 'download',
                    'path'   => $this->addPrefixPath($image['path'], $prefix),
                    'params' => array(
                        'url'    => $image['url'],
                        'rename' => true,
                    ),
                );
            }
            if ($image_data) {
                $image_url    = $this->getConnectorUrl('image');
                $image_import = $this->getConnectorData($image_url, array(
                    'images' => serialize($image_data)
                ));
                if ($image_import && $image_import['result'] == 'success') {
                    foreach ($image_save as $image_key => $link) {
                        $image_import_path = isset($image_import['data'][$image_key]) ? $image_import['data'][$image_key] : false;
                        if ($image_import_path) {
                            $image_import_url = $this->getUrlSuffix($image_import_path);
                            $html             = str_replace($link, $image_import_url, $html);
                        }
                    }
                }
            }
        }

        return $html;
    }

    /**
     * TODO: EXTEND
     */

    public function combinationFromMultiArray($arrays = array())
    {
        $result = array();
        $arrays = array_values($arrays);
        $sizeIn = sizeof($arrays);
        $size   = $sizeIn > 0 ? 1 : 0;
        foreach ($arrays as $array)
            $size = $size * sizeof($array);
        for ($i = 0; $i < $size; $i++) {
            $result[$i] = array();
            for ($j = 0; $j < $sizeIn; $j++)
                array_push($result[$i], current($arrays[$j]));
            for ($j = ($sizeIn - 1); $j >= 0; $j--) {
                if (next($arrays[$j]))
                    break;
                elseif (isset ($arrays[$j]))
                    reset($arrays[$j]);
            }
        }

        return $result;
    }

    /**
     * Get list array from list by list field value
     */
    public function getListFromListByListField($list, $field, $values)
    {
        if (!$list) {
            return array();
        }
        if (!is_array($values)) {
            $values = array($values);
        }
        $result = array();
        foreach ($list as $row) {
            if (in_array($row[$field], $values)) {
                $result[] = $row;
            }
        }

        return $result;
    }

    /**
     * Get list array from list by field  value
     */
    public function getListFromListByField($list, $field, $value)
    {
        if (!$list) {
            return array();
        }
        $result = array();
        foreach ($list as $row) {
            // if(isset($row[$field])){
            if (is_array($value)) {
                foreach ($value as $temp) {
                    if ($row[$field] == $temp) {
                        $result[] = $row;
                    }
                }
            } else {

                if ($row[$field] == $value) {
                    $result[] = $row;
                }
            }
            // }else{
            //     // var_dump($field);
            //     // var_dump($list);
            //     // var_dump($value);
            //     // exit;
            // }
        }

        return $result;
    }

    public function filterArrayValueFalse($array)
    {
        if (!$array) {
            return $array;
        }
        foreach ($array as $key => $value) {
            if (!$value) {
                unset($array[$key]);
            }
        }

        return $array;
    }

    /**
     * Get one array from list array by field value
     */
    public function getRowFromListByField($list, $field, $value)
    {
        if (!$list) {
            return false;
        }
        $result = false;
        foreach ($list as $row) {
            if (isset($row[$field]) && $row[$field] == $value) {
                $result = $row;
                break;
            }
        }

        return $result;
    }

    /**
     * Get array value from list array by field value and key of field need
     */
    public function getRowValueFromListByField($list, $field, $value, $need)
    {
        if (!$list) {
            return false;
        }
        $row = $this->getRowFromListByField($list, $field, $value);
        if (!$row) {
            return false;
        }

        return $row[$need];
    }

    /**
     * Get and unique array value by key
     */
    public function duplicateFieldValueFromList($list, $field)
    {
        $result = array();
        if (!$list) {
            return $result;
        }
        foreach ((array)$list as $item) {
            if (isset($item[$field])) {
                $result[] = $item[$field];
            }
        }
        $result = array_unique($result);

        return $result;
    }

    /**
     * Filter value of array 3D
     */
    public function filterArrayValueDuplicate($array)
    {
        $result = array();
        if ($array && !empty($array)) {
            $array_values = array_values($array);
            foreach ($array_values as $key => $value) {
                foreach ($array_values as $key_filter => $value_filter) {
                    if ($key_filter < $key) {
                        if ($value == $value_filter) {
                            unset($array_values[$key]);
                        }
                    }
                }
            }
            $result = array_values($array_values);
        }

        return $result;
    }

    /**
     * Unset list key from array
     */
    public function unsetListArray($need, $haystack)
    {
        if (!$need || !is_array($need) || !is_array($haystack)) {
            return $haystack;
        }
        foreach ($need as $key) {
            if (isset($haystack[$key])) {
                unset($haystack[$key]);
            }
        }

        return $haystack;
    }

    public function setListArray($need, $haystack)
    {
        if (!$need || !is_array($need) || !is_array($haystack)) {
            return $haystack;
        }
        $data = array();
        foreach ($need as $key) {
            $data[$key] = isset($haystack[$key]) ? $haystack[$key] : null;
        }

        return $data;
    }

    public function getArrayValueByValueArray($value, $need = array(), $haystack = array())
    {
        $result = false;
        if (!is_array($need) || !is_array($haystack)) {
            return $result;
        }
        $key = array_search($value, $need);
        if ($key === false) {
            return $result;
        }
        $result = isset($haystack[$key]) ? $haystack[$key] : false;

        return $result;
    }

    /**
     * Convert result of query get count to count
     */
    public function arrayToCount($array, $name = false)
    {
        if (empty($array)) {
            return 0;
        }
        $count = 0;
        if ($name) {
            $count = isset($array[0][$name]) ? $array[0][$name] : 0;
        } else {
            $count = isset($array[0][0]) ? $array[0][0] : 0;
        }

        return $count;
    }

    /**
     * Add class success to text for show in console
     */
    public function consoleSuccess($msg)
    {
        $result = '<p class="success"> - ' . $msg . '</p>';

        return $result;
    }

    /**
     * Add class warning to text for show in console
     */
    public function consoleWarning($msg)
    {
        $result = '<p class="warning"> - ' . $msg . '</p>';

        return $result;
    }

    /**
     * Add class error to text for show in console
     */
    public function consoleError($msg)
    {
        $result = '<p class="error"> - ' . $msg . '</p>';

        return $result;
    }

    /**
     * Message if not save info to magento database
     */
    public function errorDatabase($console = false)
    {
        $msg = "Database isn't working.";
        if ($console) {
            $msg = $this->consoleError($msg);
        }

        return array(
            'result' => 'error',
            'msg'    => $msg
        );
    }

    public function warningImportEntity($type, $id = null, $code = null, $error_code = '')
    {
        $msg = ucfirst($type) . ' ';
        if ($code) {
            $msg .= 'code: ' . $code;
        } else {
            if ($id) {
                $msg .= 'id: ' . $id;
            }
        }
        $msg .= ' import failed.';
        if ($error_code) {
            $msg .= 'Error: ' . $error_code;
        }

        return $this->consoleWarning($msg);
    }

    /**
     * Convert time to string show in console
     */
    public function createTimeToShow($time)
    {
        $hour   = gmdate('H', $time);
        $minute = gmdate('i', $time);
        $second = gmdate('s', $time);
        $result = '';
        if ($hour && $hour > 0) $result .= $hour . ' hours ';
        if ($minute && $minute > 0) $result .= $minute . ' minutes ';
        if ($second && $second > 0) $result .= $second . ' seconds ';

        return $result;
    }

    /**
     * Create key by string
     */
    public function joinTextToKey($text, $length = false, $char = '-', $lower = true)
    {
        $text .= " ";
        if ($length) {
            $length = (int)$length;
            $text   = substr($text, 0, $length);
            if ($end = strrpos($text, ' ')) {
                $text = substr($text, 0, strrpos($text, ' '));
            }
        }
        $text = preg_replace('/[^A-Za-z0-9 ]/', '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = str_replace(' ', $char, $text);
        $text = trim($text, $char);
        if ($lower) $text = strtolower($text);

        return $text;
    }

    /**
     * Check sync cart type select and cart type detect
     */
    public function checkCartSync($cms, $select)
    {
        $pos = strpos($select, $cms);
        if ($pos === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get percent by total and import
     */
    public function getPoint($total, $import, $finish = false)
    {
        if (!$finish && $total == 0) {
            return 0;
        }
        if ($finish) {
            return 100;
        }
        if ($total < $import) {
            $point = 100;
        } else {
            $percent = $import / $total;
            $point   = number_format($percent, 2) * 100;
        }

        return $point;
    }

    /**
     * Get message for next entity import
     */
    public function getMsgStartImport($type)
    {
        $result = '';
        if (!$type) {
            $result .= $this->consoleSuccess("Finished migration!");

            return $result;
        }
        $types    = array('taxes', 'manufacturers', 'categories', 'products', 'customers', 'orders', 'reviews', 'pages', 'blocks', 'transactions', 'rules', 'cartrules');
        $type_key = array_search($type, $types);
        foreach ($types as $key => $value) {
            if ($type_key <= $key && $this->_notice['config'][$value]) {
                $result .= $this->consoleSuccess('Importing ' . $value . ' ... ');
                break;
            }
        }

        return $result;
    }

    /**
     * Increment order price pass through magento order grand total not equal 0
     */
    public function incrementPriceToImport($price)
    {
        if ($price == 0) {
            $price = 0.001;
        }

        return $price;
    }

    public function convertFloatToPercent($percent, $decimals = 2)
    {
        $point  = number_format($percent, $decimals, '.', '');
        $result = $point * 100;

        return $result;
    }

    /**
     * Convert string of full name to first name and last name
     */
    public function getNameFromString($name)
    {
        $result              = array();
        $parts               = explode(' ', $name);
        $result['lastname']  = array_pop($parts);
        $result['firstname'] = implode(" ", $parts);

        return $result;
    }

    /**
     * Delete folder and content of folder
     */
    public function deleteDir($path)
    {
        if (!is_dir($path)) {
            return array(
                'result' => 'error',
                'msg'    => 'Path is not directory.'
            );
        }
        try {
            $path  = rtrim($path, '/\\');
            $items = glob($path . '/*', GLOB_MARK);
            foreach ($items as $item) {
                if (is_dir($item)) {
                    $this->deleteDir($item);
                } else {
                    unlink($item);
                }
            }
            rmdir($path);

            return array(
                'result' => 'success'
            );
        } catch (Exception $e) {
            return array(
                'result' => 'error',
                'msg'    => $e->getMessage()
            );
        }
    }

    /**
     * Convert version from string to int
     *
     * @param string $v : String of version split by dot
     * @param int $num : number of result return
     * @return int
     */
    public function convertVersion($v, $num)
    {
        $digits  = @explode(".", $v);
        $version = 0;
        if (is_array($digits)) {
            foreach ($digits as $k => $value) {
                if ($k <= $num) {
                    $version += ((int)substr($value, 0, 1) * pow(10, max(0, ($num - $k))));
                }
            }
        }

        return $version;
    }

    public function createFolderUpload($url)
    {
        $code = $url . time();

        return md5($code);
    }

    protected function _checkCartTypeSync($type_src, $type_select)
    {
        $pos = strpos($type_select, $type_src);
        if ($pos === false) {
            return false;
        } else {
            return true;
        }
    }

    protected function _defaultResponse()
    {
        return array(
            'result' => '',
            'msg'    => '',
            'elm'    => '',
            'data'   => array()
        );
    }

    public function getUrlSuffix($suffix)
    {
        $url = rtrim($this->_cart_url, '/') . '/' . ltrim($suffix, '/');

        return $url;
    }

    public function datetimeNow($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    public function addPrefixPath($path, $prefix = '')
    {
        $join_path = '';
        if ($prefix) {
            $join_path .= rtrim($prefix, '\\/') . '/';
        }
        $join_path .= ltrim($path, '\\/');

        return $join_path;
    }

    public function removePrefixPath($path, $prefix = '')
    {
        if ($prefix) {
            $prefix_length = strlen($prefix);
            $path          = substr($path, $prefix_length);
        }

        return $path;
    }

    public function checkUrlSame($domain, $url)
    {
        $domain_none_http = $this->removeHttp($domain);
        $url_none_http    = $this->removeHttp($url);

        return (strpos($url_none_http, $domain_none_http) === false) ? false : true;
    }

    public function removeHttp($url)
    {
        $disallowed = array('http://', 'https://');
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }

        return $url;
    }

    public function convertUrlToDownload($url, $domain)
    {
        if (!$this->checkUrlSame($domain, $url)) {
            return null;
        }
        $domain_none_http = $this->removeHttp($domain);
        $url_none_http    = $this->removeHttp($url);
        $url_path         = str_replace($domain_none_http, '', $url_none_http);
        $url_host         = str_replace($url_path, '', $url);

        return array(
            'domain' => rtrim($url_host, '/'),
            'path'   => ltrim($url_path, '/'),
        );
    }

    /**
     * TODO: EXTEND CONNECTOR
     */

    public function getConnectorUrl($action, $token = null, $type = null)
    {
        if (!$type) {
            $type = $this->getType();
        }
        if (!$token) {
            $token = $this->_notice[$type]['config']['token'];
        }
        $url = $this->getUrlSuffix(self::CONNECTOR_SUFFIX);
        $url .= '?action=' . $action . '&token=' . $token;

        return $url;
    }

    public function getConnectorData($url, $data = null)
    {
        if ($data) {
            $data = $this->_insertParamCharSet($data);
            $data = $this->_addTablePrefix($data);
            $data = $this->_encodeConnectorData($data);
        }
        $response = $this->curlPost($url, $data);
        if (!$response) {
            return false;
        }
        if ($this->_notice['setting']['delay']) {
            @sleep($this->_notice['setting']['delay']);
        }
        $response = @unserialize(base64_decode($response));
        if (isset($response['object'])) {
            $response['data'] = $response['object'];
            unset($response['object']);
        }

        return $response;
    }

    public function syncConnectorObject($data, $extra)
    {
        if ($data['data'] && $extra['data']) {
            foreach ($extra['data'] as $key => $rows) {
                if (!isset($data['data'][$key])) {
                    $data['data'][$key] = $rows;
                }
            }
        }

        return $data;
    }

    protected function _insertParamCharSet($data)
    {
        $type = $this->getType();
        if ($this->_notice[$type]['config']['charset'] == 'utf8') {
            $data['charset'] = 'utf8';
        }

        return $data;
    }

    protected function _addTablePrefix($data)
    {
        if (isset($data['query'])) {
            $type           = $this->getType();
            $setting_prefix = ($type == 'src') ? $this->_notice['setting']['src_prefix'] : $this->_notice['setting']['target_prefix'];
            if ($setting_prefix) {
                $prefix = $setting_prefix;
            } else {
                $prefix = $this->_notice[$type]['config']['table_prefix'];
            }
            $queries = unserialize($data['query']);
            if (isset($data['serialize'])) {
                $add = array();
                foreach ($queries as $table => $query) {
                    $query['query'] = str_replace('_DBPRF_', $prefix, $query['query']);
                    $add[$table]    = $query;
                }
                $data['query'] = serialize($add);
            } else {
                $query          = $queries;
                $query['query'] = str_replace('_DBPRF_', $prefix, $query['query']);
                $data['query']  = serialize($query);
            }
        }

        return $data;
    }

    protected function _encodeConnectorData($data)
    {
        $encodeData = array();
        foreach ($data as $key => $value) {
            $encodeData[$key] = base64_encode($value);
        }

        return $encodeData;
    }

    /**
     * Create combinations from multi array
     */
    protected function _combinationFromMultiArray($arrays = array())
    {
        $result = array();
        $arrays = array_values($arrays);
        $sizeIn = sizeof($arrays);
        $size   = $sizeIn > 0 ? 1 : 0;
        foreach ($arrays as $array)
            $size = $size * sizeof($array);
        for ($i = 0; $i < $size; $i++) {
            $result[$i] = array();
            for ($j = 0; $j < $sizeIn; $j++)
                array_push($result[$i], current($arrays[$j]));
            for ($j = ($sizeIn - 1); $j >= 0; $j--) {
                if (next($arrays[$j]))
                    break;
                elseif (isset ($arrays[$j]))
                    reset($arrays[$j]);
            }
        }

        return $result;
    }

    public function errorConnector($console = true)
    {
        $msg = "Could not connect to Connector!";
        if ($console) {
            $msg = $this->consoleError($msg);
        }

        return array(
            'result' => 'error',
            'msg'    => $msg,
        );
    }
//    public function errorConnector($console = true,$line='')
//    {
//        $msg = "Could not connect to Connector!";
//        if ($console) {
//            $msg = $this->consoleError($msg);
//        }
//        return array(
//            'result' => 'error',
//            'msg' => $msg.": ".$line,
//        );
//    }

    /**
     * TODO: EXTENDS FILE
     */

    public function syncTitleRow($title, $row)
    {
        if (!$row) {
            return array();
        }
        $row_value = array_filter($row);
        if (!$row_value || empty($row_value)) {
            return array();
        }
        $data = array();
        foreach ($title as $key => $title_name) {
            $data[$title_name] = (isset($row[$key])) ? $row[$key] : null;
        }

        return $data;
    }

    public function getNextFileType($type)
    {
        $file_info = $this->getFileInfo();
        if (!$file_info) {
            return false;
        }
        $keys         = array_keys($file_info);
        $search_index = array_search($type, $keys);
        if (!$search_index) {
            return false;
        }
        $next_index = $search_index + 1;
        $next_type  = isset($keys[$next_index]) ? $keys[$next_index] : false;

        return $next_type;
    }

    public function noStorageData()
    {
        return array(
            'result' => 'success',
            'msg'    => '',
        );
    }

    public function getValue($src, $key, $default = null)
    {
//        $result = $default;
        if (!isset($src[$key])) {
            return $default;
        }
        switch (gettype($src[$key])) {
            case 'NULL':
                return $default;
            case 'boolean':
                return $default;
            case 'string':
                if ($src[$key] == '') {
                    return $default;
                } else
                    return $src[$key];
            default:
                return $src[$key];

        }
    }
    public function createInsertQuery($table,$data,$prefix = true){
        $table = $prefix?'_DBPRF_'.$table:$table;
        $query = "INSERT INTO `".$table."` ".$this->arrayToInsertCondition($data);
        return array(
            'type' => 'insert',
            'query' => $query,
        );
    }

    public function createUpdateQuery($table,$set,$where,$prefix = true){
        $table = $prefix?'_DBPRF_'.$table:$table;
        $query = "UPDATE `".$table."` SET ".$this->arrayToSetCondition($set)." WHERE ".$this->arrayToWhereCondition($where);
        return array(
            'type' => 'update',
            'query' => $query,
        );
    }

    public function importData($query,$type = 'query',$params = true){
        if($query){
            $query['params'] = array(
                'insert_id' => true,
            );
        }
        $result = $this->getConnectorData($this->getConnectorUrl('query'),array(
            'query' => serialize($query),
        ));
        if(!$result || $result['result'] != 'success' || !$result['data']){
            Bootstrap::logError($query['query'],$type);
            return false;
        }
        if(!$params){
            return true;
        }
        return $result['data'];

    }
    public function importMultipleData($queries,$type){
        $result = true;
        $all_import_data = array();
        foreach ($queries as $key=> $query){
            $all_import_data[$key] = $query;
        }
        $all_import = $this->getConnectorData($this->getConnectorUrl('query'),array(
            'serialize' => true,
            'query' => serialize($all_import_data),
        ));
//        var_dump($all_import);exit;
        if(!$all_import){
            $result= false;
        }
        if(!$all_import['data']){
            Bootstrap::logError($queries,$type);
            $result = false;
        }
        foreach ($all_import['data'] as $key=>$import){
            if(!$import){
                Bootstrap::logError($queries[$key]['query'],$type);
                $result = false;
            }
        }
        return $result;
    }
}