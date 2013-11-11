<?php

	require_once('../../../vendor/Simpletest/autorun.php');
	
	class TestOfCinemas extends UnitTestCase {
		
		protected $api_url = "http://localhost/github";
		
		//create a function that will allow you to call API endpoints at-will.
		private function loadEndpoint($url, $fields, $type) {
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);	
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json')                                                                 
			);   
			
			if (!empty($fields))
				curl_setopt($ch,CURLOPT_POSTFIELDS,  json_encode($fields));				
		
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);
			return array(
			  'body' => $output,
			  'info' => $info
			);
		}
		
		// Test add cinemas
		function testAddCinemas() 
		{      		
			$url = $this->api_url."/cinemas";
			$fields = array(
						'name' => 'cinema2',
						'location' => 'london',
						'films' => 23
				);	
				
			echo "<h1>TEST ADD CINEMAS</h1>";
			echo "Params: <br/>";
			echo "name => cinemas2 <br/>";
			echo "location => london <br/>";
			echo "films => 23";
			
			$response = $this->loadEndpoint($url,$fields,"POST");	
			
			echo "<h1>Result</h1>";
			echo $response['body'];
			
			$resultArray = json_decode($response['body'],true);
												
			$this->assertEqual($resultArray['status'], "1");
		}
		
		function testUpdateCinemas()
		{
			$url = $this->api_url."/cinemas/1";
			$fields = array(
						'name' => 'cinema23',
						'location' => 'london',
						'films' => 4
				);	
				
			echo "<h1>TEST UPDATE CINEMAS</h1>";
			echo "Params: <br/>";
			echo "name => cinemas2 <br/>";
			echo "location => london <br/>";
			echo "films => 23";
			
			$response = $this->loadEndpoint($url,$fields,"PUT");	
			
			echo "<h1>Result</h1>";
			echo $response['body'];
			
			$resultArray = json_decode($response['body'],true);
												
			$this->assertEqual($resultArray['status'], "1");
		}
		
		function testDeleteCinemas()
		{
			$url = $this->api_url."/cinemas/2";
			$fields = array();
			echo "<h1>TEST DELETE CINEMAS</h1>";
			echo "Params: <br/>";
			echo "name => cinemas2 <br/>";
			echo "location => london <br/>";
			echo "films => 23";
			
			$response = $this->loadEndpoint($url,$fields,"DELETE");	
			
			echo "<h1>Result</h1>";
			echo $response['body'];
			
			$resultArray = json_decode($response['body'],true);
												
			$this->assertEqual($resultArray['status'], "1");
		}	
		
	}
	
?>