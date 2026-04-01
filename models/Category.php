<?php
/*    Category Model
++++++++++++++++++++++++++++++++++++++++++++++++++++
This class provides CRUD operations for the
categories table in the database.

It does the following
    <> Connects to the database via PDO
    <> Provides read, create, update, delete methods
    <> Returns JSON-friendly arrays for API responses
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    public function __construct($db){
        $this->conn = $db;
    }

    // Read all categories
    public function read(){
        $query = 'SELECT id, category FROM ' . $this->table;
        // if ID exists, add filter
        if(!empty($this->id)){
            $query .= ' WHERE id = :id';
        }
        $query .= ' ORDER BY id';
        $stmt = $this->conn->prepare($query);
        // if ID exists, bind ID
        if(!empty($this->id)){
            $stmt->bindParam(':id', $this->id);
        }
        $stmt->execute();
        return $stmt;
    }

    // GET single category by ID
    public function read_single(){
        $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    // CREATE a category
    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category) RETURNING id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $this->category);
        // execute query
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return ['id' => $this->id, 'category' => $this->category];
        }
        return ['message' => 'Could not create category'];
    }

    // UPDATE a category
    public function update(){
        $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
        // execute query
        if($stmt->execute()){
            // check if row was updated else return error
            if($stmt->rowCount() > 0){
                return ['id' => $this->id, 'category' => $this->category];
            }
            else {
                return ['message' => 'No Category Found'];
            }
        }
        return ['message' => 'Could not update category'];
    }

    // DELETE a category
    public function delete(){
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        // execute query
        if($stmt->execute()){
            // check if row was deleted else return error
            if($stmt->rowCount() > 0){
                return ['id' => $this->id];
            }
            else {
                return ['message' => 'No Category Found'];
            }
        }
        return ['message' => 'Could not delete category'];
    }
}