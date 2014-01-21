<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Comments_model extends CI_Model {

    const TABLE_COMMENTS = 'comments';

    public function add_comment($content, $author_id, $topic_id){
        $data = array(
            'content' => $content,
            'author_id' => $author_id,
            'topic_id' => $topic_id,
            'created_on' => time()
        );
        if ($this->db->insert(self::TABLE_COMMENTS, $data)){
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_topic_comments($topic_id, $page = 1, $comments_per_page = 100){
        $query = $this->db->select('id, content, author_id, created_on')
            ->where('topic_id', $topic_id)
            ->limit($comments_per_page, ($page - 1) * $comments_per_page)
            ->get(self::TABLE_COMMENTS);
//        $query = $this->db->select('comments.id, comments.content, comments.created_on,
//            users.id as author_id, users.username as author_name')
//            ->where('topic_id', $topic_id)
//            ->join('users', 'comments.author_id = users.id')
//            ->limit($comments_per_page, ($page - 1) * $comments_per_page)
//            ->get(self::TABLE);
        return $query->result_array();
    }

    public function get_comment_by_id($id, $select = '*'){
        $query = $this->db->select($select)
            ->where('id', $id)
            ->get(self::TABLE_COMMENTS);
        return $query->row_array();
    }

}