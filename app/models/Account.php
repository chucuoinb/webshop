<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/03/2018
 * Time: 17:35
 */
class Model_Account extends Model
{
    const MAIN_TABLE = 'admin_account';
    protected $_data;
    protected $_data_filter = array();
    protected $table_construct = array(
        'id' => 'id',
        'username' => 'username',
        'password' => 'password',
        'first_name' => 'first_name',
        'last_name' => 'last_name',
        'create_at' => 'create_at',
        'update_at' => 'update_at',
        'is_active' => 'is_active',
        'log_date' => 'log_date',
        'token' => 'token',
        'role_id' => 'role_id',
        'last_login' => 'last_login',
    );
    public function __construct()
    {
        parent::__construct();
        $this->_main_table = self::MAIN_TABLE;
    }
    public function save(){
        if($this->checkAccountExist($this->_data[$this->table_construct['username']])){
            throw new Exception("Account đã tồn tại");
        }
        $this->_data = $this->syncDataConstruct();
        $insert = $this->insertTable($this->_main_table,$this->_data);
        if($insert['result'] != 'success'){
            $this->throwException($insert['msg']);
        }
        $id = $insert['data'];
        $this->addData('id',$id);
        return $id;
    }
    public function syncDataConstruct(){
        $sync_data = array();
        foreach ($this->table_construct as $label=>$value){
            if(isset($this->_data[$value])){
                $sync_data[$value] = $this->_data[$value];
                if($value == $this->table_construct['password']){
                    $sync_data[$value] = $this->passwordHash($this->_data[$value]);
                }
            }
        }

        if(!isset($sync_data['create_at'])){
            $sync_data['create_at'] = $this->getNewDate();
        }
        if(!isset($sync_data['update_at'])){
            $sync_data['update_at'] = $this->getNewDate();
        }
        if(!isset($sync_data['role_id'])){
            $sync_data['role_id'] = 1;
        }
        if(!isset($sync_data['is_active'])){
            $sync_data['is_active'] = 1;
        }
        return $sync_data;
    }
    protected function checkAccountExist($account){
        $account_exist = $this->addFieldToFilter($this->table_construct['username'],$account)->filter();
        return count($account_exist)>0;
    }

    public function getId(){
        return $this->getData('id');
    }
    public function getUsername(){
        return $this->getData('username');
    }
}