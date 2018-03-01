<?php
class Setup_Install_Core extends Model{
    const TABLE_SETUP = 'setup_database';
    const TABLE_ADMIN_ROLE = 'admin_role';
    const TABLE_ADMIN_ACCOUNT = 'admin_account';
    const TABLE_CONFIG_DATA = 'config_data';
    const TABLE_CUSTOMER_GROUP = 'customer_group';
    public function install($function)
    {
        if(method_exists($this,$function)){
//            var_dump($this->$function());exit;
            return $this->$function();
        }else{
            return array(
                'result' => 'success',
            );
        }
    }
    function setupDatabaseTableConstruct(){
        return array(
            'table' => self::TABLE_SETUP,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'name' => 'VARCHAR(255) NOT NULL',
                'version' => 'VARCHAR(255) NOT NULL',
            ),
        );
    }
    function adminRoleTableConstruct(){
        return array(
            'table' => self::TABLE_ADMIN_ROLE,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'name' => 'VARCHAR(255) NOT NULL',
                'role' => 'VARCHAR(255) NOT NULL',
            ),
        );
    }
    function adminAccountTableConstruct(){
        return array(
            'table' => self::TABLE_ADMIN_ACCOUNT,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'username' => 'VARCHAR(255) NOT NULL',
                'password' => 'VARCHAR(255) NOT NULL',
                'first_name' => 'VARCHAR(255) ',
                'last_name' => 'VARCHAR(255) ',
                'create_at' => 'DATETIME',
                'update_at' => 'DATETIME',
                'is_active' => 'DATETIME',
                'log_date' => 'LONGTEXT',
                'token' => 'TEXT',
                'role_id' => 'BIGINT NOT NULL',
                'last_login' => 'DATETIME'
            ),
            'references' => array(
                'role_id' => array(
                    'table' =>self::TABLE_ADMIN_ROLE,
                    'row' => 'id',
                ),
            ),
        );
    }

    function customerGroupTableConstruct(){
        return array(
            'table' => self::TABLE_CUSTOMER_GROUP,
            'rows' => array(
                'id' => 'SMALLINT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'code' => 'VARCHAR(32) NOT NULL',
                'label' => 'VARCHAR(32)'
            ),
        );
    }

    function configDataTableConstruct(){

    }
    function createSetupDatabaseTable(){
        return $this->createTableQuery('setupDatabaseTableConstruct','createAdminRoleTable');
    }

    function createAdminRoleTable(){
        $result = $this->createTableQuery('adminRoleTableConstruct','createAdminAccountTable');
        if($result['result'] == 'success'){
            $add_data = $this->addDataDefaultTableAdminRole();
            if($add_data['result'] != 'success'){
                return $add_data;
            }
        }
        return $result;
    }

    function createAdminAccountTable(){
        return $this->createTableQuery('adminAccountTableConstruct','createCustomerGroupTable');

    }

    function createCustomerGroupTable(){
        $result = $this->createTableQuery('customerGroupTableConstruct','',true);
        if($result['result'] == 'success'){
            $add_data = $this->addDataDefaultCustomerGroup();
            if($add_data['result'] != 'success'){
                return $add_data;
            }
        }
        return $result;
    }
    function addDataDefaultTableAdminRole(){
        $insert_data = array(
            'name' => 'Super Admin',
            'role' => $this->getRoleAdminDefault(),
        );
        $truncate = $this->truncateTable(self::TABLE_ADMIN_ROLE);
        if(!$truncate || $truncate['result'] != 'success'){
            return $this->errorConnectDatabase($truncate['msg']);
        }
        $res = $this->insertTable(self::TABLE_ADMIN_ROLE,$insert_data);
        if(!$res || $res['result'] != 'success'){
            return $this->errorConnectDatabase($res['msg']);
        }
        return array(
            'result' => 'success',
            'msg' => '',
        );
    }

    function addDataDefaultCustomerGroup(){
        $insert_data = array(
            0 => array(
                'code' => 'default',
                'label' => 'Guest',
            ),
            1 => array(
                'code' => 'general',
                'label' => 'General'
            )
        );
        $truncate = $this->truncateTable(self::TABLE_CUSTOMER_GROUP);
        if(!$truncate || $truncate['result'] != 'success'){
            return $this->errorConnectDatabase($truncate['msg']);
        }
        foreach ($insert_data as $key=>$data){
            $res = $this->insertTable(self::TABLE_CUSTOMER_GROUP,$data);
            if(!$res || $res['result'] != 'success'){
                return $this->errorConnectDatabase($res['msg']);
            }
        }
        return array(
            'result' => 'success',
            'msg' => '',
        );
    }

    function getRoleAdminDefault(){
        return json_encode(array(
            'category' => true,
            'product' => true,
            'customer' => true,
            'order' => true,
            'super_admin' => true,
        ));
    }
}