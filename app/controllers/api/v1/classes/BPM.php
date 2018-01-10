<?php


class BPM extends Model{

  function BPM(){
    parent::__construct("BPM");
  }

  function insert($data){
    $perm = array("user_idx", "bpm", "timestamp");
    return $this->_insert($perm, $data);
  }

 function __insert($user_idx, $bpm, $timestamp){
    $perm = array("user_idx", "bpm", "timestamp");
    $data = array("user_idx" => $user_idx, "bpm" => $bpm, "timestamp" => $timestamp);

    $query = "insert into BPM  values ($user_idx, $bpm, '$timestamp');";
    $this->db->query($query);
 }
}

?>
