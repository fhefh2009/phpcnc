<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Notifications_model extends CI_Model {

    const TABLE_NOTIFICATIONS = 'notifications';

    public function add_comment_notification($sender_id, $receiver_id, $topic_id, $comment_id){
        $data = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'topic_id' => $topic_id,
            'comment_id' => $comment_id,
            'type' => 0,//normal comment notifications
            'created_on' => time()
        );

        if($this->db->insert(self::TABLE_NOTIFICATIONS, $data)){
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function add_reply_notification($sender_id, $receiver_id, $topic_id, $comment_id){
        $data = array(
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'topic_id' => $topic_id,
            'comment_id' => $comment_id,
            'type' => 1,//@ notification
            'created_on' => time()
        );

        if($this->db->insert(self::TABLE_NOTIFICATIONS, $data)){
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_notifications($receiver_id, $page = 1, $notifications_per_page = 50){
        $query = $this->db->select('*')
            ->where('receiver_id', $receiver_id)
            ->order_by('is_read', 'asc')
            ->order_by('created_on', 'desc')
            ->limit($notifications_per_page, ($page - 1) * $notifications_per_page)
            ->get(self::TABLE_NOTIFICATIONS);
        return $query->result_array();
    }

    public function unread_count($receiver_id){
        $this->db->where('receiver_id', $receiver_id)
                 ->where('is_read', 0)
                 ->from(self::TABLE_NOTIFICATIONS);
       return $this->db->count_all_results();
    }

    public function count($receiver_id){
        $this->db->where('receiver_id', $receiver_id)
            ->from(self::TABLE_NOTIFICATIONS);
        return $this->db->count_all_results();
    }

    public function set_read($id){
        $data = array(
            'is_read' => 1
        );
        $this->db->where('id', $id);
        return $this->db->update(self::TABLE_NOTIFICATIONS, $data);
    }

    public function delete_notification($id, $receiver_id){
       return $this->db->where('id', $id)
           ->where('receiver_id', $receiver_id)
           ->delete(self::TABLE_NOTIFICATIONS);
    }

    public function empty_notifications($receiver_id){
        return $this->db->where('receiver_id', $receiver_id)
            ->delete(self::TABLE_NOTIFICATIONS);
    }

}