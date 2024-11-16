<?php
require_once 'config/config.php';

try {
    $stmt = $pdo->query("SELECT id, title, description, image, live_url FROM projects");
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($projects);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>