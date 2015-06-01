<?php
class User_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_users() {
        $users = $this->db->get('user');
        $users_list = array();
        
        if($users->result()) {
            foreach($users->result() as $user) {
                $users_list[$user->id] = $user;
            }
        }
        return $users_list;
    }
    public function create_user() {
        
    }
    public function delete_user() {
        
    }
    public function update_user() {
        
    }
}