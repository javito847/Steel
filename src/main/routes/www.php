<?php

	class www extends steel 
	{
		static protected $_api;
		static protected $_orm;
		static protected $_configuration;
		static protected $_smarty;
		
		public function __construct()
        {
			self::$_api = steel::$_api;
			self::$_orm = steel::$_orm;			
			self::$_configuration = steel::$_configuration;
			self::$_smarty = steel::$_smarty;
		}
		
		// Routes
		public function loadRoutes(){
			// Index web
			self::$_api->get('/', function () {
				$index = new index();
				$index->getIndex();
			});
			
		}		
	}
	
?>