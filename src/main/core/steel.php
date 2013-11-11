<?php

	abstract class steel
	{
		static protected $_api;
		static protected $_orm;
		static protected $_configuration;
		static protected $_smarty;
	
		public static function setApi($api)
		{
			self::$_api = $api;
		}
		
		public static function setOrm($orm)
		{
			self::$_orm = $orm;					
		}
	
		public static function setConfig($config)
		{
			self::$_configuration = $config;
		}
		
		public static function setSmarty($smarty)
		{
			self::$_smarty = $smarty;
		}
	}

?>