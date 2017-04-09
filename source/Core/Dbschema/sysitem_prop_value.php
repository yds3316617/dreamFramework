<?php
#规格属性表
return array(
	'columns' => array(
            'id' => array(
                        'lable'=>'ID',
                        'pk' => true,
                        'auto_increment' => true,
                        'type' => 'int',
                        'length'=>10,
                        'width' => '60',
                        'extra' =>'not null auto_increment',
                    ),
            'name' => array(
                        'lable'=>'属性值名称',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>80,
                        'width' => '30',
                    ),
           'prop_id' => array(
                        'lable'=>'关联属性ID',
                        'type' => 'enum',
                        'length'=>0,
                        'width' => '30',
                    ),
        ),
);
