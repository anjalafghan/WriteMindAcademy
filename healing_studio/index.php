<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
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
    <link href="css/dist/output.css" rel="stylesheet">

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

    <nav class="bg-lime-600 p-4 shadow-md">
        <div class="container mx-auto flex flex-wrap items-center justify-between">
            <!-- Logo or Brand Name -->
            <a href="#" class="text-white text-2xl font-bold tracking-wide">Healing Studio</a>

            <!-- Hamburger Menu Button -->
            <button class="block md:hidden text-white focus:outline-none" id="nav-toggle">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            <!-- Navigation Menu -->
            <ul class="hidden md:flex flex-col md:flex-row md:space-x-6 text-white space-y-4 md:space-y-0 w-full md:w-auto mt-4 md:mt-0" id="nav-content">
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
                    <h3 class="text-6xl font-semibold mb-4 text-lime-500">About Healing Studio</h3>
                    <p class="text-lg text-gray-800 mb-4">
                        Healing Studio™ is a venture to support people to overcome their life struggles.
                        It is to help every adult to live a good, happy, and peaceful life. It is a safe place where you can share your life freely without fear and where every word is protected as secret.
                        In the long journey of life, it's understandable to get emotionally hurt, get your heart wounded, or create a feeling of guilt and sadness. These burdens make life a troublesome, sad, and uninspiring journey. However, you need not live with these burdens.
                    </p>
                    <p class="text-lg text-gray-800"> Because you deserve a good, happy, and peaceful life. </p>
                </div>
            </div>
        </section>

        <section id="founder" class="mb-10 snap-start">
            <div class="flex flex-col md:flex-row items-center rounded-lg">
                <!-- Adjusted image styling with smaller height  #TODO image height-->
                <img src="ibrahim.jpeg" alt="founder Image" class="md:w-1/2 h-18 object-scale-down  object-cover mb-4 md:mb-0 rounded-lg">

                <!-- Text section with better spacing and alignment -->
                <div class="md:ml-6 flex-1">
                    <h3 class="text-6xl font-semibold mb-4 text-lime-500">About Ibrahim Afghan</h3>
                    <p class="text-lg text-gray-800 mb-4">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
            </div>
        </section>

        <section id="team" class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <h3 class="text-4xl font-extrabold text-center mb-12 text-lime-500">Meet Our Team</h3>
        <div class="flex flex-col md:flex-row md:space-x-8">
            <!-- Team Member 1 -->
            <div class="flex flex-col items-center md:items-start mb-8 md:mb-0">
                <img src="ibrahim.jpeg" alt="Ibrahim Afghan" class="w-32 h-32 object-cover rounded-full shadow-lg mb-4">
                <h4 class="text-2xl font-semibold text-gray-800">Ibrahim Afghan</h4>
                <p class="text-gray-600 text-center md:text-left">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>
            <!-- Team Member 2 -->
            <div class="flex flex-col items-center md:items-start mb-8 md:mb-0">
                <img src="team_member2.jpeg" alt="Team Member 2" class="w-32 h-32 object-cover rounded-full shadow-lg mb-4">
                <h4 class="text-2xl font-semibold text-gray-800">Team Member 2</h4>
                <p class="text-gray-600 text-center md:text-left">
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
                </p>
            </div>
            <!-- Team Member 3 -->
            <div class="flex flex-col items-center md:items-start">
                <img src="team_member3.jpeg" alt="Team Member 3" class="w-32 h-32 object-cover rounded-full shadow-lg mb-4">
                <h4 class="text-2xl font-semibold text-gray-800">Team Member 3</h4>
                <p class="text-gray-600 text-center md:text-left">
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
        </div>
    </div>
</section>


        <section id="programs" class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <h3 class="text-4xl font-extrabold text-center mb-12 text-lime-500">Our Sessions</h3>
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
                                        <a href="https://chat.whatsapp.com/IQWv8R3tejI42lDDKG7mZO" class="bg-lime-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-green-700 transition-colors duration-300" target="_blank">Join WhatsApp Community</a>
                                    <?php else : ?>
                                        <a href="#modal2" class="bg-fuchsia-900 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-purple-800 transition-colors duration-300 modal-trigger">Register Now</a>
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
                <h3 class="text-3xl font-semibold mb-4 text-center">Contact Us</h3>
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
                    <button type="submit" class="w-full bg-fuchsia-900 text-white p-2 rounded-lg">Submit</button>
                </form>
            </div>
        </section>

        <section id="testimonials" class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <h3 class="text-4xl font-extrabold text-center mb-12 text-lime-500">Testimonials</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($testimonials as $testimonial) : ?>
                        <div class="bg-gray-100 text-gray-800 p-6 rounded-lg shadow-md">
                            <p class="text-lg mb-4">"<?php echo htmlspecialchars(
                                                            $testimonial["testimonial_text"]
                                                        ); ?>"</p>
                            <p class="font-semibold"><?php echo htmlspecialchars(
                                                            $testimonial["name"]
                                                        ); ?></p>
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars(
                                                                    $testimonial["position"]
                                                                ); ?></p>
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
                <button type="submit" class="w-full bg-fuchsia-900 text-white p-2 rounded-lg hover:bg-purple-800">Submit</button>
            </form>
        </div>
    </div>


    <footer class="bg-lime-600 text-white py-8">
    <div class="container mx-auto px-4 text-center">
        <div class="mb-6">
            <h5 class="text-2xl font-semibold mb-2">Healing Studio</h5>
            <p class="text-lg mb-4">Empowering your journey to wellness</p>
            <div class="flex justify-center space-x-4 mb-4">
                <a href="https://www.facebook.com" class="hover:text-gray-200 transition-colors duration-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.twitter.com" class="hover:text-gray-200 transition-colors duration-300">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.instagram.com" class="hover:text-gray-200 transition-colors duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.linkedin.com" class="hover:text-gray-200 transition-colors duration-300">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
        <p class="text-sm">&copy; 2024 Healing Studio. All rights reserved.</p>
        <p class="text-sm">
            <a href="#privacy-policy" class="hover:underline">Privacy Policy</a> | 
            <a href="#terms-of-service" class="hover:underline">Terms of Service</a>
        </p>
    </div>
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


        // Toggle the mobile menu
        document.getElementById('nav-toggle').onclick = function() {
            document.getElementById('nav-content').classList.toggle('hidden');
        };
    </script>
 
</body>

</html>