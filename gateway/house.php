<?php
	
	/* 
		Gateway between specific pages where house details are needed and functions.php.
		This page calls all the functions needed in house table and returns the result using json_encode.
	*/
	include "../inc/functions.php"; 
	
	$db = new phpork_functions (); 

	/*
		If ddl_house is set, it calls ddl_house() function and returns details from house table. 
		
	*/
	if(isset($_GET['ddl_house'])){
		$arr_house = $db->ddl_house(); 
		echo json_encode($arr_house);
		/*localhost/phpork2/gateway/house.php?ddl_house=1*/
						
	}

	/*
		If getHouseByLoc is set, it calls getHouseByLoc() function and returns lists of house numbers by a specific location. 
		
	*/
	if(isset($_POST['getHouseByLoc'])){
		$loc_id = $_POST['loc'];
		$arr_house = $db->getHouseByLoc($loc_id); 
		echo json_encode($arr_house);
		/*localhost/phpork2/gateway/house.php?getHouseByLoc=1&loc=1*/
						
	}

	/*
		If getHouseDetails is set, it calls getHouseDetails() function and returns specific house number details from house table. 
		
	*/
	if(isset($_POST['getHouseDetails'])){
		$h_id = $_POST['house'];
		$arr_house = $db->getHouseDetails($h_id); 
		echo json_encode($arr_house);
		/*localhost/phpork2/gateway/house.php?getHouseDetails=1&house=1*/
						
	}
	/*
		If getHouse is set, it calls getHouse() function and returns a house number by a specific location. 
		
	*/
	if(isset($_POST['getHouse'])){
		$loc_id = $_POST['farm'];
		$arr_house = $db->getHouse($loc_id); 
		echo json_encode($arr_house);
		/*localhost/phpork2/gateway/house.php?getHouseByLoc=1&loc=1*/
						
	}
?>