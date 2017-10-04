<?php

	/* 
		Gateway between specific pages where medication details are needed and functions.php.
		This page calls all the functions needed in medication and med_transaction  table and returns the result using json_encode.
	*/
	include "../inc/functions.php"; 
	
	$db = new phpork_functions (); 

	if(isset($_POST['subMed'])){
		$medid = $_POST['selectMeds']; 
		$medDate = $_POST['medDate']; 
		$medTime = $_POST['medTime']; 
		$qty = $_POST['medQty'];
		$unit = $_POST['selUnit'];
		$user = $_POST['user'];
		$sparray = array();
		$size = 0;
		if (isset($_POST['pensel'])) {
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				$size = $size+ sizeof($sparray);
			}
			$fqty = $qty/$size;
			
			$medqty = number_format($fqty, 4, '.', ',');
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				foreach ($sparray as $a ) {
					
					$db->addMeds($medid,$medDate,$medTime,$a,$medqty,$unit,$user); 
				
				}
				
				
			}

		}
		if (isset($_POST['pigpen'])) {
			$pigsize = sizeof($_POST['pigpen']);
			$fqty = $qty/$pigsize;
			foreach($_POST['pigpen'] as $pid){
				$db->addMeds($medid,$medDate,$medTime,$pid,$fqty,$unit,$user);  					
			} 
		}
	} 
	
	if(isset($_POST['med']) && isset($_POST['getMedType'])){
		$med = $_POST['med']; 
		$mtype[] =  $db->getMedType($med); 
		echo json_encode($mtype); 
	} 
	if(isset($_POST['getMedsDetails'])){
		$med = $_POST['med']; 
		echo json_encode($db->getMedsDetails($med)); 
		/*localhost/phpork2/gateway/meds.php?getMedsDetails=1&med=1*/
	} 
	if(isset($_POST['getMedsReport'])){
		$pig = $_POST['pig']; 
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
					
			$meds = $db->getMedsReport($from,$to,$choice,$ar); 
			echo json_encode($meds);
			

		}
		if (isset($_POST['housesel'])) {
			$choice = 'house';
			
			foreach ($_POST['housesel'] as $key) {
				$sparray = $db->ddl_pigperhouse($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$meds = $db->getMedsReport($from,$to,$choice,$ar); 
			echo json_encode($meds);
			

		}
		if (isset($_POST['pensel'])) {
			$choice = 'pen';
			
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$meds = $db->getMedsReport($from,$to,$choice,$ar); 
			echo json_encode($meds);
			

		}
		if (isset($_POST['pigsel'])) {
			$choice = 'pig';
			
			foreach ($_POST['pigsel'] as $key) {
				$sparray[] = $db->ddl_perpig($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$meds = $db->getMedsReport($from,$to,$choice,$ar); 
			echo json_encode($meds);
			

		}
		/*localhost/phpork2/gateway/meds.php?getMedsDetails=1&med=1*/
	}
	if(isset($_POST['getMedsReportByMedication'])){
		//$medid = $_POST['med_id']; 
		$from = $_POST['from'];
		$to = $_POST['to'];
		$ar = array();
		echo "hey2";
		if (isset($_POST['medsel'])) {
			$choice = 'med';
			
			foreach ($_POST['medsel'] as $key) {
				$sparray[] = $db->ddl_medRecord2($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
			//echo '<script>alert(JSON.stringify(ar));</script>';
					
			$meds = $db->getMedsReportByMedication($from,$to,$choice,$ar); 
			echo json_encode($meds);
			
		}
	} 
	if(isset($_GET['getMedsTransDetails'])){
		$med = $_GET['med']; 
		echo json_encode($db->getMedsTransDetails($med)); 
		/*localhost/phpork2/gateway/meds.php?getMedsTransDetails=1&med=1*/
	} 
	if(isset($_POST['getMaxMedDate'])){
		echo json_encode($db->getMaxMedDate()); 
		/*localhost/phpork2/gateway/meds.php?getMedsDetails=1&med=1*/
	} 
	if(isset($_POST['ddl_meds'])){
		$arr_med = $db->ddl_meds(); 
		echo json_encode($arr_med);
		/*localhost/phpork/gateway/meds.php?ddl_meds=1*/
						
	}
	if(isset($_POST['ddl_medRecord'])){
		$pid = $_POST['pig']; 
		echo json_encode($db->ddl_medRecord($pid)); 
		/*localhost/phpork2/gateway/meds.php?ddl_medRecord=1&pig=1*/
	}
	if(isset($_POST['ddl_medRecord2'])){
		$pid = $_POST['pig']; 
		echo json_encode($db->ddl_medRecord2($pid)); 
		/*localhost/phpork2/gateway/meds.php?ddl_medRecord=1&pig=1*/
	}  
	if(isset($_POST['getLastMed'])){
		$pid = $_POST['pig']; 
		echo json_encode($db->getLastMed($pid)); 
		/*localhost/phpork2/gateway/meds.php?ddl_medRecord=1&pig=1*/
	} 
	if(isset($_POST['updateMeds'])){
		$mrid = $_POST['mrid']; 
		$medid = $_POST['med_id']; 
		$user = $_POST['user']; 
		echo json_encode($db->updateMeds($medid,$mrid,$user)); 
		/*localhost/phpork2/gateway/meds.php?ddl_medRecord=1&pig=1*/
	} 
?>