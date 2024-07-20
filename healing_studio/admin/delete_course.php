<?php
include_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the course ID from the POST request
    $course_id = $_POST["course_id"];

    // Database connection
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        echo "Course deleted successfully";
    } else {
        echo "Error deleting course: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
        }
        .confirmation {
            max-width: 600px;
            margin: 0 auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #da190b;
        }
        select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>Delete Course</h2>
    <div class="confirmation">
        <form action="delete_course.php" method="POST">
            <label for="course_id">Select Course to Delete:</label><br>
            <select id="course_id" name="course_id">
                <?php
                include_once "../config.php";

                // Database connection
                $conn = new mysqli(
                    $db_host,
                    $db_username,
                    $db_password,
                    $db_name
                );

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
                } else {
                    echo "<option disabled>No courses available</option>";
                }

                // Close database connection
                $conn->close();
                ?>
            </select><br>
            <button type="submit">Delete Course</button>
        </form>
    </div>
</body>
</html>
