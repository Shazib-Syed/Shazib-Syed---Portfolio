<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($username === "admin" && $password === "") {
        $_SESSION["loggedin"] = true;
        header("Location: cms_dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Login</title>
<!-- Tailwindcss link -->
<link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-custom-bg flex items-center justify-center min-h-screen">
    <div class="bg-cms-bg p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl text-custom-text font-bold mb-6 text-center">CMS Login</h2>
        <?php if (isset($error)): ?>
            <p class="text-form-invalid mb-4"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="username" class="block text-custom-text font-bold mb-2">Username</label>
                <input type="text" id="username" name="username" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-custom-text font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-3 py-2 border rounded-lg">
            </div>
            <button type="submit" class="w-full bg-custom-bg text-custom-text px-4 py-2 rounded hover:bg-gray-600 transition-colors">Login</button>
        </form>
    </div>
</body>
</html>