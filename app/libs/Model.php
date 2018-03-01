<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 09/02/2018
 * Time: 16:31
 */
class Model {
    protected $_db;

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

    public function insertTable($table, $data, $insert_id = true)
    {
        return $this->getDb()->insertObj($table, $data, $insert_id);

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
        return  $this->getDb()->updateObj($table, $data . $where);
    }

    public function deleteTable($table, $where = null)
    {
        return $this->getDb()->deleteObj($table, $where);
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
    public function queryRaw($query){
        return $this->getDb()->queryRaw($query);
    }

    public function truncateTable($query){
        return $this->getDb()->truncateTable($query);

    }

    public function getVersionInstall($type){

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

    function createTableQuery($construct,$next_function,$finish = false){
        $table_construct = $this->$construct();
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
        return $this->errorConnectDatabase();
    }
}