<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function login_required($false2url = 'login'){
    $CI = &get_instance();
    if($current_user = $CI->session->userdata('current_user')){
        return $current_user;
    }else if($CI->input->is_ajax_request()){
        header("Content-Type: application/json");
        exit(json_encode(array(
            'error' => 'Unauthorized',
            'location' => $false2url
        )));
    }else{
        redirect($false2url);
    }
}

function logout_required($false2url = '/'){
    $CI = &get_instance();
    if($CI->session->userdata('current_user')){
        if($CI->input->is_ajax_request()){
            header("Content-Type: application/json");
            exit(json_encode(array(
                'error' => 'Authorized',
                'location' => $false2url
            )));
        }else{
            redirect($false2url);
        }
    }
}

function correct_password($password){
    $CI = &get_instance();
    $current_user = $CI->session->userdata('current_user');
    if($password === $current_user['password']){
        return TRUE;
    }
    return FALSE;
}