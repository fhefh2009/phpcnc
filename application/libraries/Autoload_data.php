<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Autoload_data {

    public function __construct(){
        $CI = & get_instance();

        $data['current_user'] = $CI->session->userdata('current_user');
        if($data['current_user']){
            $CI->load->model('notifications_model');
            $data['unread_notifications_count'] = $CI->notifications_model->unread_count($data['current_user']['id']);
        }

        $CI->load->vars($data);
    }
} 