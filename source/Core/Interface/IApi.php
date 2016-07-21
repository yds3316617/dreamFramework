<?php
namespace Core;
	/*
	 * 接口，所有api都要实现此接口
	 * */
    interface IApi{
		
    	/*
		 * 接口具体实现入口
		 * */
    	public  function Api($params);
		
		/*
		 * 返回错误代码
		 * */
		public  function getCode();

        /*
		 * 参数解释
		 * */
		public  function getParams();

        
		
    }
