<?php

class Service {
    private $conn_mysqli; 
    private $table_name = "services"; 

    
    
    @param mysqli 
     
    public function __construct($db_mysqli) {
        $this->conn_mysqli = $db_mysqli;
    }

    /**
     * Create a new service record in the database.
     *
     * @param string $title 
     * @param string $desc 
     * @param string $img_filename 
     * @return bool True if creation was successful, false otherwise.
     */
    public function create($title, $desc, $img_filename) {
        
       
        $query = "INSERT INTO " . $this->table_name . " (title, description, image) VALUES (?, ?, ?)";
        
        
        $stmt = $this->conn_mysqli->prepare($query);

        // Check if prepare() failed
        if ($stmt === false) {
           
            // error_log('MySQLi prepare error (create): ' . $this->conn_mysqli->error);
            return false;
        }

        /
        // The primary protection against SQL injection comes from using prepared statements.
        $title_san = htmlspecialchars(strip_tags($title));
        $desc_san = htmlspecialchars(strip_tags($desc));
        $img_filename_san = htmlspecialchars(strip_tags($img_filename)); 
       
        // "sss" means all three parameters are strings.
        $stmt->bind_param("sss", $title_san, $desc_san, $img_filename_san);

      
        if ($stmt->execute()) {
            $stmt->close(); 
            return true;    
        } else {
        
            // error_log('MySQLi execute error (create): ' . $stmt->error);
            $stmt->close(); 
            return false;   
        }
    }

    /**
     * Read all services from the database.
     * Can optionally filter by a search term (for Task 5.3).
     *
     * @param string|null $searchTerm Optional keyword to search in title or description.
     * @return mysqli_result|false The mysqli_result object containing the results, or false on failure.
     */
    public function readAll($searchTerm = null) {
       
        $query = "SELECT id, title, description, image FROM " . $this->table_name;
        
        $params = []; // To store parameters for binding if searchTerm is used
        $types = "";  // To store type string for bind_param if searchTerm is used

        if ($searchTerm) {
            $query .= " WHERE title LIKE ? OR description LIKE ?";
            // Prepare the search term with wildcards for LIKE
            $wildcardSearchTerm = "%" . htmlspecialchars(strip_tags($searchTerm)) . "%";
            $params[] = $wildcardSearchTerm; // Add to params array
            $params[] = $wildcardSearchTerm; // Add again for description
            $types .= "ss"; // Two string parameters
        }
        
       
        $query .= " ORDER BY id DESC"; 

       
        $stmt = $this->conn_mysqli->prepare($query);
        if ($stmt === false) {
            // error_log('MySQLi prepare error (readAll): ' . $this->conn_mysqli->error);
            return false;
        }

       
        if ($searchTerm && count($params) > 0) {
            // The "..." operator (splat operator) unpacks the $params array
            // into individual arguments for bind_param.
            $stmt->bind_param($types, ...$params);
        }

        
        if (!$stmt->execute()) {
            // error_log('MySQLi execute error (readAll): ' . $stmt->error);
            $stmt->close();
            return false;
        }
        
        
        $result = $stmt->get_result();
        $stmt->close(); 
        
        return $result; 

    /**
     * Read a single service by its ID.
     *
     * @param int $id The ID of the service to retrieve.
     * @return array|null An associative array of the service data, or null if not found or error.
     */
    public function readOne($id) {
        $query = "SELECT id, title, description, image FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        
        $stmt = $this->conn_mysqli->prepare($query);
        if ($stmt === false) {
            // error_log('MySQLi prepare error (readOne): ' . $this->conn_mysqli->error);
            return null; 
        }

        // Ensure ID is an integer for binding
        $id_san = (int) $id;
        $stmt->bind_param("i", $id_san); 

        if (!$stmt->execute()) {
            // error_log('MySQLi execute error (readOne): ' . $stmt->error);
            $stmt->close();
            return null;
        }
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc(); 
        
        $stmt->close();
        return $row; 
    }

    /**
     * Update an existing service.
     *
     * @param int $id The ID of the service to update.
     * @param string $title The new title.
     * @param string $desc The new description.
     * @param string|null $img_filename The new image filename/path. If null, image is not updated.
     * @return bool True if update was successful, false otherwise.
     */
    public function update($id, $title, $desc, $img_filename = null) {
        $query = "UPDATE " . $this->table_name . " SET title = ?, description = ?";
        $params = [];
        $types = "ss"; 

      
        $title_san = htmlspecialchars(strip_tags($title));
        $desc_san = htmlspecialchars(strip_tags($desc));
        $params[] = $title_san;
        $params[] = $desc_san;

        if ($img_filename !== null) { // If a new image filename is provided
            $query .= ", image = ?"; // Add image update to query
            $img_filename_san = htmlspecialchars(strip_tags($img_filename));
            $params[] = $img_filename_san;
            $types .= "s"; 
        }

        $query .= " WHERE id = ?"; 
        $id_san = (int) $id;       
        $params[] = $id_san;
        $types .= "i";             
        
        $stmt = $this->conn_mysqli->prepare($query);
        if ($stmt === false) {
            // error_log('MySQLi prepare error (update): ' . $this->conn_mysqli->error);
            return false;
        }

        
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            // error_log('MySQLi execute error (update): ' . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    /**
     * Delete a service from the database.
     *
     * @param int $id The ID of the service to delete.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete($id) {
       
        $serviceToDelete = $this->readOne($id);

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn_mysqli->prepare($query);
        if ($stmt === false) {
            // error_log('MySQLi prepare error (delete): ' . $this->conn_mysqli->error);
            return false;
        }

        $id_san = (int) $id;
        $stmt->bind_param("i", $id_san);

        if ($stmt->execute()) {
            $stmt->close();

            // If database deletion was successful, try to delete the image file from the server
            if ($serviceToDelete && !empty($serviceToDelete['image'])) {
               
                $filePath = __DIR__ . '/../' . $serviceToDelete['image']; 
                
                if (file_exists($filePath)) {
                    @unlink($filePath); 
                }
            }
            return true;
        } else {
            // error_log('MySQLi execute error (delete): ' . $stmt->error);
            $stmt->close();
            return false;
        }
    }
}
?>