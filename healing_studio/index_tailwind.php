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

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healing Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFFFFF;
        }

        .header, .footer {
            background-color: #77a047;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .main-color {
            color: #77a047;
        }

        .highlight-color {
            color: #7c287c;
        }

        .bg-main {
            background-color: #77a047;
        }

        .bg-highlight {
            background-color: #7c287c;
        }

        .card {
            background-color: white;
            border: 2px solid #77a047;
            border-radius: 10px;
            overflow: hidden;
        }

        .card img {
            border-bottom: 2px solid #77a047;
        }

        .card h5 {
            color: #7c287c;
        }

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body>

    <nav class="bg-main p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-white text-lg font-bold">Healing Studio</a>
            <ul class="flex space-x-4 text-white">
                <li><a href="#about" class="hover:text-gray-300">About</a></li>
                <li><a href="#services" class="hover:text-gray-300">Services</a></li>
                <li><a href="#programs" class="hover:text-gray-300">Upcoming Programs</a></li>
                <li><a href="#about_us" class="hover:text-gray-300">About Us</a></li>
                <li><a href="#testimonials" class="hover:text-gray-300">Testimonials</a></li>
                <li><a href="#resources" class="hover:text-gray-300">Resources</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mx-auto py-10">

        <section id="about" class="mb-10">
            <div class="flex flex-col md:flex-row items-center">
                <img src="ibrahim.jpeg" alt="About Image" class="md:w-1/2 h-auto mb-4 md:mb-0">
                <div class="md:ml-6">
                    <h3 class="text-3xl font-semibold mb-4 main-color">About Healing Studio</h3>
                    <p class="text-lg">Healing Studio™ is a venture to support people to overcome their life struggles. It is
                        to help every adult to live a good, happy, and peaceful life. It is a safe place where you
                        can share your life freely without fear and where every word is protected as secret.
                        In the long journey of life, it's understandable to get emotionally hurt, get your heart
                        wounded, or create a feeling of guilt and sadness. These burdens make life a
                        troublesome, sad, and uninspiring journey. However, you need not live with these
                        burdens. Because you deserve a good, happy, and peaceful life.</p>
                </div>
            </div>
        </section>

        <section id="services" class="mb-10">
            <h3 class="text-3xl font-semibold mb-4 main-color">What We Do</h3>
            <p class="text-lg">Details about the services provided by the studio.</p>
        </section>

        <section id="programs" class="mb-10">
            <h3 class="text-3xl font-semibold mb-4 main-color">Sessions</h3>
            <div class="grid grid-cols-1 gap-9">
                <?php foreach ($courses as $course) : ?>
                    <div class="card flex shadow-lg">
                        <img src="<?php echo $course["image"]; ?>" class="w-1/3 object-cover">
                        <div class="p-4 w-2/3 flex flex-col justify-between">
                            <div>
                                <h5 class="text-xl font-bold text-center mb-2"><?php echo $course["name"]; ?></h5>
                                <p class="text-gray-700 mb-4"><?php echo $course["description"]; ?></p>
                            </div>
                            <div class="text-center">
                                <?php if ($course["free"] == 1) : ?>
                                    <a href="#" class="highlight-color" onclick="generateWhatsappLink()">Click to join WhatsApp community</a>
                                <?php else : ?>
                                    <a href="#modal2" class="highlight-color modal-trigger">Register now</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="contact" class="mb-10">
            <div class="max-w-md mx-auto">
                <h3 class="text-3xl font-semibold mb-4 main-color">Contact Us</h3>
                <form class="bg-white p-6 rounded-lg shadow-lg border-2 border-main">
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
                    <button type="submit" class="w-full bg-highlight text-white p-2 rounded-lg">Submit</button>
                </form>
            </div>
        </section>

        <section id="testimonials" class="mb-10">
            <h3 class="text-3xl font-semibold mb-4 main-color">Testimonials</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-main text-white p-4 rounded-lg">Testimonial 1</div>
                <div class="bg-main text-white p-4 rounded-lg">Testimonial 2</div>
                <div class="bg-main text-white p-4 rounded-lg">Testimonial 3</div>
                <div class="bg-main text-white p-4 rounded-lg">Testimonial 4</div>
                <div class="bg-main text-white p-4 rounded-lg">Testimonial 5</div>
                <div class="bg-main text-white p-4 rounded-lg">Testimonial 6</div>
            </div>
        </section>

    </div>

    <div id="modal2" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
            <h5 class="text-2xl font-semibold mb-6">Please help us reach out to you</h5>
            <form action="create_leads_healing.php" method="post" target="dummyframe">
                <div class="mb-4">
                    <label for="first_name_modal" class="block text-gray-700">First Name</label>
                    <input type="text" id="first_name_modal" name="first_name" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="last_name_modal" class="block text-gray-700">Last Name</label>
                    <input type="text" id="last_name_modal" name="last_name" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="phone_number_modal" class="block text-gray-700">Phone Number</label>
                    <input type="tel" id="phone_number_modal" name="phone_number" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mb-4">
                    <label for="program_modal" class="block text-gray-700">Select Program</label>
                    <select id="program_modal" name="program" class="w-full p-2 border border-gray-300 rounded-lg">
                    <?php foreach ($courses as $course) : ?>
                                <?php if ($course["free"] == 0) : ?>
                                    <option value="<?php echo $course["name"]; ?>"><?php echo $course["name"]; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="w-full bg-purple-700 text-white p-2 rounded-lg">Submit</button>
            </form>
        </div>
    </div>

    <footer class="bg-green-700 text-white p-4 text-center">
        <p>Healing Studio &copy; 2024</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".modal-trigger").click(function (e) {
                e.preventDefault();
                $("#modal2").removeClass("hidden").addClass("flex");
            });

            $(document).on("click", function (e) {
                if ($(e.target).closest("#modal2 .p-6").length === 0 && $(e.target).closest(".modal-trigger").length === 0) {
                    $("#modal2").removeClass("flex").addClass("hidden");
                }
            });

            $("form").submit(function (event) {
                event.preventDefault();

                var formData = $(this).serialize();
                var modalInstance = $("#modal2");

                $.ajax({
                    type: 'POST',
                    url: 'create_leads.php',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        modalInstance.removeClass("flex").addClass("hidden");
                        alert('Thank you for your submission!');
                    },
                    error: function (error) {
                        console.error(error);
                        alert('Form submission failed. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>
