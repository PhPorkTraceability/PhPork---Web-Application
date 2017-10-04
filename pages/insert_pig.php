<!DOCTYPE html>
<html lang="en">
  <?php
    /*
      Page for the insertion of new pigs
    */ 
    session_start(); 
    require_once "../connect.php"; 
    require_once "../inc/dbinfo.inc"; 
    if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
      header("Location: login.php"); 
    }
    include "../inc/functions.php"; 
    $db = new phpork_functions (); 
  ?> 

  <head> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Pork Traceability System</title> 
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.css">
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-responsive.css">
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style_insert_pig.css">

    <script src="<?php echo HOST;?>/phpork/js/jquery-2.1.4.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/jquery-latest.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/jquery.min.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/bootstrap.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/bootstrap.min.js"></script>
  </head> 

  <body> 
    <div class="page-header" data-trigger= "hover" data-toggle="tooltip" title="Click to go back to home page which is 'View', 'Insert' and 'Customize' " data-placement="bottom"> 
      <a href="/phpork/encoder/home" >
        <img class="img-responsive" src="<?php echo HOST;?>/phpork/images/Header1.png"> 
      </a>
    </div>

    <form class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/out" style="width:50%;float:right;"> 
      <div class="form-group logout" > 
        <input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; id="user" border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
        <div class="col-xs-1 col-sm-1" style="left: -1%;"> 
          <button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
        </div> 
      </div> 
    </form> 

   
  <form method="post" >
    <div class="row row-centered pos1 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
      <!--Pig Details(1)-->
      <div id="pig1" style="display: inline-block;">
        <div class="content"> 
          <ul class="step-indicator"> 
            <li class="each-step active"></li>
            <li class="each-step"></li> 
            <li class="each-step"></li> 
            <li class="each-step"></li> 
          </ul> 
        </div> 
        <div class="row row-centered pos1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="lowerPanel">
            <h3><span class="label">Pig Details - 1</span></h3>
            <!--<div class="t1">-->
              <div class="input-group gro">
                <span class="input-group-addon" id="basic-addon3">Pig Label: </span>
                <input type="text" class="form-control" id="pigId" name="new_pid" aria-describedby="basic-addon3" value="" pattern="[0-9]+" required>
              </div>
              <br/>
              <div class="input-group gro">
                <span class="input-group-addon" id="basic-addon3">RFID: </span>
                <input type="text" readonly class="form-control" id="rfid" aria-describedby="basic-addon3">

                <input type="hidden" id="tag_id" >              </div>
              <br/>
              <div class="input-group gro">
                <span class="input-group-addon" id="basic-addon3">Farrowing Date: </span>
                <input type="date" class="form-control" id="farrowingDate" name="pbdate"  value="" aria-describedby="basic-addon3">
              </div>
              <br/>
              <div class="input-group gro">
                <span class="input-group-addon" id="basic-addon3">Week Farrowed: </span>
                <input type="text"  class="form-control" name="weekFarrowed" value="" id = "weekFarrowed" pattern="[A-z,a-z]+[0-9]+"> 
              </div>
              <br/>
              <div class="input-group gro">
                <span class="input-group-addon" id="basic-addon3">Status: </span>
                <select  class="form-control" id="pigStatus" name="selStat" style="color:black;" required> 
                  <option value="" disabled selected>Select pig status..</option> 
                  <option value="Weaning">Weaning</option> 
                  <option value="Growing">Growing</option> 
                  <option value="Sow">Sow</option> 
                  <option value="Boar">Boar</option> 
                </select> 
              </div>
              <br/>
              <div class="input-group gro">
                <span class="input-group-addon" id="basic-addon3">Weight: </span>
                <input type="number" min="1" step="0.01" class="form-control" id="weight" aria-describedby="basic-addon3" style="width: 90%;">
                <span class="kg">kg</span>
              </div>
              <br/>
              <div class="input-group gro">
                <span class="input-group-addon" id="basic-addon3">Weight Type: </span>
                <input type="text" class="form-control" id="weightType" value="" aria-describedby="basic-addon3" pattern="[A-za-z]+" required>
              </div>
          </div>
          <div class="btnpos">
            <button type="button" class="btn1" id="pigDetails2" data-trigger= "hover" data-toggle="tooltip" title="Click to go to the next page. (Pig details part 2) " data-placement="left">
              Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </button>
          </div>
        </div>
      </div>
      <!--Pig Details(1)-->

      <!--Pig Details(2)-->
      <div id="pig2" style="display:none;">
        <div class="content"> 
          <ul class="step-indicator">
            <li class="each-step active"></li>
            <li class="each-step active"></li> 
            <li class="each-step"></li> 
            <li class="each-step"></li> 
          </ul> 
        </div> 
        <div class="row row-centered pos1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="lowerPanel">
            <h3><span class="label">Pig Details - 2</span></h3>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Gender: </span>
              <select  class="form-control" id="gender" name="selStat" style="color:black;" value="" required> 
                <option value="" disabled selected>Select pig gender</option>
                <option value="M">Male</option> 
                <option value="F">Female</option> 
              </select>
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Breed: </span>
              <select class="form-control" name="pbreed" id="breed"  required> 
                <option value="" disabled selected>Select breed...</option> 
                </select> 
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Farm: </span>
              <select class="form-control" id="farm" style="color:black;" required> 
                <option value="" disabled selected>Select farm location...</option> 
              </select> 
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">House: </span>
              <select class='form-control'  id='house' style='color:black;' required> 
                <option value='' disabled selected>Select House...</option> 
              </select> 
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Pen: </span>
              <select class='form-control' id='pen' style='color:black;' required> 
                <option value='' disabled selected>Select Pen...</option> 
              </select> 
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Parents: </span>
              <select  name="pboar" id="boarParent" class='form-control' required> 
                <option value="" disabled selected>Select boar...</option> 
                <option value="null">N/A</option> 
              </select> 
              <select  name="psow" id="sowParent" class='form-control' required> 
                <option value="" disabled selected>Select sow...</option> 
                <option value="null">N/A</option> 
              </select> 
              <select name="pfoster" id="fosterParent" class="form-control" required> 
                <option value="" disabled selected>Select foster sow...</option> 
                <option value="null">N/A</option> 
              </select> 
            </div>
          </div>
          <div class="btnpos">
            <button type="button" class="btn1" id="backToPig1" data-trigger= "hover" data-toggle="tooltip" title="Click to go back to previous page. (Pig details part 1) " data-placement="left">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
            </button>
            <button type="button" class="btn1" id="feedDetails" data-trigger= "hover" data-toggle="tooltip" title="Click to go to the next page. (Feed details) " data-placement="right">
              Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </button>
          </div>
        </div>
      </div>
      <!--Pig Details(2)-->

      <!--Feed Details-->
      <div id="feeds" style="display: none;">
        <div class="content"> 
          <ul class="step-indicator"> 
            <li class="each-step active"></li> 
            <li class="each-step active"></li> 
            <li class="each-step active"></li>
            <li class="each-step"></li>
          </ul> 
        </div> 
         
        <div class="row row-centered pos1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="lowerPanel">
            <h3><span class="label">Feed Details</span></h3>
            <br/> 
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Last feed: </span>
              <select class = "form-control" id="lastFeed" required> 
                <option value="" disabled selected>Select feeds</option> 
              </select> 
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Feed Type: </span>
              <input type="text" readonly class="form-control" id="feedType" aria-describedby="basic-addon3">
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Production date of feed: </span>
              <input type="date" class="form-control" id="prodDateOfFeed" aria-describedby="basic-addon3" placeholder="mm/dd/yyyy" value="">
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Date and time given: </span>
              <input type="date" class="form-control" id="dateFeedGiven" aria-describedby="basic-addon3" placeholder="mm/dd/yyyy" value="">
              <input type="time" class="form-control" id="timeFeedGiven" aria-describedby="basic-addon3" value="">
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Quantity: </span>
              <input type="number" min="1" step="0.01" class="form-control" id="feedQty" aria-describedby="basic-addon3" style="width: 90%;" value="">
              <span class="kg">kg</span>
            </div>
          </div>
          <div class="btnpos">
            <button type="button" class="btn1" id="backToPig2" data-trigger= "hover" data-toggle="tooltip" title="Click to go back to previous page. (Pig details part 2) " data-placement="left">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
            </button>
            <button type="button" class="btn1" id="medDetails" data-trigger= "hover" data-toggle="tooltip" title="Click to go to the next page. (Medication details) " data-placement="right">
              Next <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </button>
          </div>
        </div>  
      </div>


      <!--Medication Details // ito po yung 3-->
      <div id="meds" style="display: none;">
        <div class="content"> 
          <ul class="step-indicator"> 
            <li class="each-step active"></li> 
            <li class="each-step active"></li> 
            <li class="each-step active"></li>
            <li class="each-step active"></li>
          </ul> 
        </div> 
        <div class="row row-centered pos1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="lowerPanel">
            <h3><span class="label">Medication Details</span></h3>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Last medication given: </span>
              <select name="selectMeds" id="lastMedGiven" class="form-control"> 
                <option value="" disabled selected>Select medication...</option> 
              </select> 
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Medication type: </span>
              <input type="text" readonly class="form-control" id="medType" aria-describedby="basic-addon3">
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Date and time given: </span>
              <input type="date" class="form-control" id="dateMedGiven" aria-describedby="basic-addon3" placeholder="mm/dd/yyyy">
              <input type="time" class="form-control" id="timeMedGiven" aria-describedby="basic-addon3">
            </div>
            <br/>
            <div class="input-group gro">
              <span class="input-group-addon" id="basic-addon3">Quantity: </span>
              <input type="number" min="1" step="0.01" class="form-control qan" id="medQty" aria-describedby="basic-addon3">
              <select  class="form-control qan1" id="unit" name="unit"required> 
                <option value="cc" selected>cc</option> 
                <option value="ml">mL</option>
                <option value="kg">kg</option>  
              </select>
            </div>
          </div>
          <div class="btnpos">
            <button type="button" class="btn1" id="backToFeeds" data-trigger= "hover" data-toggle="tooltip" title="Click to go back to previous page. (Feed details) " data-placement="left">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
            </button> 
            <button type="submit" class="btn1" id="insert" data-trigger= "hover" data-toggle="tooltip" title="Click to insert pig details and its feed and medication details. " data-placement="right">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Insert Pig
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div class="page-footer"> 
    Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB || funded by PCAARRD 
  </div>
  <div> 
    <?php 
      $u = $_SESSION['user_id']; 
      echo "<input type='hidden' value='$u' name='user' id='userId'/>";
    ?> 
  </div>  

    
      <script type="text/javascript"> 
        $(document).ready(function () {

          
          $('#pigId').on("focusout",function() {
          var pig = $('#pigId').val(); 
          $.ajax({
            type: "post", 
            url: "/phpork/gateway/pig.php", 
            data: {
              getinsertRFID: '1',
              pig: pig
            }, 
            success: function(data) {
              var data = jQuery.parseJSON(data); 
              $("#rfid").attr("value",data[0].t_rfid);  
              $("#tag_id").attr("value",data[0].t_id); 
            } 
          }); 
        }); 

         $('#feedDetails').on("click", function() {
		          var farm = $('#farm').val();
                var house = $('#house').val();
                var pen = $('#pen').val();
                var gender = $('#gender').val();
                var breed = $('#breed').val();  
                var boarParent = $('#boarParent').val();
                var sowParent = $('#sowParent').val();
                var fosterParent = $('#fosterParent').val();
		
            		if(farm == null || house == null || pen == null || gender == null || breed == null || boarParent == null || sowParent == null || fosterParent == null){
            			alert("Please fill up all fields");
            		}else{
                          		$('#pig1').attr("style", "display: none");
                          		$('#pig2').attr("style", "display: none");
                          		$('#feeds').attr("style", "display: inline-block");
                          		$('#meds').attr("style", "display: none");
            		}
          });
          

         $('#medDetails').on("click", function() {
                var lastFeed = $('#lastFeed').val();
                var prodDateOfFeed = $('#prodDateOfFeed').val();
                var dateFeedGiven = $('#dateFeedGiven').val();
                var timeFeedGiven = $('#timeFeedGiven').val();
                var feedQty = $('#feedQty').val();
                var days = 7;
                $.ajax({
                  url: '/phpork/gateway/feeds.php',
                  type: 'post',
                  data : {
                    getMaxFeedDate: '1'
                  },
                  success: function (data) { 
                    var data = jQuery.parseJSON(data); 
                    var to = new Date(data[0].fdate);
                    var from = new Date(to -(days * 24 * 60 * 60 * 1000) );
                    var check = new Date(dateFeedGiven);
                    var checkprod = new Date(prodDateOfFeed);
                    var min = new Date("0001-01-01");
                    var max = new Date("2016-01-01");
                    var today = new Date();
                    if(lastFeed == "" || prodDateOfFeed == "" || dateFeedGiven == "" || timeFeedGiven == "" || feedQty == ""){
                       alert("Please fill up all fields.");
                    }else{
                        if(check >= from && check <= to){
                          $('#pig1').attr("style", "display:none ");
                          $('#pig2').attr("style", "display: none");
                          $('#feeds').attr("style", "display: none");
                          $('#meds').attr("style", "display: inline-block");
                        
                        }else if((check >= min && check <= max)  || check > today || (checkprod >= min && checkprod <= max)  || checkprod > today){
                          alert("Invalid date.");
                        }else{
                          alert("Date given is not within the range.");
                          $('#pig1').attr("style", "display:none ");
                          $('#pig2').attr("style", "display: none");
                          $('#feeds').attr("style", "display: none");
                          $('#meds').attr("style", "display: inline-block");
                        }
                        
                    }
                       
                      
                  } 
                });
               
           });

         $('#backToPig1').on("click", function() {
             $('#pig1').attr("style", "display: inline-block");
              $('#pig2').attr("style", "display: none");
              $('#feeds').attr("style", "display: none");
              $('#meds').attr("style", "display: none");

          });

        $('#pigDetails2').on("click", function() {
            var pigId = $('#pigId').val();
            var farrowingDate = $('#farrowingDate').val();
            var weekFarrowed = $('#weekFarrowed').val();
            var pigStatus= $('#pigStatus').val();
            var weight = $('#weight').val();
            var weightType = $('#weightType').val();
            var rfid = $('#tag_id').val();
            var today = new Date();
            var check = new Date(farrowingDate);
            var matchWeight = weightType.match(/[0-9]+/g);
            var min = new Date("0001-01-01");
            var max = new Date("2016-01-01");
        		if(pigId == "" || farrowingDate == "" || weekFarrowed == "" || pigStatus == "" || rfid == "" || weight == "" || weightType == ""){
        			alert("Please fill up all fields");
        		}else if(matchWeight != null ){
                alert("invalid weight type input")
            }else{
              if((check >= min && check <= max)  || check > today){
                alert("Invalid date.");
              }else{
                $('#pig1').attr("style", "display: none");
                $('#pig2').attr("style", "display: inline-block");
                $('#feeds').attr("style", "display: none");
                $('#meds').attr("style", "display: none");
              }
          		
        		}
         });

        $('#backToFeeds').on("click", function() {
            $('#pig1').attr("style", "display: none");
            $('#pig2').attr("style", "display: none");
            $('#feeds').attr("style", "display: inline-block");
            $('#meds').attr("style", "display: none");
        });

        $('#backToPig2').on("click", function() {
            $('#pig1').attr("style", "display: none");
            $('#pig2').attr("style", "display: inline-block");
            $('#feeds').attr("style", "display: none");
            $('#meds').attr("style", "display: none");
        }); 
 


          $('#farm').on("change", function(e) {
            e.preventDefault(); 
              var location = $('#farm').val();

              $.ajax({
                url: '/phpork/gateway/house.php',
                type: 'post',
                data : {
                  getHouseByLoc: '1',
                  loc: location
                },
                success: function (data) { 
                   var data = jQuery.parseJSON(data); 
                  
                      $("#house").html("<option value='' disabled selected style='display:none;'>Select house..</option>");
                      
                      for(i=0;i<data.length;i++){
                        
                        $("#house").append($("<option></option>").attr("value",data[i].h_id)
                          .attr("name","house")
                          .text("House " +data[i].h_no)); 
                      }
                } 
              });
           });

               $('#house').on("change", function(e) {
                e.preventDefault(); 
                 var houseno = $("#house").val(); 
                  
                  $.ajax({
                    url: '/phpork/gateway/pen.php',
                    type: 'post',
                    data : {
                      ddl_notMortalityPen: '1',
                      house: houseno
                    },
                    success: function (data) { 
                       var data = jQuery.parseJSON(data); 
                          $("#pen").html("<option value='' disabled selected style='display:none;'>Select pen..</option>");
                          for(i=0;i<data.length;i++){
                            $("#pen").append($("<option></option>").attr("value",data[i].pen_id)
                              .attr("name","pen")
                              .text("Pen " +data[i].pen_no)); 
                          }
                        }
                      });
                  });

            $('#lastFeed').on("change", function() {
               
                 var feeds = $("#lastFeed").val(); 
                  console.log(feeds);
                  $.ajax({
                    url: '/phpork/gateway/feeds.php',
                    type: 'post',
                    data : {
                      getFeedsDetails: '1',
                      feed: feeds
                    },
                    success: function (data) { 
                       var data = jQuery.parseJSON(data); 
                        $("#feedType").attr("value", data[0].ftype); 
                          
                     }
                  });
            });

            $('#lastMedGiven').on("change", function() {
               
                 var med = $("#lastMedGiven").val(); 
                  
                  $.ajax({
                    url: '/phpork/gateway/meds.php',
                    type: 'post',
                    data : {
                      getMedsDetails: '1',
                      med: med
                    },
                    success: function (data) { 
                       var data = jQuery.parseJSON(data); 
                        $("#medType").attr("value", data[0].mtype); 
                          
                     }
                  });
            });
           
          $('#insert').on("click", function() {
                var pigId = $('#pigId').val();
                var farrowingDate = $('#farrowingDate').val();
                var weekFarrowed = $('#weekFarrowed').val();
                var pigStatus= $('#pigStatus').val();
                var weight = $('#weight').val();
                var weightType = $('#weightType').val();
                var rfid = $('#tag_id').val();
                var farm = $('#farm').val();
                var house = $('#house').val();
                var pen = $('#pen').val();
                var gender = $('#gender').val();
                var breed = $('#breed').val();  
                var boarParent = $('#boarParent').val();
                var sowParent = $('#sowParent').val();
                var fosterParent = $('#fosterParent').val();

                var lastFeed = $('#lastFeed').val();
                var feedType = $('#feedType').val();
                var prodDateOfFeed = $('#prodDateOfFeed').val();
                var dateFeedGiven = $('#dateFeedGiven').val();
                var timeFeedGiven = $('#timeFeedGiven').val();
                var feedQty = $('#feedQty').val();

                var lastMedGiven = $('#lastMedGiven').val();
                var medType = $('#medType').val();
                var dateMedGiven = $('#dateMedGiven').val();
                var timeMedGiven = $('#timeMedGiven').val();
                var medQty = $('#medQty').val();
                var unit = $('#unit').val(); 

                var user = $('#userId').val();
                $.ajax({
                    url: '/phpork/gateway/meds.php',
                    type: 'post',
                    data : {
                      getMaxMedDate: '1'
                    },
                    success: function (data) { 
                      var data = jQuery.parseJSON(data);
                      var days = 7; 
                      var to = new Date(data[0].mdate);
                      var from = new Date(to -(days * 24 * 60 * 60 * 1000) );
                      var check = new Date(dateMedGiven);
                      var today = new Date();
                      var min = new Date("0001-01-01");
                      var max = new Date("2016-01-01");
                      if(lastMedGiven == "" || dateMedGiven == "" || timeMedGiven == "" || medQty == "" || unit == ""){
                         alert("Please fill up all fields!");
                      }else{
                        // if(check >= from && check <= to){
                          $.ajax({
                              url: '/phpork/gateway/pig.php',
                              type: 'post',
                              data : {
                                addPigFlag: '1',
                                new_pid: pigId,
                                pbdate: farrowingDate,
                                pweekfar: weekFarrowed,
                                selStat: pigStatus,
                                pweight: weight,
                                pweighttype: weightType,
                                prfid: rfid,
                                ploc: farm,
                                selHouse: house,
                                selPen: pen,
                                pgender: gender,
                                pbreed: breed,
                                pboar: boarParent,
                                psow: sowParent,
                                pfoster: fosterParent,
                                user_id: user,
                                selectFeeds: lastFeed,
                                fprodDate: prodDateOfFeed,
                                fdate: dateFeedGiven,
                                ftime: timeFeedGiven,
                                fqty: feedQty,
                                selUnit: unit,
                                selectMeds: lastMedGiven,
                                medDate: dateMedGiven,
                                medTime: timeMedGiven,
                                mqty: medQty
                              },
                              success: function (data) { 
                                 var data = jQuery.parseJSON(data); 
                                 alert("Pig Added!");

                               
                               }
                            });
                            var r = pigId.replace(/^0+$/g, "");
                            window.location = "/phpork/view/farm/house/pen/pig/" +farm+ "/" +house+ "/" +pen+ "/" +r;
                        // }
                        // else if((check >= min && check <= max)  || check > today){
                        //   alert("Invalid date.");
                        // }else{
                        //   alert("Medication date given is not between the range.")
                        // }
                      }
                      

                   
                    }  
                });

                
            });
         
      });
      </script>
      <script>
      /*Select Farm*/
        $.ajax({
          url: '/phpork/gateway/location.php',
          type: 'post',
          data : {
            ddl_location: '1'
          },
          success: function (data) { 
             var data = jQuery.parseJSON(data); 
                for(i=0;i<data.length;i++){
                  $("#farm").append($("<option></option>").attr("value",data[i].loc_id)
                    .attr("name","location")
                    .text(data[i].loc_name)); 
                }
                   
              } 
          
        });

        /*Select Breed*/

       $.ajax({
          url: '/phpork/gateway/pig.php',
          type: 'post',
          data : {
            ddl_breeds: '1'
          },
          success: function (data) { 
             var data = jQuery.parseJSON(data); 
                for(i=0;i<data.length;i++){
                  $("#breed").append($("<option></option>").attr("value",data[i].brid)
                    .attr("name","breed")
                    .text(data[i].brname)); 
                }
                   
              } 
          
        });

        /*Last Feed*/
        $.ajax({
          url: '/phpork/gateway/feeds.php',
          type: 'post',
          data : {
           ddl_feeds: '1'
          },
          success: function (data) { 
             var data = jQuery.parseJSON(data); 
                for(i=0;i<data.length;i++){
                  $("#lastFeed").append($("<option></option>").attr("value",data[i].feed_id)
                    .attr("name","feeds")
                    .text(data[i].feed_name)); 
                }
                   
              } 
          
        });

        /*Last Medication Given*/
        $.ajax({
          url: '/phpork/gateway/meds.php',
          type: 'post',
          data : {
           ddl_meds: '1'
          },
          success: function (data) { 
             var data = jQuery.parseJSON(data); 
                for(i=0;i<data.length;i++){
                  $("#lastMedGiven").append($("<option></option>").attr("value",data[i].med_id)
                    .attr("name","meds")
                    .text(data[i].med_name)); 
                }
                   
              } 
          
        });

        /*select boar*/
        $.ajax({
          url: '/phpork/gateway/pig.php',
          type: 'post',
          data : {
           ddl_parent: '1',
           var: 'boar'
          },
          success: function (data) { 
             var data = jQuery.parseJSON(data); 
                for(i=0;i<data.length;i++){
                  $("#boarParent").append($("<option></option>").attr("value",data[i].parent_id)
                    .attr("name","meds")
                    .text(data[i].label_id)); 
                }
                   
              } 
          
        });

        /*select sow*/
         $.ajax({
          url: '/phpork/gateway/pig.php',
          type: 'post',
          data : {
           ddl_parent: '1',
           var: 'sow'
          },
          success: function (data) { 
             var data = jQuery.parseJSON(data); 
                for(i=0;i<data.length;i++){
                  $("#sowParent").append($("<option></option>").attr("value",data[i].parent_id)
                    .attr("name","meds")
                    .text(data[i].label_id)); 
                }
                   
              } 
          
        });

         /*foster sow*/
          $.ajax({
          url: '/phpork/gateway/pig.php',
          type: 'post',
          data : {
           ddl_parent: '1',
           var: 'foster sow'
          },
          success: function (data) { 
             var data = jQuery.parseJSON(data); 
                for(i=0;i<data.length;i++){
                  $("#fosterParent").append($("<option></option>").attr("value",data[i].parent_id)
                    .attr("name","meds")
                    .text(data[i].label_id)); 
                }
                   
              } 
          
        });
      $('#pigDetails2').tooltip({trigger: "hover"});
      $('#backToPig1').tooltip({trigger: "hover"});
      $('#feedDetails').tooltip({trigger: "hover"});
      $('#backToPig2').tooltip({trigger: "hover"});
      $('#medDetails').tooltip({trigger: "hover"});
      $('#backToFeeds').tooltip({trigger: "hover"});
      $('#insert').tooltip({trigger: "hover"});


        
    </script>
  </body>
</html>