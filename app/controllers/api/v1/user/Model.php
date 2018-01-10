<?php
class Model{
  var $db,$TABLE;

  function __construct($TABLENAME){
    $this->db=new DB\Mysql;
    $this->TABLE=$TABLENAME;
  }
  function _insert($PERMISSION,$ARRAY){
    $COLUMNS=array();
    $VALUES=array();
    foreach( $PERMISSION as $KEY ){
      $COLUMNS[]="`$KEY`";

      if( $this->isAssoc($ARRAY) && (!empty($ARRAY[$KEY]) || isset($ARRAY[$KEY])) ){
        $VALUES[]="'".$this->db->escape_string($ARRAY[$KEY])."'";
      } else if( ! $this->isAssoc($ARRAY) ){
        foreach( $ARRAY as $i=>$VAL ){
          if( !empty($ARRAY[$i][$KEY]) || isset($ARRAY[$i][$KEY]) ){
            $VALUES[$i][]="'".$this->db->escape_string($ARRAY[$i][$KEY])."'";
          }
        }
      }
    }
    $COLUMNS=implode(",",$COLUMNS);
    if( $this->isAssoc($ARRAY) ){
      $VALUES="(".implode(",",$VALUES).")";
    } else {
      $TEMP = array();
      foreach( $VALUES as $i=>$SUB_ARR ){
        $TEMP[] = "(".implode(",", $SUB_ARR).")";
      }
      $VALUES = implode(",", $TEMP); 
    }
    $QUERY="insert into `$this->TABLE` ($COLUMNS) values $VALUES;";
    $this->db->query($QUERY);
    return $this->db->insert_id();
  }
  function _update($PERMISSION,$ARRAY,$WHERE){
    $VALUES=array();
    foreach( $PERMISSION as $KEY ){
      if( !empty($ARRAY[$KEY]) || isset($ARRAY[$KEY]) ){
        $EXP=explode(";",$ARRAY[$KEY]);
        if( count($EXP) == 2 && strlen($EXP[0]) == 1 ){
          // this means operator
          // usage: array('KEY' => "OP;VAL")         OP : +, -, etc..
          $VALUES[]="`$KEY`=`$KEY`$EXP[0]'".$this->db->escape_string($EXP[1])."'";
        }else{
          $VALUES[]="`$KEY`='".$this->db->escape_string($ARRAY[$KEY])."'";
        }
      }
    }
    $VALUES=implode(",",$VALUES);
    $QUERY="update `$this->TABLE` SET $VALUES WHERE $WHERE";
    return $this->db->query($QUERY);
  }
  function _delete($VALIDATE,$ARRAY){
    $VALUES=array();
    foreach( $VALIDATE as $KEY ){
      $VALUES[]="`$KEY`='".$this->db->escape_string($ARRAY[$KEY])."'";
    }
    $WHERE=implode(" and ",$VALUES);
    $QUERY="delete from `$this->TABLE` where 1 and $WHERE";
    return $this->db->query($QUERY);
  }

  // Ture if array is key=>value, False if array is index.
  function isAssoc($arr){
    return array_keys($arr) !== range(0, count($arr) - 1);
  }

}
?>
