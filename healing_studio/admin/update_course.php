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

// Initialize variables
$course_id = $_POST["course_id"];
$name = isset($_POST["name"]) ? $_POST["name"] : "";
$description = isset($_POST["description"]) ? $_POST["description"] : "";
$file_to_upload = isset($_FILES["file_to_upload"])
    ? $_FILES["file_to_upload"]
    : null;

// Prepare SQL update query
$update_fields = [];
if (!empty($name)) {
    $update_fields[] = "name = '" . $conn->real_escape_string($name) . "'";
}
if (!empty($description)) {
    $update_fields[] =
        "description = '" . $conn->real_escape_string($description) . "'";
}
if ($file_to_upload && $file_to_upload["size"] > 0) {
    $imageData = file_get_contents($file_to_upload["tmp_name"]);
    $imageData = $conn->real_escape_string($imageData);
    $update_fields[] = "image = '$imageData'";
}

if (!empty($update_fields)) {
    $update_sql =
        "UPDATE courses SET " .
        implode(", ", $update_fields) .
        " WHERE id = " .
        $conn->real_escape_string($course_id);
    if ($conn->query($update_sql) === true) {
        echo "Course updated successfully.";
    } else {
        echo "Error updating course: " . $conn->error;
    }
} else {
    echo "No fields to update.";
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="file"] {
            margin-top: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        button:hover {
            background-color: #45a049;
        }
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Update Course</h2>
    <form action="update_course.php" method="POST" enctype="multipart/form-data">
        <label for="course_id">Select Course:</label>
        <select id="course_id" name="course_id">
            <?php
            include_once "../config.php";

            // Database connection
            $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch courses from database
            $sql = "SELECT id, name FROM courses";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" .
                        $row["id"] .
                        "'>" .
                        $row["name"] .
                        "</option>";
                }
            }

            // Close database connection
            $conn->close();
            ?>
        </select><br>
        <label for="name">Course Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter updated course name"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" placeholder="Enter updated course description"></textarea><br>
        <label for="file_to_upload">Upload Image:</label>
        <input type="file" id="file_to_upload" name="file_to_upload"><br>
        <button type="submit">Update Course</button>
    </form>
</body>
</html>
