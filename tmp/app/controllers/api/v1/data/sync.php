<?
/**
 *  Author : leesk0502
 *
 *  Insert experiment data in database
 *
 *  Type : json
 *  Input Example : Array( "access_token" => "access_token string",
                           "data" => json_encode(array ( "BPM" => array ( 
 *                                                          array( "bpm" => 2000, "timestamp" => "2016-05-02 22:00:00.000" ),
 *                                                          array( "bpm" => 2000, "timestamp" => "2016-05-02 22:00:00.000" ),
 *                                                          array( "bpm" => 2000, "timestamp" => "2016-05-02 22:00:00.000" )
 *                                                         ),
 *                                          "RRI" => array (
 *                                                          array( "rri" => 70, "timestamp" => "2016-05-02 22:00:00.000" )
 *                                                         )
 *                                          "ACC" => array (
 *                                       array( "x" => 0.22, "y" => 0.23, "z" => 0.55, "timestamp" => "2016-05-02 22:00:00.000" ),
 *                                       array( "x" => 0.22, "y" => 0.23, "z" => 0.55, "timestamp" => "2016-05-02 22:00:00.000" )
 *                                                         )
 *                                        ))
 *                       )
 */

$utils = new Utils();
$token = new AccessToken();
$perm = array("access_token", "data");

if( $utils->check_parameter( $perm, $_POST ) ){
  $user_idx = $token->check_auth($_POST['access_token']);
  if( $user_idx ){
    $BPM = new BPM();
    $RRI = new RRI();
    $ACC = new ACC();

    if( $_POST['data'] ){
      $_POST = json_decode($_POST['data'], true); 
      //$BPM->insert($_POST['BPM']);
      $BPM->__insert($user_idx, $_POST['BPM']['bpm'], $_POST['BPM']['timestamp']);
      $ACC->__insert($user_idx, $_POST['ACC']['x'], $_POST['ACC']['y'], $_POST['ACC']['z'], $_POST['ACC']['timestamp']);
      $RRI->__insert($user_idx, $_POST['RRI']['rri'], $_POST['RRI']['timestamp']);

      $res = array("result"=>true, "error_code" => 1000,"BPM"=>$_POST['BPM'], "ACC"=>$_POST['ACC'], "RRI"=>$_POST['RRI']);
    } else {
      $res = array("result"=>false, "error_code" => 1003);
    }
  } else {
    $res = array("result"=>false, "error_code" => 1002);
  }
} else {
  $res = array("result" => false, "error_code" => 1001);
}
?>
