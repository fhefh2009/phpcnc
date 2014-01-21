<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Topics_model extends CI_Model {

    const TABLE_TOPICS = 'topics';

    public function add_topic($title, $content, $author_id, $subject_id){
        $time = time();
        $data = array(
            'title' => $title,
            'content' => $content,
            'author_id' => $author_id,
            'subject_id' => $subject_id,
            'created_on' => $time,
            'updated_on' => $time
        );
        if($this->db->insert(self::TABLE_TOPICS, $data)){
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_recent_topics($page = 1, $topics_per_page = 30){
        $query = $this->db->select('id, title, comment_count, created_on, updated_on,
            author_id, last_commenter_id, last_comment_on, subject_id' )
            ->order_by('last_comment_on', 'desc')
            ->order_by('updated_on', 'desc')
            ->order_by('created_on', 'desc')
            ->limit($topics_per_page, ($page - 1) * $topics_per_page)
            ->get(self::TABLE_TOPICS);
        return $query->result_array();
    }

    public function get_hot_topics($limit = 10){
        $query = $this->db->select('id, title')
            ->order_by('comment_count', 'desc')
            ->limit($limit)
            ->get(self::TABLE_TOPICS);
        return $query->result_array();
    }
    
    public function get_subject_hot_topics($subject_id, $limit = 10){
        $query = $this->db->select('id, title')
            ->where('subject_id', $subject_id)
            ->order_by('comment_count', 'desc')
            ->limit($limit)
            ->get(self::TABLE_TOPICS);
        return $query->result_array();
    }

    public function get_user_hot_topics($user_id, $exclude_id = '', $limit = 10){
        $this->db->select('id, title')
            ->where('author_id', $user_id)
            ->order_by('comment_count', 'desc')
            ->limit($limit);
        if($exclude_id)
            $this->db->where('id !=', $exclude_id);
        $query =  $this->db->get(self::TABLE_TOPICS);
        return $query->result_array();
    }

    public function get_recent_user_topics($user_id, $page = 1, $topics_per_page = 20){
        $query = $this->db->select('id, title, comment_count, created_on, updated_on,
            author_id, last_commenter_id, last_comment_on, subject_id' )
            ->where('author_id', $user_id)
            ->order_by('updated_on', 'desc')
            ->order_by('created_on', 'desc')
            ->order_by('last_comment_on', 'desc')
            ->limit($topics_per_page, ($page - 1) * $topics_per_page)
            ->get(self::TABLE_TOPICS);
        return $query->result_array();
    }

    public function get_recent_subject_topics($subject_id, $page = 1, $topics_per_page = 30){
        $query = $this->db->select('id, title, comment_count, created_on, updated_on,
            author_id, last_commenter_id, last_comment_on, subject_id' )
            ->where('subject_id', $subject_id)
            ->order_by('updated_on', 'desc')
            ->order_by('created_on', 'desc')
            ->order_by('last_comment_on', 'desc')
            ->limit($topics_per_page, ($page - 1) * $topics_per_page)
            ->get(self::TABLE_TOPICS);
        return $query->result_array();
    }

    public function get_topic_by_id($id, $select = '*'){
        $query = $this->db->select($select)
            ->where('id', $id)
            ->get(self::TABLE_TOPICS);
        return $query->row_array();
    }

    public function validate_topic_owner($id, $author_id){
        $query = $this->db->select('id, title, content, subject_id')
            ->where('id', $id)
            ->where('author_id', $author_id)
            ->get(self::TABLE_TOPICS);
        return $query->row_array();
    }

    public function update_topic_by_id($id, $data){
        $this->db->where('id', $id);
        return $this->db->update(self::TABLE_TOPICS, $data);
    }

    public function update_topic($id, $title, $content){
        $data = array(
            'title' => $title,
            'content' => $content,
            'updated_on' => time()
        );
        return $this->update_topic_by_id($id, $data);
    }

    public function increment_read_count($id){
        $this->db->set('read_count', 'read_count + 1', FALSE)->where('id', $id);
        return $this->db->update(self::TABLE_TOPICS);
    }

    public function update_comment_data($id, $commenter_id){
        $this->db->set('comment_count', 'comment_count + 1', FALSE)
            ->set('last_commenter_id', $commenter_id)
            ->set('last_comment_on', time())
            ->where('id', $id);
        return $this->db->update(self::TABLE_TOPICS);
    }

    public function id_exist($id){
        $this->db->where('id', $id);
        $this->db->from(self::TABLE_TOPICS);
        if($this->db->count_all_results() === 1)
            return TRUE;
        else
            return FALSE;
    }

    public function get_topic_author_id($id){
        $topic = $this->db->select('author_id')
            ->where('id', $id)
            ->get(self::TABLE_TOPICS_TOPICS)->row_array();
        if($topic)
            return $topic['author_id'];
        else
            return FALSE;
    }

}