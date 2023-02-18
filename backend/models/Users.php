<?php 
  class Users {
    // DB stuff
    private $conn;
    private $table = 'users';
    
    // User Properties
    public $id;
    public $firstname;
    public $lastname;
    public $username;
    public $password;
    public $intro;
    public $email;
    public $contact;
    public $user_err_message;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Login User
    public function login() {
          // Create query
          $query = 'SELECT * FROM '.$this->table. ' WHERE username = :username and password = :password';
  

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(':username', $this->username);
          $stmt->bindParam(':password', $this->password);
          // Execute query
          $stmt->execute(); 

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if($row){
            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->username = $row['username'];
            $this->intro = $row['intro'];
            $this->email = $row['email'];
            $this->contact = $row['contact'];
            $this->user_err_message = "success";
          } else{
            $this->user_err_message = "Invalid Credential";
          }
          
    }
        // Get Single User
    public function get_user() {
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
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->username = $row['username'];
            $this->intro = $row['intro'];
            $this->email = $row['email'];
            $this->contact = $row['contact'];
            $this->user_err_message = "success";
          } else{
            $this->user_err_message = "Invalid ID";
          }

          
    }

    // Register User
    public function register() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET 
            firstname = :firstname, 
            lastname = :lastname, 
            username = :username, 
            password = :password,
            intro = :intro,
            email = :email,
            contact = :contact
          ';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind data
          $stmt->bindParam(':firstname', $this->firstname);
          $stmt->bindParam(':lastname', $this->lastname);
          $stmt->bindParam(':username', $this->username);
          $stmt->bindParam(':password', $this->password);
          $stmt->bindParam(':intro', $this->intro);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':contact', $this->contact);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . ' 
                                SET 
                                pass = :pass
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);
          
          // Bind data
          $stmt->bindParam(':pass', $this->pass);
          $stmt->bindParam(':id', $this->id);
          
          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }


    }
    
  