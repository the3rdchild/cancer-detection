<?php
require_once '../app/database.php';

// Enable Cross-Origin Resource Sharing (CORS) if needed
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Connect to the database
$db = Database::connect();

try {
    // Fetch the latest detection data
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

    // Add camera feed URL
    $cameraFeed = 'http://localhost:8080/video_feed'; // Replace with actual camera feed URL or logic

    // Fetch previously detected images from the "Machine Learning/Result/Image" directory
    $imageDir = '../Machine Learning/Result/image'; // Path to the image folder
    $images = array_diff(scandir($imageDir), array('..', '.')); // Remove '.' and '..' entries

    // Combine data for the browser
    $response = [
        'camera_feed' => $cameraFeed,
        'latest_detection' => $latestDetection,
        'previous_images' => $images // List of previously detected images
    ];

    // Output as JSON
    echo json_encode($response);
} catch (Exception $e) {
    error_log($e->getMessage(), 3, '../app/logs/database_error.log');
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch data.']);
} finally {
    Database::disconnect();
}
?>
