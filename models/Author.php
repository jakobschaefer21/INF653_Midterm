<?php
/*    Author Model
++++++++++++++++++++++++++++++++++++++++++++++++++++
This class provides CRUD operations for the
authors table in the database.

It does the following
    <> Connects to the database via PDO
    <> Provides read, create, update, delete methods
    <> Returns JSON-friendly arrays for API responses
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db){
        $this->conn = $db;
    }

    // reads ALL authors
    public function read(){
        $query = 'SELECT id, author FROM ' . $this->table;
        // if ID exists, add filter
        if(!empty($this->id)){
            $query .= ' WHERE id = :id';
        }
        $query .= ' ORDER BY id';
        $stmt = $this->conn->prepare($query);
        // bind ID if filtering
        if(!empty($this->id)){
            $stmt->bindParam(':id', $this->id);
        }
        $stmt->execute();
        return $stmt;
    }

    // read a SINGLE author
    public function read_single(){
        $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    // CREATE a new author
    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author) RETURNING id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author', $this->author);
        // execute query
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return ['id' => $this->id, 'author' => $this->author];
        }
        return ['message' => 'Could not create author'];
    }

    // UPDATE an author
    public function update(){
        $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
        // execute query
        if($stmt->execute()){
            // check if row was updated else return error
            if($stmt->rowCount() > 0){
                return ['id' => $this->id, 'author' => $this->author];
            }
            else {
                return ['message' => 'No Author Found'];
            }
        }
        return ['message' => 'Could not update author'];
    }

    // DELETE an author
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
                return ['message' => 'No Author Found'];
            }
        }
        return ['message' => 'Could not delete author'];
    }
}