<?php
/*    Category Update
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles PUT requests to update
an existing category record in the database

It does the following
    <> Accepts JSON input
    <> Validates required fields (ID and category)
    <> Uses Category model to update data
    <> Returns updated category or error message
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// CORS and Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
// If id and category are not empty, update category
// Else, return error message
if (!empty($data->id) && !empty($data->category)) {
    $category->id = $data->id;
    $category->category = $data->category;
    $result = $category->update();
    echo json_encode($result);
}
else {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
}