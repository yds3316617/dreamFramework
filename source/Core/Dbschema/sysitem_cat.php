<?php
return array(
	'columns' => array(
            'id' => array(
                        'lable'=>'分类ID',
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
                        'length'=>80,
                        'width' => '30',
                    ),
            'parent_id' => array(
//                        'lable'=>'父分类ID',
                        'type' => 'int',
                        'search_type'=>'has',//搜索项
                        'length'=>10,
                        'width' => '30',
                    ),
            'path' => array(
//                        'lable'=>'路径，逗号隔开',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>50,
                        'width' => '30',
                    ),
            'depth' => array(
                        'lable'=>'深度',//1,2,3共三级分类
                        'type' => 'mediumint',
                        'length'=>10,
                        'width' => '30',
                    ),
            'lastmodifytime' => array(
                        'lable'=>'最后修改时间',
                        'type' => 'int',
                        'length'=>10,
                        'width' => '30',
                    ),
            'createtime' => array(
                        'lable'=>'创建时间',
                        'type' => 'int',
                        'length'=>10,
                        'width' => '30',
                    ),


        ),
);
