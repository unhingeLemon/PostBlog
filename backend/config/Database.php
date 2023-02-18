<?php 
  class Database {
    // DB Params
    private $host = 'localhost';
    private $db_name = 'portblog';
    private $username = 'root';
    private $password = '';
    private $conn;
    
    public function createTable(){
        $conn = new mysqli($this->host, $this->username, $this->password,$this->db_name);
        $sql = "CREATE TABLE users (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          firstname VARCHAR(30) NOT NULL,
          lastname VARCHAR(30) NOT NULL,
          username VARCHAR(30) NOT NULL UNIQUE,
          password VARCHAR(100) NOT NULL,
          intro VARCHAR(500) NOT NULL,
          contact VARCHAR(30) NOT NULL,
          email VARCHAR(50) NOT NULL
          )";
        $conn->query($sql);

        $sql = "CREATE TABLE blogs (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          blog_title VARCHAR(300) NOT NULL,
          blog_body VARCHAR(65535) NOT NULL,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          written_by VARCHAR(100) NOT NULL
          )";
        $conn->query($sql);

        $sql = "CREATE TABLE projects (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          project_title VARCHAR(300) NOT NULL,
          project_desc VARCHAR(65535) NOT NULL,
          link VARCHAR(500) DEFAULT '#', 
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          made_by VARCHAR(100) NOT NULL
          )";
        $conn->query($sql);

        $sql = "CREATE TABLE comments (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          commenter VARCHAR(300) NOT NULL,
          comment VARCHAR(65535) NOT NULL,
          blog_id VARCHAR(100) NOT NULL, 
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP
          )";
        $conn->query($sql);
    }
    
    // DB Connect
    public function connect() {
      $conn = new mysqli($this->host, $this->username, $this->password);
      $sql = "CREATE DATABASE ". $this->db_name;
      $conn->query($sql);

      $this->createTable();

      
      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }
?>