<?php
/*    Authors API Request Handler
++++++++++++++++++++++++++++++++++++++++++++++++++++
This script handles incoming API requests and
routes them to the appropriate file based on the HTTP method (GET, POST, PUT, DELETE)

It does the following:
    <> Checks the incoming request method
    <> Routes the request to the appropriate handler (read.php, create.php, update.php, delete.php)
    <> Sends back an error message if the request method is invalid
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
        include 'read.php';
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
