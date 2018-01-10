<?php

$utils = new Utils();
$user = new User();
$perm = array("email", "password", "name", "birth", "gender", "height", "weight");

if( $utils->check_parameter($perm, $_POST) ){
  $res = $user->signup($_POST);
  if( $res ){
    $res = array("result" => true, "error_code" => 1000);
  } else{
    $res = array("result" => false, "error_code" => 1003);
  }
} else {
  $res = array("result" => false, "error_code" => 1001);
}

?>
