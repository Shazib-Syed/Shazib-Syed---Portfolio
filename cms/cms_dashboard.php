<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: cms_login.php");
    exit;
}

try {
    $stmt = $pdo->query("SELECT id, title, description, image, live_url FROM projects");
    $projects = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Dashboard</title>
    <!-- Tailwindcss link -->
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-custom-bg">
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl text-custom-text font-bold">CMS Dashboard</h1>
            <div class="space-x-4">
                <a href="cms_add_project.php" class="bg-green-500 text-custom-text px-4 py-2 rounded hover:bg-green-600">Add New Project</a>
                <a href="logout.php" class="bg-form-invalid text-custom-text px-4 py-2 rounded hover:bg-red-600">Logout</a>
            </div>
        </div>
        
        <div class="bg-cms-bg shadow-md rounded-lg overflow-hidden">
            <table class="w-full">
    <thead class="bg-custom-button">
        <tr>
            <th class="px-4 text-custom-bg py-2">Title</th>
            <th class="px-4 text-custom-bg  py-2">Description</th>
            <th class="px-4 text-custom-bg  py-2">Image</th>
            <th class="px-4 text-custom-bg  py-2">Live URL</th>
            <th class="px-4 text-custom-bg  py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($projects as $project): ?>
            <tr>
                <td class="text-custom-text px-4 py-2"><?php echo htmlspecialchars($project["title"]); ?></td>
                <td class="text-custom-text px-4 py-2"><?php echo htmlspecialchars($project["description"]); ?></td>
                <td class="border-0  text-custom-text px-4 py-2">
                    <img src="<?php echo htmlspecialchars($project["image"]); ?>" alt="Project Image" class="w-20 h-20 object-cover">
                </td>
                <td class="px-4 py-2">
                    <a href="<?php echo htmlspecialchars($project["live_url"]); ?>" target="_blank" rel="noopener noreferrer" class=" text-custom-text hover:underline hover:text-content-area"><?php echo htmlspecialchars($project["live_url"]); ?></a>
                </td>
                <td class="px-4 py-2">
                    <a href="cms_edit_project.php?id=<?php echo $project["id"]; ?>" class="bg-green-500 text-custom-text px-2 py-1 rounded hover:bg-green-600 mr-2">Edit</a>
                    <form action="cms_delete_project.php" method="POST" class="inline">
                        <input type="hidden" name="id" value="<?php echo $project["id"]; ?>">
                        <button type="submit" class="bg-form-invalid text-custom-text px-2 py-1 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        </div>
    </div>
</body>
</html>