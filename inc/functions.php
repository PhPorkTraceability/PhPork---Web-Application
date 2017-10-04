
<?php
	require_once ('../inc/dbinfo.inc');

	class phpork_functions

	{

		public function connect() {
			/* 
				This function connects the web application to database.
			*/
			$link = mysqli_connect ( HOSTNAME, USERNAME, PASSWORD, DATABASE ) or die ( 'Could not connect: ' . mysqli_error () );
			mysqli_select_db ( $link, DATABASE ) or die ( 'Could not select database' . mysql_error () );
			return $link;
		}
	 	public function login($username,$password){
	 		/* 
				This function checks if username and password exist in user table.
			*/
		    $link = $this->connect();
		    $login = mysqli_real_escape_string($link,$username);
		    $pword = mysqli_real_escape_string($link,$password);
		    $query = "SELECT user_id,user_name FROM user WHERE user_name = '$login' AND password = '".$pword."' LIMIT 1";
		    $result = mysqli_query ( $link, $query );
		    if(mysqli_num_rows($result) == 1){
		      while ( $row = mysqli_fetch_row ( $result ) ) {
		        $lid = $row[0];

		        session_start();
		        session_regenerate_id(TRUE);
		        $_SESSION['userid'] = $row[0];
		        $_SESSION['uname'] = $row[1];
		      }
		     
		      return true;
		    }else{
		      return false;
		    }
	  	}
	  	public function signup($username,$password,$usertype,$user)
		{
				/* 
					This function inserts new user in user table.
					It also inserts that the user added new user in user_transaction table.
				*/
				$link = $this->connect();
				$q = "SELECT max(user_id)
					FROM user";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO user(user_id,user_name,password,user_type) 
						VALUES('" . $max . "','" . $username . "','" . $password . "','" . $usertype . "');";
				if ($result = mysqli_query( $link, $query )) {
		      		$data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
		      		$this->userTransactionEdit($user,$max,"user",0,$username,1,0);
			    }else {
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}
		public function getUser($user_id)
		{
			/* 
				This function returns details of a specific user.
			*/
				$link = $this->connect();
				$query = "SELECT user_id,
							user_name, 
							user_type,
							password 
						FROM user
						WHERE user_id = '" .$user_id. "'";
				$result = mysqli_query($link, $query) or die(mysqli_error($link));
				$userDetails = array();
				$arr_user = array();
				while ($row = mysqli_fetch_row($result)) {
						$userDetails['user_id'] = $row[0];
						$userDetails['user_name'] = $row[1];
						$userDetails['user_type'] = $row[2];
						$userDetails['password'] = $row[3];
						$arr_user[] = $userDetails;
				}

				return $arr_user;
		}

		public function updateUser($username,$password,$usertype, $user_id)
		{
			/* 
				This function updates user table.
				If usertype is 1, user is an admin, else if usertype is 2, user is an encoder, else if usertype is 5, user is not an employee.
			*/
				$link = $this->connect();
				$query = "UPDATE user 
							set user_name = '" .$username. "', 
								password = '" . $password . "', 
								user_type = '" . $usertype . "'
						WHERE user_id = '" . $user_id. "'";
				$result = mysqli_query($link, $query);
		}

		public function userTransactionEdit($user,$edit_id, $edit_type, $prev_val, $curr_val, $flag,$pig)
		{
			/* 
				This function inserts added or edited transactions in user_transaction table.
				If flag is 1, user added new data else if flag is 2, user edited some details of the data.
			*/
				$link = $this->connect();
				
				$query = "INSERT INTO user_transaction(user_id,id_edited,type_edited,prev_value,curr_value,pig_id,flag) 
							values('" . $user . "','" . $edit_id . "','" . $edit_type . "','" . $prev_val . "','" . $curr_val . "','". $pig . "','". $flag . "');";
				print $query;
				$result = mysqli_query($link, $query);
				
			    
			   
		}
		public function ddl_user()
	    {
	    	/* 
				This function returns all user_id,user_name,user_type and password in user table.
			*/
	        $link     = $this->connect();
	        $search   = "SELECT user_id,user_name,user_type,password FROM user";
	        $resultq  = mysqli_query($link, $search);
	        $usr    = array();
	        $usrArr = array();
	        while ($row = mysqli_fetch_row($resultq)) {
	            $usr['user_id']   = $row[0];
	            $usr['username'] = $row[1];
	            $usr['user_type']   = $row[2];
	            $usr['password'] = $row[3];
	            $usrArr[]      = $usr;
	        }
	        return $usrArr;
	    }
		

	  	/* Location functions*/
	  	public function addLocationName($lname,$addr,$user)
		{
			/* 
				This function inserts new location name in location table.
				It also inserts that the user added new loaction name in user_transaction table.
			*/
				$link = $this->connect();
				
				$query = "INSERT INTO location(loc_name,address) 
						VALUES('" . $lname . "','" . $addr . "');";
				$q = "SELECT max(loc_id)
					FROM location";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				if ($result = mysqli_query( $link, $query )) {
			      	$data = array("success"=>"true",
			                    "newId"=>$link->insert_id);
		      		$this->userTransactionEdit($user,$max,"location",0,$lname,1,0);
			    }else{
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}
	  	public function ddl_location()
		{
			/* 
				This function ireturns all location details from location table.
			*/
				$link = $this->connect();
				$query = "SELECT loc_name, 
							loc_id,
							address 
						FROM location";
				$result = mysqli_query($link, $query) or die(mysqli_error($link));
				$loc = array();
				$arr_loc = array();
				while ($row = mysqli_fetch_row($result)) {
						$loc['loc_name'] = $row[0];
						$loc['loc_id'] = $row[1];
						$loc['address'] = $row[2];
						$arr_loc[] = $loc;
				}

				return $arr_loc;
		}
		public function getLocDetails($loc_id)
		{
			/* 
				This function returns location details of a specific location id.
			*/
				$link = $this->connect();
				$query = "SELECT l.loc_name, 
							l.loc_id,
							l.address
						FROM location l 
						where l.loc_id = '".$loc_id."'
						LIMIT 1";
				$result = mysqli_query($link, $query) or die(mysqli_error($link));
				$loc = array();
				$arr_loc = array();
				while ($row = mysqli_fetch_row($result)) {
						$loc['loc_name'] = $row[0];
						$loc['loc_id'] = $row[1];
						$loc['address'] = $row[2];
						$arr_loc[] = $loc;
				}

				return $arr_loc;
		}
		
		public function getHousePenByLoc($loc)
		{
			/* 
				This function returns pen and house details of a specific location id.
			*/
				$link = $this->connect();
				$search = "SELECT a.pen_id, 
								a.pen_no, 
								b.house_no,
								b.house_id 
							FROM pen a 
								INNER JOIN house b 
									ON a.house_id = b.house_id 
								INNER JOIN location l 
									ON l.loc_id = b.loc_id 
							WHERE l.loc_id = '" . $loc . "'";
				$resultq = mysqli_query($link, $search);
				$houpen = array();
				$hp_arr = array();
				while ($row = mysqli_fetch_row($resultq)) {
						$houpen['pen_id'] = $row[0];
						$houpen['pen_no'] = $row[1];
						$houpen['house_no'] = $row[2];
						$houpen['house_id'] = $row[3];
						$hp_arr[] = $houpen;
				}

				return $hp_arr;
		}

		public function updateLocation($loc_id, $loc_name, $addr)
		{
			/* 
				This function updates location table whenever the user edited some location details.
			*/
				$link = $this->connect();
				$query = "UPDATE location 
							set loc_name = '" .$loc_name. "',
								address = '" .$addr. "'
						WHERE loc_id = '" . $loc_id. "'";
				$result = mysqli_query($link, $query);

		}



		/* end of location functions*/

		/*    HOUSE FUNCTIONS  */
		public function addHouseName($hno, $hname,$fxn,$loc,$user)
		{
			/* 
				This function inserts new house name in house table.
				It also inserts new transaction that the user added new house name in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(house_id)
					FROM house";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO house(house_id,house_no,house_name,function,loc_id) 
						VALUES('" . $max . "','" . $hno . "','" . $hname . "','" . $fxn . "','" . $loc . "');";
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
		      		$this->userTransactionEdit($user,$max,"house",0,$hname,1,0);
			    }else {
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}
		public function ddl_house()
		{
			/* 
				This function returns all house details from house table.
			*/
			
				$link = $this->connect();
				$hquery = "SELECT house_id, 
								house_no, 
								house_name,
								function,
								loc_id
							FROM house";
				$hresult = mysqli_query($link, $hquery);
				$house = array();
				$arr_house = array();
				while ($row = mysqli_fetch_row($hresult)) {
						$house['h_id'] = $row[0];
						$house['h_no'] = $row[1];
						$house['h_name'] = $row[2];
						$house['fxn'] = $row[3];
						$house['loc_id'] = $row[4];
						$arr_house[] = $house;
				}

				return $arr_house;
		}
		public function getHouseByLoc($loc)
		{
			/* 
				This function returns house details of a specific location from house table.
			*/
			$link = $this->connect();
			$hquery = "SELECT house_id, 
							house_no, 
							house_name,
							function,
							loc_id
						FROM house 
						WHERE loc_id = '" . $loc . "'
						ORDER BY house_no ASC";
			$hresult = mysqli_query($link, $hquery);
			$house = array();
			$arr_house = array();
			while ($row = mysqli_fetch_row($hresult)) {
					$house['h_id'] = $row[0];
					$house['h_no'] = $row[1];
					$house['h_name'] = $row[2];
					$house['fxn'] = $row[3];
					$house['loc_id'] = $row[4];
					$arr_house[] = $house;
			}

			return $arr_house;
		
			
		}
		public function getHouseDetails($h_id)
		{
			/* 
				This function returns house details of a specific house id from house table.
			*/
			$link = $this->connect();
			$hquery = "SELECT house_id, 
							house_no, 
							house_name,
							function,
							loc_id
						FROM house 
						WHERE house_id = '" . $h_id . "'";
			$hresult = mysqli_query($link, $hquery);
			$house = array();
			$arr_house = array();
			while ($row = mysqli_fetch_row($hresult)) {
					$house['h_id'] = $row[0];
					$house['h_no'] = $row[1];
					$house['h_name'] = $row[2];
					$house['fxn'] = $row[3];
					$house['loc_id'] = $row[4];
					$arr_house[] = $house;
			}

			return $arr_house;
		
			
		}

		public function updateHouse($houseid, $houseno, $housename, $location, $fxn)
		{
			/* 
				This function updates house table whenever the user edited some house details.
			*/
				$link = $this->connect();
				$query = "UPDATE house 
							set house_name = '" .$housename. "',
								house_no = '" .$houseno. "',
								loc_id = '" .$location. "',
								function = '" .$fxn. "'
						WHERE house_id = '" . $houseid. "'";
				$result = mysqli_query($link, $query);
		}
		/*END OF HOUSE FUNCTIONS*/

		/*   PEN FUNCTIONS   */
		public function addPenName($penno,$fxn,$h_id,$user)
		{
			/* 
				This function inserts new pen name in pen table.
				It also inserts new transaction that the user added new pen name in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(pen_id)
					FROM pen";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO pen(pen_id,pen_no,function,house_id) 
						VALUES('" . $max . "','" . $penno . "','" . $fxn . "','" . $h_id . "');";
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
		      		 $this->userTransactionEdit($user,$max,"pen",0,$penno,1,0);
			    }else {
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}
		public function ddl_pen()
		{
			/* 
				This function returns all pen details from pen table.
			*/ 
				$link = $this->connect();
				$pquery = "SELECT pen_id, 
							pen_no,
							function,
							house_id 
						FROM pen";
				$presult = mysqli_query($link, $pquery);
				$pen = array();
				$arr_pen = array();
				while ($row = mysqli_fetch_row($presult)) {
						$pen['pen_no'] = $row[1];
						$pen['pen_id'] = $row[0];
						$pen['fxn'] = $row[2];
						$pen['h_id'] = $row[3];
						$arr_pen[] = $pen;
				}

				return $arr_pen;
		}
		public function ddl_notMortalityPen($house)
		{
			/* 
				This function returns pen details of a specific house except when function is equal to 'mortality'.
			*/
				$link = $this->connect();
				$pquery = "SELECT pen_id, 
							pen_no,
							function,
							house_id 
						FROM pen 
						WHERE house_id = '" . $house . "' and 
						function != 'mortality'
						ORDER BY pen_no ASC";
				$presult = mysqli_query($link, $pquery);
				$pen = array();
				$arr_pen = array();
				while ($row = mysqli_fetch_row($presult)) {
						$pen['pen_id'] = $row[0];
						$pen['pen_no'] = $row[1];
						$pen['fxn'] = $row[2];
						$pen['h_id'] = $row[3];
						$arr_pen[] = $pen;
				}

				return $arr_pen;
		}
		public function getPenByHouse($house)
		{
			/* 
				This function returns pen details of a specific house id.
			*/
				$link = $this->connect();
				$pquery = "SELECT pen_id, 
							pen_no,
							function,
							house_id
						FROM pen 
						WHERE house_id = '" . $house . "'";
				$presult = mysqli_query($link, $pquery);
				$pen = array();
				$arr_pen = array();
				while ($row = mysqli_fetch_row($presult)) {
						$pen['pen_no'] = $row[1];
						$pen['pen_id'] = $row[0];
						$pen['fxn'] = $row[2];
						$pen['h_id'] = $row[3];
						$arr_pen[] = $pen;
				}

				return $arr_pen;
		}
		public function getPenDetails($pen_id)
		{
			/* 
				This function returns pen details of a specific pen id.
			*/
				$link = $this->connect();
				$pquery = "SELECT p.pen_id, 
							p.pen_no,
							p.function,
							p.house_id,
							h.loc_id
						FROM pen p
						INNER JOIN house h on p.house_id = h.house_id 
						WHERE p.pen_id = '" . $pen_id . "'";
				$presult = mysqli_query($link, $pquery);
				$pen = array();
				$arr_pen = array();
				while ($row = mysqli_fetch_row($presult)) {
						$pen['pen_no'] = $row[1];
						$pen['pen_id'] = $row[0];
						$pen['fxn'] = $row[2];
						$pen['h_id'] = $row[3];
						$pen['loc_id'] = $row[4];
						$arr_pen[] = $pen;
				}

				return $arr_pen;
		}

		public function updatePen($penid, $penno, $fxn)
		{
			/* 
				This function updates pen table whenever the user edited some pen details.
			*/
				$link = $this->connect();
				$query = "UPDATE pen 
							set pen_no = '" .$penno. "',
								function = '" .$fxn. "'
						WHERE pen_id = '" . $penid. "'";
				$result = mysqli_query($link, $query);
		}
		/* END OF pen.php FUNCTIONS*/

		/* pig.php functions */
		
		

	  	public function addPig($pid, $pbdate, $pweekfar, $ppen, $pgender, $pbreed, $pboar, $psow, $pfoster,$pstatus, $user)
		{
			/* 
				This function inserts new pig in pig table.
				It also inserts new transaction that the user added new pig in user_transaction table.
			*/
			$handler = "";
			$valHandler = "";
			$link = $this->connect();
			if ($pboar != "null") {
					$handler = "boar_id,";
					$valHandler = "'" . $pboar . "',";
			}

			if ($psow != "null") {
					$handler = $handler . "sow_id,";
					$valHandler = $valHandler . "'" . $psow . "',";
			}

			if ($pfoster != "null") {
					$handler = $handler . "foster_sow,";
					$valHandler = $valHandler . "'" . $pfoster . "',";
			}

			

			$query=sprintf("INSERT INTO pig(pig_id," . $handler . "week_farrowed,gender,farrowing_date,pig_status,pen_id,breed_id,user,pig_batch) 
                    VALUES('" . mysqli_escape_string($link,$pid) . "'," . $valHandler . "'" . mysqli_escape_string($link,$pweekfar) . "','" . mysqli_escape_string($link,$pgender) . "','" . mysqli_escape_string($link,$pbdate) . "','" . mysqli_escape_string($link,$pstatus) . "','" . mysqli_escape_string($link,$ppen) . "','" . mysqli_escape_string($link,$pbreed) . "','" . mysqli_escape_string($link,$user) . "','-')");
		    if ($result = mysqli_query( $link, $query )) {
		      $data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
		    }else {
		      $data = array("success"=>"false",
		                      "error"=>mysqli_error($link));
		    }
		    $this->userTransactionEdit($user,0,"new pig",0,0,1,$pid);
		    return $data;
		}

		public function addPigWeight($pid, $pweight, $remarks)
		{
			/* 
				This function inserts new pig weight in weight_record table.
				It also inserts new transaction that the user added new pig weight in user_transaction table.
			*/
			$link = $this->connect();
			date_default_timezone_set("Asia/Manila");
			$d = date("Y-m-d");
			$t = date("h:i:s");
			$query = "INSERT INTO  weight_record(record_date,record_time,weight,pig_id,remarks) 
					VALUES ('" . $d . "','" . $t . "','" . $pweight . "','" . $pid . "','" . $remarks . "')";
			$this->userTransactionEdit($user,0,"weight",0,$pweight,1,$pid);
			$result = mysqli_query($link, $query);
		}
		  public function getPigDetails($pigid)
		  {
		  	/* 
				This function returns pig details of a specific pig id. It also writes the details in pig_details.json located in Desktop/reports/pig_details.
			*/
		    $link = $this->connect();
		    $query = "SELECT  p.pig_id,
			    			  pa.label_id,
			    			  par.label_id,
		                      p.foster_sow,
		                      p.week_farrowed,
		                      p.gender,
		                      p.farrowing_date,
		                      p.pig_status,
		                      p.pen_id,
		                      p.breed_id,
		                      p.user,
		                      p.pig_batch,
		                      h.house_id,
		                      l.loc_name,
		                      h.house_no,
		                      p.pen_id,
		                      pb.breed_name,
		                      rfid.tag_rfid,
		                      l.loc_id,
		                      rfid.label,
		                      rfid.tag_id
		              FROM pig p
		              INNER JOIN pen pe ON 
		              p.pen_id = pe.pen_id
		              INNER JOIN house h ON
		              pe.house_id = h.house_id
		              INNER join location l ON
		              h.loc_id = l.loc_id
		              INNER JOIN pig_breeds pb ON
		              p.breed_id = pb.breed_id
		              INNER JOIN rfid_tags rfid ON
		              rfid.pig_id = p.pig_id
		              INNER JOIN parents pa ON
		              (pa.parent_id = p.boar_id AND pa.label =\"boar\")
		             	 INNER JOIN parents par ON
		             	 (par.parent_id = p.sow_id AND par.label=\"sow\")
		             AND p.pig_id = '".$pigid."'
		              LIMIT 1";
		              
		    $result = mysqli_query($link, $query);
		   	$pig = array();
			$pig_arr = array();
			while ($row = mysqli_fetch_row($result))
		    {
		        $pig['pid'] = $row[0];
		        $pig['boar'] = $row[1];
		        $pig['sow'] = $row[2];
		        $pig['foster'] = $row[3];
		        $pig['week_far'] = $row[4];
		        $pig['gender'] = $row[5];
		        $pig['far_date'] = $row[6];
		        $pig['pig_stat'] = $row[7];
		        $pig['pen_id'] = $row[8];
		        $pig['breed_id'] = $row[9];
		        $pig['user'] = $row[10];
		        $pig['batch'] = $row[11];
		        $pig['h_id'] = $row[12];
		        $pig['loc_name'] = $row[13];
		        $pig['h_name'] = $row[14];
		        $pig['p_name'] = $row[15];
		        $pig['br_name'] = $row[16];
		        $pig['rfid_tag'] = $row[17];
		        $pig['loc_id'] = $row[18];
		        $pig['label'] = $row[19];
		        $pig['tag_id'] = $row[20];
		        $pig_arr[] = $pig;
		     }
		   
		   	$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\pig_details\\pig_details.json', 'w');
			fwrite($fp, json_encode($pig_arr));
			fclose($fp);
		    return $pig_arr;
		  }
	  	public function getPigLabel($pigid)
	    {
	    	/* 
				This function returns pig's rfid details from rfid_tags table of a specific pig.
			*/
	        $link   = $this->connect();
	        $query  = "SELECT label,
	        				tag_id,
	        				tag_rfid,
	        				pig_id,
	        				status 
        				FROM rfid_tags 
        				WHERE pig_id = '" . $pigid . "'";
	        $result = mysqli_query($link, $query);
	        $result = mysqli_query ( $link, $query );
		   	$pig = array();
			$pig_arr = array();
			while ($row = mysqli_fetch_row($result))
		    {
		        $pig['label'] = $row[0];
		        $pig['t_id'] = $row[1];
		        $pig['t_rfid'] = $row[2];
		        $pig['pig'] = $row[3];
		        $pig['stat'] = $row[4];
		        
		        $pig_arr[] = $pig;

		    }
		    return $pig_arr;
	    }
	    public function getinsertRFID($pigid)
		{
			/* 
				This function returns all pig labels with inactive rfid tags from rfid_tags table.
			*/
		    $link   = $this->connect();
		    $query  = "SELECT tag_rfid,
		                tag_id 
		                FROM rfid_tags 
		                WHERE label = '" . $pigid . "' and status = 'inactive'
		                LIMIT 1";
		    $result = mysqli_query($link, $query);
		    $row    = mysqli_fetch_row($result);
		    $r      = array();
		    $arr    = array();
		    $r['t_rfid']    = $row[0];
		    $r['t_id']    = $row[1];
		    $arr[] =$r;
		    return $arr;
		}
	  	public function getPigWeightDetails($pigid)
	  	{
	  		/* 
				This function returns latest weight details of a specific pig.
			*/
	     	$link    = $this->connect();
	        $query   = "SELECT max(record_date)
	                    FROM weight_record 
	                    WHERE pig_id = '" . $pigid . "' LIMIT 1";
	        $result  = mysqli_query($link, $query);
	        $row     = mysqli_fetch_row($result);
	        $query3   = "SELECT max(record_time)
	                    FROM weight_record 
	                    WHERE pig_id = '" . $pigid . "' and
	                    record_date = '".$row[0]."' LIMIT 1";
	        $result3  = mysqli_query($link, $query3);
	        $row3     = mysqli_fetch_row($result3);
	        $query2  = "SELECT weight,
	        				record_date,
	        				record_time,
	                        record_id,
	                        remarks 
	                    FROM weight_record 
	                    WHERE pig_id = '" . $pigid . "'
	                    AND record_date = '" . $row[0] . "' 
	                    and record_time = '" . $row3[0] . "' 
	                    LIMIT 1";
	        $result2 = mysqli_query($link, $query2);
	       	$data = array();
	       	$data2 = array();
	   	 	while($row2 =mysqli_fetch_row($result2))
		    {
		        $data['weight'] = $row2[0];
		        $data['record_date'] = $row2[1];
		        $data['record_time'] = $row2[2];
		        $data['record_id'] = $row2[3];
		        $data['remarks'] = $row2[4];
		        $data2[] = $data;
		    }
		   	
		    return $data2;
	  	}
	 	public function getPigFeedsDetails($pigid)
	 	{
	 		/* 
				This function returns feed transaction details of a specific pig.
			*/
		    $link = $this->connect();
		    $query = "SELECT ft.ft_id,
		    				ft.quantity,
		    				ft.unit,
		    				ft.date_given,
		    				ft.time_given,
		    				ft.feed_id,
		    				ft.prod_date,
		    				f.feed_name,
		    				f.feed_type
		              FROM feeds f
		              inner join feed_transaction ft 
		              	on f.feed_id = ft.feed_id
		              where ft.pig_id = '".$pigid."' LIMIT 1";
		              
	    	$result = mysqli_query ( $link, $query );
		   	$fname = array();
			$feeds = array();
			while ($row = mysqli_fetch_row($result)) {
					$fname['ft_id'] = $row[0];
					$fname['qty'] = $row[1];
					$fname['unit'] = $row[2];
					$fname['date'] = $row[3];
					$fname['time'] = $row[4];
					$fname['fid'] = $row[5];
					$fname['proddate'] = $row[6];
					$fname['fname'] = $row[7];
					$fname['ftype'] = $row[8];
					$feeds[] = $fname;
			}
			
			
			return $feeds;
	  	}
	   	public function getPigMedsDetails($pigid)
	   	{
	   		/* 
				This function returns medication transaction details of a specific pig.
			*/
		    $link = $this->connect();
		    $query = "SELECT mr.mr_id,
		    				mr.quantity,
		    				mr.unit,
		    				mr.date_given,
		    				mr.time_given,
		    				mr.med_id,
		    				m.med_name,
		    				m.med_type
		              FROM medication m
		              inner join med_record mr
		              	on m.med_id = mr.med_id
		              where mr.pig_id = '".$pigid."'
		              LIMIT 1";
		              
		    $result = mysqli_query ( $link, $query );
		   	$mname = array();
			$meds = array();
			while ($row = mysqli_fetch_row($result)) {
					$mname['mr_id'] = $row[0];
					$mname['qty'] = $row[1];
					$mname['unit'] = $row[2];
					$mname['date'] = $row[3];
					$mname['time'] = $row[4];
					$mname['mid'] = $row[5];
					$mname['mname'] = $row[6];
					$mname['mtype'] = $row[7];
					$meds[] = $mname;
			}
			
			return $meds;
	  	}
	  	 public function getCurrentHouse($pigid)
	    {
	    	/* 
				This function returns the current house of a specific pig.
			*/
	        $link   = $this->connect();
	        $query  = "SELECT h.house_no, p.pen_no 
	                    FROM pig pi 
	                        INNER JOIN pen p 
	                            ON p.pen_id = pi.pen_id 
	                        INNER JOIN house h 
	                            ON h.house_id = p.house_id 
	                        WHERE pi.pig_id = '" . $pigid . "'";
	        $result = mysqli_query($link, $query);
	      	$pig = array();
			$arr_pig = array();
			while ($row = mysqli_fetch_row($result)) {
						$pig['house'] = $row[0];
						$pig['pen'] = $row[1];
						$arr_pig[] = $pig;
				}

				return $arr_pig;
	    }
	  	public function getLastFeed($pigid)
	    {
	    	/* 
				This function returns last feed given to a specific pig.
			*/
	        $link   = $this->connect();
	        $query  = "SELECT f.feed_name, 
	                        f.feed_type, 
	                        ft.date_given
	                    FROM feeds f 
	                        INNER JOIN feed_transaction ft 
	                            ON ft.feed_id = f.feed_id 
	                   WHERE ft.time_given = (SELECT max(ft.time_given) from feed_transaction ft INNER JOIN feeds f ON f.feed_id = ft.feed_id WHERE ft.date_given = (SELECT max(ft.date_given) from feed_transaction ft INNER JOIN feeds f ON f.feed_id = ft.feed_id WHERE ft.pig_id ='$pigid'))
	                   AND ft.date_given = (SELECT max(ft.date_given) from feed_transaction ft INNER JOIN feeds f ON f.feed_id = ft.feed_id WHERE ft.pig_id = '$pigid')
	                   AND ft.pig_id =  $pigid";
	        $result = mysqli_query($link, $query);
	        $feeds = array();
			$arr_feeds = array();
			while ($row = mysqli_fetch_row($result)) {
						$feeds['feedname'] = $row[0];
						$feeds['feed_type'] = $row[1];
						$arr_feeds[] = $feeds;
				}

				return $arr_feeds;
	    }
	    public function getLastMed($pigid)
	    {
	    	/* 
				This function returns last medication given to a specific pig.
			*/
	        $link   = $this->connect();
	        $query  = "SELECT m.med_name, 
	                        m.med_type, 
	                        mr.date_given
	                    FROM medication m 
	                        INNER JOIN med_record mr 
	                            ON mr.med_id = m.med_id 
	                   WHERE mr.time_given = (SELECT max(mr.time_given) from med_record mr INNER JOIN medication m ON m.med_id = mr.med_id WHERE mr.date_given = (SELECT max(mr.date_given) from med_record mr INNER JOIN medication m ON m.med_id = mr.med_id WHERE mr.pig_id ='$pigid'))
	                   AND mr.date_given = (SELECT max(mr.date_given) from med_record mr INNER JOIN medication m ON m.med_id = mr.med_id WHERE mr.pig_id = '$pigid')
	                   AND mr.pig_id =  $pigid";
	        $result = mysqli_query($link, $query);
	       $med = array();
			$arr_med = array();
			while ($row = mysqli_fetch_row($result)) {
						$med['medname'] = $row[0];
						$med['med_type'] = $row[1];
						$arr_med[] = $med;
				}

				return $arr_med;
	    }
	 	public function getPigsByPen($pen)
	 	{
	 		/* 
				This function returns all details of pigs in a specific pen.
			*/
				$link = $this->connect();
				$pquery = "SELECT p.pig_id,
							rt.label 
						FROM pig p 
						INNER JOIN rfid_tags rt ON rt.pig_id = p.pig_id 
						WHERE p.pen_id = '" . $pen . "'
						ORDER BY p.pig_id ASC";
				$presult = mysqli_query($link, $pquery);
				$pig = array();
				$arr_pig = array();
				while ($row = mysqli_fetch_row($presult)) {
						$pig['pig_id'] = $row[0];
						$pig['lbl'] = $row[1];
						$arr_pig[] = $pig;
				}

				return $arr_pig;
		}

		public function ddl_pig()
		{
			/* 
				This function returns all pigs' details from pig table.
			*/
			$link = $this->connect();
			$query = "SELECT  p.pig_id,
		    				  p.boar_id,
		                      p.sow_id,
		                      p.foster_sow,
		                      p.week_farrowed,
		                      p.gender,
		                      p.farrowing_date,
		                      p.pig_status,
		                      p.pen_id,
		                      p.breed_id,
		                      p.user,
		                      p.pig_batch,
		                      h.house_id,
		                      l.loc_id
		              FROM pig p
		              INNER JOIN pen pe ON 
		              p.pen_id = pe.pen_id
		              INNER JOIN house h ON
		              pe.house_id = h.house_id
		              INNER join location l ON
		              h.loc_id = l.loc_id
		              ORDER BY p.pig_id ASC";
		              
		    $result = mysqli_query ( $link, $query );
		   	$pig = array();
			$pig_arr = array();
			while ($row = mysqli_fetch_row($result))
		    {
		        $pig['pid'] = $row[0];
		        $pig['boar'] = $row[1];
		        $pig['sow'] = $row[2];
		        $pig['foster'] = $row[3];
		        $pig['week_far'] = $row[4];
		        $pig['gender'] = $row[5];
		        $pig['far_date'] = $row[6];
		        $pig['pig_stat'] = $row[7];
		        $pig['pen_id'] = $row[8];
		        $pig['breed_id'] = $row[9];
		        $pig['user'] = $row[10];
		        $pig['batch'] = $row[11];
		        $pig['h_id'] = $row[12];
		        $pig['loc_id'] = $row[13];
		        $pig_arr[] = $pig;

		    }
		 
		    return $pig_arr;
		}

		public function addParent($label, $label_id,$user)
		{
			/* 
				This function inserts new parents in parents table.
				It also inserts new transaction that the user added new parents in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(parent_id)
					FROM parents";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO parents(parent_id,label,label_id) 
						VALUES('" . $max . "','" . $label . "','" . $label_id . "');";
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
	      			$this->userTransactionEdit($user,$max,"parent",0,$label,1,0);	
			    }else {
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}
		public function updateParent($parentid, $label, $label_id)
		{
			/* 
				This function updates parents table wheneve the user edited some parent details.
			*/
				$link = $this->connect();
				$query = "UPDATE parents 
							set label = '" .$label. "',
								label_id = '" .$label_id. "'
						WHERE parent_id = '" . $parentid. "'";
				$result = mysqli_query($link, $query);
		}
		public function addBreed($breed_name,$user)
		{
			/* 
				This function inserts new breed name in breed table.
				It also inserts new transaction that the user added new breed name in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(breed_id)
					FROM pig_breeds";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO pig_breeds(breed_id,breed_name) 
						VALUES('" . $max . "','" . $breed_name . "');";
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
	      			$this->userTransactionEdit($user,$max,"breed",0,$breed_name,1,0);
			    }else {
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}

		public function updateBreed($breedname, $breedid)
		{
			/* 
				This function updates breed table whenever the user edited some breed details.
			*/
				$link = $this->connect();
				$query = "UPDATE pig_breeds 
							set breed_name = '" .$breedname. "'
						WHERE breed_id = '" . $breedid. "'";
				$result = mysqli_query($link, $query);
		}
		
		public function ddl_parent($var)
		{
			/* 
				This function returns all sow details from parents table.
			*/
				$link = $this->connect();
				$search = "SELECT DISTINCT parent_id, label_id
							FROM parents where label='".$var."';";
				$resultq = mysqli_query($link, $search);
				$sow = array();
				$sow_arr = array();
				while ($row = mysqli_fetch_row($resultq)) {	
					$sow['parent_id'] =$row[0];
					$sow['label_id'] =$row[1];
					$sow_arr[] = $sow;
						
				}

				return $sow_arr;
		}
		

		public function ddl_parentdetails()
		{
			/* 
				This function returns all parent details from parents table.
			*/
				$link = $this->connect();
				$search = "SELECT DISTINCT parent_id, label_id, label
							FROM parents";
				$resultq = mysqli_query($link, $search);
				$sow = array();
				$sow_arr = array();
				while ($row = mysqli_fetch_row($resultq)) {	
					$sow['parent_id'] =$row[0];
					$sow['label_id'] =$row[1];
					$sow['label'] =$row[2];
					$fsow_arr[] = $sow;
						
				}

				return $fsow_arr;
		}
		public function getParentDetails($parent_id)
		{
			/* 
				This function returns details of a specific parent.
			*/
				$link = $this->connect();
				$search = "SELECT DISTINCT parent_id, label_id, label
							FROM parents WHERE parent_id = '" .$parent_id. "'";
				$resultq = mysqli_query($link, $search);
				$sow = array();
				$sow_arr = array();
				while ($row = mysqli_fetch_row($resultq)) {	
					$sow['parent_id'] =$row[0];
					$sow['label_id'] =$row[1];
					$sow['label'] =$row[2];
					$fsow_arr[] = $sow;
						
				}

				return $fsow_arr;
		}
		public function ddl_breeds()
	    {
	    	/* 
				This function returns all breed details.
			*/
	        $link     = $this->connect();
	        $search   = "SELECT breed_id,breed_name FROM pig_breeds";
	        $resultq  = mysqli_query($link, $search);
	        $breed    = array();
	        $breedArr = array();
	        while ($row = mysqli_fetch_row($resultq)) {
	            $breed['brid']   = $row[0];
	            $breed['brname'] = $row[1];
	            $breedArr[]      = $breed;
	        }
	        return $breedArr;
	    }
	   

		public function getBreed($br_id)
		{
			/* 
				This function returns details of a specific breed.
			*/
				$link = $this->connect();
				$query = "SELECT breed_id,breed_name
						FROM pig_breeds 
						where breed_id = '".$br_id."'";
				$result = mysqli_query($link, $query) or die(mysqli_error($link));
				$breed = array();
				$arr_breed = array();
				while ($row = mysqli_fetch_row($result)) {
						$breed['breed_id'] = $row[0];
						$breed['breed_name'] = $row[1];
						$arr_breed[] = $breed;
				}

				return $arr_breed;
		}
		


	    public function ddl_batch()
	    {
	    	/* 
				This function returns all batches of pigs.
			*/
	        $link     = $this->connect();
	        $search   = "SELECT DISTINCT pig_batch FROM pig";
	        $resultq  = mysqli_query($link, $search);
	        $batch    = array();
	        $batchArr = array();
	        while ($row = mysqli_fetch_row($resultq)) {
	            $batch['batch']   = $row[0];
	            $batchArr[]      = $batch;
	         }
	        return $batchArr;
	    }
		public function ddl_pigpen($pig, $pen, $house, $location)
	    {
	    	/* 
				This function returns all pigs inside a specific pen except from the pig id passed in the parameter.
			*/
	        $link     = $this->connect();
	        $query    = "SELECT rt.label, 
	                        p.pig_id 
	                    FROM  rfid_tags rt 
	                        INNER JOIN pig p 
	                            ON p.pig_id = rt.pig_id 
	                        INNER JOIN pen pe 
	                            ON pe.pen_id = p.pen_id 
	                        INNER JOIN house h 
	                            ON h.house_id = pe.house_id 
	                    WHERE p.pen_id  = '" . $pen . "'
	                    AND p.pig_id != $pig 
	                    AND h.house_id = $house";
	        $result   = mysqli_query($link, $query);
	        $info     = "info";
	        $ppen     = array();
	        $arr_ppen = array();
	        while ($row = mysqli_fetch_row($result)) {
	            $ppen['label'] = $row[0];
	            $ppen['pid']   = $row[1];
	            $arr_ppen[]    = $ppen;
	        }
	        return $arr_ppen;
	    }
	    public function ddl_pigpenall($pig, $pen, $house, $location)
	    {
	    	/* 
				This function returns all pig details inside a specific pen of a specific house.
			*/

	        $link     = $this->connect();
	        $query    = "SELECT rt.label, 
	                            p.pig_id 
	                    FROM  rfid_tags rt 
	                        INNER JOIN pig p 
	                            ON p.pig_id = rt.pig_id 
	                        INNER JOIN pen pe 
	                            ON pe.pen_id = p.pen_id 
	                        INNER JOIN house h 
	                            ON h.house_id = pe.house_id 
	                    WHERE p.pen_id  = '" . $pen . "'
	                    AND h.house_id = $house";
	        $result   = mysqli_query($link, $query);
	        $info     = "info";
	        $ppen     = array();
	        $arr_ppen = array();
	        while ($row = mysqli_fetch_row($result)) {
	            $ppen['label'] = $row[0];
	            $ppen['pid']   = $row[1];
	            $arr_ppen[]    = $ppen;
	        }
	        return $arr_ppen;
	    }
	    public function ddl_perpen($pen)
	    {
	    	/* 
				This function returns all pig ids inside a specifc pen.
			*/
	        $link     = $this->connect();
	        $query    = "SELECT 
	                        p.pig_id 
	                    FROM  pig p
	                    WHERE p.pen_id  = '" . $pen . "' ";
	        $result   = mysqli_query($link, $query);
	        $arr_ppen = array();
	        while ($row = mysqli_fetch_row($result)) {
	            $arr_ppen[]    = $row[0];

	        }
	        return $arr_ppen;
	    }
	    public function ddl_perpig($pig)
	    {
	    	/* 
				This function returns pig id of a specific pig.
			*/
	        $link     = $this->connect();
	        $query    = "SELECT 
	                        p.pig_id 
	                    FROM  pig p
	                    WHERE p.pig_id  = '" . $pig . "' ";
	        $result   = mysqli_query($link, $query);
	        $arr_ppig = array();
	        while ($row = mysqli_fetch_row($result)) {
	        	return $row[0];
	            

	        }
	    }
	     public function ddl_perbatch($batch)
	     {
	     	/* 
				This function returns all pig ids per batch.
			*/
	        $link     = $this->connect();
	        $query    = "SELECT 
	                        p.pig_id 
	                    FROM  pig p
	                    WHERE p.pig_batch = '" . $batch . "' ";
	        $result   = mysqli_query($link, $query);
	        $arr_ppen = array();
	        while ($row = mysqli_fetch_row($result)) {
	            $arr_ppen[]    = $row[0];

	        }
	        return $arr_ppen;
	    }
	    public function ddl_pigperhouse($house)
	    {
	    	/* 
				This function returns all pig ids per house.
			*/
	        $link     = $this->connect();
	        $query    = "SELECT 
	                        p.pig_id 
	                    FROM  pig p
	                    inner join pen pe on
	                    	pe.pen_id = p.pen_id
	                    inner join house h on 
	                    	h.house_id = pe.house_id
	                    WHERE h.house_id = '" . $house . "' ";
	        $result   = mysqli_query($link, $query);
	        $arr_ppen = array();
	        while ($row = mysqli_fetch_row($result)) {
	            $arr_ppen[]    = $row[0];

	        }
	        return $arr_ppen;
	    }
		public function updatepigRFID($pig_id, $rfid)
		{
			/* 
				This function updates the status of rfid tags to active of a specific pig id.
			*/
				$link = $this->connect();
				$query = "UPDATE rfid_tags 
							set status = 'active', 
								pig_id = " . $pig_id . ", 
								label = '" . $pig_id . "'
						WHERE tag_id = '" . $rfid . "'";
				$result = mysqli_query($link, $query);
				$this->userTransactionEdit($user,0,"rfid",0,$rfid,1,$pig_id);
		}
		public function updatePigDetails($pig_id, $user, $stat,$prev)
		{
			/* 
				This function updates the status of a specific pig. 
			*/
				$link = $this->connect();
				if ($stat == 'Dead') {
						$q = "SELECT h.house_id 
							FROM pig pi 
								INNER JOIN pen p 
									ON p.pen_id = pi.pen_id 
								INNER JOIN house h 
									ON h.house_id = p.house_id 
							WHERE pi.pig_id = '" . $pig_id . "'";
						$r = mysqli_query($link, $q);
						$row = mysqli_fetch_row($r);
						$q2 = "SELECT pen_id 
								from pen 
								where house_id=" . $row[0] . " 
								and function='mortality'";
						$r2 = mysqli_query($link, $q2);
						$row2 = mysqli_fetch_row($r2);
						$query = "UPDATE pig 
									set pig_status = '" . $stat . "', 
									pen_id = '" . $row2[0] . "', 
									user = '" . $user . "'
								WHERE pig_id = '" . $pig_id . "'";

				}
				else {
						$query = "UPDATE pig 
									set pig_status = '" . $stat . "', 
									user = '" . $user . "'
								WHERE pig_id = '" . $pig_id . "'";
				}
				if($stat!=$prev){
					$this->userTransactionEdit($user,0,"status",$prev,$stat,2,$pig_id);
				}
				

				$result = mysqli_query($link, $query);
		}
		public function updatePigWeight($pig_id,$prev, $weight, $record_id, $remarks,$prevremarks,$user)
		{
			/* 
				This function updates the weight of a specific pig.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				date_default_timezone_set("Asia/Manila");
				$d = date("Y-m-d");
				$t = date("h:i:s");
				$query = "UPDATE   weight_record
				set weight = '".$weight."',
				remarks = '".$remarks."'
				where record_id = '".$record_id."'";
				$result = mysqli_query($link, $query);
				if($weight!=$prev){
					$this->userTransactionEdit($user,0,"weight",$prev,$weight,2,$pig_id);
				}
				
				if($remarks!=$prevremarks){
					$this->userTransactionEdit($user,0,"weight type",$prevremarks,$remarks,2,$pig_id);
				}
		}
		public function updateWeekFar($user,$pig_id, $weekfar,$prev)
		{
			/* 
				This function updates the week farrowed of a specific pig.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$query = "UPDATE   pig
				set week_farrowed = '".$weekfar."'
				where pig_id = '".$pig_id."'";
				$result = mysqli_query($link, $query);
				if($weekfar!=$prev){
					$this->userTransactionEdit($user,0,"weekfar",$prev,$weekfar,2,$pig_id);
				}
		}
		public function updateRFIDdetails($pig_id, $rfid, $prevrfid, $plabel,$user)
		{
			/* 
				This function updates the status of previous rfid of pigs to lost and set the new one to active of a specific pig.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$query = "UPDATE rfid_tags 
						set status = 'lost', 
						pig_id = NULL, 
						label = '0'
						WHERE tag_id = '" . $prevrfid . "'";
				$result = mysqli_query($link, $query);
				$query = "UPDATE rfid_tags 
						set status = 'active', 
							pig_id = " . $pig_id . ", 
							label = '" . $plabel . "'
						WHERE tag_id = '" . $rfid . "'";
				$result = mysqli_query($link, $query);
				if($rfid!=$prevrfid){
					$this->userTransactionEdit($user,0,"rfid",$prevrfid,$rfid,2,$pig_id);	
				}
				
		}
		
		public function addWeight($dateWeighed, $timeWeighed, $weight, $weightType, $pigid, $user)
		{
			/* 
				This function inserts new weight of a specific pig.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(record_id)
					FROM weight_record";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO weight_record(record_date, record_time, weight, pig_id, remarks, user) 
							VALUES('" .$dateWeighed. "','" .$timeWeighed. "','" .$weight. "','" .$pigid. "','" .$weightType. "','" .$user. "');";
				
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
			        "newId"=> $link->insert_id);
			    }else {
			      $data = array("success"=>"false",
                  	"error"=>mysqli_error($link));
			    }
			    $this->userTransactionEdit($user,$max,"weight",0,$weight,1,$pigid);
			    return $data;
		}
		public function getPigWeight($pig)
		{
			/* 
				This function returns pig's weight details for the graph.
			*/
				$link = $this->connect();
				$query = "SELECT DISTINCT record_date,

							weight, 
							WEEK(record_date),
							record_time
						FROM weight_record 
						WHERE pig_id = '" . $pig . " '
						ORDER BY record_date ASC,record_time asc";
				$result = mysqli_query($link, $query);
				$dates = "";
				$weeks = "";
				$weights = "";
				$data = "";
				$data2 = 0;
				$arr = array();
				$ar_data = array();
				while ($row = mysqli_fetch_row($result)) {
						$ddate = $row[0];
						$wt = $row[1];
						$arr['color'] = '#83b26a';
						if($data2 > 0){
							if($data >= $wt){
								$arr['color'] = '#bb4230';

							}
						}
						
						$weekno = $row[2];
						$year = strtotime($ddate);
						$arr['year'] = date('F d,Y', $year);
						$dates = $ddate;
						$arr['week'] = $weekno;
						$arr['weight'] = $wt;
						$data = $wt;
						$ar_data[] = $arr;
						$data2++;
						
				}
				
				return $ar_data;
		}
		public function getWeightReport($from,$to,$choice,$sparray)
		{
			/* 
				This function returns weight details of pigs for printing reports.
				It saves the json file in Desktop under reports/weight_reports folder.
			*/
				$link = $this->connect();
				$w = array();
				$w_arr = array();
				foreach ($sparray as $var) {
					$query = " SELECT DISTINCT 
								wr.record_date,
								wr.record_time,
								wr.weight,
								wr.remarks,
								wr.pig_id
								FROM weight_record wr 
								INNER JOIN pig p on
									wr.pig_id = p.pig_id
								WHERE wr.pig_id = '" . $var . "' and
								wr.record_date BETWEEN '".$from."' and '".$to."'";
					$result = mysqli_query($link, $query);
					
					while($row = mysqli_fetch_row($result)){
						$w['Pig_id'] = $row[4];
						$date = date_create($row[0]);
						$w['Date_weighed'] = $date->format('F j,Y');
						$w['time_weighed'] = $row[1];
						$w['weight'] = $row[2];
						$w['remarks'] = $row[3];
						$w_arr[] = $w;
					}
				}
				/*	$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\weight_reports\\wtrans_details.json', 'w');
					fwrite($fp, json_encode($w_arr,JSON_PRETTY_PRINT));
					fclose($fp);
					return $w_arr;*/
				if($choice == 'batch'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\weight_reports\\wtrans_report_perbatch.json', 'w');
				}else if($choice == 'house'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\weight_reports\\wtrans_report_perhouse.json', 'w');
				}else if($choice == 'pen'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\weight_reports\\wtrans_report_perpen.json', 'w');
				}else if($choice == 'pig'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\weight_reports\\wtrans_report_perpig.json', 'w');
				}
				
				fwrite($fp, json_encode($w_arr,JSON_PRETTY_PRINT));
				fclose($fp);
				return $w_arr;
					
		}

			/* end of pig.php details */

		/*  med.php FUNCTIONS  */
		public function addMeds($mid, $mdate, $mtime, $pig,$qty,$unit,$user)
		{
			/* 
				This function inserts new medication intake of a specific pig.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(mr_id)
					FROM med_record";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO med_record(mr_id,date_given,time_given,quantity,unit,pig_id,med_id) 
							VALUES('" . $max . "','" . $mdate . "','" . $mtime . "','" . $qty . "','" . $unit . "','" . $pig . "','" . $mid . "');";
				$this->userTransactionEdit($user,$max,"medication",0,$mid,1,$pig);
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
			        "newId"=> $link->insert_id);
			    }else {
			      $data = array("success"=>"false",
                  	"error"=>mysqli_error($link));
			    }
			    return $data;
		}
		public function addMedName($mname, $mtype,$user)
		{
			/* 
				This function inserts new medicine name and type.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(med_id)
					FROM medication";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO medication(med_id,med_name,med_type) 
						VALUES('" . $max . "','" . $mname . "','" . $mtype . "');";
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
		      		$this->userTransactionEdit($user,$max,"medication name",0,$mname,1,0);
			    }else {
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}
		public function getMedsDetails($var)
		{
			/* 
				This function returns medicine details.
			*/
				$link = $this->connect();
				$query = " SELECT DISTINCT med_id,
							med_type,
							med_name
							FROM medication 
							WHERE med_id = '" . $var . "'";
				$result = mysqli_query($link, $query);
				$m = array();
				$m_arr = array();
				while($row = mysqli_fetch_row($result)){
					$m['mid'] = $row[0];
					$m['mtype'] = $row[1];
					$m['mname'] = $row[2];
					$m_arr[] = $m;
				}
				
				
				return $m_arr;
				
		}
		
		public function getMaxMedDate()
		{
			/* 
				This function returns latest medication date given to a pig.
				
			*/
				$link = $this->connect();
				$query = " SELECT max(date_given)
							FROM med_record";
				$result = mysqli_query($link, $query);
				$m = array();
				$m_arr = array();
				while($row = mysqli_fetch_row($result)){
					$m['mdate'] = $row[0];
					$m_arr[] = $m;
				}
				
				
				return $m_arr;
				
		}
		public function getMedsTransDetails($var)
		{
			/* 
				This function returns all medication details of a specific medicine.
			*/
				$link = $this->connect();
				$query = " SELECT DISTINCT mr.mr_id,
							mr.date_given,
							mr.time_given,
							mr.quantity,
							mr.unit,
							mr.pig_id,
							mr.med_id,
							m.med_name,
							m.med_type
							FROM med_record mr 
							INNER JOIN medication m on
								mr.med_id = m.med_id
							WHERE mr.med_id = '" . $var . "'";
				$result = mysqli_query($link, $query);
				$m = array();
				$m_arr = array();
				while($row = mysqli_fetch_row($result)){
					$m['mr_id'] = $row[0];
					$date = date_create($row[1]);
					$m['d_given'] = $date->format('F j,Y');
					$m['t_given'] = $row[2];
					$m['qty'] = $row[3];
					$m['unit'] = $row[4];
					$m['pid'] = $row[5];
					$m['m_id'] = $row[6];
					$m['fname'] = $row[7];
					$m['ftype'] = $row[8];
					$m_arr[] = $m;
				}
				
				
				return $m_arr;
				
		}
		public function getMedsReport($from,$to,$choice,$sparray)
		{
			/* 
				This function returns medicine details for printing report.
				Details are saved in a json file located in Desktop/reports/medication_reports folder.
			*/
				$link = $this->connect();
				$m_arr = array();
				foreach ($sparray as $var ) {
					$query = " SELECT DISTINCT 
								mr.date_given,
								mr.time_given,
								mr.quantity,
								mr.unit,
								mr.pig_id,
								mr.med_id,
								m.med_name,
								m.med_type
								FROM med_record mr 
								INNER JOIN medication m on
									mr.med_id = m.med_id
								WHERE mr.pig_id = '" . $var . "' and
								mr.date_given BETWEEN '".$from."' and '".$to."'";
					$result = mysqli_query($link, $query);
					$m = array();
					
					while($row = mysqli_fetch_row($result)){
						$m['Pig_id'] = $row[4];
						$date = date_create($row[0]);
						$m['Date_given'] = $date->format('F j,Y');
						$m['Time_given'] = $row[1];
						$m['Quantity'] = $row[2];
						$m['Unit'] = $row[3];
						$m['Feed_name'] = $row[6];
						$m['Feed_type'] = $row[7];
						$m_arr[] = $m;
					}
				}
				
				if($choice == 'batch'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\medication_reports\\mtrans_details_perbatch.json', 'w');
				}else if($choice == 'house'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\medication_reports\\mtrans_details_perhouse.json', 'w');
				}else if($choice == 'pen'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\medication_reports\\mtrans_details_perpen.json', 'w');
				}else if($choice == 'pig'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\medication_reports\\mtrans_details_perpig.json', 'w');
				}
				fwrite($fp, json_encode($m_arr,JSON_PRETTY_PRINT));
				fclose($fp);
				return $m_arr;
				
		}
		public function getMedsReportByMedication($from,$to,$choice,$sparray)
		{
			/* 
				This function returns medicine details for printing report.
				Details are saved in a json file located in Desktop/reports/medication_reports folder.
			*/
				$link = $this->connect();
				$m_arr = array();
				foreach ($sparray as $var ) {
					$query = " SELECT DISTINCT
								mr.pig_id,
								mr.med_id,
								m.med_name,
								m.med_type
								FROM med_record mr 
								INNER JOIN medication m on
									mr.med_id = m.med_id
								WHERE mr.med_id = '" . $var . "' and
								mr.date_given BETWEEN '".$from."' and '".$to."'";
					$result = mysqli_query($link, $query);
					$result2 = mysqli_query($link, $query);
					$m = array();
					//echo 'hey2';
					//console.log("HEY");
					$n = array();
					
					/*while($row = mysqli_fetch_row($result)){
						$m[]= $row[0];
					}*/
					while($row = mysqli_fetch_row($result)){
						
						$m['Med_Name'] = $row[2];
						//while($row3 = array_values($m)){
						$m['Pig_id'] = $row[0];
						
						//}
						$m_arr[] = $m;
					}
					
					
				}
				
				if($choice == 'med'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\medication_reports\\mtrans_details_permedication.json', 'w');
				}
				fwrite($fp, json_encode($m_arr,JSON_PRETTY_PRINT));
				fclose($fp);
				return $m_arr;
				
		}
		public function updateMeds($med_id, $mrid, $user)
		{
			/* 
				This function updates medicine details.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$query2 = "SELECT med_id,pig_id FROM med_record WHERE mr_id='" . $mrid . "'";
				$result2 = mysqli_query($link, $query2);
				$row = mysqli_fetch_row($result2);
				$query = "UPDATE med_record set med_id = '" . $med_id . "'WHERE mr_id = '" . $mrid . "'";
				$result = mysqli_query($link, $query);
				if ($result) {
						//$this->insertMedEditHistory($row[0], $user, $mrid);
						$this->userTransactionEdit($user,$mrid,"medication",$row[0],$med_id,2,$row[1]);
						return array(
								'success' => '1'
						);
				}
				else {
						return array(
								'success' => '0'
						);
				}

				echo "<script>alert('Successfully updated!');</script>";
		}
		 public function ddl_meds()
		{
			/* 
				This function returns all medicine names and types.
			*/
				$link = $this->connect();
				$query = "SELECT med_id, 
							med_name,
							med_type 
						FROM medication";
				$result = mysqli_query($link, $query) or die(mysqli_error($link));
				$meds = array();
				$arr_med = array();
				while ($row = mysqli_fetch_row($result)) {
						$meds['med_id'] = $row[0];
						$meds['med_name'] = $row[1];
						$meds['med_type'] = $row[2];
						$arr_med[] = $meds;
				}

				return $arr_med;
		}
		
		public function ddl_medRecord($pig)
	    {
	    	/* 
				This function returns all medication intake details of a specific pig.
			*/
	        $link      = $this->connect();
	        $query     = "SELECT m.med_name, 
	                            m.med_type, 
	                            mr.mr_id, 
	                            mr.date_given,
	                            mr.quantity,
	                            mr.unit
	                    FROM medication m 
	                        INNER JOIN med_record mr 
	                            ON mr.med_id = m.med_id 
	                    WHERE mr.pig_id = '" . $pig . "'
	                     order by mr.date_given DESC";
	        $result    = mysqli_query($link, $query);
	        $mrcrd     = array();
	        $arr_mrcrd = array();
	        while ($row = mysqli_fetch_row($result)) {
	            $mrcrd['mname']      = $row[0];
	            $mrcrd['mtype']      = $row[1];
	            $mrcrd['mrid']       = $row[2];
	            $date                = date('F d, Y', strtotime($row[3]));
	            $mrcrd['date_given'] = $date;
	            $mrcrd['qty'] = $row[4]." ".$row[5];
	            $arr_mrcrd[]         = $mrcrd;
	        }
	        return $arr_mrcrd;
	    }
	    public function ddl_medRecord2($med_id)
	    {
	    	/* 
				This function returns a specific medicine.
			*/
	        $link      = $this->connect();
	        $query     = "SELECT DISTINCT 
	        					mr.med_id
	                    FROM medication mr 
	                    WHERE mr.med_id = '" . $med_id . "' ";
	        $result    = mysqli_query($link, $query);
	        $mrcrd     = array();
	        $arr_mrcrd = array();

	        while ($row = mysqli_fetch_row($result)) {
	        	return $row[0];
	            

	        }
	    }
	    public function updateMedication($medid, $medName, $medType)
		{
			/* 
				This function updates medication table when the user edited some details.
			*/
				$link = $this->connect();
				$query = "UPDATE medication 
							set med_name = '" .$medName. "',
								med_type = '" .$medType. "'
						WHERE med_id = '" . $medid. "'";
				$result = mysqli_query($link, $query);
		}

		/* end of meds.php FUNCTIONS*/


		/*  feeds.php FUNCTIONS  */
		public function addFeeds($fid, $fdate, $ftime, $pig, $proddate,$qty,$user)
		{
			/* 
				This function inserts new feed intake details of a specific pig.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(ft_id)
					FROM feed_transaction";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO feed_transaction(ft_id,quantity,unit,date_given,time_given,pig_id,feed_id,prod_date) 
						VALUES('" . $max . "','" . $qty . "','kg','" . $fdate . "','" . $ftime . "','" . $pig . "','" . $fid . "','" . $proddate . "');";
				$this->userTransactionEdit($user,$max,"feeds",0,$fid,1,$pig);
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
			    }else {
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}
		public function addFeedName($fname, $ftype,$user)
		{
			/* 
				This function inserts new feed details.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$q = "SELECT max(feed_id)
					FROM feeds";
				$r = mysqli_query($link, $q);
				$ro = mysqli_fetch_row($r);
				$max = $ro[0] + 1;
				$query = "INSERT INTO feeds(feed_id,feed_name,feed_type) 
						VALUES('" . $max . "','" . $fname . "','" . $ftype . "');";
				if ($result = mysqli_query( $link, $query )) {
		      	$data = array("success"=>"true",
		                    "newId"=> $link->insert_id);
		      		$this->userTransactionEdit($user,$max,"feed name",0,$fname,1,0);
			    }else {
			      $data = array("success"=>"false",
			                      "error"=>mysqli_error($link));
			    }
			    return $data;
		}
		public function getFeedsDetails($var)
		{
			/* 
				This function returns all feed details from feeds table.
				
			*/
				$link = $this->connect();
				$query = " SELECT DISTINCT feed_id,
							feed_type,
							feed_name
							FROM feeds 
							WHERE feed_id = '" . $var . "'";
				$result = mysqli_query($link, $query);
				$f = array();
				$f_arr = array();
				while($row = mysqli_fetch_row($result)){
					$f['fid'] = $row[0];
					$f['ftype'] = $row[1];
					$f['fname'] = $row[2];
					$f_arr[] = $f;
				}
				
				

				return $f_arr;
				
		}
		public function getMaxFeedDate()
		{
			/* 
				This function returns latest date of feed intake in feed_transaction table.
			*/
				$link = $this->connect();
				$query = " SELECT max(date_given)
							FROM feed_transaction";
				$result = mysqli_query($link, $query);
				$f = array();
				$f_arr = array();
				while($row = mysqli_fetch_row($result)){
					$f['fdate'] = $row[0];
					$f_arr[] = $f;
				}
				
				

				return $f_arr;
				
		}
		public function getFeedTransDetails($var)
		{
			/* 
				This function returns all feed intake details of pigs for view functionality.
			*/
				$link = $this->connect();
				$query = " SELECT DISTINCT ft.ft_id,
							ft.quantity,
							ft.unit,

							ft.date_given,
							ft.time_given,
							ft.pig_id,
							ft.feed_id,
							ft.prod_date,
							f.feed_name,
							f.feed_type
							FROM feed_transaction ft 
							INNER JOIN feeds f on
								ft.feed_id = f.feed_id
							WHERE ft.feed_id = '" . $var . "'";
				$result = mysqli_query($link, $query);
				$f = array();
				$f_arr = array();
				while($row = mysqli_fetch_row($result)){
					$f['ft_id'] = $row[0];
					$f['qty'] = $row[1];
					$f['unit'] = $row[2];
					$date = date_create($row[3]);
					$f['d_given'] = $date->format('F j,Y');
					$f['t_given'] = $row[4];
					$f['pid'] = $row[5];
					$f['f_id'] = $row[6];
					$date2 = date_create($row[7]);
					$f['proddate'] = $date2->format('F j,Y');
					$f['fname'] = $row[8];
					$f['ftype'] = $row[9];
					$f_arr[] = $f;
				}
				
				
				return $f_arr;
				
		}
		public function getFeedReport($from,$to,$choice,$sparray)
		{
			/* 
				This function returns feed intake details pigs for printing report.
				Details are saved in a json file located in Desktop/reports/feed_reports folder
			*/
				$link = $this->connect();
				$f_arr = array();
				foreach ($sparray as $var) {
					$query = " SELECT DISTINCT
								ft.quantity,
								ft.unit,
								ft.date_given,
								ft.time_given,
								ft.pig_id,
								ft.prod_date,
								f.feed_name,
								f.feed_type
								FROM feed_transaction ft 
								INNER JOIN feeds f on
									ft.feed_id = f.feed_id
								WHERE ft.pig_id = '" . $var . "' and 
								ft.date_given BETWEEN '".$from."' and '".$to."'";
					$result = mysqli_query($link, $query);
					$f = array();
					
					while($row = mysqli_fetch_row($result)){
						$f['Pig_id'] = $row[4];
						$date = date_create($row[2]);
						$f['Date_given'] = $date->format('F j,Y');
						$f['Time_given'] = $row[3];
						$f['Quantity'] = $row[0];
						$f['Unit'] = $row[1];
						$date2 = date_create($row[5]);
						$f['Production_Date'] = $date2->format('F j,Y');
						$f['Feed_name'] = $row[6];
						$f['Feed_type'] = $row[7];
						$f_arr[] = $f;
					}
				}
				/*$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\feed_reports\\feed_reports.json', 'w');
				fwrite($fp, json_encode($f_arr,JSON_PRETTY_PRINT));
				fclose($fp);
				return $f_arr;*/
				if($choice == 'batch'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\feed_reports\\ftrans_details_perbatch.json', 'w');
				}else if($choice == 'house'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\feed_reports\\ftrans_details_perhouse.json', 'w');
				}else if($choice == 'pen'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\feed_reports\\ftrans_details_perpen.json', 'w');
				}else if($choice == 'pig'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\feed_reports\\ftrans_details_perpig.json', 'w');
				}
				fwrite($fp, json_encode($f_arr,JSON_PRETTY_PRINT));
				fclose($fp);
				return $f_arr;
				
		}
		public function getFeedsReportByFeed($from,$to,$choice,$sparray)
		{
			/* 
				This function returns medicine details for printing report.
				Details are saved in a json file located in Desktop/reports/medication_reports folder.
			*/
				$link = $this->connect();
				$f_arr = array();
				
				foreach ($sparray as $var ) {
					$query = " SELECT DISTINCT
								ft.pig_id,
								ft.feed_id,
								f.feed_name,
								f.feed_type
								FROM feed_transaction ft 
								INNER JOIN feeds f on
									ft.feed_id = f.feed_id
								WHERE ft.feed_id = '" . $var . "' and
								ft.date_given BETWEEN '".$from."' and '".$to."'";
					$result = mysqli_query($link, $query);
					$result2 = mysqli_query($link, $query);
					$f = array();
					//echo 'hey2';
					//console.log("HEY");
					$n = array();
					
					/*while($row = mysqli_fetch_row($result)){
						$m[]= $row[0];
					}*/
					while($row = mysqli_fetch_row($result)){
						
						$f['Feed_Name'] = $row[2];
						//while($row3 = array_values($m)){
						$f['Pig_id'] = $row[0];
						
						//}
						$f_arr[] = $f;
					}
					
					
				}
				
				if($choice == 'feed'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\feed_reports\\ftrans_details_perfeed.json', 'w');
				}
				fwrite($fp, json_encode($f_arr,JSON_PRETTY_PRINT));
				fclose($fp);
				return $f_arr;
				
		}

		public function ddl_feeds()
		{
			/* 
				This function returns all feed names and types from feeds table.
			*/
				$link = $this->connect();
				$query = "SELECT feed_id, 
							feed_name,
							feed_type 
						FROM feeds";
				$result = mysqli_query($link, $query) or die(mysqli_error($link));
				$feeds = array();
				$arr_feed = array();
				while ($row = mysqli_fetch_row($result)) {
						$feeds['feed_id'] = $row[0];
						$feeds['feed_name'] = $row[1];
						$feeds['feed_type'] = $row[2];
						$arr_feed[] = $feeds;
				}

				return $arr_feed;
		}
		
	
		
	    public function ddl_feedRecord($pig)
	    {
	    	/* 
				This function inserts new feed intake details of a specific pig.
				It also inserts the transaction done by the user in user_transaction table.
			*/
	        $link      = $this->connect();
	        $query     = "SELECT f.feed_name, 
	                        f.feed_type, 
	                        ft.prod_date, 
	                        ft.ft_id,
	                        ft.quantity,
	                        ft.unit,
	                        ft.date_given 
	                    FROM feeds f 
	                        INNER JOIN feed_transaction ft 
	                            ON ft.feed_id = f.feed_id 
	                    WHERE ft.pig_id = '" . $pig . "'
	                    order by ft.date_given DESC";
	        $result    = mysqli_query($link, $query);
	        $frcrd     = array();
	        $arr_frcrd = array();
	        while ($row = mysqli_fetch_row($result)) {
	            $frcrd['fname']      = $row[0];
	            $frcrd['ftype']      = $row[1];
	            $pd                  = date('F d, Y', strtotime($row[2]));
	            $frcrd['proddate']   = $pd;
	            $frcrd['ft_id']      = $row[3];
	            $date                = date('F d, Y', strtotime($row[6]));
	            $frcrd['date_given'] = $date;
	            $frcrd['qty'] = $row[4]." ".$row[5];
	            $arr_frcrd[]         = $frcrd;
	        }
	        return $arr_frcrd;
	    }
	    public function ddl_feedRecord2($feed_id)
	    {
	    	/* 
				This function returns a specific medicine.
			*/
	        $link      = $this->connect();
	        $query     = "SELECT DISTINCT 
	        					f.feed_id
	                    FROM feeds f 
	                    WHERE f.feed_id = '" . $feed_id . "' ";
	        $result    = mysqli_query($link, $query);
	        $mrcrd     = array();
	        $arr_mrcrd = array();

	        while ($row = mysqli_fetch_row($result)) {
	        	return $row[0];
	            

	        }
	    }
		public function updateFeeds($fid, $ftid, $user)
		{
			/* 
				This function updates feed_transaction table when the user edited feed intake details of pigs.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$query2 = "SELECT feed_id,pig_id FROM feed_transaction WHERE ft_id='" . $ftid . "'";
				$result2 = mysqli_query($link, $query2);
				$row = mysqli_fetch_row($result2);
				$query = "UPDATE feed_transaction set feed_id = '" . $fid . "'WHERE ft_id = '" . $ftid . "'";
				$result = mysqli_query($link, $query);
				if ($result) {
						
						$this->userTransactionEdit($user,$ftid,"feeds",$row[0],$fid,2,$row[1]);
						return array(
								'success' => '1'
						);
				}
				else {
						return array(
								'success' => '0'
						);
				}
		}
		public function updateFeedName($feedid, $feedName, $feedType)
		{
			/* 
				This function updates feeds table when the admin edited feed name or type.
				It also inserts the transaction done by the user in user_transaction table.
			*/
				$link = $this->connect();
				$query = "UPDATE feeds
							set feed_name = '" .$feedName. "',
								feed_type = '" .$feedType. "'
						WHERE feed_id = '" . $feedid. "'";
				$result = mysqli_query($link, $query);
		}
				
		/* end of feeds.php FUNCTIONS*/
		
		/*   movement.php FUNCTIONS */
		
		public function getPigMvmnt($pig)
		{
			/* 
				This function returns location details of a specific pig.
			*/
				$link = $this->connect();
				$query = "SELECT distinct m.server_date,
							m.server_time, 
							m.pen_id, 
							p.pen_no, 
							h.house_no, 
							h.house_name,
							l.loc_name
						from movement m 
						INNER JOIN pen p 
							ON p.pen_id = m.pen_id 
						INNER JOIN house h 
							ON h.house_id = p.house_id 
						inner join location l on
							l.loc_id = h.loc_id
						where m.pig_id = '".$pig."'
						ORDER BY m.server_date ASC, m.server_time ASC
							";
				$result = mysqli_query($link, $query);
				$data = "";
				$data2 = array();
				$housepen = "";
				while ($row = mysqli_fetch_row($result)) {
						if ($housepen == "") {
								$data2[] =$row[5]."-H" . $row[3] . "P" . $row[2];
						}
						else {
								$data2[] = $row[5]."-H" . $row[3] . "P" . $row[2];
						}
				}

				return $data2;
		}
		public function getWeekDateMvmnt($pig)
		{
			/* 
				This function returns movement details of a specific pig for graph purposes.
			*/
				$link = $this->connect();
				$query = "SELECT DISTINCT m.date_moved,WEEK(m.date_moved), m.time_moved,p.pen_no,p.function
							
						from movement m 
						inner join pen p on
							p.pen_id = m.pen_id
						where m.pig_id = '".$pig."'
						ORDER BY m.date_moved ASC";
				$result = mysqli_query($link, $query);
				$data = array();
				$arr = array();
				$i = 1;
				$j = 0;
				$mvmnt = $this->getPigMvmnt($pig);
				while ($row = mysqli_fetch_row($result)) {
						$years = strtotime($row[0]);
						$data['date'] = date('F d,Y', $years);
						if($row[3]== 'medication' || $row[3] == 'mortality'){
							$i = $i * -1;
							
						}else{
							$i++;
						}
						$data['x'] = $i;
						$data['week'] = $row[1];
						$data['time_moved'] = $row[2];
						$data['pen']=$row[3];
						$data['move'] = $mvmnt[$j];

						$arr[] = $data;
						$j++;
						if($i < 0){
							$i = $i * -1;
						}
				}

				return $arr;
		}
		public function getMvmntDetails($from,$to,$choice,$sparray)
		{
			/* 
				This function returns movement details of pigs for printing report.
				Details are saved in a json file located in Desktop/reports/movement_reports folder.
			*/
				$link = $this->connect();
				$a = array();
				$arr = array();
				foreach ($sparray as $a) {
					$query = "SELECT  m.date_moved,
								m.time_moved,
								p.pen_no,
								m.pig_id,
								h.house_name,
								l.loc_name
						from movement m 
						inner join pen p on
							p.pen_id = m.pen_id
						inner join house h on 
							h.house_id = p.house_id
						inner join location l on
							l.loc_id = h.loc_id
						where m.pig_id = '".$a."'
						and m.date_moved BETWEEN '".$from."' and '".$to."'
						ORDER BY m.date_moved ASC";
					$result = mysqli_query($link, $query);
					$data = array();
					
					$i = 1;
					$j = 0;
					$mvmnt = $this->getPigMvmnt($a);
					while ($row = mysqli_fetch_row($result)) {
						$data['pig_id'] = $row[3];	
						$data['date_moved'] = $row[0];
						$data['time_moved'] = $row[1];
						$data['location_name'] = $row[5];
						$data['house_name'] = $row[4];
						$data['pen_no'] = $row[2];
						
						$arr[] = $data;
						
					}
				}
				
				if($choice == 'batch'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\movement_reports\\movment_report_perbatch.json', 'w');
				}else if($choice == 'house'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\movement_reports\\movment_report_perhouse.json', 'w');
				}else if($choice == 'pen'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\movement_reports\\movment_report_perpen.json', 'w');
				}else if($choice == 'pig'){
					$fp = fopen(getenv("HOMEDRIVE") . getenv("HOMEPATH").'\\Desktop\\reports\\movement_reports\\movment_report_perpig.json', 'w');
				}
				
				fwrite($fp, json_encode($arr,JSON_PRETTY_PRINT));
				fclose($fp);
				return $arr;
		}
		/* end of movement.php FUNCTIONS*/
		/*  rfid.php  FUNCTIONS*/
		public function ddl_inactiveRFID()
	    {
	    	/* 
				This function returns all inactive rfid tags.
				
			*/
	        $link   = $this->connect();
	        $query  = "SELECT tag_rfid, 
	                        tag_id 
	                    FROM rfid_tags 
	                    WHERE status = 'inactive'";
	        $result = mysqli_query($link, $query);
	        $rfid   = array();
	        $arr    = array();
	        while ($row = mysqli_fetch_row($result)) {
	            $rfid['rfid']   = $row[0];
	            $rfid['tag_id'] = $row[1];
	            $arr[]          = $rfid;
	        }
	        return $arr;
	    }





	    
		
	}
?>
