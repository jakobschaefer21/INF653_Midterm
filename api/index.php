<?php
/*    API Router
++++++++++++++++++++++++++++++++++++++++++++++++++++
This script handles all incoming API requests
for Quotes, Authors, and Categories endpoints.

It does the following
    <> Parses request URI and method
    <> Routes request to the correct CRUD file
    <> Handles landing page with available endpoints
    <> Returns JSON responses for all requests
++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

// CORS and Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Parse request URI and method
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Split path into array
$path = explode('/', trim($request, '/'));

// Get last element of path
$endpoint = end($path);

// If endpoint is 'api' or 'index.php', return available endpoints
if ($endpoint === 'api' || $endpoint === 'index.php') {
    echo json_encode([
        "message" => "Welcome to the Quotes API",
        "available_endpoints" => [
            "GET /quotes",
            "GET /quotes?id=1",
            "GET /quotes?author_id=1",
            "GET /quotes?category_id=1",
            "POST /quotes",
            "PUT /quotes",
            "DELETE /quotes",
            "GET /authors",
            "GET /categories"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

// Route request to the correct CRUD file
switch ($endpoint) {
    // Quotes
    case 'quotes':
        if ($method === 'GET') {
            include_once __DIR__ . '/quotes/read.php';
        }
        elseif ($method === 'POST') {
            include_once __DIR__ . '/quotes/create.php';
        }
        elseif ($method === 'PUT') {
            include_once __DIR__ . '/quotes/update.php';
        }
        elseif ($method === 'DELETE') {
            include_once __DIR__ . '/quotes/delete.php';
        }
        break;
    // Authors
    case 'authors':
        if ($method === 'GET') {
            include_once __DIR__ . '/authors/read.php';
        }
        elseif ($method === 'POST') {
            include_once __DIR__ . '/authors/create.php';
        }
        elseif ($method === 'PUT') {
            include_once __DIR__ . '/authors/update.php';
        }
        elseif ($method === 'DELETE') {
            include_once __DIR__ . '/authors/delete.php';
        }
        break;
    // Categories
    case 'categories':
        if ($method === 'GET') {
            include_once __DIR__ . '/categories/read.php';
        }
        elseif ($method === 'POST') {
            include_once __DIR__ . '/categories/create.php';
        }
        elseif ($method === 'PUT') {
            include_once __DIR__ . '/categories/update.php';
        }
        elseif ($method === 'DELETE') {
            include_once __DIR__ . '/categories/delete.php';
        }
        break;
    // Anything else
    default:
        http_response_code(404);
        echo json_encode([
            "message" => "Endpoint Not Found"
        ]);
        break;
}
