<?php

class Home extends MY_Controller {

  function __construct(){
    parent::__construct();
    $this->data['path']['/'] = lang('Home');
  }

  function index(){
    $this->data['forums'] = $this->forum_model->getForumsForDomain($this->domain_id);
    $this->data['title'] = $this->forum_model->getd('title', lang('Forum'));
    $this->render();
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
    $config['base_url'] = site_url('forum/'.$forum_id);
    $config['total_rows'] = $this->forum_model->getTopicCount($forum_id);
    $config['per_page'] = '20'; 
    $config['uri_segment'] = 3;

    $this->pagination->initialize($config); 

    $this->data['topics'] = $this->forum_model->getTopics($forum_id, $config['per_page'], $page);

    $this->data['forum_id'] = $forum_id;
    $this->data['title'] = q($this->data['forum']['title']);
    $this->data['descr'] = $this->data['title'];
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

    $this->_processForm($forum_id, $topic_id);
    if ($topic_id != 0){
      $this->data['posts'] = $this->forum_model->getPosts($topic_id);
    } else {
      $this->data['posts'] = FALSE;
    }
 
    $this->data['path']['forum/'.$forum_id] = $this->data['forum']['title'];

    if ($this->data['posts']){
      $ptitle = 'Re:'.$this->data['posts'][0]['title'];
      $this->data['button_title'] = lang('Reply');
      $this->data['path']['topic/'.$forum_id.'/'.$topic_id] = $ptitle;
      $this->data['title'] = q($this->data['posts'][0]['title']).' &raquo; '.q($this->data['forum']['title']);
      $this->data['descr'] = $this->data['posts'][0]['title'];
    } else {
      $ptitle = '';
      $this->data['button_title'] = lang('Post');
      $this->data['path']['topic/'.$forum_id] = lang('New topic');
      $this->data['title'] = lang('New topic').' &raquo; '.q($this->data['forum']['title']);
      $this->data['descr'] = lang('New topic').' - '.$this->data['forum']['title'];
    }

    $this->action_name = 'topic';
   
    $this->data['post'] = array(
      'title' => $ptitle,
      'body' => '',
    );

    $this->load->helper(array('date', 'form'));
    $this->render();
  }

  function edit() {
    $forum_id = (int)$this->uri->segment(2);
    $topic_id = (int)$this->uri->segment(3);
    $this->data['topic_id'] = $topic_id;

    $this->data['forum'] = $this->forum_model->getForum($forum_id);
    if (!$this->data['forum']){
      show_404();
    }

    $this->data['post'] = $this->forum_model->getPost($forum_id, $topic_id);

    if (!$this->data['post']){
      show_404();
    }

    $this->_processForm($forum_id, $this->data['post']['id'], $this->data['post']['tripcode'], 'edit');

    $this->data['path']['forum/'.$forum_id] = $this->data['forum']['title'];
    $this->data['path']['topic/'.$forum_id.'/'.$topic_id] = $this->data['post']['title'];
    $this->data['path']['edit/'.$forum_id.'/'.$topic_id] = lang('Edit');

    $this->data['button_title'] = lang('Edit');
    $this->data['title'] = lang('Edit topic');
    $this->data['descr'] = lang('Edit topic');
    $this->load->helper(array('date', 'form'));
    $this->action_name = 'edit';
    $this->render();
  }

  function _processForm($forum_id, $topic_id, $tripcode='', $action = 'insert'){
    $this->load->library('form_validation'); 
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
    $this->form_validation->set_rules('name', lang('Name'), 'trim');
    $this->form_validation->set_rules('title', lang('Title'), 'strip_tags|trim|required|min_length[3]|max_length[150]');
    if ($action == 'edit'){
      $this->form_validation->set_rules('password', lang('Password'), 'required|mktripcode');
    } else {
      $this->form_validation->set_rules('password', lang('Password'), 'mktripcode');
    }
    $this->form_validation->set_rules('body', lang('Text'), 'strip_tags|trim|required|min_length[10]'); 

    if ($this->form_validation->run()){
      $name = $this->input->post('name');
      if ($name){
        redirect('forum/'.$forum_id);
      }
      
      if ($action == 'edit'){
        if ($tripcode != $_POST['password']){
          $this->form_validation->_error_array[] = lang('Wrong password');
          return;
        }
      }
      
      $id = $this->forum_model->save($forum_id, $topic_id, $_POST, $action);
      if($topic_id){
        redirect('topic/'.$forum_id.'/'.$topic_id.'#'.$id);
      } else {
        redirect('topic/'.$forum_id.'/'.$topic_id);
      }
    }

  }

}

?>
