<?php
return array(
	'columns' => array(
            'id' => array(
                        'lable'=>'商品ID',
                        'pk' => true,
                        'auto_increment' => true,
                        'type' => 'bigint',
                        'length'=>10,
                        'width' => '60',
                        'extra' =>'not null auto_increment',
                    ),
            'name' => array(
                        'lable'=>'商品名称',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>80,
                        'width' => '80',
                    ),
            'bn' => array(
                        'lable'=>'商品编号',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>30,
                        'width' => '30',
                    ),
            'brief' => array(
//                        'lable'=>'简介',
                        'type' => 'varchar',
                        'search_type'=>'has',//搜索项
                        'length'=>255,
                        'width' => '30',
                    ),
            'price' => array(
                        'lable'=>'销售价',
                        'type' => 'float',
                        'length'=>10,
                        'width' => '30',
                    ),
            'cost_price' => array(
                        'lable'=>'成本价',
                        'type' => 'float',
                        'length'=>10,
                        'width' => '30',
                    ),
            'mkt_price' => array(
                        'lable'=>'市场价',
                        'type' => 'float',
                        'length'=>10,
                        'width' => '30',
                    ),
            'brand_id' => array(
                        'lable'=>'品牌ID',
                        'type' => 'float',
                        'length'=>10,
                        'width' => '30',
                    ),
            'cat_id' => array(
                        'lable'=>'分类ID',
                        'type' => 'float',
                        'length'=>10,
                        'width' => '30',
                    ),
            'weight' => array(
                        'lable'=>'重量',
                        'type' => 'float',
                        'length'=>10,
                        'width' => '30',
                    ),
            'nospec' => array(
                        'lable'=>'是否开启规格',
                        'type' => 'mediumint',
                        'length'=>10,
                        'width' => '30',
                    ),
            'lastmodifytime' => array(
                        'lable'=>'最后修改时间',
                        'type' => 'time',
                        'length'=>10,
                        'width' => '30',
                    ),
            'createtime' => array(
                        'lable'=>'创建时间',
                        'type' => 'time',
                        'length'=>10,
                        'width' => '30',
                    ),
            'onsale' => array(
                        'lable'=>'是否上架',
                        'type' => 'int',
                        'length'=>10,
                        'width' => '30',
                    ),
             


        ),
);
