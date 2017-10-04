<!DOCTYPE html>
<html lang="en">
  <?php 

    /* 
        For the system configuration of the system: if it is fully-connected, semi-connected or not connected.
    */

    session_start(); 
    
    include "../inc/functions.php"; 
    $db = new phpork_functions ();

    $data_cat = "";
    $data_opt = "";

    if(isset($_POST['submit'])) {
      foreach ($_POST['optradio'] as $data_cat => $data_opt) {
        if($data_cat == "1"){

          $f = "netsh int ip set address \"RFID\" static 192.168.1.202 255.255.255.0\r\nnetsh int ip set address \"VIRTUAL HOST\" static 10.0.5.65 255.255.254.0 10.0.5.254\r\nnetsh interface ip set dns \"VIRTUAL HOST\" static 8.8.8.8\r\n";
          $index = fopen("../config.bat", 'w');
          fwrite ($index, $f);
          fclose ($index);
          echo '<script>alert("System Fully Connected");</script>';
        }elseif($data_cat == "2"){
          $f = "netsh int ip set address \"VIRTUAL HOST\" static 10.0.5.65 255.255.254.0 10.0.5.254\r\nnetsh interface ip set dns \"VIRTUAL HOST\" static 8.8.8.8\r\n";
          $index = fopen("../config.bat", 'w');
          fwrite ($index, $f);
          fclose ($index);
          echo '<script>alert("System Semi Connected");</script>';
        }else if($data_cat == "3"){
          echo '<script>alert("System Not Connected");</script>';
        }
      }
      echo '<script>window.close();</script>';
    }
      //echo "Hey!";
      //console.log("hey");
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
    <div class="page-header" data-trigger= "hover" data-toggle="tooltip" data-placement="bottom"> 
      <a href="/phpork/encoder/home" >
        <img class="img-responsive" src="<?php echo HOST;?>/phpork/images/Header1.png"> 
      </a>
    </div>

   
    <div class="lower" >
        <div class="table1" style="margin-left: 20%; margin-right: 20%;" >
          <table class="table">
            <thead>
              <tr>
                <th rowspan="1" colspan="1">SYSTEM CONFIG</th>
              </tr>
            </thead>
            <tbody>
                <form method="post" id="form1">
                <tr>
                  <th class="theader" scope="row" name="basicinfo">Fully Connected</td>
                  <td style="text-align:center"><input class="c" id="a2" type="radio" name="optradio[1]" value="full_connected"></td>
                </tr>
                <tr>
                  <th class="theader" scope="row" name="parentage">Semi Connected</td>
                  <td style="text-align:center"><input class="c" id="b2" type="radio" name="optradio[1]" value="semi_connected"></td>
                </tr>
                <tr>
                  <th class="theader" scope="row" name="movement">Not Connected</td>
                  <td style="text-align:center"><input class="c" id="c2" type="radio" name="optradio[1]" value="not_connected"></td>
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

  </body>
</html>