<?php

	class cinemas_controller extends api
	{
		static protected $_api;
		static protected $_orm;
		static protected $_configuration;
		
		public function __construct()
        {
			$this->_api = api::$_api;
			$this->_orm = api::$_orm;			
			$this->_configuration = api::$_configuration;
		}
		
		// Get all cinemas		
		public function getAllCinemas()
		{
			try{				
				$query = $this->_orm->createQuery("
					SELECT c
					FROM cinemas c
				");	
						
				$result = $query->getArrayResult();				
				echo json_encode($result);														
			}catch (Exception $e) {
				echo json_encode(array('error'=>array('text'=>$e->getMessage(),'code' => $e->getCode()),'status'=>"0"));
			}						
		}

		// Get cinemas id
		public function getCinemas($id){
			try{
				$cinema = $this->_orm->find('cinemas', $id);
				echo json_encode($cinema->jsonCinema());
						
			}catch (Exception $e) {
				echo json_encode(array('error'=>array('text'=>$e->getMessage(),'code' => $e->getCode()),'status'=>"0"));
			}	
		}	

		// Add cinemas
		public function addCinemas(){
			
			$request = $this->_api->request();
			$body = $request->getBody();
			$cinema = json_decode($body);
			
			try{
				$cinema = new cinemas ($cinema->name, $cinema->location, $cinema->films);
				$this->_orm->persist($cinema);						
				$this->_orm->flush();
				echo json_encode(array('status'=>"1"));	
					
			}catch (Exception $e) {
				echo json_encode(array('error'=>array('text'=>$e->getMessage(),'code' => $e->getCode()),'status'=>"0"));
			}
		}	
		
		// Update cinemas
		public function updateCinemas($id){
			
			$request = $this->_api->request();
			$body = $request->getBody();
			$cinema = json_decode($body);
					
			try{
				$qb = $this->_orm->createQueryBuilder();
				$q = $qb->update('cinemas', 'c')
						->set('c.name', $qb->expr()->literal($cinema->name))
						->set('c.location', $qb->expr()->literal($cinema->location))
						->set('c.films', $qb->expr()->literal($cinema->films))
						->where('c.id = ?1')
						->setParameter(1, $id)
						->getQuery();
						
				$p = $q->execute();
				echo json_encode(array('status'=>"1"));	
					
			}catch (Exception $e) {
				echo json_encode(array('error'=>array('text'=>$e->getMessage(),'code' => $e->getCode()),'status'=>"0"));
			}
		}
		
		// Delete cinemas
		public function deleteCinemas($id){
			
			$request = $this->_api->request();
			$body = $request->getBody();
			$cinema = json_decode($body);
					
			try{		
			
				$qb = $this->_orm->createQueryBuilder();
				$q = $qb->delete('cinemas', 'c')
						->where('c.id = ?1')
						->setParameter(1, $id)
						->getQuery();
						
				$p = $q->execute();
				echo json_encode(array('status'=>"1"));	
					
			}catch (Exception $e) {
				echo json_encode(array('error'=>array('text'=>$e->getMessage(),'code' => $e->getCode()),'status'=>"0"));
			}
		}
	}

?>