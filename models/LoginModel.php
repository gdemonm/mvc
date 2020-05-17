<?php

class LoginModel extends Model {

    private $user_id;

    public function __construct() {

        $this->db = new DB();

        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
        }
    }

    public function login($username, $password) {

        $user_query = $this->db->query("SELECT * FROM user WHERE username = '" . $this->db->escape($username) . "' AND password = '" . $this->db->escape(md5($password)) . "'");

        if ($user_query->num_rows) {
            $_SESSION['user_id'] = $user_query->row['user_id'];

            $this->user_id = $user_query->row['user_id'];

            return true;
        } else {
            return false;
        }
    }

    public function isLogged() {
        return $this->user_id;
    }

}