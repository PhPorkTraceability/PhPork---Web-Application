<?php
	/* 
		Gateway between specific pages where location details are needed and functions.php.
		This page calls all the functions needed in location table and returns the result using json_encode.
	*/
	
	include "../inc/functions.php"; 
	
	$db = new phpork_functions (); 
	/*
		If ddl_location is set, it calls ddl_location() function and 
		returns lists of location names from location table. 
		
	*/
	if(isset($_POST['ddl_location'])){
		$arr_house = $db->ddl_location(); 
		echo json_encode($arr_house);
		/*localhost/phpork2/gateway/location.php?ddl_location=1*/
						
	}
	
	/*
		If getLocDetails is set, it calls getLocDetails() function and 
		returns location details by a specific loc_id. 
		
	*/
	if(isset($_POST['getLocDetails'])){
		$loc_id = $_POST['loc'];
		$arr_house = $db->getLocDetails($loc_id); 
		echo json_encode($arr_house);
		/*localhost/phpork2/gateway/location.php?getLocDetails=1&loc=1*/
						
	}

	/*
		If getHousePenByLoc is set, it calls getHousePenByLoc() function and 
		returns house numbers and pen numbers by a specific loc_id. 
		
	*/
	if(isset($_GET['getHousePenByLoc'])){
		$loc_id = $_GET['loc'];
		$arr_house = $db->getHousePenByLoc($loc_id); 
		echo json_encode($arr_house);
		/*localhost/phpork2/gateway/location.php?getHousePenByLoc=1&loc=1*/
						
	}
?>