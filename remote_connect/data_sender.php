<?php

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// URL (change localhost to server IP)
// $url = "http://111.125.77.247/phpork/remote_connect/data_receiver.php";
$url = "localhost/phpork/android_connect/data_receiver.php";

// json response array
$response = array();

// things to update
$dataIDs = array();

// get data from required tables
$weight_record = $db->getNewWeightRecords();
$users = $db->getNewUsers();
$locs = $db->getNewLocs();
$houses = $db->getNewHouses();
$pens = $db->getNewPens();
$breeds = $db->getNewBreeds();
$parents = $db->getNewParents();
$pigs = $db->getNewPigs();
$tags = $db->getNewTags();
$feeds = $db->getNewFeeds();
$feed_transaction = $db->getNewFT();
$meds = $db->getNewMeds();
$med_records = $db->getNewMedRecords();
$movement = $db->getNewMovements();
$user_transaction = $db->getNewUserTransaction();

$wr_size = count($weight_record);
$u_size = count($users);
$l_size = count($locs);
$h_size = count($houses);
$p_size = count($pens);
$br_size = count($breeds);
$pa_size = count($parents);
$pg_size = count($pigs);
$t_size = count($tags);
$f_size = count($feeds);
$ft_size = count($feed_transaction);
$m_size = count($meds);
$mr_size = count($med_records);
$move_size = count($movement);
$ut_size = count($user_transaction);
   
$response["user"] = array();
$response["location"] = array();
$response["house"] = array();
$response["pen"] = array();
$response["pig_breeds"] = array();
$response["parents"] = array();
$response["pig"] = array();
$response["rfid_tags"] = array();
$response["feeds"] = array();
$response["feed_transaction"] = array();
$response["medication"] = array();
$response["med_record"] = array();
$response["weight_record"] = array();
$response["movement"] = array();
$response["user_transaction"] = array();

$dataIDs["user"] = array();
$dataIDs["location"] = array();
$dataIDs["house"] = array();
$dataIDs["pen"] = array();
$dataIDs["pig_breeds"] = array();
$dataIDs["parents"] = array();
$dataIDs["pig"] = array();
$dataIDs["rfid_tags"] = array();
$dataIDs["feeds"] = array();
$dataIDs["feed_transaction"] = array();
$dataIDs["medication"] = array();
$dataIDs["med_record"] = array();
$dataIDs["weight_record"] = array();
$dataIDs["movement"] = array();
$dataIDs["user_transaction"] = array();

for($i = 0;$i < $u_size;$i++) {
	$resp = array();
	$resp["user_name"] = $users[$i][1];
	$resp["password"] = $users[$i][2];
	$resp["user_type"] = $users[$i][3];

	array_push($response["user"], $resp);
	array_push($dataIDs["user"], $users[$i][0]);
}

for($i = 0;$i < $l_size;$i++) {
	$resp = array();
	$resp["loc_name"] = $locs[$i][1];
	$resp["address"] = $locs[$i][2];

	array_push($response["location"], $resp);
	array_push($dataIDs["location"], $locs[$i][0]);
}

for($i = 0;$i < $h_size;$i++) {
	$resp = array();
	$resp["house_no"] = $houses[$i][1];
	$resp["house_name"] = $houses[$i][2];
	$resp["function"] = $houses[$i][3];
	$resp["loc_id"] = $houses[$i][4];

	array_push($response["house"], $resp);
	array_push($dataIDs["house"], $houses[$i][0]);
}

for($i = 0;$i < $p_size;$i++) {
	$resp = array();
	$resp["pen_no"] = $pens[$i][1];
	$resp["function"] = $pens[$i][2];
	$resp["house_id"] = $pens[$i][3];

	array_push($response["pen"], $resp);
	array_push($dataIDs["pen"], $pens[$i][0]);
}

for($i = 0;$i < $br_size;$i++) {
	$resp = array();
	$resp["breed_name"] = $breeds[$i][1];

	array_push($response["pig_breeds"], $resp);
	array_push($dataIDs["pig_breeds"], $breeds[$i][0]);
}

for($i = 0;$i < $pa_size;$i++) {
	$resp = array();
	$resp["label"] = $parents[$i][1];
	$resp["label_id"] = $parents[$i][2];

	array_push($response["parents"], $resp);
	array_push($dataIDs["parents"], $parents[$i][0]);
}


for($i = 0;$i < $pg_size;$i++) {
	$resp = array();
	$resp["pig_id"] = $pigs[$i][0];
	$resp["boar_id"] = $pigs[$i][1];
	$resp["sow_id"] = $pigs[$i][2];
	$resp["foster_sow"] = $pigs[$i][3];
	$resp["week_farrowed"] = $pigs[$i][4];
	$resp["gender"] = $pigs[$i][5];
	$resp["farrowing_date"] = $pigs[$i][6];
	$resp["pig_status"] = $pigs[$i][7];
	$resp["pen_id"] = $pigs[$i][8];
	$resp["breed_id"] = $pigs[$i][9];
	$resp["user"] = $pigs[$i][10];

	array_push($response["pig"], $resp);
	array_push($dataIDs["pig"], $pigs[$i][0]);
}

for($i = 0;$i < $t_size;$i++)
{
	$resp = array();
	$resp["tag_rfid"] = $tags[$i][1];
	$resp["pig_id"] = $tags[$i][2];
	$resp["label"] = $tags[$i][3];
	$resp["status"] = $tags[$i][4];

	array_push($response["rfid_tags"], $resp);
	array_push($dataIDs["rfid_tags"], $tags[$i][0]);
}

for($i = 0;$i < $f_size;$i++)
{
	$resp = array();
	$resp["feed_name"] = $feeds[$i][1];
	$resp["feed_type"] = $feeds[$i][2];		

	array_push($response["feeds"], $resp);
	array_push($dataIDs["feeds"], $feeds[$i][0]);
}

for($i = 0;$i < $ft_size;$i++)
{
	$resp = array();
	$resp["quantity"] = $feed_transaction[$i][1];
	$resp["unit"] = $feed_transaction[$i][2];
	$resp["date_given"] = $feed_transaction[$i][3];
	$resp["time_given"] = $feed_transaction[$i][4];
	$resp["pig_id"] = $feed_transaction[$i][5];
	$resp["feed_id"] = $feed_transaction[$i][6];
	$resp["prod_date"] = $feed_transaction[$i][7];

	array_push($response["feed_transaction"], $resp);
	array_push($dataIDs["feed_transaction"], $feed_transaction[$i][0]);
}

for($i = 0;$i < $m_size;$i++)
{
	$resp = array();
	$resp["med_name"] = $meds[$i][1];
	$resp["med_type"] = $meds[$i][2];

	array_push($response["medication"], $resp);
	array_push($dataIDs["medication"], $meds[$i][0]);
}

for($i = 0;$i < $mr_size;$i++)
{
	$resp = array();
	$resp["date_given"] = $med_records[$i][1];
	$resp["time_given"] = $med_records[$i][2];
	$resp["quantity"] = $med_records[$i][3];
	$resp["unit"] = $med_records[$i][4];
	$resp["pig_id"] = $med_records[$i][5];
	$resp["med_id"] = $med_records[$i][6];
	
	array_push($response["med_record"], $resp);
	array_push($dataIDs["med_record"], $med_records[$i][0]);
}

for($i = 0;$i < $wr_size;$i++)
{
	$resp = array();
	$resp["record_date"] = $weight_record[$i][1];
	$resp["record_time"] = $weight_record[$i][2];
	$resp["weight"] = $weight_record[$i][3];
	$resp["pig_id"] = $weight_record[$i][4];
	$resp["remarks"] = $weight_record[$i][5];

	array_push($response["weight_record"], $resp);
	array_push($dataIDs["weight_record"], $weight_record[$i][0]);
}

for($i = 0;$i < $move_size;$i++)
{
	$resp = array();
	$resp["date_moved"] = $movement[$i][1];
	$resp["time_moved"] = $movement[$i][2];
	$resp["pen_id"] = $movement[$i][3];
	$resp["server_date"] = $movement[$i][4];
	$resp["server_time"] = $movement[$i][5];
	$resp["pig_id"] = $movement[$i][6];

	array_push($response["movement"], $resp);
	array_push($dataIDs["movement"], $movement[$i][0]);
}

for($i = 0;$i < $ut_size;$i++)
{
	$resp = array();
	$resp["user_id"] = $user_transaction[$i][1];
	$resp["date_edited"] = $user_transaction[$i][2];
	$resp["id_edited"] = $user_transaction[$i][3];
	$resp["type_edited"] = $user_transaction[$i][4];
	$resp["prev_value"] = $user_transaction[$i][5];
	$resp["curr_value"] = $user_transaction[$i][6];
	$resp["pig_id"] = $user_transaction[$i][7];
	$resp["flag"] = $user_transaction[$i][8];

	array_push($response["user_transaction"], $resp);
	array_push($dataIDs["user_transaction"], $user_transaction[$i][0]);
}


//Encode the array into JSON.
$json = json_encode($response);

//Initiate cURL.
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url); 

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1 ); 
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $json); 
 
//Set the content type to application/json 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($json))                                                                       
);

// return output for error checking   
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                                                                          

//Execute the request
$result = curl_exec($ch);

// check for errors
if (curl_errno($ch)) { 
   print curl_error($ch); 
}

// close curl handle
curl_close ($ch);

// display response
$response = json_decode($result, true);

if($response["error"]) {
   echo $response["error_message"];
} else {

	for($i = 0; $i < count($dataIDs['user']);$i++){
		$id = $dataIDs['user'][$i];

		$db->updateUserSync($id);
	}

	for($i = 0; $i < count($dataIDs['location']);$i++){
		$id = $dataIDs['location'][$i];

		$db->updateLocSync($id);
	}

	for($i = 0; $i < count($dataIDs['house']);$i++){
		$id = $dataIDs['house'][$i];

		$db->updateHouseSync($id);
	}

	for($i = 0; $i < count($dataIDs['pen']);$i++){
		$id = $dataIDs['pen'][$i];

		$db->updatePenSync($id);
	}

	for($i = 0; $i < count($dataIDs['pig_breeds']);$i++){
		$id = $dataIDs['pig_breeds'][$i];

		$db->updateBreedSync($id);
	}

	for($i = 0; $i < count($dataIDs['parents']);$i++){
		$id = $dataIDs['parents'][$i];

		$db->updateParentSync($id);
	}

	for($i = 0; $i < count($dataIDs['pig']);$i++){
		$id = $dataIDs['pig'][$i];

		$db->updatePigSync($id);
	}

	for($i = 0; $i < count($dataIDs['rfid_tags']);$i++){
		$id = $dataIDs['rfid_tags'][$i];

		$db->updateTagSync($id);
	}

	for($i = 0; $i < count($dataIDs['feeds']);$i++){
		$id = $dataIDs['feeds'][$i];

		$db->updateFeedSync($id);
	}

	for($i = 0; $i < count($dataIDs['feed_transaction']);$i++){
		$id = $dataIDs['feed_transaction'][$i];

		$db->updateFTSync($id);
	}

	for($i = 0; $i < count($dataIDs['movement']);$i++){
		$id = $dataIDs['movement'][$i];

		$db->updateMovementSync($id);
	}

	for($i = 0; $i < count($dataIDs['medication']);$i++){
		$id = $dataIDs['medication'][$i];

		$db->updateMedSync($id);
	}

	for($i = 0; $i < count($dataIDs['med_record']);$i++){
		$id = $dataIDs['med_record'][$i];

		$db->updateMedRecSync($id);
	}

	for($i = 0; $i < count($dataIDs['weight_record']);$i++){
		$id = $dataIDs['weight_record'][$i];

		$db->updateWeightSync($id);
	}

	for($i = 0; $i < count($dataIDs['user_transaction']);$i++){
		$id = $dataIDs['user_transaction'][$i];

		$db->updateUserTransSync($id);
	}
	
	echo "Successfully updated.";
}

?>