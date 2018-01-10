<?php

class User extends Model{

  function User(){
    parent::__construct("User");
  }

  function signup($data){
    if( $this->is_user($data['email']) ){
      return array("result" => false, "error_code" => 1003); 
    }
    $perm = array("email", "password", "name", "birth", "gender", "height", "weight");
    return $this->_insert($perm, $data);
  }

  function is_user($email){
    $email = $this->db->escape_string($email);
    $query = "select idx from `User` where email='".$email."' limit 1";

    $this->db->query($query);
    $res = $this->db->nfo();

    if( !$res ) 
      return false;
    return true;
  }

  function get_user_info($user_idx){
    $user_idx = $this->db->escape_string($user_idx);
    $query = "select email, name, birth, gender, height, weight from `User` where idx='".$user_idx."'";

    $this->db->query($query);
    $res = $this->db->nfa();

    return $res;
  }

  function get_idx($email){
    $email = $this->db->escape_string($email);
    $query = "select idx from `User` where email='".$email."' limit 1";

    $this->db->query($query);
    $res = $this->db->nfo();

    if( !$res ) 
      return false;
    return $res->idx;
  }
  function get_password($email){
    $email = $this->db->escape_string($email);
    $query = "select password from `User` where email='".$email."' limit 1";

    $this->db->query($query);
    $res = $this->db->nfo();

    if( !$res ) 
      return false;
    return $res->password;
 
  }
}
?>
