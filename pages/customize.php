<!DOCTYPE html>
<html lang="en">
  <?php 

  /* 
		  For the customization of data of the system: if it is local, private or open.
	*/

    session_start(); 
    require_once "../connect.php"; 
    require_once "../inc/dbinfo.inc"; 
    if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
      header("Location: /phpork/user"); 
    }
    include "../inc/functions.php"; 
    $db = new phpork_functions ();

    $basicinfo = 'default';
    $parentage = 'default';
    $movement = 'default';
    $feeds = 'default';
    $medicine = 'default';
    $weight = 'default';

    $data_cat = "";
    $data_opt = "";

    if(isset($_POST['submit'])) {
      foreach ($_POST['optradio'] as $data_cat => $data_opt) {
        if($data_cat == "1"){

          if($data_opt == 'basicinfo_save_local') {
            $basicinfo2_status = 'checked';
            $basicinfo1_status = 'unchecked';
            $basicinfo3_status = 'unchecked';
            $basicinfo4_status = 'unchecked';

            $basicinfo = 'Local';
          }
          elseif($data_opt == 'basicinfo_keep_private') {
            $basicinfo3_status = 'checked';
            $basicinfo2_status = 'unchecked';
            $basicinfo1_status = 'unchecked';
            $basicinfo4_status = 'unchecked';

            $basicinfo = 'Private';
          }
          elseif($data_opt == 'basicinfo_open_data') {
            $basicinfo4_status = 'checked';
            $basicinfo2_status = 'unchecked';
            $basicinfo3_status = 'unchecked';
            $basicinfo1_status = 'unchecked';

            $basicinfo = 'Open';
          }

        }elseif($data_cat == "2"){

          if($data_opt == 'parentage_save_local') {
            $parentage2_status = 'checked';
            $parentage1_status = 'unchecked';
            $parentage3_status = 'unchecked';
            $parentage4_status = 'unchecked';

            $parentage = 'Local';
          }
          elseif($data_opt == 'parentage_keep_private') {
            $parentage3_status = 'checked';
            $parentage2_status = 'unchecked';
            $parentage1_status = 'unchecked';
            $parentage4_status = 'unchecked';

            $parentage = 'Private';
          }
          elseif($data_opt == 'parentage_open_data') {
            $parentage4_status = 'checked';
            $parentage2_status = 'unchecked';
            $parentage3_status = 'unchecked';
            $parentage1_status = 'unchecked';

            $parentage = 'Open';
          }
        }else if($data_cat == "3"){

          if($data_opt == 'movement_save_local') {
            $movement2_status = 'checked';
            $movement1_status = 'unchecked';
            $movement3_status = 'unchecked';
            $movement4_status = 'unchecked';

            $movement = 'Local';
          }
          elseif($data_opt == 'movement_keep_private') {
            $movement3_status = 'checked';
            $movement1_status = 'unchecked';
            $movement2_status = 'unchecked';
            $movement4_status = 'unchecked';

            $movement = 'Private';
          }
          elseif($data_opt == 'movement_open_data') {
            $movement4_status = 'checked';
            $movement1_status = 'unchecked';
            $movement2_status = 'unchecked';
            $movement3_status = 'unchecked';
            $movement = 'Open';
          }
        }else if($data_cat == "4"){
 
          if($data_opt == 'feeds_save_local') {
            $feeds2_status = 'checked';
            $feeds1_status = 'unchecked';
            $feeds3_status = 'unchecked';
            $feeds4_status = 'unchecked';

            $feeds = 'Local';
          }
          elseif($data_opt == 'feeds_keep_private') {
            $feeds3_status = 'checked';
            $feeds1_status = 'unchecked';
            $feeds2_status = 'unchecked';
            $feeds4_status = 'unchecked';

            $feeds = 'Private';
          }
          elseif($data_opt == 'feeds_open_data') {
            $feeds4_status = 'checked';
            $feeds1_status = 'unchecked';
            $feeds2_status = 'unchecked';
            $feeds3_status = 'unchecked';

            $feeds = 'Open';
          }
        }else if($data_cat == "5"){
          if($data_opt == 'medicine_save_local') {
            $medicine2_status = 'checked';
            $medicine1_status = 'unchecked';
            $medicine3_status = 'unchecked';
            $medicine4_status = 'unchecked';

            $medicine = 'Local';
          }
          elseif($data_opt == 'medicine_keep_private') {
            $medicine3_status = 'checked';
            $medicine1_status = 'unchecked';
            $medicine2_status = 'unchecked';
            $medicine4_status = 'unchecked';

            $medicine = 'Private';
          }
          elseif($data_opt == 'medicine_open_data') {
            $medicine4_status = 'checked';
            $medicine1_status = 'unchecked';
            $medicine2_status = 'unchecked';
            $medicine3_status = 'unchecked';

            $medicine = 'Open';
          }
        }else if($data_cat == "6"){
          if($data_opt == 'weight_save_local') {
            $weight2_status = 'checked';
            $weight1_status = 'unchecked';
            $weight3_status = 'unchecked';
            $weight4_status = 'unchecked';

            $weight = 'Local';
          }
          elseif($data_opt == 'weight_keep_private') {
            $weight3_status = 'checked';
            $weight1_status = 'unchecked';
            $weight2_status = 'unchecked';
            $weight4_status = 'unchecked';

            $weight = 'Private';
          }
          elseif($data_opt == 'weight_open_data') {
            $weight4_status = 'checked';
            $weight1_status = 'unchecked';
            $weight2_status = 'unchecked';
            $weight3_status = 'unchecked';

            $weight = 'Open';
          }
        }
      }

  	$f = array();
  	$f['Basic_Info'] = $basicinfo;
  	$f['Parentage'] = $parentage;
  	$f['Movement'] = $movement;
  	$f['Feeds'] = $feeds;
  	$f['Medicine'] = $medicine;
  	$f['Weight'] = $weight;
  	$json = json_encode($f, JSON_PRETTY_PRINT);
  	$index = fopen("../data_config.txt", 'w');
  	fwrite ($index, $json);
  	fclose ($index);
    }
  ?> 

  <head> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Pork Traceability System</title> 
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.css"> 
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.css"> 
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.min.css"> 
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style_customize.css"> 
    <script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
  </head> 
  <body>
    <div class="page-header" data-trigger= "hover" data-toggle="tooltip" title="Click to go back to home page which is 'View', 'Insert' and 'Customize' " data-placement="bottom"> 
      <a href="/phpork/encoder/home" >
        <img class="img-responsive" src="<?php echo HOST;?>/phpork/images/Header1.png"> 
      </a>
    </div>

    <form class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/out" style="width:50%; float:right;"> 
      <div class="form-group logout" > 
        <input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
        <div class="col-xs-1 col-sm-1" style="left: -1%;"> 
          <button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
        </div> 
      </div> 
    </form> 
      <div class="lower">
        <div class="table1">
	        <table class="table">
	          <thead>
	            <tr>
	              <th rowspan="3">Data</th>
	              <th colspan="3" style="text-align: center;">Record</th>
	            </tr>
	            <tr>
	              <th rowspan="2" style="text-align: center;">BUT Save Locally</th>
	              <th colspan="2" style="text-align: center;">AND Send to NPTS</th>
	            </tr>
	            <tr>
	              <th style="text-align: center;">BUT Keep Private</th>
	              <th style="text-align: center;">AND Open Data</th>
	            </tr>
	          </thead>
	          <tbody>
	          	<form method="post" id="form1">
	          		<tr>
		              <th class="theader" scope="row" name="basicinfo">Basic Info</td>
		              <!--<td><input class="c" id="a1" type="radio" name="optradio[1]" value="parentage_NOT_record"></td>-->
		              <td style="text-align:center"><input class="c" id="a2" type="radio" name="optradio[1]" value="basicinfo_save_local"></td>
		              <td style="text-align:center"><input class="c" id="a3" type="radio" name="optradio[1]" value="basicinfo_keep_private"></td>
		              <td style="text-align:center"><input class="c" id="a4" type="radio" name="optradio[1]" value="basicinfo_open_data"></td>
		            </tr>
	          		<tr>
		              <th class="theader" scope="row" name="parentage">Parentage</td>
		              <!--<td><input class="c" id="a1" type="radio" name="ptradio[1]" value="parentage_NOT_record"></td>-->
		              <td style="text-align:center"><input class="c" id="b2" type="radio" name="optradio[2]" value="parentage_save_local"></td>
		              <td style="text-align:center"><input class="c" id="b3" type="radio" name="optradio[2]" value="parentage_keep_private"></td>
		              <td style="text-align:center"><input class="c" id="b4" type="radio" name="optradio[2]" value="parentage_open_data"></td>
		            </tr>
		            <tr>
		              <th class="theader" scope="row" name="movement">Movement</td>

		              <td style="text-align:center"><input class="c" id="c2" type="radio" name="optradio[3]" value="movement_save_local"></td>
		              <td style="text-align:center"><input class="c" id="c3" type="radio" name="optradio[3]" value="movement_keep_private"></td>
		              <td style="text-align:center"><input class="c" id="c4" type="radio" name="optradio[3]" value="movement_open_data"></td>
		            </tr>
		            <tr>
		              <th class="theader" scope="row" name="feeds">Feeds</td>

		              <td style="text-align:center"><input class="c" id="d2" type="radio" name="optradio[4]" value="feeds_save_local"></td>
		              <td style="text-align:center"><input class="c" id="d3" type="radio" name="optradio[4]" value="feeds_keep_private"></td>
		              <td style="text-align:center"><input class="c" id="d4" type="radio" name="optradio[4]" value="feeds_open_data"></td>
		            </tr>
		            <tr>
		              <th class="theader" scope="row" name="medicine">Medicine</td>

		              <td style="text-align:center"><input class="c" id="e2" type="radio" name="optradio[5]" value="medicine_save_local"></td>
		              <td style="text-align:center"><input class="c" id="e3" type="radio" name="optradio[5]" value="medicine_keep_private"></td>
		              <td style="text-align:center"><input class="c" id="e4" type="radio" name="optradio[5]" value="medicine_open_data"></td>
		            </tr>
		            <tr>
		              <th class="theader" scope="row" name="weight">Weight</td>

		              <td style="text-align:center"><input class="c" id="f2" type="radio" name="optradio[6]" value="weight_save_local"></td>
		              <td style="text-align:center"><input class="c" id="f3" type="radio" name="optradio[6]" value="weight_keep_private"></td>
		              <td style="text-align:center"><input class="c" id="f4" type="radio" name="optradio[6]" value="weight_open_data"></td>
		            </tr>
	          	</form>
	          </tbody>
	        </table>
      	</div>
	    </br>
	    <div style="margin-left: 40%">
			<button type="submit" name="submit" form="form1" class="btn1" id="Done">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> DONE 
			</button>
	    </div>
  	</div>

    <div class="page-footer"> 
      Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB || funded by PCAARRD 
    </div>
     <script type="text/javascript"> 
       $(document).ready(function () {
          $('#backH').on("click",function(){
              var val = $('.prnt').val();
              
          });
       });
      </script>
  </body>
</html>
