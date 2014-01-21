<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function send_active_email($to, $id, $activation_code){
    $CI = &get_instance();
    $CI->load->library('email');
    $CI->email->from('phpcnc@phpcnc.org', 'phpcnc');
    $CI->email->to($to);
    $CI->email->subject('账号激活');
    $data['active_segments'] = 'active/'.$id.'/'.$activation_code;
    $CI->email->message($CI->load->view('email/active', $data, TRUE));
    if(!$CI->email->send()){
        log_message( 'error', '未能成功发送激活邮件');
        show_error('OOPS!TIGER IS COMING!');
    }
}

function send_reset_password_email($to, $id, $forgotten_password_code){
    $CI = &get_instance();
    $CI->load->library('email');
    $CI->email->from('phpcnc@phpcnc.org', 'phpcnc');
    $CI->email->to($to);
    $CI->email->subject('密码重置');
    $data['reset_segments'] = 'reset/password/'.$id.'/'.$forgotten_password_code;
    $CI->email->message($CI->load->view('email/reset_password', $data, TRUE));
    if(!$CI->email->send()){
        log_message( 'error', '未能成功发送重置邮件');
        show_error('OOPS!TIGER IS COMING!');
    }
}