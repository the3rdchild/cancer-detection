<?php
require_once '../app/database.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$db = Database::connect();

try {
    // Fetch the latest detection from the database
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

    // Access the image directory
    $imageDir = realpath(dirname(__FILE__) . '/../..' . '/Machine Learning/Result/image');
    
    // Check if the directory exists
    if ($imageDir && is_dir($imageDir)) {
        $images = array_diff(scandir($imageDir), array('..', '.'));
        
        // Sort images by file modification time
        usort($images, function ($a, $b) use ($imageDir) {
            return filemtime($imageDir . '/' . $b) - filemtime($imageDir . '/' . $a);
        });
        
        // Get the latest image
        $latestImage = reset($images);
        $latestImagePath = $latestImage ? "Machine Learning/Result/image/" . $latestImage : 'No images found'; 
        // D:/Program Files/xampp/htdocs/cancer-detection/Machine Learning/Result/image
        } else {
        $latestImagePath = 'Error accessing image directory';
    }

    // Generate a list of all images
    $imageList = array_map(function ($image) use ($imageDir) {
        return "http://localhost/cancer_detection/Machine%20Learning/Result/image/" . $image;
    }, array_diff(scandir($imageDir), array('..', '.')));
    
    // Send JSON response
    $response = [
        'camera_feed' => 'http://127.0.0.1:4000/preview', 
        'latest_detection' => $latestDetection ? $latestDetection : 'No recent detection',
        'latest_image' => $latestImagePath,
        'image_list' => $imageList
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
