<?php 
  class Projects {
    // DB stuff
    private $conn;
    private $table = 'projects';
    
    // Blog Properties
    public $id;
    public $project_title;
    public $project_desc;
    public $created_at;
    public $link;
    public $made_by;
    public $err_message;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    public function add_project() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET 
        project_title = :project_title, 
        project_desc = :project_desc, 
        link = :link, 
        made_by = :made_by
      ';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind data
      $stmt->bindParam(':project_title', $this->blog_title);
      $stmt->bindParam(':project_desc', $this->project_desc);
      $stmt->bindParam(':link', $this->link);
      $stmt->bindParam(':made_by', $this->made_by);

      // Execute query
      if($stmt->execute()) {
        return true;
      }
      
      // Print error if something goes wrong
      printf ("Error: %s.\n", $stmt->error);

      return false;
  }

    public function get_user_projects() {
      // Create query
      $query = 'SELECT *
                FROM ' . $this->table . 
                ' WHERE made_by=:made_by';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
       // Bind ID
      $stmt->bindParam(':made_by', $this->made_by);
      // Execute query
      $stmt->execute();

      return $stmt;
    }

        // Get Single Project
    public function get_single_project() {
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
            $this->project_title = $row['project_title'];
            $this->project_desc = $row['project_desc'];
            $this->created_at = $row['created_at'];
            $this->made_by = $row['made_by'];
            $this->link = $row['link'];
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
    
  