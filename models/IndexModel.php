<?php

class IndexModel extends Model {

    private $user_id;

    public function __construct() {

        $this->db = new DB();

        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
        }
    }

    public function isLogged() {
        return $this->user_id;
    }

    public function getTasks($data=array()) {

        $sql = "SELECT * FROM tasks";

        $sort_data = array(
            'id',
            'name',
            'email',
            'completed',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
        } else {
            $sql .= " ORDER BY id";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 3;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalTasks() {

        $query = $this->db->query("SELECT COUNT(*) AS total FROM tasks");
        return $query->row['total'];

    }

    public function addTask($data) {
        $sql = "INSERT INTO tasks SET name='".$this->db->escape($data['name'])."', email='".$this->db->escape($data['email'])."', text='".$this->db->escape($data['text'])."', completed='".(int)$data['completed']."'";
        $this->db->query($sql);

    }

    public function changeStatus($data=array()) {

        $sql = "UPDATE tasks SET completed='".(int)$data['completed']."' WHERE id = '".(int)$data['taskid']."'";
        $this->db->query($sql);
    }

    public function changeText($data=array()) {

        $sql = "UPDATE tasks SET edited = 1, text='".$this->db->escape($data['text'])."' WHERE id = '".(int)$data['taskid']."'";
        $this->db->query($sql);
    }

}