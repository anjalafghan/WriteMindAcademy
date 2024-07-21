<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /admin/index.php'); // Redirect to admin dashboard if already logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Admin Login</h2>
        <?php
        if (isset($_SESSION['login_error'])) {
            echo '<p class="text-red-500 mb-4">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']);
        }
        ?>
        <form action="login_process.php" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-purple-700 text-white py-2 px-4 rounded-lg">Login</button>
        </form>
    </div>
</body>
</html>
