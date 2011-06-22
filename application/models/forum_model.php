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

  public function getForumsForDomain($domain_id) {
    $this->db->where('f.domain_id', $domain_id);
    $this->db->where('f.status', 1);
    $this->db->order_by('f.sorder');
    $query = $this->db->get('forum f');
    return $query->result_array();
  }

  public function getForum($forum_id){
    $domain_id = $this->getd('domain_id');
    $this->db->where('domain_id', $domain_id);
    $this->db->where('status', 1);
    $this->db->limit(1);
    $query = $this->db->get('forum');
    return $query->row_array();
  }

  public function getTopics($forum_id, $start, $offset){
    $this->db->where('forum_id', $forum_id);
    $this->db->where('status', 1);
    $this->db->where('pid', 0);
    $this->db->limit($start, $offset);
    $query = $this->db->get('post p');
    return $query->result_array();
  }

  public function getTopicCount($forum_id){
    $this->db->where('forum_id', $forum_id);
    $this->db->where('pid', 0);
    $this->db->where('status', 1);
    $this->db->from('post');
    return $this->db->count_all_results();
  }

  public function getPosts($topic_id){
    $this->db->where('status', 1);
    $this->db->where('id', $topic_id);
    $this->db->or_where('pid', $topic_id);
    $this->db->order_by('pid');
    $this->db->order_by('created');
    $query = $this->db->get('post p');
    return $query->result_array();
  }

  public function getPost($forum_id, $topic_id){
    $this->db->where('id', $topic_id);
    $this->db->where('forum_id', $forum_id);
    $this->db->where('status', 1);
    $this->db->limit(1);
    $query = $this->db->get('post p');
    return $query->row_array();
  }
  
  function save($forum_id, $topic_id, $post, $action){
    $data = array(
      'title' => $post['title'],
      'body' => $post['body'],
    );
    if ($action == 'insert'){
      $data['forum_id'] = $forum_id;
      $data['pid'] = $topic_id;
      $data['tripcode'] = $post['password'];
      $data['status'] = 1;
      $this->db->set($data);
      $this->db->set('updated', 'CURRENT_TIMESTAMP', FALSE);
      $this->db->insert('post');
      $id = $this->db->insert_id();
      if($topic_id){
        $this->db->set('updated', 'CURRENT_TIMESTAMP', FALSE);
        $this->db->where('id', $topic_id);
        $this->db->update('post');
      }
      return $id;
    } else {
      $this->db->set($data);
      $this->db->set('updated', 'CURRENT_TIMESTAMP', FALSE);
      $this->db->where('id', $topic_id);
      $this->db->where('forum_id', $forum_id);
      $this->db->update('post');
      return $topic_id;
    }
  }

  public function getPostsForDomain($domain_id, $limit = 30){
    $this->db->select('p.*');
    $this->db->join('forum f', 'f.id = p.forum_id');
    $this->db->where('f.domain_id', $domain_id);
    $this->db->order_by('p.created', 'DESC');
    $this->db->limit($limit);
    $query = $this->db->get('post p');
    return $query->result_array();
  }

}

?>
