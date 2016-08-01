<?php
return array(
	'columns' => array(
            'id' => array(
                        'lable'=>'品牌ID',
                        'pk' => true,
                        'auto_increment' => true,
                        'type' => 'bigint',
                        'length'=>10,
                        'width' => '60',
                        'extra' =>'not null auto_increment',
                    ),
            'brandname' => array(
                        'lable'=>'品牌名称',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>30,
                        'width' => '50',
                    ),
            'brief' => array(
                        'lable'=>'简介',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>255,
                        'width' => '50',
                    ),
            'logo_image' => array(
                        'lable'=>'图片ID',
                        'type' => 'varchar',
                        'length'=>50,
                        'width' => '50',
                    ),
            'intro' => array(
                        'lable'=>'详细介绍',
                        'type' => 'text',
//                      'length'=>10,
                        'width' => '50',
                    ),

        ),
);
