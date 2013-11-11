<?php

	class index extends www
	{
		static protected $_api;
		static protected $_orm;
		static protected $_configuration;
		static protected $_smarty;
		
		public function __construct()
        {
			$this->_api = www::$_api;
			$this->_orm = www::$_orm;			
			$this->_configuration = www::$_configuration;
			$this->_smarty = www::$_smarty;
		}
		
		// Index web
		public function getIndex(){
			$this->_smarty->assign('name','World');
			$this->_smarty->display('index.tpl');
		}
		
	}

?>