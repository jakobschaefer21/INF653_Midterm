<?php

/*    Quotes API Request Router
++++++++++++++++++++++++++++++++++++++++++++++++++++
This script handles incoming API requests and routes them
to the corresponding handler based on the HTTP method (GET, POST, PUT, DELETE).
Additionally, it supports conditional GET requests that may include an ID.

It does the following:
    <> Checks the request method (GET, POST, PUT, DELETE)
    <> Routes the request to the appropriate handler script (read.php, create.php, update.php, delete.php)
    <> Handles CORS (Cross-Origin Resource Sharing) pre-flight requests
    <> Adds conditional behavior to the GET request based on the presence of an ID
    <> Returns an error message for invalid methods
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Check the incoming request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle preflight requests
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Route the request based on the HTTP method
switch($method) {
    case 'GET':
        if(isset($_GET['id'])) {
            include 'read.php';
        } else {
            include 'read.php';
        }
        break;

    case 'POST':
        include 'create.php';
        break;

    case 'PUT':
        include 'update.php';
        break;

    case 'DELETE':
        include 'delete.php';
        break;

    default:
        echo json_encode(["message" => "Invalid Request"]);
        break;
}