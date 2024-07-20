<?php
include_once "config.php";

// Database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch courses from the database, including image blobs
$sql = "SELECT name, description, image, free FROM courses";
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
            "free" => $row["free"],
        ];
    }
}


// Fetch testimonials from the database
$sql_testimonials = "SELECT name, testimonial_text, position FROM testimonials";
$result_testimonials = $conn->query($sql_testimonials);

// Initialize an array to store testimonials
$testimonials = [];

if ($result_testimonials->num_rows > 0) {
    // Fetch data from each row
    while ($row = $result_testimonials->fetch_assoc()) {
        // Store testimonial data
        $testimonials[] = [
            "name" => $row["name"],
            "testimonial_text" => $row["testimonial_text"],
            "position" => $row["position"],
        ];
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healing Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .custom-img {
            width: 300px;
            height: 200px;
        }

        .header,
        .footer {
            background-color: #26a69a;
            color: white;
            padding: 20px;
            text-align: center;
        }
        html {
    scroll-behavior: smooth;
}
    </style>
</head>

<body class="bg-white-100">

<nav class="bg-green-600 p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo or Brand Name -->
        <a href="#" class="text-white text-2xl font-bold tracking-wide">Healing Studio</a>
        
        <!-- Navigation Menu -->
        <ul class="flex space-x-6 text-white">
            <li><a href="#about" class="hover:text-gray-300 transition-colors duration-300">About</a></li>
            <li><a href="#services" class="hover:text-gray-300 transition-colors duration-300">Services</a></li>
            <li><a href="#programs" class="hover:text-gray-300 transition-colors duration-300">Upcoming Programs</a></li>
            <li><a href="#about_us" class="hover:text-gray-300 transition-colors duration-300">About Us</a></li>
            <li><a href="#testimonials" class="hover:text-gray-300 transition-colors duration-300">Testimonials</a></li>
            <li><a href="#resources" class="hover:text-gray-300 transition-colors duration-300">Resources</a></li>
        </ul>
    </div>
</nav>


    <div class="container mx-auto py-10">

    <section id="about" class="mb-10 snap-start">
    <div class="flex flex-col md:flex-row items-center rounded-lg">
        <!-- Adjusted image styling with smaller height  #TODO image height-->
        <img src="ibrahim.jpeg" alt="About Image" class="md:w-1/2 h-18 object-scale-down  object-cover mb-4 md:mb-0 rounded-lg">

        <!-- Text section with better spacing and alignment -->
        <div class="md:ml-6 flex-1">
            <h3 class="text-6xl font-semibold mb-4 text-green-600">About Healing Studio</h3>
            <p class="text-lg text-gray-800">
                Healing Studio™ is a venture to support people to overcome their life struggles.
                It is to help every adult to live a good, happy, and peaceful life. It is a safe place where you can share your life freely without fear and where every word is protected as secret.
                In the long journey of life, it's understandable to get emotionally hurt, get your heart wounded, or create a feeling of guilt and sadness. These burdens make life a troublesome, sad, and uninspiring journey. However, you need not live with these burdens.
            </p> <p class="text-lg text-gray-800"> Because you deserve a good, happy, and peaceful life. </p>
        </div>
    </div>
</section>


<section id="programs" class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h3 class="text-4xl font-extrabold text-center mb-12 text-green-600">Our Sessions</h3>
        <div class="space-y-12">
            <?php foreach ($courses as $course) : ?>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">
                    <!-- Image Section -->
                    <div class="md:w-1/3">
                        <img src="<?php echo $course["image"]; ?>" class="w-full h-64 object-cover md:rounded-l-lg">
                    </div>

                    <!-- Details Section -->
                    <div class="p-6 md:w-2/3 flex flex-col justify-between">
                        <div class="flex-1">
                            <h5 class="text-3xl font-bold mb-4 text-gray-800"><?php echo $course["name"]; ?></h5>
                            <p class="text-gray-600 mb-6"><?php echo $course["description"]; ?></p>
                        </div>
                        <div class="flex justify-center mt-4">
                            <?php if ($course["free"] == 1) : ?>
                                <a href="#" class="bg-green-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-green-700 transition-colors duration-300" onclick="generateWhatsappLink()">Join WhatsApp Community</a>
                            <?php else : ?>
                                <a href="#modal2" class="bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-purple-800 transition-colors duration-300 modal-trigger">Register Now</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>









        <section class="session mb-10">
            <div class="max-w-md mx-auto">
                <h3 class="text-3xl font-semibold mb-4">Contact Us</h3>
                <form class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="phone_number" class="block text-gray-700">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="program" class="block text-gray-700">Select Program</label>
                        <select id="program" name="program" class="w-full p-2 border border-gray-300 rounded-lg">
                            <?php foreach ($courses as $course) : ?>
                                <option value="<?php echo $course["name"]; ?>"><?php echo $course["name"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-purple-700 text-white p-2 rounded-lg">Submit</button>
                </form>
            </div>
        </section>

        <section id="testimonials" class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h3 class="text-4xl font-extrabold text-center mb-12 text-green-600">Testimonials</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($testimonials as $testimonial) : ?>
                <div class="bg-gray-100 text-gray-800 p-6 rounded-lg shadow-md">
                    <p class="text-lg mb-4">"<?php echo htmlspecialchars($testimonial["testimonial_text"]); ?>"</p>
                    <p class="font-semibold"><?php echo htmlspecialchars($testimonial["name"]); ?></p>
                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($testimonial["position"]); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

    </div>

    <div id="modal2" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
        <h5 class="text-2xl font-semibold mb-6">Please help us reach out to you</h5>
        <form action="create_leads_healing.php" method="post">
            <div class="mb-4">
                <label for="first_name_modal" class="block text-gray-700">First Name</label>
                <input type="text" id="first_name_modal" name="first_name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="last_name_modal" class="block text-gray-700">Last Name</label>
                <input type="text" id="last_name_modal" name="last_name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="phone_number_modal" class="block text-gray-700">Phone Number</label>
                <input type="tel" id="phone_number_modal" name="phone_number" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="program_modal" class="block text-gray-700">Select Program</label>
                <select id="program_modal" name="program" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    <?php foreach ($courses as $course) : ?>
                        <?php if ($course["free"] == 0) : ?>
                            <option value="<?php echo $course["name"]; ?>"><?php echo $course["name"]; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="w-full bg-purple-700 text-white p-2 rounded-lg hover:bg-purple-800">Submit</button>
        </form>
    </div>
</div>


    <footer class="bg-green-700 text-white p-4 text-center">
        <p>Healing Studio &copy; 2024</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".modal-trigger").click(function(e) {
                e.preventDefault();
                $("#modal2").removeClass("hidden").addClass("flex");
            });

            $(document).on("click", function(e) {
                if ($(e.target).closest("#modal2 .p-6").length === 0 && $(e.target).closest(".modal-trigger").length === 0) {
                    $("#modal2").removeClass("flex").addClass("hidden");
                }
            });

            $("form").submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();
                var modalInstance = $("#modal2");

                $.ajax({
                    type: 'POST',
                    url: 'create_leads_healing.php',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        modalInstance.removeClass("flex").addClass("hidden");
                        alert('Thank you for your submission!');
                    },
                    error: function(error) {
                        console.error(error);
                        alert('Form submission failed. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>