<?php


class RRI extends Model{

  function RRI(){
    parent::__construct("RRI");
  }

  function insert($data){
    $perm = array("user_idx", "rri", "timestamp");
    return $this->_insert($perm, $data);
  }
function __insert($user_idx, $rri, $timestamp){	
    $query = "insert into RRI  values ($user_idx, $rri, '$timestamp');";
    $this->db->query($query);
 }

}

?>
