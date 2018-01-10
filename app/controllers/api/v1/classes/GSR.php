<?php


class GSR extends Model{

  function GSR(){
    parent::__construct("GSR");
  }

  function insert($data){
    $perm = array("user_idx", "gsr", "timestamp");
    return $this->_insert($perm, $data);
  }

 function __insert($user_idx, $gsr, $timestamp){
    $perm = array("user_idx", "gsr", "timestamp");
    $data = array("user_idx" => $user_idx, "gsr" => $gsr, "timestamp" => $timestamp);

    $query = "insert into GSR  values ($user_idx, $gsr, '$timestamp');";
    $this->db->query($query);
 }
}

?>
