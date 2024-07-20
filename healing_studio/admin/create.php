<?php
include_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $free = $_POST["free"];
    $file_to_upload = $_FILES["file_to_upload"];

    // Database connection
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if a file was uploaded without errors
    if (isset($file_to_upload) && $file_to_upload["error"] == 0) {
        // Get the file details
        $fileName = $file_to_upload["name"];
        $fileTmpName = $file_to_upload["tmp_name"];
        $fileSize = $file_to_upload["size"];
        $fileType = $file_to_upload["type"];

        // Get the file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allow only certain file formats
        $allowed = ["jpg", "jpeg", "png", "gif", "pdf", "doc", "docx"];

        if (in_array($fileExt, $allowed)) {
            if ($fileSize <= 5000000) {
                // Limit the file size to 5MB
                // Read the file content as a blob
                $fileContent = addslashes(file_get_contents($fileTmpName));

                // Insert the data into the database
                $sql = "INSERT INTO courses (name, description, image, free) VALUES ('$name', '$description', '$fileContent', '$free')";

                if ($conn->query($sql) === true) {
                    echo "File uploaded successfully!";
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Your file is too large.";
            }
        } else {
            echo "You cannot upload files of this type.";
        }
    } else {
        echo "No file uploaded or an error occurred.";
    }

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect to the homepage or handle it accordingly
    header("Location: index.html");
    exit();
}
?>
