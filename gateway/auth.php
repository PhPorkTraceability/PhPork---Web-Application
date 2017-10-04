<?php
  include "../inc/functions.php";
  $db = new phpork_functions();
  /* 
    Gateway for login.php and functions.php. 
    This page calls all the functions needed in login.php page and returns the result using json_encode.
  */
  
  if(isset($_POST['signup'])){
    $u = $_POST['username'];
    $p = base64_encode($_POST['password']);
    $uType = $_POST['usertype'];
    $user = $_POST['user'];
    $db->signup($u, $p , $uType,$user);
     
  }

  if(isset($_POST['getUser'])){
    $user_id = $_POST['user_id'];
    echo json_encode($db->getUser($user_id)); 
    
  
  }

  if(isset($_POST['ddl_user'])){
     echo json_encode($db->ddl_user()); 
  }


?>