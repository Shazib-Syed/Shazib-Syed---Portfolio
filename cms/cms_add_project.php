<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: cms_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $live_url = $_POST["live_url"];
    
    $target_dir = "uploads/"; 
    // $target_dir = __DIR__ . "/uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    if(isset($_FILES["image"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $image = $target_dir . uniqid() . '.' . $imageFileType;
            $image = $target_dir . uniqid() . '.' . $imageFileType;
            $image = 'uploads/' . uniqid() . '.' . $imageFileType;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, live_url) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$title, $description, $image, $live_url]);
                    $success = "Project added successfully";
                } catch(PDOException $e) {
                    $error = "Error: " . $e->getMessage();
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "File is not an image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project</title>
    <!-- Tailwindcss link -->
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-custom-bg">
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl text-custom-text font-bold">Add New Project</h1>
            <a href="cms_dashboard.php" class="bg-cms-bg text-white px-4 py-2 rounded hover:bg-gray-600">Back to Dashboard</a>
        </div>
        
        <?php if (isset($success)): ?>
            <p class="text-green-500 mb-4"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="text-red-500 mb-4"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="POST" action="" enctype="multipart/form-data" class="bg-cms-bg shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-custom-text text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-custom-bg leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" name="title" required>
            </div>
            <div class="mb-4">
                <label class="block text-custom-text text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-custom-bg leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-custom-text text-sm font-bold mb-2" for="image">
                    Project Image
                </label>
                <input type="file" name="image" id="image" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
            </div>
            <div class="mb-4">
                <label class="block text-custom-text text-sm font-bold mb-2" for="live_url">
                    Live URL
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-custom-bg leading-tight focus:outline-none focus:shadow-outline" id="live_url" type="url" name="live_url" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-custom-bg  hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Add Project
                </button>
            </div>
        </form>
    </div>
</body>
</html>