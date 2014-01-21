<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Notifications extends CI_Controller {

    const NOTIFICATIONS_PER_PAGE = 50;

    public function __construct(){
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('notifications_model');
        $this->load->model('topics_model');
        $this->load->model('comments_model');
        $this->load->model('statistics_model');
        $this->load->helper('date');
        $this->load->helper('auth_check');
        $this->load->helper('request_method');
        $this->load->helper('markdown');
    }

    public function notification_list($page = 1){
        $current_user = login_required();

        $notifications_count = $this->notifications_model->count($current_user['id']);
        $max_page = ceil($notifications_count / self::NOTIFICATIONS_PER_PAGE);
        $max_page = $max_page ? $max_page : 1;
        if($page < 1 || $page > $max_page)
            show_404(uri_string());

        $notifications = $this->notifications_model->get_notifications($current_user['id'], $page, self::NOTIFICATIONS_PER_PAGE);

        foreach($notifications as &$notification){
            $notification['topic_id'] = $this->topics_model->get_topic_by_id($notification['topic_id'], 'id, title');
            $notification['sender_id'] = $this->users_model->get_user_by_id($notification['sender_id'], 'id, username, avatar');
            $notification['comment_id'] = $this->comments_model->get_comment_by_id($notification['comment_id'], 'content');
            $notification['comment_id']['content'] = markdown($notification['comment_id']['content']);
            $notification['created_on'] = timespan($notification['created_on']);
            $this->notifications_model->set_read($notification['id']);
        }
        unset($notification);

        $hot_topics = $this->topics_model->get_hot_topics();
        $statistics = $this->statistics_model->get_statistics();

        $data['title'] = '通知';
        $data['notifications'] = $notifications;
        $data['hot_topics'] = $hot_topics;
        $data['statistics'] = $statistics;
        $data['csrf_token'] = $this->security->get_csrf_hash();
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['pre_page'] = $page > 1 ? $page - 1 : FALSE;
        $data['next_page'] = $page < $max_page ? $page + 1 : FALSE;
        $this->load->view('notifications/notification_list', $data);

    }

    public function delete(){
        $current_user = login_required();

        $id = $this->input->post('id');
        $this->notifications_model->delete_notification($id, $current_user['id']);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => TRUE)));
    }

    public function delete_all(){
        $current_user = login_required();

        if(is_post())
            $this->notifications_model->empty_notifications($current_user['id']);
        redirect('notifications');
    }

}