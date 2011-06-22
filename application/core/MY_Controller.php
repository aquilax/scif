<?php

class MY_Controller extends CI_Controller {

  protected $data = array();
  protected $domain_id = 1;

  public function __construct() {
    parent::__construct();
    $this->load->model('forum_model');
    $this->_getDomain();
    $this->_loadDefaults();
    //$this->output->enable_profiler(TRUE);
  }

  private function _getDomain() {
    $domain = strtolower($_SERVER['HTTP_HOST']);
    if (substr($domain, 0, 4) == 'www.') {
      $domain = substr($domain, 4);
    }
    $domain_id = $this->forum_model->getDomain($domain);
  }

  private function _loadDefaults() {
    $this->controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
    $this->action_name = $this->router->fetch_method();

    $site_title = $this->forum_model->getd('title');
    $this->data['site_title'] = $site_title?$site_title:'Forum';

    $this->data['pre_posts'] = $this->forum_model->getd('pre_text');
    $this->data['post_posts'] = $this->forum_model->getd('post_text');
    $this->data['analytics'] = $this->forum_model->getd('analytics');

    $this->data['title'] = 'Page Title';    
    $this->data['descr'] = 'Page Description';
    $this->data['heading'] = 'Page Heading';
    $this->data['content'] = '';
    $this->data['path'] = array();
  }

  protected function render($template = 'main'){
    $view_path = $this->controller_name . '/' . $this->action_name . '_tpl.php';
    if (file_exists(APPPATH . 'views/' . $view_path)) {
      $this->data['content'] .= $this->load->view($view_path, $this->data, true);
    }
    $this->load->view("layouts/".$template."_tpl.php", $this->data);    
  }
}
?>
