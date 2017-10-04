<!DOCTYPE html>
<html lang="en">
  <?php
    /*
      Home page for the encoder type of user where you can choose if you will view pig, insert pig or customize pig data
    */ 
    session_start(); 
    require_once "../connect.php"; 
    require_once "../inc/dbinfo.inc"; 
    if(!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
      header("Location: /phpork/in"); 
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
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style_home.css">

    <script src="<?php echo HOST;?>/phpork/js/jquery-2.1.4.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/jquery-latest.js" type="text/javascript"></script>
    <script src="<?php echo HOST;?>/phpork/js/jquery-latest.min.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/bootstrap.js" type="text/javascript"></script> 
  </head> 
  <body> 
    <div class="page-header"> 
      <img class="img-responsive" src="<?php echo HOST;?>/phpork/images/Header1.png"> 
    </div> 

    <form class="form-horizontal col-xs-10 col-sm-10 col-md-10 col-lg-10"  method="post" action="/phpork/out" style="width:50%; float:right;"> 
      <div class="form-group logout" > 
        <input type="text" class="col-xs-6 col-sm-5" readonly style="text-align: left; border: 2px solid; border-color: #83b26a;" value="<?php echo $_SESSION['username'];?>"> 
        <div class="col-xs-1 col-sm-1" style="left: -1%;"> 
          <button type="submit" class="btn btn-primary btn-sm" >Logout</button> 
        </div> 
      </div> 
    </form> 

    <div class="menu"> 
      <div class="col-md-2 col-centered image1" data-trigger= "hover" data-toggle="tooltip" title="Click to view and edit the details of pig. This is also where you input daily intake of feed and medication of pigs."> 
        <a href="/phpork/pages/farm">
          <img class="img-responsive" src="<?php echo HOST;?>/phpork/images/home_view.png">
        </a> 
      </div> 
      <div class="col-md-2 col-centered image2" data-trigger= "hover" data-toggle="tooltip" title="Click to insert new pigs. It includes basic details, last feed intake and last medication given. "> 
        <a href="/phpork/addPig/pigDetails">
          <img class="img-responsive" src="<?php echo HOST;?>/phpork/images/home_insert.png">
        </a> 
      </div>
      <div class="col-md-2 col-centered image3" data-trigger= "hover" data-toggle="tooltip" title="Click to edit the information on what information will be displayed to customers and farm employees."> 
        <a href="/phpork/customize">
          <img class="img-responsive" src="<?php echo HOST;?>/phpork/images/home_customize.png">
        </a> 
      </div> 
    </div>

    <div class="page-footer"> 
      Prototype Pork Traceability System || Copyright &copy; 2014 - <?php echo date("Y");?> UPLB || funded by PCAARRD 
    </div>
    <script>
    $(document).ready(function(){
        /* Add user's tooltip*/
        $('.image1').tooltip({trigger: "hover"});
        $('.image2').tooltip({trigger: "hover"});
        $('.image3').tooltip({trigger: "hover"});
      });
      </script>
  </body>
</html>
