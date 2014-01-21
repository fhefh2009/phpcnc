<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Common extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('topics_model');
        $this->load->model('statistics_model');
    }

    public function about(){

        $hot_topics = $this->topics_model->get_hot_topics();
        $statistics = $this->statistics_model->get_statistics();

        $data['title'] = '关于PHPCNC';
        $data['hot_topics'] = $hot_topics;
        $data['statistics'] = $statistics;
        $this->load->view('common/about', $data);
    }

}