<?php
error_reporting(E_ALL); ini_set('display_errors', 1);

require_once 'include/DB_Functions.php';

$db = new DB_Functions();

$response = array();

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
	$response["error"] = TRUE;
	$response["error_message"] = "Request method must be POST!";
} else {
	
	//Make sure that the content type of the POST request has been set to application/json
	$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
	if(strcasecmp($contentType, 'application/json') != 0) {
		$response["error"] = TRUE;
		$response["error_message"] = "Content type must be: application/json";
	} else {
		
		//Receive the RAW post data.
		file_put_contents('test_2.txt', file_get_contents('php://input'));

		$content = file_get_contents("php://input");

		//Attempt to decode the incoming RAW post data from JSON.
		$array = json_decode($content, true);
		 
		//If json_decode failed, the JSON is invalid.
		if(!is_array($array)) {
			$response["error"] = TRUE;
			$response["error_message"] = "Received content contained invalid JSON!";
		} else {

		// if(!empty($array)){

			$response["error"] = FALSE;
			
			for($i = 0; $i < count($array['user']);$i++) {
				$user_name = $array['user'][$i]['user_name'];
				$password = $array['user'][$i]['password'];
				$user_type = $array['user'][$i]['user_type'];

				$db->addUsers($user_name, $password, $user_type);
			}

			for($i = 0; $i < count($array['location']);$i++) {
				$loc_name = $array['location'][$i]['loc_name'];
				$address = $array['location'][$i]['address'];

				$db->addLocations($loc_name, $address);
			}

			for($i = 0; $i < count($array['house']);$i++) {
				$house_no = $array['house'][$i]['house_no'];
				$house_name = $array['house'][$i]['house_name'];
				$function = $array['house'][$i]['function'];
				$loc_id = $array['house'][$i]['loc_id'];

				$db->addHouses($loc_name, $address);
			}

			for($i = 0; $i < count($array['pen']);$i++) {
				$pen_no = $array['pen'][$i]['pen_no'];
				$function = $array['pen'][$i]['function'];
				$house_id = $array['pen'][$i]['house_id'];

				$db->addPens($pen_no, $function, $house_id);
			}

			for($i = 0; $i < count($array['pig_breeds']);$i++) {
				$breed_name = $array['pig_breeds'][$i]['breed_name'];	

				$db->addBreeds($pig_breeds);
			}

			for($i = 0; $i < count($array['parents']);$i++) {
				$label = $array['parents'][$i]['label'];
				$label_id = $array['parents'][$i]['label_id'];		

				$db->addParents($label, $label_id);
			}

			for($i = 0; $i < count($array['feeds']);$i++) {
				$feed_name = $array['feeds'][$i]['feed_name'];
				$feed_type = $array['feeds'][$i]['feed_type'];

				$db->addFeeds($feed_name, $feed_type);
			}

			for($i = 0; $i < count($array['medication']);$i++) {
				$med_name = $array['medication'][$i]['med_name'];
				$med_type = $array['medication'][$i]['med_type'];

				$db->addMeds($med_name, $med_type);
			}

			for($i = 0; $i < count($array['rfid_tags']);$i++) {
				$tag_rfid = $array['rfid_tags'][$i]['tag_rfid'];
				$pig_id = $array['rfid_tags'][$i]['pig_id'];
				$label = $array['rfid_tags'][$i]['label'];
				$status = $array['rfid_tags'][$i]['status'];

				$db->addRFIDTags($tag_rfid, $pig_id, $label, $status);
			}


			for($i = 0; $i < count($array['pig']);$i++) {
				$pig_id = $array['pig'][$i]['pig_id'];
				$boar_id = $array['pig'][$i]['boar_id'];
				$sow_id = $array['pig'][$i]['sow_id'];
				$foster_sow = $array['pig'][$i]['foster_sow'];
				$week_farrowed = $array['pig'][$i]['week_farrowed'];
				$gender = $array['pig'][$i]['gender'];
				$farrowing_date = $array['pig'][$i]['farrowing_date'];
				$pig_status = $array['pig'][$i]['pig_status'];
				$pen_id = $array['pig'][$i]['pen_id'];
				$breed_id = $array['pig'][$i]['breed_id'];
				$user = $array['pig'][$i]['user'];

				$db->addPigs($pig_id, $boar_id, $sow_id, $foster_sow, $week_farrowed, $gender,
					$farrowing_date, $pig_status, $pen_id, $breed_id, $user);
			}

			for($i = 0; $i < count($array['weight_record']);$i++) {	
				$record_date = $array['weight_record'][$i]['record_date'];
				$record_time = $array['weight_record'][$i]['record_time'];
				$weight = $array['weight_record'][$i]['weight'];
				$pig_id = $array['weight_record'][$i]['pig_id'];
				$remarks = $array['weight_record'][$i]['remarks'];

				$db->addWeightRecord($record_date, $record_time, $weight, $pig_id, $remarks);
			} 

			for($i = 0; $i < count($array['feed_transaction']);$i++) {
				$quantity = $array['feed_transaction'][$i]['quantity'];
				$unit = $array['feed_transaction'][$i]['unit'];
				$date_given = $array['feed_transaction'][$i]['date_given'];
				$time_given = $array['feed_transaction'][$i]['time_given'];
				$pig_id = $array['feed_transaction'][$i]['pig_id'];
				$feed_id = $array['feed_transaction'][$i]['feed_id'];
				$prod_date = $array['feed_transaction'][$i]['prod_date'];

				$db->addFeedsTransact($quantity, $unit, $date_given, $time_given, $pig_id, $feed_id, $prod_date);
			}
			
			for($i = 0; $i < count($array['med_record']);$i++) {
				$date_given = $array['med_record'][$i]['date_given'];
				$time_given = $array['med_record'][$i]['time_given'];
				$quantity = $array['med_record'][$i]['quantity'];
				$unit = $array['med_record'][$i]['unit'];
				$pig_id = $array['med_record'][$i]['pig_id'];
				$med_id = $array['med_record'][$i]['med_id'];

				$db->addMedRecord($date_given, $time_given, $quantity, $unit, $pig_id, $med_id);
			}

			for($i = 0; $i < count($array['user_transaction']);$i++) {
				$user_id = $array['user_transaction'][$i]['user_id'];
				$date_edited = $array['user_transaction'][$i]['date_edited'];
				$id_edited = $array['user_transaction'][$i]['id_edited'];
				$type_edited = $array['user_transaction'][$i]['type_edited'];
				$prev_value = $array['user_transaction'][$i]['prev_value'];
				$curr_value = $array['user_transaction'][$i]['curr_value'];
				$pig_id = $array['user_transaction'][$i]['pig_id'];
				$flag = $array['user_transaction'][$i]['flag'];

				$db->addUserTransactions($user_id, $date_edited, $id_edited, $type_edited, $prev_value, $curr_value, $pig_id, $flag);
			}

			for($i = 0; $i < count($array['movement']);$i++) {
				$date_moved = $array['movement'][$i]['date_moved'];
				$time_moved = $array['movement'][$i]['time_moved'];
				$pen_id = $array['movement'][$i]['pen_id'];
				$server_date = $array['movement'][$i]['server_date'];
				$server_time = $array['movement'][$i]['server_time'];
				$pig_id = $array['movement'][$i]['pig_id'];

				$db->addMovements($date_moved, $time_moved, $pen_id, $server_date, $server_time, $pig_id);
			}
		}
	}	 
}
 
echo json_encode($response);
?>
