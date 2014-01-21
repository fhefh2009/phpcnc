<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Comments extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('comments_model');
        $this->load->model('users_model');
        $this->load->model('statistics_model');
        $this->load->model('topics_model');
        $this->load->model('notifications_model');
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper('at_user');
        $this->load->helper('markdown');
        $this->load->helper('auth_check');
    }

    public function create(){
        $current_user = login_required();

        if($this->form_validation->run() === FALSE){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'invalid content', 'content' => validation_errors())));
        }else{
            $topic_id = $this->input->post('topic');
            $topic = $this->topics_model->get_topic_by_id($topic_id, 'id, author_id');
            if(!$topic){
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('error' => 'invalid data')));
            }

            $content = $this->input->post('content');
            $at_users = extract_at_users($content);
            foreach($at_users as &$at_user){
                $at_user = $this->users_model->get_user_by_username($at_user, 'id, username');
                if(!$at_user){
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('error' => 'invalid user')));
                    return;
                }
            }
            unset($at_user);

            $content = at_users_to_html($content, $at_users);

            $this->db->trans_start();
            $comment_id = $this->comments_model->add_comment($content, $current_user['id'], $topic['id'] );
            $this->topics_model->update_comment_data($topic['id'], $current_user['id']);
            $this->users_model->increment_comment_count($current_user['id']);
            $this->statistics_model->increment_comment_count();
            if($current_user['id'] != $topic['author_id'])
                $this->notifications_model->add_comment_notification($current_user['id'], $topic['author_id'], $topic['id'], $comment_id);
            foreach($at_users as $at_user){
                if($at_user['id'] === $current_user['id'])
                    continue;
                if($at_user['id'] === $topic['author_id'])
                    continue;
                $this->notifications_model->add_reply_notification($current_user['id'], $at_user['id'], $topic['id'], $comment_id);
            }
            unset($at_user);
            $this->db->trans_complete();

            if($this->db->trans_status() === FALSE){
                $this->output
                    ->set_status_header(500)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('error' => 'OOPS!TIGER IS COMING!')));
                exit;
            }

            $comment = $this->comments_model->get_comment_by_id($comment_id, 'author_id, content, created_on');
            $comment['content'] = markdown($comment['content']);
            $comment['author_id'] = $this->users_model->get_user_by_id($comment['author_id'], 'id, username, avatar');
            $comment['created_on'] = timespan($comment['created_on']);
            $view = $this->load->view('comments/list_item', array('comment' => $comment), TRUE);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('content' => $view)));
        }
    }

}