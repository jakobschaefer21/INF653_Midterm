<?php
/*    Category Deletion
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles DELETE requests to remove
a category record from the database

It does the following
    <> Accepts JSON input
    <> Validates required fields (ID)
    <> Uses Category model to delete data
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
include_once __DIR__ . '/../../models/Category.php';

// Connect to Database
$database = new Database();
$db = $database->getConnection();

// Create Category Object
$category = new Category($db);

// Get input and decode JSON
$data = json_decode(file_get_contents("php://input"));

// Validation
// If id exists, delete category
// Else, return error message
if (!empty($data->id)) {
    $category->id = $data->id;
    $result = $category->delete();
    echo json_encode($result);
}
else {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
}