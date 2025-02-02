<?php
session_start();


include_once("../config.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query to check user credentials
    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_username, $db_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $db_password)) {
            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $db_username;
            header('Location: /writemind/healing_studio/admin/index.php'); // Redirect to admin dashboard
            exit();
        } else {
            // Invalid credentials
            $_SESSION['login_error'] = "Invalid username or password.";
            header('Location: /writemind/healing_studio/admin/login.php'); // Redirect back to login page
            exit();
        }
    } else {
        // Invalid username
        $_SESSION['login_error'] = "Invalid username or password.";
        header('Location: /writemind/healing_studio/admin/login.php'); // Redirect back to login page
        exit();
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted, redirect to the login page
    header('Location: /writemind/healing_studio/admin/login.php');
    exit();
}
