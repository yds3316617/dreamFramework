<?php
#规格属性表
return array(
	'columns' => array(
            'id' => array(
                        'lable'=>'属性ID',
                        'pk' => true,
                        'auto_increment' => true,
                        'type' => 'int',
                        'length'=>10,
                        'width' => '60',
                        'extra' =>'not null auto_increment',
                    ),
            'name' => array(
                        'lable'=>'属性名称',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>80,
                        'width' => '30',
                    ),
           'prop_type' => array(
                        'lable'=>'属性类型',
                        'type' => array('sale'=>'销售属性','nature'=>'自然属性'),
                        'length'=>0,
                        'width' => '30',
                    ),
        ),
);
