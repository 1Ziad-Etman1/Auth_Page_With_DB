<?php
        define('DB_HOST','localhost');
        define('DB_USER','toaster');
        define('DB_PASS','br0ken');
        /*
        for windows
        define('DB_USER','root');
        define('DB_PASS','');
        */
        define('DB_NAME','projectdb');
class DB_ops {
    public $conn;
    
    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function create($Name, $username, $phone, $whatsapp, $email, $Password, $image, $address) {
        $sql = "INSERT INTO users (name, username, phone, whatsapp, email, password, image, address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
       
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die("Error preparing statement: " . $this->conn->error);
        }
    
        $stmt->bind_param("ssssssss", $Name, $username, $phone, $whatsapp, $email, $Password, $image, $address);
    
        if ($stmt->execute()) {
            echo "New record created successfully. ID: " . $this->conn->insert_id;
        } else {
            echo "Error: " . $stmt->error;
        }
    
       
        $stmt->close();
    }
    
    public function read($id) {
        $sql = "SELECT * FROM users WHERE Id = ?";
        
        $stmt = $this->conn->prepare($sql);   
        $stmt->bind_param("i", $id);    
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch data as an associative array mesh map, leh m3rfsh
        $user = $result->fetch_assoc(); 
        $stmt->close();
        return $user;
    }
    

    public function delete($id) {
        $sql = "DELETE FROM users WHERE Id = $id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
    }

    public function clearDB() {
        $sql = "DELETE FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }
}

$ee = new DB_ops();
//$ee->create("John Doe", "johnd", "123456789", "987654321", "john@example.com", "securepass", "profile.jpg", "123 Street, City");
//$ee->create("Jane Smith", "janes", "5551234567", "5559876543", "jane@example.com", "mypassword123", "avatar.jpg", "456 Avenue, New York");
//$ee->create("dw","ww","11","22","33","rrg","efe","wdww");
//$ee->clearDB();
//$ee->read(1);
//$ee->delete(1);
// $userData = $ee->read(1); // Fetch user with ID = 1

// if ($userData) {
//     print_r($userData);
// } else {
//     echo "No user found.";
// }

?>




