<?php
/*    Quote Creation
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles POST requests to create
a new quote record in the database

It does the following
    <> Accepts JSON input
    <> Validates required fields (quote, author_id, category_id)
    <> Uses Quote model to insert data
    <> Returns JSON response with new quote ID
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// CORS and Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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

// Validate
// If all required fields are not empty, create new quote
// Else, return error message
if (
    isset($data->quote) &&
    isset($data->author_id) &&
    isset($data->category_id)
) {
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;
    $result = $quote->create();
    echo json_encode([
        "id" => $result
    ]);
}
else {
    echo json_encode([
        "message" => "Missing Required Parameters"
    ]);
}