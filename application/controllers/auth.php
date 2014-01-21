<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('statistics_model');
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->helper('email');
        $this->load->helper('string');
        $this->load->helper('captcha');
        $this->load->helper('security');
        $this->load->helper('date');
        $this->load->helper('auth_check');
        $this->load->helper('gravatar');
    }

    public function register(){
        logout_required();

        if($this->form_validation->run() === FALSE){
            $data['title'] = "加入PHPCNC";
            $data['csrf_token'] = $this->security->get_csrf_hash();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['registered'] = $this->session->flashdata('registered');
            $this->load->view('auth/register', $data);
        }else{
            $email = $this->input->post('email');
            $active_code = random_string('sha1');
            $id = $this->users_model->add_user($email, $active_code);
            if($id){
                send_active_email($email, $id, $active_code);
                $this->session->set_flashdata('registered', 'ok');
                redirect('register');
            }else{
                show_error('OOPS!TIGER IS COMING!');
            }
        }
    }

    public function login(){
       logout_required();

        if($this->form_validation->run() === FALSE){
            if($this->agent->is_referral()){
                $referrer = $this->agent->referrer();
                if($referrer != base_url(uri_string()) && strpos($referrer, base_url()) !== FALSE){
                    $this->session->set_userdata('referrer', $referrer);
                }
            }
            $data['title'] = "冒泡";
            $data['csrf_token'] = $this->security->get_csrf_hash();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['login'] = $this->session->flashdata('login');
            $data['reset_password'] = $this->session->flashdata('reset_password');
            $this->load->view('auth/login', $data);
        }else{
            $email = $this->input->post('email');
            $password = do_hash($this->input->post('password'));
            if($user = $this->users_model->verify_user($email, $password)){
                $this->users_model->update_login_time($user['id']);
                $user['created_on'] = mdate('%Y-%m-%d', $user['created_on']);
                $this->session->set_userdata('current_user', $user);
                if($referrer = $this->session->userdata('referrer')){
                    $this->session->unset_userdata('referrer');
                    redirect($referrer);
                }else{
                    redirect('/');
                }
            }else{
                $this->session->set_flashdata('login', 'fail');
                redirect('login');
            }
        }
    }

    public function logout(){
        login_required();
        $this->session->sess_destroy();
        redirect('/');
    }

    public function active($id = '', $activation_code = ''){
        logout_required();

        if($id && $activation_code){
            if($user = $this->users_model->check_activation_code($id, $activation_code)){
                $this->session->set_userdata('user', $user);
                redirect('active');
            }else{
                show_404(uri_string());
            }
        }else{
            $user = $this->session->userdata('user');
            if($user){
                if($this->form_validation->run() === FALSE){
                    $data['title'] = '激活账户';
                    $data['csrf_token'] = $this->security->get_csrf_hash();
                    $data['csrf_name'] = $this->security->get_csrf_token_name();
                    $this->load->view('auth/active', $data);
                }else{
                    $username = $this->input->post('username');
                    $password = do_hash($this->input->post('password'));
                    $avatar = get_gravatar_hash($user['email']);

                    $this->db->trans_start();
                    $user = $this->users_model->active_user($user['id'], $username, $password, $avatar);
                    $this->statistics_model->increment_user_count();
                    $this->db->trans_complete();

                    if($this->db->trans_status() === FALSE){
                        show_error('OOPS!TIGER IS COMING!');
                    }else{
                        $this->session->set_userdata('current_user', $user);
                        $this->session->unset_userdata('user');
                        redirect('/');
                    }
                }
            }else{
                show_404(uri_string());
            }
        }

    }

    public function forgotten_password(){
        logout_required();

        if($this->form_validation->run() === FALSE){
            $data['title'] = "忘记密码";
            $data['csrf_token'] = $this->security->get_csrf_hash();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['send_email'] = $this->session->flashdata('send_email');
            $this->load->view('auth/forgotten_password', $data);
        }else{
            $email = $this->input->post('email');
            $forgotten_password_code = random_string('sha1');
            if($id = $this->users_model->set_forgotten_password_code($email, $forgotten_password_code)){
                send_reset_password_email($email, $id, $forgotten_password_code);
                $this->session->set_flashdata('send_email', 'ok');
            }
            redirect('forgotten/password');
        }
    }

    public function reset_password($id = '', $forgotten_password_code = ''){
        logout_required();

        if($id && $forgotten_password_code){
            if($this->users_model->check_forgotten_password_code($id, $forgotten_password_code)){
                $this->session->set_userdata('user_id', $id);
                redirect('reset/password');
            }else{
                show_404(uri_string());
            }
        }else{
            $user_id = $this->session->userdata('user_id');
            if($user_id){
                if($this->form_validation->run() === FALSE){
                    $data['title'] = '重置密码';
                    $data['csrf_token'] = $this->security->get_csrf_hash();
                    $data['csrf_name'] = $this->security->get_csrf_token_name();
                    $this->load->view('auth/reset_password', $data);
                }else{
                    $password = do_hash($this->input->post('password'));
                    $this->users_model->reset_password($user_id, $password);
                    $this->session->unset_userdata('user_id');
                    $this->session->set_flashdata('reset_password', 'ok');
                    redirect('login');
                }
            }else{
                show_404(uri_string());
            }

        }
    }

    public function captcha(){
        $option = array(
            'img_path' => './static/img/captcha/',
            'img_url' => $this->config->item('base_url').'static/img/captcha/',
            'expiration' => 60
        );
        $cap = create_captcha($option);
        $this->session->set_flashdata('captcha', strtolower($cap['word']));
        $this->output->set_output( $cap['image']);
    }

    public function _check_captcha($captcha){
        if(strtolower($captcha) === $this->session->flashdata('captcha')){
            return true;
        }else{
            return false;
        }
    }

    public function _email_valid($email){
        return $this->users_model->email_valid($email);
    }
}