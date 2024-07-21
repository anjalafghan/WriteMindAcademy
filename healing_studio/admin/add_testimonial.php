<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
include_once "../config.php";

// Database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = $conn->real_escape_string(trim($_POST['name']));
    $position = $conn->real_escape_string(trim($_POST['position']));
    $testimonial_text = $conn->real_escape_string(trim($_POST['testimonial_text']));

    // Insert data into the database
    $sql = "INSERT INTO testimonials (name, position, testimonial_text) VALUES ('$name', '$position', '$testimonial_text')";

    if ($conn->query($sql) === TRUE) {
        $message = "New testimonial added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Testimonial</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-roboto">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-center mb-8 text-green-600">Submit Your Testimonial</h1>
        
        <?php if (isset($message)): ?>
            <div class="bg-green-200 text-green-800 p-4 rounded-lg mb-4 text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="" class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Name:</label>
                <input type="text" id="name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div class="mb-4">
                <label for="position" class="block text-gray-700 text-sm font-semibold mb-2">Position:</label>
                <input type="text" id="position" name="position" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div class="mb-4">
                <label for="testimonial_text" class="block text-gray-700 text-sm font-semibold mb-2">Testimonial:</label>
                <textarea id="testimonial_text" name="testimonial_text" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-600 transition-colors duration-300">Submit Testimonial</button>
            </div>
        </form>
    </div>
</body>
</html>
