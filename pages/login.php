<!DOCTYPE HTML> 
<html lang = "en">
  <?php 
    session_start(); 
    // if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['user_type'])){
    //   if($_SESSION['user_type'] == 1) header("Location: /phpork/admin/home");
    //   else  header("Location: /phpork/encoder/home");
    // } 
    require_once "../connect.php"; 
    require_once "../inc/dbinfo.inc"; 

    if(count($_POST)>0){
      $res =  mysqli_query($con, "SELECT user_id,user_name,password,user_type FROM user WHERE user_name='" . $_POST["username"]."'; ") or die ( mysqli_error ( $con ) );
       $r = mysqli_fetch_row($res); 
       $pw = base64_decode($r[2]);
      /* $result = mysqli_query($con, "SELECT user_id,user_name,password,user_type FROM user WHERE user_name='" . $_POST["username"]."' and password = '". $_POST["password"]."'; ") or die ( mysqli_error ( $con ) ); */
      /* $row = mysqli_fetch_row($result); */
      if($r != null && $pw == $_POST['password']){
        $_SESSION["user_id"] = $r[0]; 
        $_SESSION["username"] = $r[1]; 
        $_SESSION["password"] = $r[2];
        $_SESSION["user_type"] = $r[3];

        if($_SESSION['user_type'] == 1) header("Location: /phpork/admin/home");
        elseif($_SESSION['user_type'] == 2)  header("Location: /phpork/encoder/home");
        else echo "<script> alert('This user is not valid anymore.'); </script>"; 

      }else{
        echo "<script> alert('Invalid username/password!'); </script>"; 
      } 
      mysqli_free_result($res); 
      mysqli_close($con); 
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
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/bootstrap-responsive.css">
    <link rel="stylesheet" href="<?php echo HOST;?>/phpork/css/style_login.css">

    <script src="<?php echo HOST;?>/phpork/js/jquery-2.1.4.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/jquery-latest.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/jquery.min.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/bootstrap.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/bootstrap.min.js" type="text/javascript"></script> 
    <script src="<?php echo HOST;?>/phpork/js/jquery.min.js"></script> 
    <script src="<?php echo HOST;?>/phpork/js/bootstrap.min.js"></script>
  </head>
  
  <body>
    <div class="container">
      <div class="row row-right pos3">
        <div class="col-md-2 col-centered" style="height: 10%; width: 13%;">
          <img src="<?php echo HOST;?>/phpork/images/qrcode.png" class="img-responsive">
        </div>
      </div>
      <form  method = "post"  autocomplete = "off">
        <div class="row row-centered pos1">
          <div class="col-sm-6 col-md-4 col-centered" style="background-color: #bb1d24; border-radius: 25px; padding-top: 1%">
              <img src="<?php echo HOST;?>/phpork/images/logo.jpg" class="img-responsive">
            <div class="form-group form-group-sm input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input class="form-control userInput" type="username" name='username' placeholder="Username" data-trigger= "hover" data-toggle="tooltip" title="Input your username." required/>     
            </div>
            <div class="form-group form-group-sm input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input class="form-control pwInput" type="password" name='password' placeholder="Password" data-trigger= "hover" data-toggle="tooltip" title="Input your password." required/>     
            </div>
            <button type="submit" class="submit" name="loginFlag" data-trigger= "hover" data-toggle="tooltip" title="Click to proceed to next page.">
              <i class="fa fa-long-arrow-right">
                <img src="<?php echo HOST;?>/phpork/images/arrow.png" id="arrow_img">
              </i>
            </button>    
          </div>
        </div>
      </form>
      <div class="row row-centered pos2">
        <div class="col-md-2 col-centered" style="height: 10.5%; width: 10.5%;">
          <img src="<?php echo HOST;?>/phpork/images/logos/ADSC logo.jpg" class="img-responsive">
        </div>
        <div class="col-md-2 col-centered" style="height: 11%; width: 11%;">
          <img src="<?php echo HOST;?>/phpork/images/logos/ICS logo.png" class="img-responsive">
        </div>
        <div class="col-md-2 col-centered" style="height: 9.8%; width: 9.8%;">
          <img src="<?php echo HOST;?>/phpork/images/logos/PCAARRD logo.png" class="img-responsive">
        </div>
        <div class="col-md-2 col-centered" style="height: 10.5%; width: 10.5%;">
          <img src="<?php echo HOST;?>/phpork/images/logos/UPLB logo.png" class="img-responsive">
        </div>
      </div>
    </div> 
    <script>
    $(document).ready(function(){
        $('.submit').tooltip({trigger: "hover"});
        $('.userInput').tooltip({trigger: "hover"});
        $('.pwInput').tooltip({trigger: "hover"});
    });
    </script> 
  </body>
</html>
