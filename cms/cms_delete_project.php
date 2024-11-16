<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: cms_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    try {
        $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
        $stmt->execute([$_POST["id"]]);
        $project = $stmt->fetch();
        
        if ($project && file_exists($project["image"])) {
            unlink($project["image"]); 
        }
        
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$_POST["id"]]);
        
        header("Location: cms_dashboard.php");
        exit;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

header("Location: cms_dashboard.php");
exit;