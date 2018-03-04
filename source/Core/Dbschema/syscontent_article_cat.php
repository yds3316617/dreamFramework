<?php
return array(
	'columns' => array(
            'id' => array(
                        'lable'=>'ID',
                        'pk' => true,
                        'auto_increment' => true,
                        'type' => 'bigint',
                        'length'=>10,
                        'width' => '60',
                        'extra' =>'not null auto_increment',
                    ),
            'name' => array(
                        'lable'=>'分类名称',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>100,
                        'width' => '50',
                    ),
            'deep' => array(
                        'lable'=>'文章内容',
                        'type' => 'tinyint',
//                        'search_type'=>'has',//搜索项
                        'length'=>4,
                        'width' => '50',
                    ),
            'parent_ids' => array(
                        'lable'=>'父节点',
                        'type' => 'varchar',
                        //'search_type'=>'has',//搜索项
                        'length'=>255,
                        'width' => '50',
                    ),
             'order' => array(
                        'lable'=>'优先级',
                        'type' => 'int',
                        //'search_type'=>'has',//搜索项
                        'length'=>30,
                        'width' => '50',
                    ),

        ),
);
