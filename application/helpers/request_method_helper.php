<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function is_post(){
    $CI = &get_instance();
    if($CI->input->server('REQUEST_METHOD') === 'POST')
        return TRUE;
    else
        return FALSE;
}

function is_get(){
    $CI = &get_instance();
    if($CI->input->server('REQUEST_METHOD') === 'GET')
        return TRUE;
    else
        return FALSE;
}

function post_required(){
    $CI = &get_instance();
    if($CI->input->server('REQUEST_METHOD') === 'GET'){
        if($CI->input->is_ajax_request()){
            $CI->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'error' => 'Not Found'
                )));
            exit;
        }else{
            show_404(uri_string());
        }
    }
}

function get_required(){
    $CI = &get_instance();
    if($CI->input->server('REQUEST_METHOD') === 'POST'){
        if($CI->input->is_ajax_request()){
            $CI->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'error' => 'Not Found'
                )));
            exit;
        }else{
            show_404(uri_string());
        }
    }
}


