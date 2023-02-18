<?php 
  class Blogs {
    // DB stuff
    private $conn;
    private $table = 'blogs';
    
    // Blog Properties
    public $id;
    public $blog_title;
    public $blog_body;
    public $created_at;
    public $written_by;
    public $err_message;
    public $searchKey;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    public function add_blog() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET 
        blog_title = :blog_title, 
        blog_body = :blog_body, 
        written_by = :written_by
      ';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind data
      $stmt->bindParam(':blog_title', $this->blog_title);
      $stmt->bindParam(':blog_body', $this->blog_body);
      $stmt->bindParam(':written_by', $this->written_by);

      // Execute query
      if($stmt->execute()) {
        return true;
      }
      
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
  }

    public function get_user_blogs() {
      // Create query
      $query = 'SELECT *
                FROM ' . $this->table . 
                ' WHERE written_by=:written_by';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
       // Bind ID
      $stmt->bindParam(':written_by', $this->written_by);
      // Execute query
      $stmt->execute();

      return $stmt;
    }
    public function search_blog() {
      // Create query
      $query = 'SELECT *
                FROM ' . $this->table . 
                ' WHERE '.$this->searchKey;
      
      // Prepare statement
      //echo $query;
      $stmt = $this->conn->prepare($query);
      // Bind ID

      //echo $this->searchKey;
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
    
  