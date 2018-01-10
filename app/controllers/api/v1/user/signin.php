<?php

require('DB\Mysql.php');
require('./Model.php');
require('./Utils.php');
require('./Digest.php');
require('./User.php');
require('./AccessToken.php');

$utils = new Utils();
$user = new User();
$digest = new Digest();
$token = new AccessToken();
$realm = "aptp_app";
$perm1 = array("hash");
$perm2 = array("email", "nonce", "realm", "hash", "uri");

// GET 방식으로 들어온 파라미터가 있는지 확인
if( $utils->check_parameter($perm1, $_GET) ){
  $nonce = hash("sha256", uniqid());
  $result = $digest->start_auth($_GET['hash'], $nonce, $realm, "POST:/api/v1/user/signin.json");
  if( $result )
    $res = array("result" => true, "error_code" => 1000, "nonce" =>$nonce, "realm"=>$realm);
  else
    $res = array("result" => false, "error_code" => 1003);

    echo json_encode($res);
}
// POST 방식으로 들어온 파라미터가 있는지 확인
else if( $utils->check_parameter($perm2, $_POST) ){
  $password = $user->get_password($_POST['email']);
  $data = $digest->get_digest($_POST['nonce']);
  $ha1 = hash("sha256", $_POST['email'].":".$realm.":".$password);
  $ha2 = hash("sha256", 'POST:'.$_POST['uri']);
  $hash = hash("sha256", $ha1.":".$data->nonce.":".$ha2);

  $res =   $res = array("result" => "yet" );

  if( $hash == $_POST['hash'] ){
    $user_idx = $user->get_idx($_POST['email']);
    $access_token = $token->assign_access_token($user_idx, $_POST['nonce']);
    if( $access_token ){
      $res = array("result" => true, "error_code" => 1000, "access_token" => $access_token );
      //echo json_encode($res);
    } else {
      $res = array("result" => false, "error_code" => 1003, "access_token" => $user_idx);
    }
  } else {
    $res = array("result" => false, "error_code" => 1002);
  }

  echo json_encode($res);
}
// 파라미터 에러
else {
  $res = array("result" => false, "error_code" => 1001);
}

?>
