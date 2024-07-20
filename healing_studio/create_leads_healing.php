<?php
include_once("config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone_number = $_POST["phone_number"];
    $course = isset($_POST['program']) ? $_POST['program'] : ''; // Changed 'course' to 'program'

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to insert data into the "leads" table
    $sql = "INSERT INTO leads (first_name, last_name,course_name, phone_number) VALUES ('$first_name', '$last_name', '$course', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect to the homepage or handle it accordingly
    header("Location: index.html");
    exit();
}
?>
