<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Statistics_model extends CI_Model {

    const TABLE_STATISTICS = 'statistics';

    public function get_statistics(){
       return $this->db
           ->get(self::TABLE_STATISTICS)
           ->row_array();
    }

    public function increment_topic_count(){
        $this->db->set('topic_count', 'topic_count + 1', FALSE);
        return $this->db->update(self::TABLE_STATISTICS);
    }

    public function increment_comment_count(){
        $this->db->set('comment_count', 'comment_count + 1', FALSE);
        return $this->db->update(self::TABLE_STATISTICS);
    }

    public function increment_user_count(){
        $this->db->set('user_count', 'user_count + 1', FALSE);
        return $this->db->update(self::TABLE_STATISTICS);
    }

}