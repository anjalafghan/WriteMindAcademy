<?php 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .container {
                display: flex;
                flex-direction: column;
                align-items: center;
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                box-sizing: border-box;
            }

            h1 {
                text-align: center;
                color: #333;
                margin: 0 0 20px 0;
            }

            form {
                width: 300px;
                box-sizing: border-box;
            }

            input[type="text"],
            textarea,
            input[type="file"] {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            textarea {
                resize: none;
                height: 100px;
            }

            button {
                width: 100%;
                padding: 10px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            button:hover {
                background-color: #218838;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Create Course</h1>
            <form
                action="create_course.php"
                method="post"
                enctype="multipart/form-data"
            >
                <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Course Name"
                    required
                />
                <label for="free">Is the course free? </label>
                <select id="free" name="free">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <textarea
                    name="description"
                    id="description"
                    placeholder="Course Description"
                    required
                ></textarea>
                <input
                    type="file"
                    name="file_to_upload"
                    id="file_to_upload"
                    required
                />
                <button type="submit">Submit</button>
            </form>
        </div>
    </body>
</html>
