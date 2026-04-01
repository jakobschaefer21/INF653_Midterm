<?php
/*    Quote Model
++++++++++++++++++++++++++++++++++++++++++++++++++++
This class provides CRUD operations for the
quotes table in the database, including joins
to authors and categories for full data.

It does the following
    <> Connects to the database via PDO
    <> Provides read, create, update, delete methods
    <> Supports filtering by ID, author_id, or category_id
    <> Returns JSON-friendly arrays for API responses
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
class Quote {
    private $conn;
    private $table = 'quotes';
    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    public $author;
    public $category;
    // Constructor
    public function __construct($db){
        $this->conn = $db;
    }
    // Read all quotes
    public function read(){
        $query = "SELECT 
                q.id,
                q.quote,
                a.author,
                c.category
              FROM " . $this->table . " q
              LEFT JOIN authors a ON q.author_id = a.id
              LEFT JOIN categories c ON q.category_id = c.id";
        $conditions = [];
        // if ID exists, add filter
        if(!empty($this->id)){
            $conditions[] = "q.id = :id";
        }
        // if author_id exists, add filter
        if(!empty($this->author_id)){
            $conditions[] = "q.author_id = :author_id";
        }
        // if category_id exists, add filter
        if(!empty($this->category_id)){
            $conditions[] = "q.category_id = :category_id";
        }
        // if conditions exist, add them to the query
        if(count($conditions) > 0){
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $this->conn->prepare($query);
        // bind ID if filtering
        if(!empty($this->id)){
            $stmt->bindParam(':id', $this->id);
        }
        // if filtering by author_id, bind it
        if(!empty($this->author_id)){
            $stmt->bindParam(':author_id', $this->author_id);
        }
        // if filtering by category_id, bind it
        if(!empty($this->category_id)){
            $stmt->bindParam(':category_id', $this->category_id);
        }
        $stmt->execute();
        return $stmt;
    }

    // Read a single quote
    public function read_single(){
        $query = "SELECT 
                    q.id,
                    q.quote,
                    a.author,
                    c.category
                  FROM " . $this->table . " q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // set properties to values
        if($row){
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];
            return true;
        }
        return false;
    }

    // CREATE a quote
    public function create(){
        $query = "INSERT INTO " . $this->table . "
                  (quote, author_id, category_id)
                  VALUES
                  (:quote, :author_id, :category_id)
                  RETURNING id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        // execute query
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        }
        return false;
    }

    // UPDATE a quote
    public function update(){
        $query = "UPDATE " . $this->table . "
                  SET quote = :quote,
                      author_id = :author_id,
                      category_id = :category_id
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
        // execute query
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        return false;
    }

    // DELETE a quote
    public function delete(){
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        // execute query
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        return false;
    }
}