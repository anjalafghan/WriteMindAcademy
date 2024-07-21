<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone_number = $_POST["phone_number"];
    $course = isset($_POST['program']) ? $_POST['program'] : 'sample';

    // Debugging: Print form data
    error_log("First Name: $first_name");
    error_log("Last Name: $last_name");
    error_log("Phone Number: $phone_number");
    error_log("Course: $course");

    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to insert data into the "leads" table
    $sql = "INSERT INTO leads (first_name, last_name, phone_number, course_name) VALUES ('$first_name', '$last_name', '$phone_number', '$course')";

    // Debugging: Print SQL query
    error_log("SQL Query: $sql");

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        // Debugging: Print SQL error
        echo "Error: " . $sql . "<br>" . $conn->error;
        error_log("SQL Error: " . $conn->error);
    }

    // Close the database connection
    $conn->close();
} else {

    // If the form is not submitted, redirect to the homepage or handle it accordingly
}
?>
