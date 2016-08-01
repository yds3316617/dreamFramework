<?php
namespace Site;
	/*
	 * 接口，所有后台的控制器 都要实现这个接口
	 * */
    interface IAdminController{
		
    	#展示数据
		function getData();
		
		#设置标题
		function getTitle();
		
		#获取列信息
		function getColumns();
        
		
    }
