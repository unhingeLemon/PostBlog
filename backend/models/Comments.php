<?php 
  class Comments {
    // DB stuff
    private $conn;
    private $table = 'comments';
    
    // Blog Properties
    public $id;
    public $commenter;
    public $comment;
    public $blog_id;
    public $created_at;
    public $err_message;



    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    public function add_comment() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET 
        commenter = :commenter, 
        comment = :comment,
        blog_id = :blog_id
      ';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind data
      $stmt->bindParam(':commenter', $this->commenter);
      $stmt->bindParam(':comment', $this->comment);
      $stmt->bindParam(':blog_id', $this->blog_id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }
      
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
  }

    public function get_blog_comments() {
      // Create query
      $query = 'SELECT *
                FROM ' . $this->table . 
                ' WHERE blog_id=:blog_id';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
       // Bind ID
      $stmt->bindParam(':blog_id', $this->blog_id);
      // Execute query
      $stmt->execute();

      return $stmt;
    }

        // Get Single User
    public function get_single_blog() {
          // Create query
          $query = 'SELECT * FROM '.$this->table. ' WHERE id = :id';
  

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(':id', $this->id);
          // Execute querys
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
          if($row){
            $this->id = $row['id'];
            $this->blog_title = $row['blog_title'];
            $this->blog_body = $row['blog_body'];
            $this->created_at = $row['created_at'];
            $this->written_by = $row['written_by'];
            $this->err_message = "success";
          } else{
            $this->user_err_message = "Invalid ID";
          }
          // Set properties
          
    }

    // // Update Post
    // public function update() {
    //       // Create query
    //       $query = 'UPDATE ' . $this->table . ' 
    //                             SET 
    //                             pass = :pass
    //                             WHERE id = :id';

    //       // Prepare statement
    //       $stmt = $this->conn->prepare($query);
          
    //       // Bind data
    //       $stmt->bindParam(':pass', $this->pass);
    //       $stmt->bindParam(':id', $this->id);
          
    //       // Execute query
    //       if($stmt->execute()) {
    //         return true;
    //       }

    //       // Print error if something goes wrong
    //       printf("Error: %s.\n", $stmt->error);

    //       return false;
    // }


    }
    
  