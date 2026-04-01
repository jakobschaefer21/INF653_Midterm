<?php
/*    Database Connection
++++++++++++++++++++++++++++++++++++++++++++++++++++
This script loads environment variables and
provides a Database class to connect to PostgreSQL.

It does the following
    <> Loads .env file
    <> Sets environment variables
    <> Provides Database class with getConnection()
    <> Returns a PDO connection object
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// Load .env file
$env = parse_ini_file(__DIR__ . '/../.env');
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}
else {
    die("Missing .env file");
}

// Database Class
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    // Constructor
    public function __construct(){
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'quotesdb';
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
    }

    // Get Database Connection
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO(
                "pgsql:host=".$this->host.";port=5432;dbname=".$this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Connection error: ".$exception->getMessage();
        }
        return $this->conn;
    }
}