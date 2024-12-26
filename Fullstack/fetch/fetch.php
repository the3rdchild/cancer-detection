<?php
require_once '../app/database.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$db = Database::connect();

try {
    $sql = "SELECT 
                session_id, 
                height_location, 
                detection_time, 
                cancer_type, 
                confidence, 
                image_path, 
                detection_status 
            FROM detection_results 
            ORDER BY detection_time DESC 
            LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $latestDetection = $stmt->fetch();

    $cameraFeed = 'http://localhost:8080/video_feed'; 

    $response = [
        'camera_feed' => $cameraFeed,
        'latest_detection' => $latestDetection
    ];

    echo json_encode($response);
} catch (Exception $e) {
    error_log($e->getMessage(), 3, '../app/logs/database_error.log');
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch data.']);
} finally {
    Database::disconnect();
}
?>
