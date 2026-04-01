<?php
/*    Quote Retrieval
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles GET requests to retrieve
quote data from the database

It does the following
    <> Connects to database
    <> Reads optional query parameters (id, author_id, category_id)
    <> Retrieves one or all quotes
    <> Returns JSON response
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// Required File Paths
include_once(__DIR__ . '/../../config/database.php');
include_once(__DIR__ . '/../../models/Quote.php');

// Connect to Database
$database = new Database();
$db = $database->getConnection();

// Create Quote Object
$quoteObj = new Quote($db);

// Get query parameters from URL
$quoteObj->id = isset($_GET['id']) ? $_GET['id'] : null;
$quoteObj->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$quoteObj->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Execute query and get number of rows
$stmt = $quoteObj->read();
$num = $stmt->rowCount();

// If records exist, create array, else return error
if ($num > 0) {
    $quotes_arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $quotes_arr[] = [
            'id' => $row['id'],
            'quote' => $row['quote'],
            'author' => $row['author'],
            'category' => $row['category']
        ];
    }
    // If specific ID, return single object, else return array
    if ($quoteObj->id && count($quotes_arr) === 1) {
        echo json_encode($quotes_arr[0]);
    }
    else {
        echo json_encode($quotes_arr);
    }
}
else {
    echo json_encode([
        "message" => "No Quotes Found"
    ]);
}