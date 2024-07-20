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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        .card-image img {
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

        .navbar {
            margin-bottom: 20px;
        }

        .heading {
            font-family: 'Lora', serif;
            font-weight: 600;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .session {
            padding: 20px;
        }

        .session div {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <nav>
        <div class="nav-wrapper light-green darken-3">
            <a href="#" class="brand-logo">Healing Studio</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#programs">Upcoming Programs</a></li>
                <li><a href="#about_us">About Us</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#resources">Resources</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <div class="section" id="about">
            <div class="row">
                <div class="col s12 m6">
                    <img src="ibrahim.jpeg" alt="About Image" class="responsive-img" style="width: auto; height: 80%;">
                </div>
                <div class="col s12 m6 ">
                    <h3>About Healing Studio</h3>
                    <p class="valign-wrapper">Healing Studio™ is a venture to support people to overcome their life struggles. It is
                        to help every adult to live a good, happy, and peaceful life. It is a safe place where you
                        can share your life freely without fear and where every word is protected as secret.
                        In the long journey of life, it's understandable to get emotionally hurt, get your heart
                        wounded, or create a feeling of guilt and sadness. These burdens make life a
                        troublesome, sad, and uninspiring journey. However, you need not live with these
                        burdens. Because you deserve a good, happy, and peaceful life</p>
                </div>
            </div>
        </div>

        <div class="section" id="services">
            <h3>What We Do</h3>
            <p>Details about the services provided by the studio.</p>
        </div>

        <div class="section" id="programs">
            <h3>Session</h3>
            <div class="row s12 m6">
                <?php foreach ($courses as $course) : ?>

                    <div class="col s12 m12 l12">
                        <div class="card horizontal">
                            <div class="card-image responsive-img">
                                <img src="<?php echo $course["image"]; ?>" style="width: 100%; height: auto;">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <h5 class="center-align"><?php echo $course["name"]; ?></h5>
                                    <p class="flow-text"><?php echo $course["description"]; ?></p>
                                </div>
                                <div class="card-action center-align">

                                    <?php if ($course["free"] == 1) : ?>
                                        <a href="#" class="purple-text" onclick="generateWhatsappLink()">
                                            Click to join WhatsApp community
                                        </a>
                                    <?php else : ?>
                                        <a class="purple-text modal-trigger" href="#modal2">
                                            Register now
                                        </a>

                                    <?php endif; ?>

                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>




        <div class="section session">
            <div class="row">


                <div class="col s12 m4">
                    <h3>Contact Us</h3>
                    <form>
                        <div class="input-field">
                            <input type="text" name="first_name" id="first_name">
                            <label for="first_name">First Name</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="last_name" id="last_name">
                            <label for="last_name">Last Name</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="phone_number" id="phone_number">
                            <label for="phone_number">Phone Number</label>
                        </div>
                        <div class="input-field">
                            <select name="program" id="program">
                                <?php foreach ($courses as $course) : ?>
                                    <?php if ($course["free"] == 0) : ?>
                                        <option value="<?php echo $course["name"]; ?>"><?php echo $course["name"]; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <label for="program">Select Program</label>
                        </div>
                        <button type="submit" class="btn purple">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="section" id="testimonials">
            <h3>Testimonials</h3>
            <div class="row">
                <div class="col s12 m6">
                    <div class="card-panel light-green darken-3 ">
                        <span>Testimonial 1</span>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card-panel light-green darken-3 ">
                        <span>Testimonial 2</span>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card-panel light-green darken-3 ">
                        <span>Testimonial 3</span>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card-panel light-green darken-3 ">
                        <span>Testimonial 4</span>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card-panel light-green darken-3 ">
                        <span>Testimonial 5</span>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card-panel light-green darken-3 ">
                        <span>Testimonial 6</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="modal2" class="modal center-align">
            <div class="modal-content">
                <h5>Please help us reach out to you</h5><br><br>

                <div class="row">
                    <form class="col s12" action="create_leads_healing.php" method="post" target="dummyframe">
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="first_name" required type="text" class="validate" name="first_name">
                                <label for="first_name">First Name</label>
                            </div>
                            <div class="input-field col s6">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="last_name" required type="text" class="validate" name="last_name">
                                <label for="last_name">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">phone</i>
                                <input id="phone_number" required type="tel" class="validate" name="phone_number">
                                <label for="phone_number">Phone Number</label>

                            </div>

                        </div>
                        <div class="row">

                            <div class="input-field">
                                <select name="program" id="program">
                                    <?php foreach ($courses as $course) : ?>
                                        <option value="<?php echo $course["name"]; ?>"><?php echo $course["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="program">Select Program</label>
                            </div>
                        </div>

                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col s12 center"><button type="submit" class="waves-effect waves-light btn purple white-text" onsubmit="closemodal()">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>Healing Studio &copy; 2024</p>
    </footer>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        });

        function openForm() {}
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.parallax');
            var instances = M.Parallax.init(elems);
        });
        $(document).ready(function() {
            $("#logo").attr("src", "images/Writemind academy Logo.png");
            $('.collapsible').collapsible();

            $('.modal-trigger').click(function() {
                console.log("here");
                var modalId = $(this).attr('href');
                var modalInstance = M.Modal.getInstance($(modalId));
                modalInstance.open({
                    preventScrolling: false
                });
            });

            $('.modal').modal();

            // Add a submit event listener to the form
            $('form').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                // Your form processing logic here, e.g., sending data to the server using AJAX
                var formData = $(this).serialize();
                var modalInstance = M.Modal.getInstance($(this).closest('.modal'));

                // Serialize form data
                $.ajax({
                    type: 'POST', // or 'GET' depending on your server-side logic
                    url: 'create_leads.php', // replace with your form processing URL
                    data: formData,
                    success: function(response) {
                        // Handle the server response if needed
                        console.log(response);

                        // Close the form submission modal
                        modalInstance.close();
                        // Open the "thank you" modal
                        var thankYouModalInstance = M.Modal.getInstance($('#thankYouModal'));
                        thankYouModalInstance.open();
                    },
                    error: function(error) {
                        // Handle the error if the form submission fails
                        console.error(error);
                        alert('Form submission failed. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>