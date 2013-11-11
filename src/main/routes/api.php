<?php

	class api extends steel 
	{
		static protected $_api;
		static protected $_orm;
		static protected $_configuration;
		
		public function __construct()
        {
			self::$_api = steel::$_api;
			self::$_orm = steel::$_orm;			
			self::$_configuration = steel::$_configuration;
		}
		
		// Routes
		public function loadRoutes(){
			// Api default
			self::$_api->get('/', function () {
				echo "<h1>Api running :-)!!</h1>";
			});
			
			// Get all cinemas 
			self::$_api->get('/cinemas', function () {
				$cinemas = new cinemas_controller();
				$cinemas->getAllCinemas();
			});
						
			// Search cinemas 
			self::$_api->get('/cinemas/:id', function ($id) 
			{
				$cinemas = new cinemas_controller();
				$cinemas->getCinemas($id);
			});
			
			// Add cinemas
			self::$_api->post('/cinemas', function () 
			{
				$cinemas = new cinemas_controller();
				$cinemas->addCinemas();
			});
			
			// Update cinemas
			self::$_api->put('/cinemas/:id', function ($id) 
			{
				$cinemas = new cinemas_controller();
				$cinemas->updateCinemas($id);
			});
						
			// Delete cinemas
			self::$_api->delete('/cinemas/:id', function ($id) 
			{
				$cinemas = new cinemas_controller();
				$cinemas->deleteCinemas($id);
			});			
		
		}		
	}
	
?>