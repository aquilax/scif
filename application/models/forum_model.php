<?php

class Forum_Model extends CI_Model {

  private $row = array();

  function __construct(){
    parent::__construct();
    //TODO: Get rid of this
    $this->db->query('SET search_path TO forum, public;');
  }

  public function getd($name, $default = FALSE){
    if (isset($this->row[$name])){
      return $this->row[$name];
    }
    return $default;
  }

  public function getDomain($domain){
    $this->db->where('status', 1);
    $this->db->where('url', $domain);
    $this->db->limit(1);
    $query = $this->db->get('edomain');
    if ($query->num_rows() > 0){
      $this->row = $query->row_array();
      return $this->row['domain_id'];
    }
  }
  
}

?>
