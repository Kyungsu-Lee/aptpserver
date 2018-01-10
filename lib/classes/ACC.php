<?php


class ACC extends Model{

  function ACC(){
    parent::__construct("ACC");
  }

  function insert($data){
    $perm = array("user_idx", "x", "y", "z", "timestamp");
    return $this->_insert($perm, $data);
  }
function __insert($user_idx, $x, $y, $z , $timestamp){

    $query = "insert into ACC values ($user_idx, $x, $y, $z, '$timestamp');";
    $this->db->query($query);
 }

}

?>
