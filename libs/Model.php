<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 09/02/2018
 * Time: 16:31
 */
class Model implements Abstract_Model {
    protected $_db;



    protected $_main_table;
    protected $_data;
    protected $_data_filter = array();
    protected $table_construct = array();
    public function __construct()
    {
        if (!$this->_db) {
            $dbConfig = Bootstrap::getDbConfig();
            $db       = Libs_Db::getInstance($dbConfig);
            if (!$db) {
                return null;
            }
            $connect = $db->getConnect();
            if ($connect) {
                $this->_db = $db;
            }
        }
        $this->_db->queryRaw('SET FOREIGN_KEY_CHECKS=0;');
    }

    public function getDb()
    {
        if (!$this->_db) {
            $dbConfig = Bootstrap::getDbConfig();
            $db       = Libs_Db::getInstance($dbConfig);
            if (!$db) {
                return null;
            }
            $connect = $db->getConnect();
            if ($connect) {
                $this->_db = $db;
            }
        }
        $this->_db->queryRaw('SET FOREIGN_KEY_CHECKS=0;');
        return $this->_db;
    }
    /**
     * TODO: DATABASE
     */

    public function selectTable($table, $where = null)
    {
        $result = array();
        $select = $this->_db->selectObj($table, $where);
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

    public function insertTable($table, $data, $insert_id = true)
    {
        return $this->_db->insertObj($table, $data, $insert_id);

    }

    public function resultConstruct(){
        return array(
            'result' => '',
            'msg' => '',
            'data' => '',
        );
    }

    public function updateTable($table, $data, $where = null)
    {
        return  $this->_db->updateObj($table, $data . $where);
    }

    public function deleteTable($table, $where = null)
    {
        return $this->_db->deleteObj($table, $where);
    }

    public function escape($value)
    {
        return $this->_db->escape($value);
    }

    public function arrayToInCondition($array)
    {
        return $this->_db->arrayToInCondition($array);
    }

    public function arrayToSetCondition($array)
    {
        return $this->_db->arrayToSetCondition($array);
    }

    public function arrayToInsertCondition($array, $allow_keys = null)
    {
        return $this->_db->arrayToInsertCondition($array, $allow_keys);
    }

    public function arrayToWhereCondition($array)
    {
        return $this->_db->arrayToWhereCondition($array);
    }

    public function arrayToCreateTableSql($array)
    {
        return $this->_db->arrayToCreateTableSql($array);
    }
    public function queryRaw($query){
        return $this->_db->queryRaw($query);
    }

    public function truncateTable($query){
        return $this->_db->truncateTable($query);

    }

    public function getVersionInstall($type){

    }

    public function getConfig($key,$default = ''){
        return Bootstrap::getConfig($key,$default);
    }
    public function setConfig($key,$data){
        return Bootstrap::setConfig($key,$data);
    }
    public function unsetConfig($key){
        return Bootstrap::unsetConfig($key);
    }
    public function errorConnectDatabase($msg = null){
        return array(
            'result' => 'error',
            'msg' => $this->consoleError($msg?$msg:'not connect database'),
            'data' => array(),
        );
    }
    public function getTableName($table){
        $prefix = Bootstrap::getConfig('db_prefix','');
        return $prefix.$table;
    }
    /**
     * Add class success to text for show in console
     */
    public function consoleSuccess($msg){
        $result = '<p class="console-success"> - ' . $msg . '</p>';
        return $result;
    }

    /**
     * Add class warning to text for show in console
     */
    public function consoleWarning($msg){
        $result = '<p class="console-warning"> - ' . $msg . '</p>';
        return $result;
    }

    /**
     * Add class error to text for show in console
     */
    public function consoleError($msg){
        $result = '<p class="console-error"> - ' . $msg . '</p>';
        return $result;
    }

    protected function defaultResponse()
    {
        return array(
            'result'    => '',
            'msg'       => '',
            'data'      => '',
        );
    }

    function createTableQuery($table_construct,$next_function,$finish = false){
        $query = $this->arrayToCreateTableSql($table_construct);
        if($query['result'] != 'success' || !isset($query['query'])){
            return $this->errorConnectDatabase();
        }
        $create = $this->queryRaw($query['query']);

        if($create['result'] == 'success'){
            return array(
                'result' => 'success',
                'msg' => $this->consoleSuccess('create table '.$this->getTableName($table_construct['table']).' success'),
                'data' => array(
                    'status' => $finish?'success':'process',
                    'function' => $next_function,
                ),
            );
        }
        return $this->errorConnectDatabase($create['msg']);
    }
    public function getNewDate($time = null){
        if($time){
            return date("Y-m-d H:i:s",$time);
        }
        return date("Y-m-d H:i:s");
    }
    public function passwordHash($password){
        return md5($password);
    }
    public function getData($key = '',$default = ''){
        if(!$key){
            return $this->_data;
        }
        if(isset($this->_data[$key])){
            return $this->_data[$key];
        }
        return $default;
    }
    public function getValue($data, $key, $default = null)
    {
        if (!isset($data[$key])) {
            return $default;
        }
        return $data[$key];
    }
    public function filter()
    {
        // TODO: Implement filter() method.
        $filter = $this->selectTable($this->_main_table,$this->_data_filter);
        return $filter;
    }

    public function addFieldToFilter($key,$value)
    {
        // TODO: Implement addFieldToFilter() method.
        $this->_data_filter[$key] = $value;
        return $this;
    }

    public function addDataFilter($data)
    {
        // TODO: Implement addDataFilter() method.
        $this->_data_filter = $data;
        return $this;
    }

    public function setData($data)
    {
        // TODO: Implement addData() method.
        $this->_data = $data;
    }
    public function save()
    {
        // TODO: Implement save() method.
    }
    public function addData($key, $value)
    {
        // TODO: Implement addData() method.
        $this->_data[$key] = $value;
    }
    public function throwException($message){
        throw new Exception($message);
    }

    public function load($id)
    {
        // TODO: Implement load() method.
        $filter = $this->selectTableRow($this->_main_table,array('id' => $id));
        if($filter){
            $this->setData($filter);
            $this->syncDataConstruct();
            return $this;
        }
        return false;
    }

    public function syncDataConstruct()
    {
        // TODO: Implement syncDataConstruct() method.
    }
}