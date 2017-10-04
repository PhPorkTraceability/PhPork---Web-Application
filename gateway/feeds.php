<?php
	/* 
		Gateway between specific pages where feed details are needed and functions.php.
		This page calls all the functions needed in feeds table and returns the result using json_encode.
	*/
	include "../inc/functions.php"; 
	
	$db = new phpork_functions (); 
	
	/*
		If addFeeds is set, it calls addFeeds() function if the user wants to add new feed transaction. 
		
	*/
	if(isset($_POST['addFeeds'])){
		$fid = $_POST['selectFeeds']; 
		$fdate = $_POST['fdate']; 
		$ftime = $_POST['ftime']; 
		$selpig = $_POST['selpig']; 
		$proddate = $_POST['feedtypeDate']; 
		$qty = $_POST['feedQty'];
		$user = $_POST['user'];

		$sparray = array();
		$size = 0;

		if (isset($_POST['pensel'])) {
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				
				
				$size = $size+ sizeof($sparray);
				
			}
			$fqty = $qty/$size;

			
			$feedqty = number_format($fqty, 2, '.', ',');
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				foreach ($sparray as $a ) {
					
					echo json_encode($db->addFeeds($fid,$fdate,$ftime,$a,$proddate,$feedqty,$user)); 
				
				}
			}

		}
		if (isset($_POST['pigpen'])) {

			$pigsize = sizeof($_POST['pigpen']);
			$fqty = $qty/$pigsize;
			foreach($_POST['pigpen'] as $pid){
				echo json_encode($db->addFeeds($fid,$fdate,$ftime,$pid,$proddate,$fqty,$user)); 					
			} 
		}
/*localhost/phpork2/gateway/feeds.php?addFeeds=1&selectFeeds=2&fdate=2016-03-05&ftime=08:00:00&feedtypeDate=2016-03-05&feedQty=0.20&selpig=1*/
	
	}
	
	/*
		If getFeedsDetails is set, it calls getFeedsDetails() function 
		if the user wants to return all details from feeds table where feed_id = $_POST['feed']. 
		
	*/
	if(isset($_POST['getFeedsDetails'])){
		$feed = $_POST['feed']; 
		echo json_encode($db->getFeedsDetails($feed)); 
		/*localhost/phpork/gateway/feeds.php?getFeedsDetails=1&feed=1*/
	} 
	/*
		If getFeedTransDetails is set, it calls getFeedTransDetails() function 
		if the user wants to return all feed details from feed_transaction table where feed_id = $_POST['feed']. 
		
	*/
	if(isset($_GET['getFeedTransDetails'])){
		$feed = $_GET['feed']; 
		echo json_encode($db->getFeedTransDetails($feed)); 
		/*localhost/phpork/gateway/feeds.php?getFeedTransDetails=1&feed=1*/
	} 

	/*
		If getFeedReport is set, it calls getFeedReport() function 
		if the user wants to print a json file report of feed transaction.
		The user can choose if per batch,house,pen or pig. 
		
	*/
	if(isset($_POST['getFeedReport'])){
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
					
			$feeds = $db->getFeedReport($from,$to,$choice,$ar); 
			echo json_encode($feeds);
			

		}
		if (isset($_POST['housesel'])) {
			$choice = 'house';
			
			foreach ($_POST['housesel'] as $key) {
				$sparray = $db->ddl_pigperhouse($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$feeds = $db->getFeedReport($from,$to,$choice,$ar); 
			echo json_encode($feeds);
			

		}
		if (isset($_POST['pensel'])) {
			$choice = 'pen';
			
			foreach ($_POST['pensel'] as $key) {
				$sparray = $db->ddl_perpen($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$feeds = $db->getFeedReport($from,$to,$choice,$ar); 
			echo json_encode($feeds);
			

		}
		if (isset($_POST['pigsel'])) {
			$choice = 'pig';
			
			foreach ($_POST['pigsel'] as $key) {
				$sparray[] = $db->ddl_perpig($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
					
			$feeds = $db->getFeedReport($from,$to,$choice,$ar); 
			echo json_encode($feeds);
			

		}
		/*localhost/phpork2/gateway/meds.php?getMedsDetails=1&med=1*/
	}

	if(isset($_POST['getFeedsReportByFeed'])){
		//$medid = $_POST['med_id']; 
		$from = $_POST['from'];
		$to = $_POST['to'];
		$ar = array();
		//echo "hey2";
		if (isset($_POST['feedsel'])) {
			$choice = 'feed';
			
			foreach ($_POST['feedsel'] as $key) {
				$sparray[] = $db->ddl_feedRecord2($key);
				foreach ($sparray as $a ) {
					
					$ar[] = $a;

				}
			}
			//echo '<script>alert(JSON.stringify(ar));</script>';
					
			$feeds = $db->getFeedsReportByFeed($from,$to,$choice,$ar); 
			echo json_encode($feeds);
			
		}
	}  

	/*
		If getMaxFeedDate is set, it calls getMaxFeedDate() function 
		if the user wants to return the latest feed transaction date. 
		
	*/
	if(isset($_POST['getMaxFeedDate'])){
		echo json_encode($db->getMaxFeedDate()); 
		/*localhost/phpork2/gateway/meds.php?getMedsDetails=1&med=1*/
	} 

	/*
		If ddl_feeds is set, it calls ddl_feeds() function 
		if the user wants to return all feed names and its details from feeds table. 
		
	*/
	if(isset($_POST['ddl_feeds'])){
		$arr_feed = $db->ddl_feeds(); 
		echo json_encode($arr_feed);
		/*localhost/phpork/gateway/feeds.php?ddl_feeds=1*/
						
	}

	

	/*
		If ddl_feedRecord is set, it calls ddl_feedRecord() function 
		to print all feed details for viewing or editing. 
		
	*/
	if(isset($_POST['ddl_feedRecord'])){
		$pid = $_POST['pig']; 
		echo json_encode($db->ddl_feedRecord($pid)); 
		/*localhost/phpork/gateway/feeds.php?ddl_feedRecord=1&pig=1*/
	}

	/*
		If getLastFeed is set, it calls getLastFeed() function 
		to return the last feed transaction of a specific pig. 
		
	*/
	if(isset($_POST['getLastFeed'])){
		$pid = $_POST['pig']; 
		echo json_encode($db->getLastFeed($pid)); 
		
	} 

	/*
		If updateFeeds is set, it calls updateFeeds() function if the user edited
		some details in feeds table. 
		
	*/
	if(isset($_POST['updateFeeds'])){
		$fid = $_POST['fid']; 
		$ft_id = $_POST['ft_id']; 
		$user = $_POST['user']; 
		echo json_encode($db->updateFeeds($fid,$ft_id,$user)); 
		/*localhost/phpork2/gateway/meds.php?ddl_medRecord=1&pig=1*/
	} 
?>