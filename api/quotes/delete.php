<?php
/*    Quote Deletion
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles DELETE requests to remove
a quote record from the database

It does the following
    <> Accepts JSON input
    <> Validates required field (ID)
    <> Uses Quote model to delete data
    <> Returns deleted quote ID or error message
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// CORS and Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Required File Paths
include_once __DIR__ . '/../../config/Database.php';
include_once __DIR__ . '/../../models/Quote.php';

// Connect to Database
$database = new Database();
$db = $database->getConnection();

// Create Quote Object
$quote = new Quote($db);

// Get input and decode JSON
$data = json_decode(file_get_contents("php://input"));

// Validation
// If id exists, delete quote
// Else, return error message
if (!empty($data->id)) {
    $quote->id = $data->id;
    $result = $quote->delete();
    // if successful, return deleted quote; else, return error message
    if ($result > 0) {
        echo json_encode([
            "id" => $quote->id
        ]);
    }
    else {
        echo json_encode([
            "message" => "No Quotes Found"
        ]);
    }
}
else {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
}