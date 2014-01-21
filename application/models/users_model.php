<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users_model extends CI_Model {

    const TABLE_USERS = 'users';
    const SESSION_SELECT = 'id, email, username, city, company, blog, intro, avatar, password, created_on';

    public function add_user($email, $activation_code){
        $data = array(
            'email' => $email,
            'activation_code' => $activation_code,
            'created_on' => time()
        );
        if($this->db->insert(self::TABLE_USERS, $data)){
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function verify_user($email, $password){
        $query = $this->db->select(self::SESSION_SELECT)
            ->where('email', $email)
            ->where('password', $password)
            ->get(self::TABLE_USERS);
        return $query->row_array();
    }

    public function update_login_time($id){
        $data = array(
            'last_login' => time()
        );
        return $this->update_user_by_id($id, $data);
    }

    public function get_user_by_email($email, $select = '*'){
        $query = $this->db->select($select)
            ->where('email', $email)
            ->get(self::TABLE_USERS);
        return $query->row_array();
    }

    public function get_user_by_id($id, $select = '*'){
        $query = $this->db->select($select)
            ->where('id', $id)
            ->get(self::TABLE_USERS);
        return $query->row_array();
    }

    public function get_user_by_username($username, $select = '*'){
        $query = $this->db->select($select)
            ->where('username', $username)
            ->get(self::TABLE_USERS);
        return $query->row_array();
    }

    public function get_user_detail($id){
        return $this->get_user_by_id($id,
            'id, username, city, company, blog, intro, avatar, topic_count, created_on');
    }

    public function check_activation_code($id, $activation_code){
        $user = $this->get_user_by_id($id, 'id, email, activation_code, active');
        if($user){
            if($user['active'] == 0 &&
                $user['activation_code'] === $activation_code)
                return $user;
            else
                return FALSE;
        }
       return FALSE;
    }

//    public function  is_active($id){
//        if($user = $this->get_user_by_id($id, 'active')){
//            if($user['active'] == 1){
//                return TRUE;
//            }else{
//                return FALSE;
//            }
//        }
//        return FALSE;
//    }

    public function update_user_by_id($id, $data){
        $this->db->where('id', $id);
        return $this->db->update(self::TABLE_USERS, $data);
    }

    public function update_user_by_email($email, $data){
        $this->db->where('email', $email);
        return $this->db->update(self::TABLE_USERS, $data);
    }

    public function active_user($id, $username, $password, $avatar){
        $data = array(
            'username' => $username,
            'password' => $password,
            'avatar' => $avatar,
            'last_login' => time(),
            'active' => 1
        );
        if($this->update_user_by_id($id, $data)){
            return $this->get_user_by_id($id, self::SESSION_SELECT);
        }
        return FALSE;
    }

    public function email_valid($email){
        $this->db->where('email', $email)
                 ->where('active', 1)
                 ->from(self::TABLE_USERS);
        if($this->db->count_all_results() === 1)
            return TRUE;
         else
            return FALSE;
    }

    public function set_forgotten_password_code($email, $forgotten_password_code){
        $data = array(
            'forgotten_password_code' => $forgotten_password_code,
            'forgotten_password_time' => time()
        );
       if($this->update_user_by_email($email, $data)){
           $user = $this->get_user_by_email($email, $select = 'id');
           if($user){
                return $user['id'];
           }
       }
       return FALSE;
    }

    public function check_forgotten_password_code($id, $forgotten_password_code){
        $user = $this->get_user_by_id($id, 'forgotten_password_code, forgotten_password_time');
        if($user && $forgotten_password_code === $user['forgotten_password_code']
            && time() < $user['forgotten_password_time'] + 86400)//in 24 hours
            return TRUE;
        else
            return FALSE;
    }

    public function reset_password($id, $password){
        $data = array(
            'password' => $password,
            'forgotten_password_time' => NULL
        );
        return $this->update_user_by_id($id, $data);
    }

    public function update_profile($id, $city, $company, $blog, $intro){
        $data = array(
            'city' => $city,
            'company' => $company,
            'blog' => $blog,
            'intro' => $intro
        );
        return $this->update_user_by_id($id, $data);
    }

    public function get_top108(){
        $query = $this->db->select('id, username, avatar' )
             ->where('active', 1)
             ->order_by('topic_count', 'desc')
             ->order_by('comment_count', 'desc')
             ->order_by('last_login', 'desc')
             ->limit(108)
             ->get(self::TABLE_USERS);
        return $query->result_array();
    }

    public function increment_topic_count($id){
        $this->db->set('topic_count', 'topic_count + 1', FALSE)->where('id', $id);
        return $this->db->update(self::TABLE_USERS);
    }

    public function increment_comment_count($id){
        $this->db->set('comment_count', 'comment_count + 1', FALSE)->where('id', $id);
        return $this->db->update(self::TABLE_USERS);
    }

}