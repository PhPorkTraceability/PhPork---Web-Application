<?php
	
	/* 
		Gateway between specific pages where rfid details are needed and functions.php.
		This page calls all the functions needed in rfid_tags table and returns the result using json_encode.
	*/

	include "../inc/functions.php"; 
	
	$db = new phpork_functions (); 
	
	if(isset($_POST['ddl_inactiveRFID'])){
		$arr_rfid = $db->ddl_inactiveRFID(); 
		echo json_encode($arr_rfid);
		/*localhost/phpork2/gateway/rfid.php?ddl_inactiveRFID=1*/
						
	}
	if(isset($_GET['ddl_notMortalityPen'])){
		$h_id = $_GET['house'];
		$arr_pen = $db->ddl_notMortalityPen($h_id); 
		echo json_encode($arr_pen);
		/*localhost/phpork2/gateway/pen.php?ddl_notMortalityPen=1&house=1*/
						
	}
	if(isset($_GET['getPenByHouse'])){
		$h_id = $_GET['house'];
		$arr_pen = $db->getPenByHouse($h_id); 
		echo json_encode($arr_pen);
		/*localhost/phpork2/gateway/pen.php?getPenByHouse=1&house=1*/
						
	}
	if(isset($_GET['getPenDetails'])){
		$h_id = $_GET['pen'];
		$arr_pen = $db->getPenDetails($h_id); 
		echo json_encode($arr_pen);
		/*localhost/phpork2/gateway/pen.php?getPenDetails=1&pen=1*/
						
	}
?>