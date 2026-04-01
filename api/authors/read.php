<?php
/*    Author Retrieval
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles GET requests to retrieve
author data from the database

It does the following
    <> Connects to database
    <> Reads query parameters (optional ID)
    <> Retrieves one or all authors
    <> Returns JSON response
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// Required File Paths
include_once(__DIR__ . '/../../config/database.php');
include_once(__DIR__ . '/../../models/Author.php');

// Connect to Database
$database = new Database();
$db = $database->getConnection();

// Create Author object
$author = new Author($db);

// Gets parameters from URL
parse_str($_SERVER['QUERY_STRING'], $params);

// Assign ID if present
$author->id = isset($params['id']) ? $params['id'] : null;

// Execute and get number of rows
$stmt = $author->read();
$num = $stmt->rowCount();

// If records exist, create array, else return error
if ($num > 0) {
    $authors_arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $authors_arr[] = [
            'id' => $row['id'],
            'author' => $row['author']
        ];
    }
    // If specific ID, return single object, else return array
    if (!empty($author->id) && count($authors_arr) === 1) {
        echo json_encode($authors_arr[0]);
    }
    else {
        echo json_encode($authors_arr);
    }
}
else {
    echo json_encode([
        "message" => "No Authors Found"
    ]);
}