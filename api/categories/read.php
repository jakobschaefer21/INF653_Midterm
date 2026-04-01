<?php
/*    Category Retrieval
++++++++++++++++++++++++++++++++++++++++++++++++++++
Script handles GET requests to retrieve
category data from the database

It does the following
    <> Connects to database
    <> Reads query parameters (optional ID)
    <> Retrieves one or all categories
    <> Returns JSON response
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// Set headers
header('Content-Type: application/json');

// Required File Paths
include_once(__DIR__ . '/../../config/database.php');
include_once(__DIR__ . '/../../models/Category.php');

// Connect to Database
$database = new Database();
$db = $database->getConnection();

// Create Category Object
$category = new Category($db);

// Gets parameters from URL
parse_str($_SERVER['QUERY_STRING'], $params);

// Assign ID if present
$category->id = isset($params['id']) ? $params['id'] : null;

// Execute and get number of rows
$stmt = $category->read();
$num = $stmt->rowCount();

// If records exist, create array, else return error
if ($num > 0) {
    $categories_arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categories_arr[] = [
            'id' => $row['id'],
            'category' => $row['category']
        ];
    }
    // If specific ID, return single object, else return array
    if (!empty($category->id) && count($categories_arr) === 1) {
        echo json_encode($categories_arr[0]);
    }
    else {
        echo json_encode($categories_arr);
    }
}
else {
    echo json_encode([
        "message" => "No Categories Found"
    ]);
}