<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Collections_model extends CI_Model {

    const TABLE_COLLECTIONS = 'collections';

    public function add_collection($topic_id, $creator_id){
        $data = array(
            'topic_id' => $topic_id,
            'creator_id' => $creator_id,
            'created_on' => time()
        );
        if($this->db->insert(self::TABLE_COLLECTIONS, $data)){
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function delete_collection($topic_id, $creator_id){
        return $this->db->where('topic_id', $topic_id)
            ->where('creator_id', $creator_id)
            ->delete(self::TABLE_COLLECTIONS);
    }

    public function empty_collections($creator_id){
        return $this->db->where('creator_id', $creator_id)
            ->delete(self::TABLE_COLLECTIONS);
    }

    public function is_collected($topic_id, $creator_id){
        $this->db->where('topic_id', $topic_id)
            ->where('creator_id', $creator_id)
            ->from(self::TABLE_COLLECTIONS);
        if($this->db->count_all_results() === 1)
            return TRUE;
        else
            return FALSE;
    }

    public function get_collections($creator_id, $page = 1, $collections_per_page = 50){
        $query = $this->db->select('id, topic_id, created_on')
            ->where('creator_id', $creator_id)
            ->order_by('created_on', 'desc')
            ->limit($collections_per_page, ($page - 1) * $collections_per_page)
            ->get(self::TABLE_COLLECTIONS);
        return $query->result_array();
    }

    public function count($creator_id){
        $this->db->where('creator_id', $creator_id)
            ->from(self::TABLE_COLLECTIONS);
        return $this->db->count_all_results();
    }

}