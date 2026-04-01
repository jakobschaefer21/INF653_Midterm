<?php
/*    Category Creation
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles POST requests to create
a new category record in the database

It does the following
    <> Accepts JSON input
    <> Validates required fields
    <> Uses Category model to insert data
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
include_once __DIR__ . '/../../models/Category.php';

// Connect to Database
$database = new Database();
$db = $database->getConnection();

// Create Category Object
$category = new Category($db);

// Get input and decode JSON
$data = json_decode(file_get_contents("php://input"));

// Validation
// If category is not empty, create new category
// Else, return error
if (!empty($data->category)) {
    $category->category = $data->category;
    $result = $category->create();
    echo json_encode($result);
}
else {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
}