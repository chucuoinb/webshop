<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/02/2018
 * Time: 14:46
 */

class Setup_Install_Product extends Model
{
    const TABLE_ATTRIBUTE = 'product_attribute';
    const TABLE_ATTRIBUTE_SET = 'attribute_set';
    const TABLE_ATTRIBUTE_GROUP = 'attribute_group';
    const TABLE_ATTRIBUTE_GROUP_VALUE = 'attribute_group_value';
    const TABLE_ATTRIBUTE_OPTION = 'attribute_option';
    const TABLE_PRODUCT = 'product';
    const TABLE_PRODUCT_MEDIA = 'product_media';
    const TABLE_PRODUCT_CAT = 'product_category';
    const TABLE_PRODUCT_OPTION = 'product_option';
    const TABLE_PRODUCT_OPTION_VALUE = 'product_option_value';
    const TABLE_PRODUCT_RELATION = 'product_relation';
    const TABLE_PRODUCT_TEXT = 'product_text';
    const TABLE_PRODUCT_INT = 'product_int';
    const TABLE_PRODUCT_VARCHAR = 'product_varchar';
    const TABLE_PRODUCT_DATETIME = 'product_datetime';
    const TABLE_PRODUCT_DECIMAL = 'product_decimal';
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

    public function createAttributeTable(){
        $table_construct = array(
            'table' => self::TABLE_ATTRIBUTE,
            'rows' => array(
                'id' => 'SMALLINT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'code' => 'VARCHAR(255) NOT NULL',
                'label' => 'VARCHAR(255)',
                'type' => 'VARCHAR(255) NOT NULL',
                'input' => 'VARCHAR(255) NOT NULL',
                'is_core' => 'TINYINT(2)',
                'is_show_grid' => 'TINYINT(2)',
                'is_required' => 'TINYINT(2)',
                'is_unique' => 'TINYINT(2)',
                'default_value' => 'TEXT',
            ),

        );
        return $this->createTableQuery($table_construct,'createAttributeOptionTable',false);
    }
    public function attributeOptionTableConstruct(){
        return array(
            'table' => self::TABLE_ATTRIBUTE_OPTION,
            'rows' => array(
                'id' => 'SMALLINT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'attribute_id' => 'SMALLINT(5) NOT NULL',
                'value' => 'VARCHAR(255)',
            ),
            'references' => array(
                'attribute_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE,
                    'row' => 'id',
                )
            ),

        );
    }
    public function createAttributeOptionTable(){
        $table_construct = array(
            'table' => self::TABLE_ATTRIBUTE_OPTION,
            'rows' => array(
                'id' => 'SMALLINT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'attribute_id' => 'SMALLINT(5) NOT NULL',
                'value' => 'VARCHAR(255)',
            ),
            'references' => array(
                'attribute_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE,
                    'row' => 'id',
                )
            ),

        );
        return $this->createTableQuery($table_construct,'createAttributeSetTable',false);
    }
    public function createAttributeSetTable(){
        $table_construct =array(
            'table' => self::TABLE_ATTRIBUTE_SET,
            'rows' => array(
                'id' => 'SMALLINT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'code' => 'VARCHAR(255) NOT NULL',
                'label' => 'VARCHAR(255)',
            ),

        );
        return $this->createTableQuery($table_construct,'createAttributeGroupTable',false);
    }
    public function createAttributeGroupTable(){
        $table_construct =array(
            'table' => self::TABLE_ATTRIBUTE_GROUP,
            'rows' => array(
                'id' => 'SMALLINT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'code' => 'VARCHAR(255) NOT NULL',
                'label' => 'VARCHAR(255)',
                'attribute_set_id' => 'SMALLINT(5) NOT NULL'
            ),
            'references' => array(
                'attribute_set_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE_SET,
                    'row' => 'id',
                )
            ),
        );
        return $this->createTableQuery($table_construct,'createAttributeGroupValueTable',false);
    }
    public function createAttributeGroupValueTable(){
        $table_construct =array(
            'table' => self::TABLE_ATTRIBUTE_GROUP_VALUE,
            'rows' => array(
                'id' => 'SMALLINT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'attribute_group_id' => 'SMALLINT(5) NOT NULL',
                'attribute_id' => 'SMALLINT(5) NOT NULL',
            ),
            'references' => array(
                'attribute_group_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE_GROUP,
                    'row' => 'id',
                ),
                'attribute_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE,
                    'row' => 'id',
                )
            ),
        );
        return $this->createTableQuery($table_construct,'createProductTable',false);
    }
    public function createProductTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'name' => 'VARCHAR(255) NOT NULL',
                'sku' => 'VARCHAR(255) NOT NULL',
                'status' => 'TINYINT(2)',
                'create_at' => 'DATETIME',
                'update_at' => 'DATETIME',
                'description' => 'TEXT',
                'url_key' => 'VARCHAR(255) NOT NULL',
                'attribute_set' => 'SMALLINT(5) NOT NULL'
            ),
            'references' => array(
                'attribute_set' => array(
                    'table' =>self::TABLE_ATTRIBUTE_GROUP,
                    'row' => 'id',
                )
            ),
        );
        return $this->createTableQuery($table_construct,'createProductMediaTableConstruct',false);
    }

    public function createProductMediaTableConstruct(){
        require_once ('Core.php');
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_MEDIA,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'product_id' => 'BIGINT NOT NULL',
                'media_id' => 'BIGINT NOT NULL',
                'status' => 'TINYINT(2)',
                'is_thumbnail' => 'TINYINT(2)'
            ),
            'references' => array(
                'media_id' => array(
                    'table' =>Setup_Install_Core::TABLE_MEDIA,
                    'row' => 'id',
                ),
                'product_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),
        );
        return $this->createTableQuery($table_construct,'createProductCategoryTable',false);

    }

    public function createProductCategoryTable(){
        require_once ('Category.php');

        $table_construct = array(
            'table' => self::TABLE_PRODUCT_CAT,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'product_id' => 'BIGINT NOT NULL',
                'category_id' => 'BIGINT NOT NULL',
            ),
            'references' => array(
                'category_id' => array(
                    'table' =>Setup_Install_Category::TABLE_CATEGORY,
                    'row' => 'id',
                ),
                'product_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),
        );
        return $this->createTableQuery($table_construct,'createProductOptionTable',false);
    }
    public function createProductOptionTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_OPTION,
            'rows' => array(
                'id' => 'INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'product_id' => 'BIGINT NOT NULL',
                'is_required' => 'TINYINT(2)',
                'type' => 'VARCHAR(255) NOT NULL',
                'title' => 'VARCHAR(255) NOT NULL'
            ),
            'references' => array(
                'product_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),
        );
        return $this->createTableQuery($table_construct,'createProductOptionValueTable',false);
    }
    public function createProductOptionValueTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_OPTION_VALUE,
            'rows' => array(
                'id' => 'INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'option_id' => 'INT(10) NOT NULL',
                'is_default' => 'TINYINT(2)',
                'title' => 'VARCHAR(255) NOT NULL',
                'price' => 'DECIMAL(12,4)',
                'price_type' => 'VARCHAR(7)'
            ),
            'references' => array(
                'option_id' => array(
                    'table' =>self::TABLE_PRODUCT_OPTION,
                    'row' => 'id',
                )
            ),
        );
        return $this->createTableQuery($table_construct,'createProductRelationTable',false);
    }
    public function createProductRelationTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_RELATION,
            'rows' => array(
                'id' => 'INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'parent_id' => 'BIGINT NOT NULL',
                'product_id' => 'BIGINT NOT NULL',
            ),
            'references' => array(
                'parent_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                ),
                'product_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),
        );
        return $this->createTableQuery($table_construct,'createProductIntTable',false);
    }

    public function createProductIntTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_INT,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'attribute_id' => 'SMALLINT(5) NOT NULL',
                'parent_id' => 'BIGINT NOT NULL',
                'value' => 'INT(11)'
            ),
            'references' => array(
                'attribute_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE,
                    'row' => 'id',
                ),
                'parent_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),

        );
        return $this->createTableQuery($table_construct,'createProductVarcharTable',false);
    }
    public function createProductVarcharTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_VARCHAR,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'attribute_id' => 'SMALLINT(5) NOT NULL',
                'parent_id' => 'BIGINT NOT NULL',
                'value' => 'VARCHAR(255)'
            ),
            'references' => array(
                'attribute_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE,
                    'row' => 'id',
                ),
                'parent_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),

        );
        return $this->createTableQuery($table_construct,'createProductTextTable',false);
    }
    public function createProductTextTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_TEXT,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'attribute_id' => 'SMALLINT(5) NOT NULL',
                'parent_id' => 'BIGINT NOT NULL',
                'value' => 'TEXT'
            ),
            'references' => array(
                'attribute_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE,
                    'row' => 'id',
                ),
                'parent_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),

        );
        return $this->createTableQuery($table_construct,'createProductDatetimeTable',false);
    }
    public function createProductDatetimeTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_DATETIME,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'attribute_id' => 'SMALLINT(5) NOT NULL',
                'parent_id' => 'BIGINT NOT NULL',
                'value' => 'datetime'
            ),
            'references' => array(
                'attribute_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE,
                    'row' => 'id',
                ),
                'parent_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),

        );
        return $this->createTableQuery($table_construct,'createProductDecimalTable',false);
    }
    public function createProductDecimalTable(){
        $table_construct = array(
            'table' => self::TABLE_PRODUCT_DECIMAL,
            'rows' => array(
                'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
                'attribute_id' => 'SMALLINT(5) NOT NULL',
                'parent_id' => 'BIGINT NOT NULL',
                'value' => 'DECIMAL(12,4)	'
            ),
            'references' => array(
                'attribute_id' => array(
                    'table' =>self::TABLE_ATTRIBUTE,
                    'row' => 'id',
                ),
                'parent_id' => array(
                    'table' =>self::TABLE_PRODUCT,
                    'row' => 'id',
                )
            ),

        );
        return $this->createTableQuery($table_construct,'createCategoryTable',true);
    }
}