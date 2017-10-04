<?php
	/* 
		Gateway between specific pages where pig details are needed and functions.php.
		This page calls all the functions needed in pig table and returns the result using json_encode.
	*/
	
	include "../inc/functions.php"; 
	$db = new phpork_functions ();  
	if(isset($_POST['addPigFlag'])){
		$pid = $_POST['new_pid']; 
		$pbdate = $_POST['pbdate']; 
		$pweekfar = $_POST['pweekfar']; 
		$pfarm = $_POST['ploc']; 
		$pstatus = $_POST['selStat']; 
		$phouse = $_POST['selHouse']; 
		$ppen = $_POST['selPen']; 
		$prfid = $_POST['prfid']; 
		$pgender = $_POST['pgender']; 
		$pbreed = $_POST['pbreed']; 
		$pboar = $_POST['pboar']; 
		$psow = $_POST['psow']; 
		$pfoster = $_POST['pfoster'];
		$pweight = $_POST['pweight']; 
		$user = $_POST['user_id']; 
		$fid = $_POST['selectFeeds']; 
		$fdate = $_POST['fdate']; 
		$ftime = $_POST['ftime']; 
		$medid = $_POST['selectMeds']; 
		$medDate = $_POST['medDate'];
		$medTime = $_POST['medTime']; 
		$proddate = $_POST['fprodDate']; 
		$remarks = $_POST['pweighttype']; 
		$fqty = $_POST['fqty'];
		$mqty = $_POST['mqty'];
		$unit = $_POST['selUnit'];
		echo json_encode($db->addPig($pid,$pbdate,$pweekfar,$ppen,$pgender,$pbreed,$pboar,$psow,$pfoster,$pstatus,$user)); 
		$db->addPigWeight($pid,$pweight,$remarks); 
		$db->addFeeds($fid,$fdate,$ftime,$pid,$proddate,$fqty); 
		$db->addMeds($medid,$medDate,$medTime,$pid,$mqty,$unit);
		$db->updatepigRFID($pid,$prfid); 
		echo "<script>alert('Added successfully!');</script>"; 
		/*localhost/phpork2/gateway/pig.php?addPigFlag=1&new_pid=104&pbdate=2016-04-12&pweekfar=8&ploc=2&selStat=Weaning&selHouse=2&selPen=8&prf*id=104&pgender='M'&pbreed=1&pboar=64&psow=E4LY.6547&pfoster=''&pweight=12.12&user_id=1&selectFeeds=2&fdate=2016-04-12&ftime=08:00:00&selectMeds=3&medDate=2016-04-04&medTime=08:00:00&fprodDate=2016-04-04&pweighttype=weaning&fqty=12.12&mqty=31.08&selUnit=kg*/
		
	} 
	
	if(isset($_POST['getPigDetails'])){
		$pid = $_POST['pig_id'];
		echo json_encode($db->getPigDetails($pid));
		/*http://localhost/phpork2/gateway/pig.php?getPigDetails=1&pig_id=1*/
	}
	if(isset($_POST['getPigWeightDetails'])){
		$pid = $_POST['pig_id'];
		echo json_encode($db->getPigWeightDetails($pid));
		/*http://localhost/phpork2/gateway/pig.php?getPigWeightDetails=1&pig_id=1*/
	}
	if(isset($_GET['getLastFeed'])){
		$pid = $_GET['pig_id'];
		echo json_encode($db->getLastFeed($pid));
		/*http://localhost/phpork2/gateway/pig.php?getLastFeed=1&pig_id=1*/
	}
	if(isset($_GET['getLastMed'])){
		$pid = $_GET['pig_id'];
		echo json_encode($db->getLastMed($pid));
		/*http://localhost/phpork2/gateway/pig.php?getLastMed=1&pig_id=1*/
	}
	if(isset($_GET['getPigFeedsDetails'])){
		$pid = $_GET['pig_id'];
		echo json_encode($db->getPigFeedsDetails($pid));
		/*http://localhost/phpork2/gateway/pig.php?getPigFeedsDetails=1&pig_id=1*/
	}
	if(isset($_GET['getPigMedsDetails'])){
		$pid = $_GET['pig_id'];
		echo json_encode($db->getPigMedsDetails($pid));
		/*http://localhost/phpork2/gateway/pig.php?getPigMedsDetails=1&pig_id=1*/
	}
	
	if(isset($_POST['getPigsByPen'])){
		$pid = $_POST['pen'];
		echo json_encode($db->getPigsByPen($pid));
		/*http://localhost/phpork2/gateway/pig.php?getPigsByPen=1&pen=5*/
	}
	if(isset($_GET['getPigLabel'])){
		$pid = $_GET['pig'];
		echo json_encode($db->getPigLabel($pid));
		/*http://localhost/phpork2/gateway/pig.php?getPigLabel=1&pig=1*/
	}
	if(isset($_POST['getinsertRFID'])){
		$pid = $_POST['pig'];
		echo json_encode($db->getinsertRFID($pid));
		/*http://localhost/phpork2/gateway/pig.php?getinsertRFID=1&pig=1*/
	}
	if(isset($_POST['getCurrentHouse'])){
		$pid = $_POST['pig'];
		echo json_encode($db->getCurrentHouse($pid));
		/*http://localhost/phpork2/gateway/pig.php?getCurrentHouse=1&pig=1*/
	}
	
	if(isset($_POST['updatePig'])){
		$pid = $_POST['pig'];
		$user = $_POST['user'];
		$prevStatus = $_POST['prevStatus'];
		$stat = $_POST['stat'];
		echo json_encode($db->updatePigDetails($pid, $user, $stat,$prevStatus));
		/*http://localhost/phpork2/gateway/pig.php?getUserEdited=1&pig=1*/
	}
	if(isset($_POST['updateRFID'])){
		$pid = $_POST['pig'];
		$rfid = $_POST['rfid'];
		$prevrfid = $_POST['prevRFID'];
		$label = $_POST['label'];
		$user = $_POST['user'];
		echo json_encode($db->updateRFIDdetails($pid, $rfid, $prevrfid, $label,$user));
		
	}
	if(isset($_POST['updatePigWeight'])){
		$pig_id = $_POST['pig'];
		$weight = $_POST['weight'];
		$record_id = $_POST['record_id'];
		$remarks = $_POST['remarks'];
		$user = $_POST['user'];
		$prevWeight = $_POST['prevWeight'];
		$prevweighttype = $_POST['prevWeightType'];
		echo json_encode($db->updatePigWeight($pig_id, $prevWeight,$weight, $record_id, $remarks,$prevweighttype,$user));
		
	}

	if(isset($_POST['updateWeekFar'])){
		$user = $_POST['user'];
		$pigid = $_POST['pig'];
		$prevWeekFar = $_POST['prevWeekFar'];
		$week_far = $_POST['week_far'];
		echo json_encode($db->updateWeekFar($user,$pigid,$week_far,$prevWeekFar));
	}

	if(isset($_POST['addParent'])){
		$lbl = $_POST['label'];
		$lbl_id = $_POST['label_id'];
		$user = $_POST['user'];
		echo json_encode($db->addParent($lbl,$lbl_id,$user)); 
		/*localhost/phpork2/gateway/pig.php?addParent=1&lbl=sow&lbl_id=2345*/
	} 
	if(isset($_POST['addBreed'])){
		$br_name = $_POST['breed_name'];
		$user = $_POST['user'];
		echo json_encode($db->addBreed($br_name,$user)); 
		/*localhost/phpork2/gateway/pig.php?addBreed=1&breed_name=Galore-White*/
	} 
	if(isset($_POST['ddl_parent'])){
		$var = $_POST['var'];
		echo json_encode($db->ddl_parent($var));
		/*http://localhost/phpork2/gateway/pig.php?ddl_sow=1*/
	}
	
	if(isset($_POST['ddl_parentdetails'])){
		echo json_encode($db->ddl_parentdetails());
		/*http://localhost/phpork2/gateway/pig.php?ddl_foster=1*/
	}
	if(isset($_POST['getParentDetails'])){
		$parent = $_POST['parent'];
		echo json_encode($db->getParentDetails($parent));
		/*http://localhost/phpork2/gateway/pig.php?ddl_foster=1*/
	}
	if(isset($_GET['ddl_pig'])){
		
		echo json_encode($db->ddl_pig());
		/*http://localhost/phpork2/gateway/pig.php?ddl_pig=1*/
	}
	if(isset($_POST['ddl_breeds'])){
		echo json_encode($db->ddl_breeds());
		/*http://localhost/phpork2/gateway/pig.php?ddl_breeds=1*/
	}
	if(isset($_POST['getBreed'])){
		$id = $_POST['breed_id'];
		echo json_encode($db->getBreed($id));
		//http://localhost/phpork2/gateway/pig.php?ddl_breeds=1
	}
	if(isset($_POST['ddl_batch'])){
		
		echo json_encode($db->ddl_batch());
		/*http://localhost/phpork2/gateway/pig.php?ddl_breeds=1*/
	}
	if(isset($_GET['ddl_pigpen'])){
		$pig = $_GET['pig'];
		$pen = $_GET['pen'];
		$house = $_GET['house'];
		$loc = $_GET['location'];
		echo json_encode($db->ddl_pigpen($pig,$pen,$house,$loc));
		/*http://localhost/phpork2/gateway/pig.php?ddl_pigpen=1&location=2&house=2&pen=6&pig=40*/
	}
	if(isset($_GET['ddl_pigpenall'])){
		$pig = $_GET['pig'];
		$pen = $_GET['pen'];
		$house = $_GET['house'];
		$loc = $_GET['location'];
		echo json_encode($db->ddl_pigpenall($pig,$pen,$house,$loc));
		/*http://localhost/phpork2/gateway/pig.php?ddl_pigpenall=1&location=2&house=2&pen=6&pig=40*/
	}
	if(isset($_POST['insertWeight'])){
		$weight = $_POST['weight']; 
		$weightType = $_POST['weightType']; 
		$dateWeighed = $_POST['dateWeighed']; 
		$timeWeighed = $_POST['timeWeighed'];
		$user = $_POST['user'];
		$sparray = array();
		$size = 0;

		if (isset($_POST['batchsel'])) {
			foreach ($_POST['batchsel'] as $key) {
				$sparray = $db->ddl_perbatch($key);
				$size = $size+ sizeof($sparray);
			}
			$fqty = $weight/$size;
			
			$minWeight = number_format($fqty, 2, '.', ',');
			foreach ($_POST['batchsel'] as $key) {
				$sparray = $db->ddl_perbatch($key);
				foreach ($sparray as $a ) {
					
					$db->addWeight($dateWeighed, $timeWeighed, $minWeight, $weightType, $a, $user); 
				
				}
				
				
			}

		}
		if (isset($_POST['pigsel'])) {
			$pigsize = sizeof($_POST['pigsel']);
			$fqty = $weight/$pigsize;
			print($pigsize);
			foreach($_POST['pigsel'] as $pid){
				$db->addWeight($dateWeighed, $timeWeighed, $fqty, $weightType, $pid, $user);  					
			} 
		}
	} 
	if (isset($_GET['mvmntChart'])) {
			$id = $_GET['pig'];
			echo json_encode($db->getWeekDateMvmnt($id));
		}
	if (isset($_GET['weightChart'])) {
		$id = $_GET['pig'];
		echo json_encode($db->getPigWeight($id));
	}
	if(isset($_POST['getWeightReport'])){
		$from = $_POST['from'];
		$to = $_POST['to'];
		$ar = array();
		if (isset($_POST['selbtch'])) {
			$choice = 'batch';
			foreach ($_POST['selbtch'] as $key) {
				$sparray = $db->ddl_perbatch($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$weight = $db->getWeightReport($from,$to,$choice,$ar); 
			echo json_encode($weight);
			

		}
		if (isset($_POST['selhouse'])) {
			$choice = 'house';
			
			foreach ($_POST['selhouse'] as $key) {
				$sparray = $db->ddl_pigperhouse($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$weight = $db->getWeightReport($from,$to,$choice,$ar); 
			echo json_encode($weight);
			

		}
		if (isset($_POST['selpen'])) {
			$choice = 'pen';
			
			foreach ($_POST['selpen'] as $key) {
				$sparray = $db->ddl_perpen($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$weight = $db->getWeightReport($from,$to,$choice,$ar); 
			echo json_encode($weight);
			

		}
		if (isset($_POST['selpig'])) {
			$choice = 'pig';
			
			foreach ($_POST['selpig'] as $key) {
				$sparray[] = $db->ddl_perpig($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$weight = $db->getWeightReport($from,$to,$choice,$ar); 
			echo json_encode($weight);
			

		}
		/*localhost/phpork2/gateway/meds.php?getMedsDetails=1&med=1*/
	} 
	if(isset($_POST['ddl_inactiveRFID'])){
		echo json_encode($db->ddl_inactiveRFID());
	}

	
?>   