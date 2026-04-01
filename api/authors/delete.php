<?php
/*    Author Deletion
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles DELETE requests to remove
an author record from the database

It does the following
    <> Accepts JSON input
    <> Validates required fields
    <> Uses Author model to delete data
    <> Returns JSON response
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// CORS and Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Required File Paths
include_once __DIR__ . '/../../config/Database.php';
include_once __DIR__ . '/../../models/Author.php';

// Connect to Database
$database = new Database();
$db = $database->getConnection();

// Creates Author Object
$author = new Author($db);

// Get input and decode JSON
$data = json_decode(file_get_contents("php://input"));

// Validation
// If id exists, delete author
// Else, return error message
if (!empty($data->id)) {
    $author->id = $data->id;
    $result = $author->delete();
    echo json_encode($result);
}
else {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
}