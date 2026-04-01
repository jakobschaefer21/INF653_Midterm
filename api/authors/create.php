<?php
/*    Author Creation
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles POST requests to create
a new author record in the database

It does the following
    <> Accepts JSON input
    <> Validates required fields
    <> Confirms with Author Database to insert data
    <> Returns JSON response
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// CORS and Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Required File Paths
include_once __DIR__ . '/../../config/Database.php';
include_once __DIR__ . '/../../models/Author.php';

// Connects to Database
$database = new Database();
$db = $database->getConnection();

// Creates Author Object
$author = new Author($db);

// Get input and decode JSON
$data = json_decode(file_get_contents("php://input"));

// Validation
// If author is not empty, create new author
// Else, return error
if (!empty($data->author)) {
    $author->author = $data->author;
    $result = $author->create();
    echo json_encode($result);
}
else {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
}