<?php

$utils = new Utils();
$token = new AccessToken();
$user = new User();
$perm = array("access_token");

if( $utils->check_parameter( $perm, $_POST ) ){
  $user_idx = $token->check_auth($_POST['access_token']);
  if( $user_idx ){
    $data = $user->get_user_info($user_idx);
    if( $data ){
      $res = array("result" => true, "error_code" => 1000);
      $res = array_merge($res, $data);
    } else {
      $res = array("result" => false, "error_code" => 1003);
    }
  } else {
    $res = array("result"=>false, "error_code" => 1002);
  }
} else {
  $res = array("result" => false, "error_code" => 1001);
}

?>
