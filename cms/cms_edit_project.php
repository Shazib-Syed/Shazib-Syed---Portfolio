<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: cms_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    try {
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $project = $stmt->fetch();
        if (!$project) {
            echo "Project not found.";
            exit;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $live_url = $_POST["live_url"];
    
    try {
        if ($_FILES["image"]["size"] > 0) {
            $target_dir = "uploads/";
            $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $image = $target_dir . uniqid() . '.' . $imageFileType;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
                $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
                $stmt->execute([$id]);
                $old_image = $stmt->fetchColumn();
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
                
                $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, image = ?, live_url = ? WHERE id = ?");
                $stmt->execute([$title, $description, $image, $live_url, $id]);
            } else {
                throw new Exception("Failed to upload new image.");
            }
        } else {
            $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, live_url = ? WHERE id = ?");
            $stmt->execute([$title, $description, $live_url, $id]);
        }
        
        header("Location: cms_dashboard.php");
        exit;
    } catch(Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    header("Location: cms_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <!-- Tailwindcss link -->
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-custom-bg">
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl text-custom-text font-bold">Edit Project</h1>
            <a href="cms_dashboard.php" class="bg-cms-bg text-white px-4 py-2 rounded hover:bg-gray-600">Back to Dashboard</a>
        </div>
        
        <form method="POST" action="" enctype="multipart/form-data" class="bg-cms-bg shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
            <div class="mb-4">
                <label class="block text-custom-text text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-custom-bg leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-custom-text text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-custom-bg leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-custom-text text-sm font-bold mb-2" for="image">
                    Current Image
                </label>
                <img src="<?php echo htmlspecialchars($project['image']); ?>" alt="Current Project Image" class="w-32 h-32 object-cover mb-2">
                <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-custom-text file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                <p class="text-sm text-custom-text mt-1">Leave empty to keep the current image</p>
            </div>
            <div class="mb-4">
                <label class="block text-custom-text text-sm font-bold mb-2" for="live_url">
                    Live URL
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-custom-bg leading-tight focus:outline-none focus:shadow-outline" id="live_url" type="url" name="live_url" value="<?php echo htmlspecialchars($project['live_url']); ?>" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-custom-bg hover:bg-gray-600 text-custom-text font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Project
                </button>
            </div>
        </form>
    </div>
</body>
</html>