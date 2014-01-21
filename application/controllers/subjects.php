<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Subjects extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('subjects_model');
        $this->load->model('statistics_model');
        $this->load->helper('date');
    }

    public function subject_list(){
        $subjects = $this->subjects_model->get_subjects();
        foreach($subjects as &$subject){
            $subject['last_alter_on'] = timespan($subject['last_alter_on']);
        }
        unset($comment);

        $data['title'] = '主题';
        $data['subjects'] = $subjects;
        $data['statistics'] = $this->statistics_model->get_statistics();
        $this->load->view('subjects/subject_list', $data);
    }
}