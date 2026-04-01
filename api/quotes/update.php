<?php
/*    Quote Update
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles PUT requests to update
an existing quote record in the database

It does the following
    <> Accepts JSON input
    <> Validates required fields (ID, quote, author_id, category_id)
    <> Uses Quote model to update data
    <> Returns updated quote or error message
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// CORS and Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
// If all required fields are not empty, update quote
// Else, return error message
if (
    !empty($data->id) &&
    !empty($data->quote) &&
    !empty($data->author_id) &&
    !empty($data->category_id)
) {
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;
    $result = $quote->update();
    // if successful, return updated quote; else, return error message
    if ($result > 0) {
        echo json_encode([
            "id" => $quote->id,
            "quote" => $quote->quote,
            "author_id" => $quote->author_id,
            "category_id" => $quote->category_id
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