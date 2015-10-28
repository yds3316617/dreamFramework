<?php
	/*
	 * 服务器模拟类
	 * */
    interface IServer{
		
		/*
		 * 系统启动
		 * */
    	public function run();
		
		
		/*
		 * 初始化服务器环境
		 * 设置内存等
		 * */
		public function initEnvironment();
		
		
    }
