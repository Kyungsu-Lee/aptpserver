<?php

class Utils{
  function check_parameter($permission, $array){
    foreach( $permission as $key ){
      if( !isset($array[$key]) || empty($array[$key]) ){
        return false;
      }
    }
    return true;
  }
}
