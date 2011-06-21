<?php

class Home extends MY_Controller {

  function index(){
    $this->data['forums'] = $this->forum_model->getForumsForDomain($this->domain_id);
    $this->render();
    $this->data['path']['/'] = lang('Home');
  }

  function forum(){
    $forum_id = (int)$this->uri->segment(2);
    $page = (int)$this->uri->segment(3);
    $page = $page?$page:0;

    if (!$forum_id){
      show_404();
    }

    $this->data['forum'] = $this->forum_model->getForum($forum_id);
    if (!$this->data['forum']){
      show_404();
    }

 
    $this->load->library('pagination');
    $config['base_url'] = site_url('forum/'.$forum_id.'/'.$page);
    $config['total_rows'] = $this->forum_model->getTopicCount($forum_id);
    $config['per_page'] = '20'; 
    $config['uri_segment'] = 3;
    $this->pagination->initialize($config); 

    $this->data['topics'] = $this->forum_model->getTopics($forum_id, $config['per_page'], $page);

    $this->data['path']['forum/'.$forum_id] = $this->data['forum']['title'];
    $this->action_name = 'forum';
    $this->render();
  }

  function topic(){
    $forum_id = (int)$this->uri->segment(2);
    $topic_id = (int)$this->uri->segment(3);
    $this->data['topic_id'] = $topic_id;

    $this->data['forum'] = $this->forum_model->getForum($forum_id);
    if (!$this->data['forum']){
      show_404();
    }

    $this->data['posts'] = $this->forum_model->getPosts($topic_id);
    
    if ($this->data['posts']){
      $ptitle = $this->data['posts'][0]['title'];
      $this->data['button_title'] = lang('Reply');
    } else {
      $ptitle = '';
      $this->data['button_title'] = lang('Post');
    }


    $this->load->library('form_validation'); 

    $this->action_name = 'topic';
   
    $this->data['post'] = array(
      'title' => $ptitle,
      'body' => '',
    );

    $this->data['path']['forum/'.$forum_id] = $this->data['forum']['title'];
    $this->data['path']['topic/'.$forum_id.'/'.$topic_id] = $ptitle;
    $this->load->helper(array('date', 'form'));
    $this->render();
  }

}

?>
