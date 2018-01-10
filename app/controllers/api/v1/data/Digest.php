<?php

class Digest extends Model{

  function Digest(){
    parent::__construct("Digest");
  }

  function start_auth($hash, $nonce, $realm, $uri){
    $hash = $this->db->escape_string($hash);
    $nonce = $this->db->escape_string($nonce);
    $realm = $this->db->escape_string($realm);
    $uri = $this->db->escape_string($uri);
    $perm = array("hash", "nonce", "realm", "uri");
    $data = array("hash" => $hash, "nonce" => $nonce, "realm" => $realm, "uri" => $uri);
    return $this->_insert($perm, $data);
  }

  function get_digest($nonce){
    $nonce = $this->db->escape_string($nonce);
    $query = "select * from `Digest` where nonce='".$nonce."'";
    $this->db->query($query);
    $res = $this->db->nfo();

    return $res;
  }
}
