<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/02/2018
 * Time: 14:46
 */

class Setup_Install_Category extends Model
{
    const TABLE_CATEGORY = 'category';
    public function install($function)
    {
        if(method_exists($this,$function)){
            return $this->$function();
        }else{
            return array(
                'result' => 'success',
            );
        }
    }


    public function cate(){
        return array(
            'table' => 'cate',
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'cate_id' => 'BIGINT NOT NULL',
            ),
            'references' => array(
                'cate_id' => array(
                    'table' =>self::TABLE_CATEGORY,
                    'row' => 'id',
                ),
            ),
        );
    }

    public function createCateTable(){
        $query = $this->arrayToCreateTableSql($this->cate());
        if($query['result'] != 'success' || !isset($query['query'])){
            return $this->errorConnectDatabase();
        }
        $create = $this->queryRaw($query['query']);
        if($create['result'] == 'success'){
            return array(
                'result' => 'success',
                'msg' => $this->consoleSuccess('create table '.$this->getTableName('cate').' success'),

                'data' => array(
                    'status' => 'success',
                    'function' => '',
                ),
            );
        }
        return $this->errorConnectDatabase();
    }

    public function createCategoryTable(){
        $table_construct = array(
            'table' => self::TABLE_CATEGORY,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'name' => 'VARCHAR(255) NOT NULL',
                'status' => 'TINYINT(2)',
                'parent_id' => 'BIGINT NOT NULL',
                'level' => 'INT(11) NOT NULL',
                'update_at' => 'DATETIME',
                'create_at' => 'DATETIME',
                'description' => 'TEXT',
                'url_key' => 'VARCHAR(255) NOT NULL',
                'position' => 'INT(11)',
                'path' => 'VARCHAR(255)',
                'product_count' => 'INT(11)'
            ),
        );
        return $this->createTableQuery($table_construct,'createCategoryTable',true);
    }
}