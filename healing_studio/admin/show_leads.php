<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
include_once("../config.php");

// Connect to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from the "leads" table
$sql = "SELECT first_name, last_name, phone_number, course_name FROM leads";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Leads List</h1>

        <?php if ($result->num_rows > 0) : ?>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-600">
                        <th class="py-2 px-4 border-b">First Name</th>
                        <th class="py-2 px-4 border-b">Last Name</th>
                        <th class="py-2 px-4 border-b">Phone Number</th>
                        <th class="py-2 px-4 border-b">Course</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row["first_name"]); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row["last_name"]); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row["phone_number"]); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($row["course_name"]); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="text-gray-600">No leads found.</p>
        <?php endif; ?>

        <?php
        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
