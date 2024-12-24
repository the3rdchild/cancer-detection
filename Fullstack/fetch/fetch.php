<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../app/database.php';

try {
    $db = Database::connect();
    
// logika

    Database::disconnect();
}

} catch (Exception $e) {
    error_log($e->getMessage(), 3, '../app/logs/database_error.log');
    echo json_encode([
        "error" => "Something went wrong"
    ]);
}
?>
