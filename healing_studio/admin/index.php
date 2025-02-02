<?php 

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
// Check if the user is logged in

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f4f4f9;
                margin: 0;
            }

            .button-container {
                display: flex;
                gap: 10px;
            }

            a {
                text-decoration: none;
            }

            button {
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="button-container">
            <a href="create.php"><button>Create Course</button></a>
            <a href="update_course.php"><button>Update Course</button></a>
            <a href="delete_course.php"><button>Delete Course</button></a>
            <a href="add_testimonial.php"><button>Add testimonial</button></a>
            <a href="show_leads.php"><button>Show Leads</button></a>
        </div>
    </body>
</html>
