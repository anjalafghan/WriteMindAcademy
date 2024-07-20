<?php
include_once "config.php";

// Database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch courses from the database, including image blobs
$sql = "SELECT name, description, image FROM courses";
$result = $conn->query($sql);

// Initialize an array to store courses
$courses = [];

if ($result->num_rows > 0) {
    // Fetch data from each row
    while ($row = $result->fetch_assoc()) {
        // Convert blob data to base64 for image display
        $imageData = base64_encode($row["image"]);
        // Format the image data into a proper data URI
        $imageSrc = "data:image/" . "png" . ";base64," . $imageData;

        // Store course data including the image data URI
        $courses[] = [
            "name" => $row["name"],
            "description" => $row["description"],
            "image" => $imageSrc,
        ];
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
    <title>Healing Studio</title>
    <style>

        body {
            font-family: Arial, sans-serif;
        }
        header {
            text-align: center;
            font-size: 2em;
            padding: 10px;
        }
        .heading {
            text-align: center;
            font-size: 1.5em;
            padding: 10px;
        }
        .navbar {
            text-align: center;
            margin: 20px 0;
        }
        .navbar a {
            margin: 0 10px;
            text-decoration: none;
            font-size: 1.2em;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }
        .about, .what_we_do {
            flex: 1 1 45%;
            margin: 10px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .about img, .what_we_do img {
            max-width: 100%;
            border-radius: 8px;
        }
        .testimonials, .courses {
            flex: 1 1 100%;
            margin: 10px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .testimonials .testimonial-item, .courses .course-item {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .course-item{
            display: inline-block;
        }
        .session {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }
        .session div {
            flex: 1 1 45%;
            margin: 10px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .session form {
            display: flex;
            flex-direction: column;
        }
        .session form input, .session form select {
            margin: 5px 0;
            padding: 10px;
            font-size: 1em;
        }
        .session form button {
            padding: 10px;
            font-size: 1em;
            margin-top: 10px;
        }
        .course_image{
            width: 200px;
             height: 300px;
            object-fit: cover;

        }
    </style>
</head>
<body>
    <header>Healing Studio</header>
    <div class="heading">Welcome to Our Healing Studio</div>
    <div class="navbar">
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#programs">Upcoming Programs</a>
        <a href="#about_us">About Us</a>
        <a href="#testimonials">Testimonials</a>
        <a href="#resources">Resources</a>
    </div>
    <div class="container">
        <div class="about" id="about">
            <img src="image_path.jpg" alt="About Image">
            <h2>About Healing Studio</h2>
            <p>Description about the healing studio goes here.</p>
        </div>
        <div class="what_we_do" id="services">
            <h2>What We Do</h2>
            <p>Details about the services provided by the studio.</p>
        </div>
    </div>
    <div class="testimonials" id="testimonials">
        <h2>Testimonials</h2>
        <div class="testimonial-item">
            <p>Testimonial 1</p>
        </div>
        <div class="testimonial-item">
            <p>Testimonial 2</p>
        </div>
        <div class="testimonial-item">
            <p>Testimonial 3</p>
        </div>
        <div class="testimonial-item">
            <p>Testimonial 4</p>
        </div>
        <div class="testimonial-item">
            <p>Testimonial 5</p>
        </div>
        <div class="testimonial-item">
            <p>Testimonial 6</p>
        </div>
    </div>
    <div class="courses" id="programs">
        <h2>Upcoming Programs</h2>
        <?php foreach ($courses as $course): ?>
            <div class="course-item">
                <h3><?php echo $course["name"]; ?></h3>
                <img class="course_image" src="<?php echo $course[
                    "image"
                ]; ?>" alt="<?php echo $course["name"]; ?>">
                <p><?php echo $course["description"]; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="session">
        <div>
            <h2>Free Session</h2>
            <p>Details about free session</p>
            <button>Click to WhatsApp Community</button>
        </div>
        <div>
            <h2>Group Session (Paid)</h2>
            <p>Details about group session</p>
            <button>Register Now</button>
        </div>
        <div>
            <h2>Contact Us</h2>
            <form>
                <input type="text" name="first_name" placeholder="First Name">
                <input type="text" name="last_name" placeholder="Last Name">
                <input type="text" name="phone_number" placeholder="Phone Number">
                <select name="program">
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course[
                            "name"
                        ]; ?>"><?php echo $course["name"]; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
