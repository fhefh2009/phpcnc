<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Subjects_model extends CI_Model {

    const TABLE_SUBJECTS = 'subjects';

    public function get_subjects(){
        $query = $this->db->select('id, name, topic_count, last_alter_on')
            ->order_by('topic_count', 'desc')
            ->order_by('last_alter_on', 'desc')
            ->get(self::TABLE_SUBJECTS);
        return $query->result_array();
    }

    public function get_subject_by_id($id, $select = '*'){
        $query = $this->db->select($select)
            ->where('id', $id)
            ->get(self::TABLE_SUBJECTS);
        return $query->row_array();
    }

    public function get_subject_detail($id){
        return $this->get_subject_by_id($id, 'id, name, description, topic_count');
    }

    public function increment_topic_count($id){
        $this->db->set('topic_count', 'topic_count + 1', FALSE)
            ->set('last_alter_on', time())
            ->where('id', $id);
        return $this->db->update(self::TABLE_SUBJECTS);
    }

    public function update_last_alter_time($id){
        $data = array(
            'last_alter_on' => time()
        );
        $this->db->where('id', $id);
        return $this->db->update(self::TABLE_SUBJECTS, $data);
    }

}