<?php
/*    Author Update
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles PUT requests to update
an existing author record in the database

It does the following
    <> Accepts JSON input
    <> Validates required fields (ID and author)
    <> Uses Author model to update data
    <> Returns JSON response
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// Cors and Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Required File Paths
include_once __DIR__ . '/../../config/Database.php';
include_once __DIR__ . '/../../models/Author.php';

// Connect to Database
$database = new Database();
$db = $database->getConnection();

// Create Author object
$author = new Author($db);

// Get input and decode JSON
$data = json_decode(file_get_contents("php://input"));

// Validation
// If id and author are not empty, update author
// Else, return error message
if (!empty($data->id) && !empty($data->author)) {
    $author->id = $data->id;
    $author->author = $data->author;
    $result = $author->update();
    echo json_encode($result);
}
else {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
}
