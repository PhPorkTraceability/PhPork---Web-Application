<?php

	/* 
		Gateway between specific pages where movement details are needed and functions.php.
		This page calls all the functions needed in movement table and returns the result using json_encode.
	*/
	include "../inc/functions.php"; 
	
	$db = new phpork_functions (); 
	if(isset($_POST['getWeekDateMvmnt'])){
		$pid = $_POST['pig'];
		$mvmnt = $db->getWeekDateMvmnt($pid); 
		echo json_encode($mvmnt);
		/*localhost/phpork2/gateway/movement.php?getWeekDateMvmnt=1&pig=1*/
						
	}
	if(isset($_POST['getMvmntDetails'])){
		$from = $_POST['from'];
		$to = $_POST['to'];
		$ar = array();
		if (isset($_POST['btchsel'])) {
			$choice = 'batch';
			foreach ($_POST['btchsel'] as $key) {
				$sparray = $db->ddl_perbatch($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$mvmnt = $db->getMvmntDetails($from,$to,$choice,$ar); 
			echo json_encode($mvmnt);
			

		}
		if (isset($_POST['hsesel'])) {
			$choice = 'house';
			
			foreach ($_POST['hsesel'] as $key) {
				$sparray = $db->ddl_pigperhouse($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$mvmnt = $db->getMvmntDetails($from,$to,$choice,$ar); 
			echo json_encode($mvmnt);
			

		}
		if (isset($_POST['pensel'])) {
			$choice = 'pen';
			
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$mvmnt = $db->getMvmntDetails($from,$to,$choice,$ar); 
			echo json_encode($mvmnt);
			

		}
		if (isset($_POST['pigsel'])) {
			$choice = 'pig';
			
			foreach ($_POST['pigsel'] as $key) {
				$sparray[] = $db->ddl_perpig($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$mvmnt = $db->getMvmntDetails($from,$to,$choice,$ar); 
			echo json_encode($mvmnt);
			

		}

		// if (isset($_POST['pigpen'])) {
		// 	$pigsize = sizeof($_POST['pigpen']);
		// 	$fqty = $qty/$pigsize;
		// 	foreach($_POST['pigpen'] as $pid){
		// 		$db->addMeds($medid,$medDate,$medTime,$pid,$fqty,$unit,$user);  					
		// 	} 
		// }
		
		/*localhost/phpork2/gateway/movement.php?getWeekDateMvmnt=1&pig=1*/
						
	}
	if (isset($_GET['mvmntChart'])) {
			$id = $_GET['pig'];
			echo json_encode($db->getWeekDateMvmnt($id));
	}

?>