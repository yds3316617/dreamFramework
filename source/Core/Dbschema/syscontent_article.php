<?php
return array(
	'columns' => array(
            'id' => array(
                        'lable'=>'文章ID',
                        'pk' => true,
                        'auto_increment' => true,
                        'type' => 'bigint',
                        'length'=>10,
                        'width' => '60',
                        'extra' =>'not null auto_increment',
                    ),
            'title' => array(
                        'lable'=>'文章标题',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>30,
                        'width' => '50',
                    ),
            'content' => array(
                        //'lable'=>'文章内容',
                        'type' => 'text',
                        //'search_type'=>'has',//搜索项
                        //'length'=>255,
                        'width' => '50',
                    ),
            'cat_id' => array(
                        'lable'=>'所属分类',
                        'type' => 'int',
                        //'search_type'=>'has',//搜索项
                        'length'=>10,
                        'width' => '50',
                    ),
            'ispublic' => array(
                        'lable'=>'是否发布',
                        'type' => 'tinyint',
                        //'search_type'=>'has',//搜索项
                        'length'=>10,
                        'width' => '50',
                    ),
            'createtime' => array(
                        'lable'=>'创建时间',
                        'type' => 'time',
                        //'search_type'=>'has',//搜索项
                        'length'=>10,
                        'width' => '50',
                    ),
           'lastmodifytime' => array(
                        'lable'=>'最后修改时间',
                        'type' => 'time',
                        //'search_type'=>'has',//搜索项
                        'length'=>10,
                        'width' => '50',
                    ),

        ),
);
