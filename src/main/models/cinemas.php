<?php

	/** @entity */
	class cinemas
	{
		/** 
			@id 
			@column(type="bigint") 
			@GeneratedValue				
		**/
		private $id;
		
		/** @column(length=255)  **/ 
		private $name;
		
		/** @column(length=255)  **/ 
		private $location;
		
		/** @column(type="integer")  **/ 
		private $films;
		
		public function __construct($name, $location, $films)
		{
			$this->name = $name;
			$this->location = $location;
			$this->films = $films;
		}
		
		public function jsonCinema()
		{
			return (array('id'=>$this->id,'name'=>$this->name,'location'=>$this->location,'films'=>$this->films));
		}
	}
	
?>