<?php
// model classes and file names should be singular and controllers should be plural
class Post {
    private $db;

    public function __construct(){
        $this->db = new Database;
//        echo 'post class loaded';
    }

    // Create method to get posts
    public function getPosts(){
        $this->db->query("SELECT * FROM posts");
        return $this->db->resultSet();
    }



}
?>