<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Individual Assignment 1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
</head>
<style>
    .navbar {
        box-shadow: 1px 1px 5px -1px #000;
    }

    .bg-green {
        background-color: #2E8B57;
    }

    .carousel-item img {
        width: 1080px;
        height: 700px;
        object-fit: cover;
    }

    .navbar-nav .nav-link {
        color: #2E8B57;
    }

    .navbar-nav .nav-link:hover {
        color: #ffffff !important;
        background-color: transparent !important;
        outline: 2px solid #ffffff;
    }
</style>

<body>

    <nav class="navbar navbar-expand-lg bg-primary text-uppercase fixed-top" id="mainNav"
        style="padding: 0.5rem !important;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#page-top">Perotiga</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <?php
                    if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
                        ?>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="index.php">Home</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="carlist.php">Car</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="proposal.php">Proposal</a></li>
                        <?php
                        if ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3) {
                            echo '<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="userlist.php">User List</a></li>';
                        }
                        ?>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="profile.php">Profile</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="about.php">About</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="logout.php">Logout</a></li>
                        <?php
                    } else {
                        ?>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="register.php">Register</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="login.php">Login</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-section bg-primary text-white mb-0 mt-2 pb-4" id="location">
            <div class="container">
                <h2 class="page-section-heading text-center text-uppercase text-white">Our Location</h2>
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.6603711960317!2d101.4669195!3d3.063013!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc5361bb8204cf%3A0xbb4ec2c716dea019!2sPerodua%20klang%20branch%20(miela)!5e0!3m2!1sen!2smy!4v1622389876817!5m2!1sen!2smy"
                            width="100%" height="400"  style="border: 2px solid #000000" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-4">
                            <h3 class="text-uppercase mb-4">Address</h3>
                            <p>No 37A 1st Floor, Jalan Tiara 2a/Ku1, Bandar Baru Klang, 41150 Klang, Selangor</p>
                            <p>Our office is located above Perodua Store in Bandar Baru Klang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <section class="page-section bg-light text-white mb-0 mt-2 pb-0" id="about">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary">About</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="lead text-dark">Perotiga Rental System, where convenience meets reliability in the world of car
                        rentals. Our platform is designed to simplify the process of renting a car, offering a diverse
                        range of vehicles to suit every need. Whether you're planning a weekend getaway or a business
                        trip, our user-friendly interface and dedicated team ensure a seamless experience from start to
                        finish. Discover more about our commitment to quality service and customer satisfaction below.
                    </p>
                </div>
            </div>
        </div>

        <section class="page-section portfolio bg-primary">
            <div class="container">
                <h2 class="page-section-heading text-center text-uppercase text-light mb-0">Services</h2>
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <p class="lead">We are focuses on giving our customer the best rental service website
                            possible mainly focusing on local car brands with a mixture of imported cars.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright &copy; Perotiga 2024</small></div>
        </div>

        <script src="js/bootstrap.bundle.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>
    </section>
</body>

</html>