<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Topics extends CI_Controller {

    const TOPICS_PER_PAGE = 30;
    const COMMENTS_PER_PAGE = 100;

    public function __construct(){
        parent::__construct();
        $this->load->model('topics_model');
        $this->load->model('subjects_model');
        $this->load->model('users_model');
        $this->load->model('comments_model');
        $this->load->model('statistics_model');
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper('markdown');
        $this->load->helper('auth_check');
    }

    public function create($subject_id = 1){
        $current_user = login_required();

        if($this->form_validation->run('topics/create') === FALSE){
            $data['title'] = "新的话题";
            $data['csrf_token'] = $this->security->get_csrf_hash();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $subject = $this->subjects_model->get_subject_by_id($subject_id, 'id, name, description');
            if($subject){
                $this->session->set_flashdata('subject_id', $subject['id']);
                $data['subject'] = $subject;
                $this->load->view('topics/create', $data);
            }else{
                show_404(uri_string());
            }
        }else{
            $subject_id = $this->session->flashdata('subject_id');
            if($subject_id){
                $title = $this->input->post('title');
                $content = $this->input->post('content');

                $this->db->trans_start();
                $id = $this->topics_model->add_topic($title, $content, $current_user['id'], $subject_id);
                $this->users_model->increment_topic_count($current_user['id']);
                $this->subjects_model->increment_topic_count($subject_id);
                $this->statistics_model->increment_topic_count();
                $this->db->trans_complete();

                if($this->db->trans_status() === FALSE){
                    show_error('OOPS!TIGER IS COMING!');
                }else{
                    redirect('topic/'.$id);
                }
            }else{
                show_404(uri_string());
            }
        }
    }

    public function subject_topics($subject_id, $page = 1){
        $subject = $this->subjects_model->get_subject_detail($subject_id);
        if($subject){
            $max_page = ceil($subject['topic_count'] / self::TOPICS_PER_PAGE);
            $max_page = $max_page ? $max_page : 1;
            if($page < 1 || $page > $max_page)
                show_404(uri_string());

            $topics = $this->topics_model->get_recent_subject_topics($subject['id'], $page, self::TOPICS_PER_PAGE);
            foreach($topics as &$topic){
                $topic['author_id'] = $this->users_model->get_user_by_id($topic['author_id'], 'id, username, avatar');
                $topic['last_commenter_id'] = $this->users_model->get_user_by_id($topic['last_commenter_id'], 'id, username');
                $topic['created_on'] = timespan($topic['created_on']);
                $topic['updated_on'] = timespan($topic['updated_on']);
                $topic['last_comment_on'] = timespan($topic['last_comment_on']);
                $topic['max_page'] = ceil($topic['comment_count'] / self::COMMENTS_PER_PAGE);
                $topic['max_page'] = $topic['max_page'] ? $topic['max_page'] : 1;
            }
            unset($topic);

            $hot_topics = $this->topics_model->get_subject_hot_topics($subject['id']);
            $statistics = $this->statistics_model->get_statistics();

            $data['title'] = $subject['name'];
            $data['subject'] = $subject;
            $data['topics'] = $topics;
            $data['hot_topics'] = $hot_topics;
            $data['statistics'] = $statistics;
            $data['pre_page'] = $page > 1 ? $page - 1 : FALSE;
            $data['next_page'] = $page < $max_page ? $page + 1 : FALSE;
            $this->load->view('topics/subject_topics', $data);
        }else{
            show_404(uri_string());
        }
    }

    public function detail($topic_id, $page = 1){
        $topic = $this->topics_model->get_topic_by_id($topic_id);
        if($topic){
            $max_page = ceil($topic['comment_count'] / self::COMMENTS_PER_PAGE);
            $max_page = $max_page ? $max_page : 1;
            if($page < 1 || $page > $max_page)
                show_404(uri_string());

            $comments = $this->comments_model->get_topic_comments($topic['id'], $page, self::COMMENTS_PER_PAGE);
            foreach($comments as &$comment){
                $comment['author_id'] = $this->users_model->get_user_by_id($comment['author_id'], 'id, username, avatar');
                $comment['content'] = markdown($comment['content']);
                $comment['created_on'] = timespan($comment['created_on']);
            }
            unset($comment);

            $topic['content'] = markdown($topic['content']);
            $topic['subject_id'] = $this->subjects_model->get_subject_by_id($topic['subject_id'], 'id, name');
            $topic['author_id'] = $this->users_model->get_user_by_id($topic['author_id'], 'id, username, avatar, intro');
            $topic['last_commenter_id'] = $this->users_model->get_user_by_id($topic['last_commenter_id'], 'id, username');
            $topic['created_on'] = timespan($topic['created_on']);
            $topic['updated_on'] = timespan($topic['updated_on']);
            $topic['last_comment_on'] = timespan($topic['last_comment_on']);

            $hot_topics = $this->topics_model->get_subject_hot_topics($topic['subject_id']['id']);
            $statistics = $this->statistics_model->get_statistics();
            $this->topics_model->increment_read_count($topic['id']);

            $data['title'] = $topic['title'];
            $data['comments'] = $comments;
            $data['topic'] = $topic;
            $data['hot_topics'] = $hot_topics;
            $data['statistics'] = $statistics;
            $data['pre_page'] = $page > 1 ? $page - 1 : FALSE;
            $data['next_page'] = $page < $max_page ? $page + 1 : FALSE;
            $data['csrf_token'] = $this->security->get_csrf_hash();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $this->load->view('topics/detail', $data);
        }else{
            show_404(uri_string());
        }
    }

    public function topic_list($page = 1){

//        $topic_count = $this->statistics_model->get_statistics()['topic_count'];
        $statistics = $this->statistics_model->get_statistics();
        $topic_count = $statistics['topic_count'];
        $max_page = ceil($topic_count / self::TOPICS_PER_PAGE);
        $max_page = $max_page ? $max_page : 1;
        if($page < 1 || $page > $max_page)
            show_404(uri_string());

        $topics = $this->topics_model->get_recent_topics($page, self::TOPICS_PER_PAGE);

        foreach($topics as &$topic){
            $topic['subject_id'] = $this->subjects_model->get_subject_by_id($topic['subject_id'], 'id, name');
            $topic['author_id'] = $this->users_model->get_user_by_id($topic['author_id'], 'id, username, avatar');
            $topic['last_commenter_id'] = $this->users_model->get_user_by_id($topic['last_commenter_id'], 'id, username');
            $topic['created_on'] = timespan($topic['created_on']);
            $topic['updated_on'] = timespan($topic['updated_on']);
            $topic['last_comment_on'] = timespan($topic['last_comment_on']);
            $topic['max_page'] = ceil($topic['comment_count'] / self::COMMENTS_PER_PAGE);
            $topic['max_page'] = $topic['max_page'] ? $topic['max_page'] : 1;
        }
        unset($topic);

        $hot_topics = $this->topics_model->get_hot_topics();
        $statistics = $this->statistics_model->get_statistics();

        $data['title'] = "PHPCNC";
        $data['topics'] = $topics;
        $data['hot_topics'] = $hot_topics;
        $data['statistics'] = $statistics;
        $data['pre_page'] = $page > 1 ? $page - 1 : FALSE;
        $data['next_page'] = $page < $max_page ? $page + 1 : FALSE;
        $this->load->view('topics/topic_list', $data);

    }


    public function edit($topic_id){
        $current_user = login_required();

        if($this->form_validation->run('topics/create') === FALSE){
            $data['title'] = '编辑话题';
            $data['csrf_token'] = $this->security->get_csrf_hash();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $topic = $this->topics_model->validate_topic_owner($topic_id, $current_user['id']);
            if($topic){
                $this->session->set_flashdata('topic', $topic);
                $topic['subject_id'] = $this->subjects_model->get_subject_by_id($topic['subject_id'], 'id, name, description');
                $data['topic'] = $topic;
                $this->load->view('topics/edit', $data);
            }else{
                show_404(uri_string());
            }
        }else{
            $topic = $this->session->flashdata('topic');
            if($topic){
                $title = $this->input->post('title');
                $content = $this->input->post('content');

                $this->db->trans_start();
                $this->topics_model->update_topic($topic['id'], $title, $content);
                $this->subjects_model->update_last_alter_time($topic['subject_id']);
                $this->db->trans_complete();

                if($this->db->trans_status() === FALSE){
                    show_error('OOPS!TIGER IS COMING!');
                }else{
                    redirect('topic/'.$topic['id']);
                }
            }else{
                show_404(uri_string());
            }
        }
    }

}