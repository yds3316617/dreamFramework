<?php
return array(
	'columns'=> array(
            'id' => array(
                        'lable'=>'管理员ID',
                        'pk' => true,
                        'auto_increment' => true,
                        'type' => 'bigint',
                        'length'=>10,
                        'width' => '60',
                        'extra' =>'not null auto_increment',
                    ),
            'username' => array(
                        'lable'=>'账号',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>30,
                        'width' => '50',
                    ),
            'password' => array(
                        'lable'=>'密码',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>30,
                        'width' => '50',
                    ),
            'name' => array(
                        'lable'=>'姓名',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>30,
                        'width' => '50',
                    ),
            'seed' => array(
                        'lable'=>'加密种子',
                        'type' => 'smallint',
                        'length'=>10,
                        'width' => '50',
                    ),

        ),
);
