<?php
	/* 
		Gateway between specific pages where admin details are needed and functions.php.
		This page calls all the functions needed in admin_home.php page and returns the result using json_encode.
	*/
	
	include "../inc/functions.php"; 
	
	$db = new phpork_functions (); 

	/*
		Calls addBreed() function if the user wants to add new breed name. 
		It also calls userTransactionEdit() function to record 
		that the user added new breed
	*/
	if(isset($_GET['addBreed'])){
		$bname = $_GET['breed_name'];
		echo json_encode($db->addBreed($bname)); 
		echo json_encode($db->userTransactionEdit($user, curdate(), curtime(), $add_id, 'breed', '-', $bname, '1')); 
		/*localhost/phpork/gateway/admin.php?addBreed=1&breed_name=Breed1*/
	}
	/*
		Calls addParent() function if the user wants to add a new parent. 
	*/ 
	if(isset($_GET['addParent'])){
		$lbl = $_GET['parent'];
		$lbl_id = $_GET['id'];
		echo json_encode($db->addParent($lbl,$lbl_id)); 
		/*localhost/phpork/gateway/admin.php?addParent=1&parent=boar&id=E34.921*/
	} 
	/*
		Calls addHouseName() function if the user wants to add new house.
	*/
	if(isset($_POST['addHouseName'])){
		$hno = $_POST['hno'];
		$hname = $_POST['hname'];
		$fxn = $_POST['fxn'];
		$loc_id = $_POST['loc'];
		$user = $_POST['user'];
		echo json_encode($db->addHouseName($hno,$hname,$fxn,$loc_id,$user)); 
		/*localhost/phpork2/gateway/house.php?addHouseName=1&hno=1&hname=House1&fxn=weaning&loc_id=3*/
	} 
	/*
		Calls addBreed() function if the user wants to add new location/farm. 
	*/
	if(isset($_POST['addLocationName'])){
		$lname = $_POST['lname'];
		$addr = $_POST['addr'];
		$user = $_POST['user'];
		echo json_encode($db->addLocationName($lname,$addr,$user)); 
		/*localhost/phpork2/gateway/location.php?addLocationName=1&lname=Farm4&addr=antipolo*/
	} 
	/*
		Calls addBreed() function if the user wants to add new pen.
	*/
	if(isset($_POST['addPenName'])){
		$penno = $_POST['penno'];
		$fxn = $_POST['fxn'];
		$h_id = $_POST['h_id'];
		$user = $_POST['user'];
		echo json_encode($db->addPenName($penno,$fxn,$h_id,$user)); 
		/*localhost/phpork2/gateway/pen.php?addPenName=1&penno=1&fxn=weaning&h_id=5*/
	} 

	/*
		If addFeedName is set, it calls addFeedName() function if the user wants to add new feed name. 
		
	*/
	if(isset($_POST['addFeedName'])){
		$fname = $_POST['fname'];
		$ftype = $_POST['ftype'];
		$user = $_POST['user'];
		echo json_encode($db->addFeedName($fname,$ftype,$user)); 
		/*localhost/phpork/gateway/feeds.php?addFeedName=1&fname=feed&ftype=feedtype*/
	} 

	/*
		Calls addMedName() function if the user wants to add new medicine.
	*/
	if(isset($_POST['addMedName'])){
		$mname = $_POST['mname'];
		$mtype = $_POST['mtype'];
		$user = $_POST['user'];
		echo json_encode($db->addMedName($mname,$mtype,$user)); 
		/*localhost/phpork2/gateway/meds.php?addMedName=1&mname=med&mtype=medtype*/
	} 
	/*
		Calls updateUser() function if the user edited 'user' table.
	 	It also calls userTransactionEdit() function to record 
		that the user made some changes in user table. 
	*/
	if(isset($_GET['editUser'])){
		$user = $_POST['user'];
		$prev_uname = $_POST['prev_uname'];
		$new_uname = $_POST['username'];
		$user_id = $_POST['user_id'];
		/*$pw = $_POST['password'];*/
		$password = base64_encode($_POST['password']);
		$prev_pword =  $_POST['prev_pword'];
		$user_type = $_POST['usertype'];
		$prev_utype = $_POST['prev_utype'];
		$user_id = $_POST['user_id'];
		/*$prev_pw_input = $_POST['pw_prev_input'];*/
		$enc_prev_input_pw = base64_encode($_POST['pw_prev_input']);
		
		
		if(!empty($new_uname) && !empty($user_type) && !empty($password)){ /* edited all */
			echo json_encode($db->userTransactionEdit($user,$user_id, 'username', $prev_uname, $new_uname, 2,0));
			echo json_encode($db->userTransactionEdit($user,$user_id, 'usertype', $prev_utype, $user_type, 2,0));
			if(empty($_POST['pw_prev_input'])){
				echo json_encode("error");
			}elseif($prev_pword != $enc_prev_input_pw){
				echo json_encode("wrong");
			}else{
				echo json_encode($db->updateUser($new_uname,$password,$user_type, $user_id));
				echo json_encode($db->userTransactionEdit($user,$user_id, 'password', $prev_pword, $password, 2,0));
			}
			
		}elseif(empty($new_uname) && empty($user_type) && !empty($password) && $prev_pword != $password){
			/* edited password */
			if(empty($_POST['pw_prev_input'])){
				echo json_encode("error");
			}elseif($prev_pword != $enc_prev_input_pw){
				echo json_encode("wrong");
			}else{
				echo json_encode($db->userTransactionEdit($user,$user_id, 'password', $prev_pword, $password, 2,0));
				echo json_encode($db->updateUser($prev_uname,$password,$prev_utype, $user_id));
			}
		}elseif(!empty($new_uname) && empty($user_type) && empty($password) && $prev_uname!=$new_uname){
			/* edited username */
			echo json_encode($db->userTransactionEdit($user,$user_id, 'username', $prev_uname, $new_uname, 2,0));
			echo json_encode($db->updateUser($new_uname,$prev_pword,$prev_utype, $user_id));
		}elseif(empty($new_uname) && !empty($user_type) && empty($password) && $prev_utype!=$user_type){
			/* edited user type */
			echo json_encode($db->userTransactionEdit($user,$user_id, 'usertype', $prev_utype, $user_type, 2,0));
			echo json_encode($db->updateUser($prev_uname,$prev_pword,$user_type, $user_id));
		}elseif(!empty($new_uname) && !empty($user_type) && empty($password) && $prev_utype!=$user_type && $prev_uname!=$new_uname){
			/* edited username and user type */
			echo json_encode($db->userTransactionEdit($user,$user_id, 'username', $prev_uname, $new_uname, 2,0));
			echo json_encode($db->userTransactionEdit($user,$user_id, 'usertype', $prev_utype, $user_type, 2,0));
			echo json_encode($db->updateUser($new_uname,$prev_pword,$user_type, $user_id));
		}elseif(!empty($new_uname) && empty($user_type) && !empty($password) && $prev_uname!=$new_uname){
			/* edited username and password */
			if(empty($_POST['pw_prev_input'])){
				echo json_encode("error");
			}elseif($prev_pword != $enc_prev_input_pw){
				echo json_encode("wrong");
			}else{
				echo json_encode($db->userTransactionEdit($user,$user_id, 'password', $prev_pword, $password, 2,0));
				echo json_encode($db->userTransactionEdit($user,$user_id, 'username', $prev_uname, $new_uname, 2,0));
				echo json_encode($db->updateUser($new_uname,$password,$prev_utype, $user_id));
			
			}
			
		}elseif(empty($new_uname) && !empty($user_type) && !empty($password) && $prev_utype!=$user_type){
			/* edited user type and password */
			if(empty($_POST['pw_prev_input'])){
				echo json_encode("error");
			}elseif($prev_pword != $enc_prev_input_pw){
				echo json_encode("wrong");
			}else{
				echo json_encode($db->userTransactionEdit($user,$user_id, 'password', $prev_pword, $password, 2,0));
				echo json_encode($db->userTransactionEdit($user,$user_id, 'usertype', $prev_utype, $user_type, 2,0));
				echo json_encode($db->updateUser($prev_uname,$password,$user_type, $user_id));
			}
			
		}else{
			echo json_encode("%%%failure%%%");
		}
		
	/*localhost/phpork/gateway/admin.php?addBreed=1&breed_name=Breed1*/
	}
	/*
		Calls updateBreed() function if the user edited 'breed' table. 
		It also calls userTransactionEdit() function to record 
		that the user made some changes in 'breed' table. 
	*/
	if(isset($_POST['editBreed'])){
	$user = $_POST['user'];
	$prev_bname = $_POST['prev_bname'];
	$bname = $_POST['breed_name'];
	$edit_id = $_POST['breed_id'];
	if(!empty($bname) && $prev_bname != $bname){
		echo json_encode($db->userTransactionEdit($user, $edit_id, 'breed', $prev_bname, $bname, '2'));
		echo json_encode($db->updateBreed($bname,$edit_id));	
	}else
		echo json_encode("empty");
	
	/*localhost/phpork/gateway/admin.php?addBreed=1&breed_name=Breed1*/
	}
	/*
		Calls updateParent() function if the user edited 'parent' table. 
		It also calls userTransactionEdit() function to record
		that the user made some changes in 'parent' table.
	 */
	if(isset($_POST['editParent'])){
		$user = $_POST['user'];
		$prev_lbl = $_POST['prev_parent'];
		$lbl = $_POST['parent'];
		$prev_lbl_id = $_POST['prev_id'];
		$lbl_id = $_POST['id'];
		$parent_id = $_POST['parent_id'];
		if (!empty($lbl) && empty($lbl_id) && $prev_lbl != $lbl) {
			/*edit label name*/
			echo json_encode($db->userTransactionEdit($user, $parent_id, 'parent', $prev_lbl, $lbl, '2'));	
			echo json_encode($db->updateParent($parent_id, $lbl, $prev_lbl_id)); 

		}else if(empty($lbl) && !empty($lbl_id) && $prev_lbl_id != $lbl_id) {
			/*edit label id*/
			echo json_encode($db->userTransactionEdit($user, $parent_id, 'parent', $prev_lbl_id, $lbl_id, '2'));	
			echo json_encode($db->updateParent($parent_id, $prev_lbl, $lbl_id)); 

		}else if(!empty($lbl) && !empty($lbl_id) && $prev_lbl != $lbl && $prev_lbl_id != $lbl_id) {
			/*edit label id and name*/
			echo json_encode($db->userTransactionEdit($user, $parent_id, 'parent', $prev_lbl, $lbl, '2'));	
			echo json_encode($db->userTransactionEdit($user, $parent_id, 'parent', $prev_lbl_id, $lbl_id, '2'));	
			echo json_encode($db->updateParent($parent_id, $lbl, $lbl_id)); 

		}else{
			echo json_encode("empty");
		}
		
		
		
		/*localhost/phpork/gateway/admin.php?addParent=1&parent=boar&id=E34.921*/
	} 
	/*
		Calls updateHouse() function if the user edited 'house' table. 
		It also calls userTransactionEdit() function to record 
		that the user made some changes in 'house' table. 
	*/
	if(isset($_POST['editHouseName'])){
		$user = $_POST['user'];
		$prev_hno = $_POST['prev_hno'];
		$hno = $_POST['hno'];
		$prev_hname = $_POST['prev_hname'];
		$hname = $_POST['hname'];
		$prev_fxn = $_POST['prev_fxn'];
		$fxn = $_POST['fxn'];
		$houseid = $_POST['house_id'];
		$loc_id = $_POST['loc'];
		if(!empty($hno) && empty($hname) && empty($fxn) && $prev_hno != $hno){ 
			/*edited house number*/
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_hno, $hno, '2'));
			echo json_encode($db->updateHouse($houseid, $hno, $prev_hname, $loc_id, $prev_fxn));

		}elseif (empty($hno) && !empty($hname) && empty($fxn) && $prev_hname != $hname) {	
			/*edited house name*/
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_hname, $hname, '2'));
			echo json_encode($db->updateHouse($houseid, $prev_hno, $hname, $loc_id, $prev_fxn));

		}elseif (empty($hno) && empty($hname) && !empty($fxn) && $prev_fxn != $fxn) {	
			/*edited house's function*/
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_fxn, $fxn, '2'));
			echo json_encode($db->updateHouse($houseid, $prev_hno, $prev_hname, $loc_id, $fxn));
		}elseif (!empty($hno) && !empty($hname) && empty($fxn) && $prev_hname != $hname && $prev_hno != $hno) {	
			/*edited house number and name*/
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_hno, $hno, '2'));
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_hname, $hname, '2'));
			echo json_encode($db->updateHouse($houseid, $hno, $hname, $loc_id, $prev_fxn));
		}elseif (!empty($hno) && empty($hname) && !empty($fxn) && $prev_hno != $hno && $prev_fxn != $fxn) {
			/*edited house's function and number*/
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_hno, $hno, '2'));
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_fxn, $fxn, '2'));
			echo json_encode($db->updateHouse($houseid, $hno, $prev_hname, $loc_id, $fxn));
		}elseif (empty($hno) && !empty($hname) && !empty($fxn) && $prev_hname != $hname && $prev_fxn != $fxn)  {
			/*edited house's function and name*/
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_hname, $hname, '2'));
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_fxn, $fxn, '2'));
			echo json_encode($db->updateHouse($houseid, $prev_hno, $hname, $loc_id, $fxn));
		}elseif(!empty($hno) && !empty($hname) && !empty($fxn) && $prev_hname != $hname && $prev_hno != $hno && $prev_fxn != $fxn){
			/*edited house's function, name and number.*/
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_hno, $hno, '2'));
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_hname, $hname, '2'));
			echo json_encode($db->userTransactionEdit($user, $houseid, 'house', $prev_fxn, $fxn, '2'));
			echo json_encode($db->updateHouse($houseid, $hno, $hname, $loc_id, $fxn));

		}else{
			echo json_encode("empty");

		}
		
		
		/*localhost/phpork2/gateway/house.php?addHouseName=1&hno=1&hname=House1&fxn=weaning&loc_id=3*/
	} 
	/*
		Calls updateLocation() function if the user edited 'location' table. 
		It also calls userTransactionEdit() function to record 
		that the user made some changes in 'location' table. 
	*/
	if(isset($_POST['editLocationName'])){
		$user = $_POST['user'];
		$prev_lname = $_POST['prev_lname'];
		$lname = $_POST['lname'];
		$prev_addr = $_POST['prev_addr'];
		$addr = $_POST['addr'];
		$loc_id = $_POST['loc_id'];
		if(empty($lname) && !empty($addr) && $prev_addr != $addr){
			/*edited location's address*/
			echo json_encode($db->userTransactionEdit($user,$loc_id, 'farm', $prev_addr, $addr, '2'));
			echo json_encode($db->updateLocation($loc_id, $prev_lname, $addr));
		}elseif (!empty($lname) && empty($addr) && $prev_lname != $lname) {
			/*edited location's name*/
			echo json_encode($db->userTransactionEdit($user,$loc_id, 'farm', $prev_lname, $lname, '2'));
			echo json_encode($db->updateLocation($loc_id, $lname, $prev_addr));
		}elseif(!empty($lname) && !empty($addr) && $prev_lname != $lname && $prev_addr != $addr){
			/*edited all*/
			echo json_encode($db->userTransactionEdit($user,$loc_id, 'farm', $prev_lname, $lname, '2'));
			echo json_encode($db->userTransactionEdit($user,$loc_id, 'farm', $prev_addr, $addr, '2'));
			echo json_encode($db->updateLocation($loc_id, $lname, $addr));
		}else{
			echo json_encode("empty");
		}
		
		
		
		/*localhost/phpork2/gateway/location.php?addLocationName=1&lname=Farm4&addr=antipolo*/
	} 
	/*
		Calls updatePen() function if the user edited 'pen' table. 
		It also calls userTransactionEdit() function to record 
		that the user made some changes in 'pen' table. 
	*/
	if(isset($_POST['editPenName'])){
		$user = $_POST['user'];
		$prev_penno = $_POST['prev_penno'];
		$penno = $_POST['penno'];
		$prev_fxn = $_POST['prev_fxn'];
		$fxn = $_POST['fxn'];
		$pen_id = $_POST['pen_id'];
		if(!empty($penno) && empty($fxn) && $prev_penno != $penno){
			/*edit pen number*/
			echo json_encode($db->userTransactionEdit($user, $pen_id, 'pen', $prev_penno, $penno, '2'));
			echo json_encode($db->updatePen($pen_id, $penno, $prev_fxn));

		}elseif (empty($penno) && !empty($fxn) && $prev_fxn != $fxn) {
			/*edit pen fucntion*/
			echo json_encode($db->userTransactionEdit($user, $pen_id, 'pen', $prev_fxn, $fxn, '2'));
			echo json_encode($db->updatePen($pen_id, $prev_penno, $fxn));

		}elseif (!empty($penno) && !empty($fxn) && $prev_fxn != $fxn && $prev_penno != $penno) {
			/*edit pen number and function*/
			echo json_encode($db->userTransactionEdit($user, $pen_id, 'pen', $prev_fxn, $fxn, '2'));
			echo json_encode($db->userTransactionEdit($user, $pen_id, 'pen', $prev_penno, $penno, '2'));
			echo json_encode($db->updatePen($pen_id, $penno, $fxn));

		}else{
			echo json_encode("empty");
		}
		
		
		/*localhost/phpork2/gateway/pen.php?addPenName=1&penno=1&fxn=weaning&h_id=5*/
	} 
	/*
		Calls updateFeedName() function if the user edited 'feeds' table. 
		It also calls userTransactionEdit() function to record 
		that the user made some changes in 'feeds' table. 
	*/
	if(isset($_POST['editFeedName'])){
		$user = $_POST['user'];
		$prev_fname = $_POST['prev_fname'];
		$fname = $_POST['fname'];
		$prev_ftype = $_POST['prev_ftype'];
		$ftype = $_POST['ftype'];
		$feed_id = $_POST['feed_id'];
		if (!empty($fname) && empty($ftype) && $prev_fname != $fname) {
			/*edit feed name*/
			echo json_encode($db->userTransactionEdit($user,$feed_id, 'feed name', $prev_fname, $fname, '2',0));
			echo json_encode($db->updateFeedName($feed_id, $fname, $prev_ftype));

		}elseif(empty($fname) && !empty($ftype) && $prev_ftype != $ftype) {
			/*edit feed type*/
			echo json_encode($db->userTransactionEdit($user,$feed_id, 'feed name', $prev_ftype, $ftype, '2',0));
			echo json_encode($db->updateFeedName($feed_id, $prev_fname, $ftype));

		}elseif(!empty($fname) && !empty($ftype) && $prev_fname != $fname && $prev_ftype != $ftype) {
			/*edit feed name and type*/
			echo json_encode($db->userTransactionEdit($user,$feed_id, 'feed name', $prev_fname, $fname, '2',0));
			echo json_encode($db->userTransactionEdit($user,$feed_id, 'feed name', $prev_ftype, $ftype, '2',0));
			echo json_encode($db->updateFeedName($feed_id, $fname, $ftype));
		}else{
			echo json_encode("empty");
		}
		
		
		
		/*localhost/phpork2/gateway/feeds.php?addFeedName=1&fname=feed&ftype=feedtype*/
	} 
	/*
		Calls updateMedication() function if the user edited 'medication' table. 
		It also calls userTransactionEdit() function to record 
		that the user made some changes in 'medication' table. 
	*/
	if(isset($_POST['editMedName'])){
		$user = $_POST['user'];
		$prev_mname = $_POST['prev_mname'];
		$mname = $_POST['mname'];
		$prev_mtype = $_POST['prev_mtype'];
		$mtype = $_POST['mtype'];
		$med_id = $_POST['med_id'];
		if(!empty($mname) && empty($mtype) && $prev_mname != $mname){
			/*edit med name*/
			echo json_encode($db->userTransactionEdit($user,$med_id, 'medication name', $prev_mname, $mname, '2'));
			echo json_encode($db->updateMedication($med_id, $mname, $prev_mtype)); 		

		}elseif(empty($mname) && !empty($mtype) && $prev_mtype != $mtype){
			/*edit med type*/
			echo json_encode($db->userTransactionEdit($user,$med_id, 'medication name', $prev_mtype, $mtype, '2'));	
			echo json_encode($db->updateMedication($med_id, $prev_mname, $mtype)); 

		}elseif(!empty($mname) && !empty($mtype) && $prev_mname != $mname && $prev_mtype != $mtype){
			/*edit med name and type*/
			echo json_encode($db->userTransactionEdit($user,$med_id, 'medication name', $prev_mname, $mname, '2'));
			echo json_encode($db->userTransactionEdit($user,$med_id, 'medication name', $prev_mtype, $mtype, '2'));
			echo json_encode($db->updateMedication($med_id, $mname, $mtype)); 

		}else{
			echo json_encode("empty");
		}
		/*localhost/phpork2/gateway/meds.php?addMedName=1&mname=med&mtype=medtype*/
	}
	
	
?>