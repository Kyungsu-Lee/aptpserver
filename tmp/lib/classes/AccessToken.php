<?php

class AccessToken extends Model{
  function AccessToken(){
    parent::__construct("AccessToken");
  }

  function assign_access_token($user_idx){
    $nonce = $this->db->escape_string($nonce);
    $access_token = hash("sha256", uniqid());
    $perm = array("user_idx", "access_token");

    $query = "select * from `AccessToken` where user_idx = '$user_idx'";
    $this->db->query($query);
    $res = $this->db->nfo();

    // Already exist
    if( $res ){
      $res = $this->_update($perm, array("access_token" => $access_token), "user_idx = '$user_idx'");
    } else {
      $res = $this->_insert($perm, array("user_idx" => $user_idx, "access_token" => $access_token));
    }

    if( $res )
      return $access_token;

    return false;
  }

  function check_auth($access_token){
    $access_token = $this->db->escape_string($access_token);
    $query = "select user_idx from AccessToken where access_token = '".$access_token."'";
    $this->db->query($query);
    $res = $this->db->nfo();
    
    if( !$res ) 
      return false;

    //$query = "update `AccessToken` set expire_time = DATE_ADD(NOW(), INTERVAL 1440 MINUTE)";
    $this->db->query($query);
    return $res->user_idx;
  }
}
