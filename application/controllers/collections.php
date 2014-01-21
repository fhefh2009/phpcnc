<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Collections extends CI_Controller {

    const COLLECTIONS_PER_PAGE = 50;
    const COMMENTS_PER_PAGE = 100;//should be same with Topics class' const COMMENTS_PER_PAGE

    public function __construct(){
        parent::__construct();
        $this->load->model('collections_model');
        $this->load->model('topics_model');
        $this->load->model('users_model');
        $this->load->model('subjects_model');
        $this->load->model('statistics_model');
        $this->load->helper('auth_check');
        $this->load->helper('request_method');
        $this->load->helper('date');
    }

    public function create(){
        $current_user = login_required();

        $topic_id = $this->input->post('topic');
        if($this->topics_model->id_exist($topic_id)){
            if(!$this->collections_model->is_collected($topic_id, $current_user['id']))
                $this->collections_model->add_collection($topic_id, $current_user['id']);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('success' => TRUE)));
        }else{
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'invalid data')));
        }
    }

    public function delete(){
        $current_user = login_required();

        $topic_id = $this->input->post('topic');
        $this->collections_model->delete_collection($topic_id, $current_user['id']);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => TRUE)));
    }

    public function delete_all(){
        $current_user = login_required();

        if(is_post())
            $this->collections_model->empty_collections($current_user['id']);
        redirect('collections');
    }

    public function get_status($topic_id){
        $current_user = login_required();

        if($this->collections_model->is_collected($topic_id, $current_user['id'])){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => TRUE)));
        }else{
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => FALSE)));
        }
    }

    public function collection_list($page = 1){
        $current_user = login_required();

        $collections_count = $this->collections_model->count($current_user['id']);
        $max_page = ceil($collections_count / self::COLLECTIONS_PER_PAGE);
        $max_page = $max_page ? $max_page : 1;
        if($page < 1 || $page > $max_page)
            show_404(uri_string());

        $collections = $this->collections_model->get_collections($current_user['id'], $page, self::COLLECTIONS_PER_PAGE);

        foreach($collections as &$collection){
            $collection['topic_id'] = $this->topics_model->get_topic_by_id($collection['topic_id'], 'id, title, comment_count,
             created_on, updated_on, author_id, last_commenter_id, last_comment_on, subject_id');
            $collection['topic_id']['author_id'] = $this->users_model->get_user_by_id($collection['topic_id']['author_id'], 'id, username, avatar');
            $collection['topic_id']['last_commenter_id'] = $this->users_model->get_user_by_id($collection['topic_id']['last_commenter_id'], 'id, username');
            $collection['topic_id']['subject_id'] = $this->subjects_model->get_subject_by_id($collection['topic_id']['subject_id'], 'id, name');
            $collection['topic_id']['created_on'] = timespan( $collection['topic_id']['created_on']);
            $collection['topic_id']['updated_on'] = timespan( $collection['topic_id']['updated_on']);
            $collection['topic_id']['last_comment_on'] = timespan( $collection['topic_id']['last_comment_on']);
            $collection['created_on'] = timespan($collection['created_on']);
            $collection['topic_id']['max_page'] = ceil($collection['topic_id']['comment_count'] / self::COMMENTS_PER_PAGE);
            $collection['topic_id']['max_page'] = $collection['topic_id']['max_page'] ? $collection['topic_id']['max_page'] : 1;
        }
        unset($collection);

        $hot_topics = $this->topics_model->get_hot_topics();
        $statistics = $this->statistics_model->get_statistics();

        $data['title'] = '我的收藏';
        $data['collections'] = $collections;
        $data['hot_topics'] = $hot_topics;
        $data['statistics'] = $statistics;
        $data['csrf_token'] = $this->security->get_csrf_hash();
        $data['csrf_name'] = $this->security->get_csrf_token_name();
        $data['pre_page'] = $page > 1 ? $page - 1 : FALSE;
        $data['next_page'] = $page < $max_page ? $page + 1 : FALSE;
        $this->load->view('collections/collection_list', $data);
    }

}