<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users extends CI_Controller {

    const TOPICS_PER_PAGE = 2;
    const COMMENTS_PER_PAGE = 100;//should be same with Topics class' const COMMENTS_PER_PAGE

    public function __construct(){
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('topics_model');
        $this->load->model('subjects_model');
        $this->load->model('statistics_model');
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper('security');
        $this->load->helper('auth_check');
    }

    public function top108(){
        $users = $this->users_model->get_top108();
        $statistics = $this->statistics_model->get_statistics();
        $data['title'] = "一百零八将";
        $data['users'] = $users;
        $data['statistics'] = $statistics;
        $this->load->view('users/top108', $data);
    }

    public function detail($user_id, $page = 1){
        $host = $this->users_model->get_user_detail($user_id);
        if($host){
            $max_page = ceil($host['topic_count'] / self::TOPICS_PER_PAGE);
            $max_page = $max_page ? $max_page : 1;
            if($page < 1 || $page > $max_page)
                show_404(uri_string());

            $topics = $this->topics_model->get_recent_user_topics($host['id'], $page, self::TOPICS_PER_PAGE);
            foreach($topics as &$topic){
                $topic['subject_id'] = $this->subjects_model->get_subject_by_id($topic['subject_id'], 'id, name');
                $topic['last_commenter_id'] = $this->users_model->get_user_by_id($topic['last_commenter_id'], 'id, username');
                $topic['created_on'] = timespan($topic['created_on']);
                $topic['updated_on'] = timespan($topic['updated_on']);
                $topic['last_comment_on'] = timespan($topic['last_comment_on']);
                $topic['max_page'] = ceil($topic['comment_count'] / self::COMMENTS_PER_PAGE);
                $topic['max_page'] = $topic['max_page'] ? $topic['max_page'] : 1;
            }
            unset($topic);

            $host['created_on'] = mdate('%Y-%m-%d', $host['created_on']);
            $hot_topics = $this->topics_model->get_user_hot_topics($host['id']);
            $statistics = $this->statistics_model->get_statistics();

            $data['title'] = $host['username'];
            $data['host'] = $host;
            $data['topics'] = $topics;
            $data['hot_topics'] = $hot_topics;
            $data['statistics'] = $statistics;
            $data['pre_page'] = $page > 1 ? $page - 1 : FALSE;
            $data['next_page'] = $page < $max_page ? $page + 1 : FALSE;
            $this->load->view('users/detail', $data);
        }else{
            show_404(uri_string());
        }
    }

    public function profile(){
        $current_user = login_required();

        if($this->form_validation->run() === FALSE){
            $data['title'] = '资料维护';
            $data['csrf_token'] = $this->security->get_csrf_hash();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['update_profile'] = $this->session->flashdata('update_profile');
            $this->load->view('users/profile', $data);
        }else{
            $city = $this->input->post('city');
            $company = $this->input->post('company');
            $blog = $this->input->post('blog');
            $intro = $this->input->post('intro');
            $this->users_model->update_profile($current_user['id'], $city,
                $company, $blog, $intro);
            $current_user['city'] = $city;
            $current_user['company'] = $company;
            $current_user['blog'] = $blog;
            $current_user['intro'] = $intro;
            $this->session->set_userdata('current_user', $current_user);
            $this->session->set_flashdata('update_profile', 'ok');
            redirect('users/profile');
        }

    }

    public function avatar(){
        $data['title'] = '头像维护';
        $this->load->view('users/avatar', $data);
    }

    public function password(){
        $current_user = login_required();

        if($this->form_validation->run() === FALSE){
            $data['title'] = '密码维护';
            $data['csrf_token'] = $this->security->get_csrf_hash();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['reset_password'] = $this->session->flashdata('reset_password');
            $this->load->view('users/password', $data);
        }else{
            $password = do_hash($this->input->post('password'));
            $this->users_model->reset_password($current_user['id'], $password);
            $current_user['password'] = $password;
            $this->session->set_userdata('current_user', $current_user);
            $this->session->set_flashdata('reset_password', 'ok');
            redirect('settings/password');
        }
    }

    public function _correct_password($password){
        return correct_password(do_hash($password));
    }
}