<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perotiga</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
</head>
<style>
    .navbar {
        box-shadow: 1px 1px 5px -1px #000;
    }

    .bg-green {
        background-color:  rgb(32,188,156);
    }

    .carousel-item img {
        width: 1080px;
        height: 728px;
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

    <nav class="navbar navbar-expand-lg bg-green text-uppercase fixed-top" id="mainNav"
        style="padding: 0.5rem !important;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Perotiga</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-green text-white rounded" type="button"
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

    <section>
        <div id="carouselExampleControls1" class="carousel slide mt-1" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="assets/img/portfolio/carousel1.png" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/img/portfolio/carousel2.png" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/img/portfolio/carousel3.jpeg" alt="Third slide">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section>
        <header class="masthead bg-green text-white text-center" id="home">
            <div class="container d-flex align-items-center flex-column">
                <h1 class="masthead-heading text-uppercase mb-0">WELCOME TO PEROTIGA</h1>
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                </div>
                <p class="masthead-subheading font-weight-light mb-5">YOUR NUMBER ONE CHOICE OF CAR RENTAL</p>
            </div>
        </header>
    </section>

    <section class="page-section portfolio">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Signature Rental Cars</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal1">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/myvi2.jpg" alt="..." />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal2">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/X70.png" alt="..." />
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal3">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/X50.jpg" alt="..." />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-green text-white mb-0 mt-2 pb-0" id="about">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-white">About</h2>
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="lead">Perotiga Rental System, where convenience meets reliability in the world of car
                        rentals. Our platform is designed to simplify the process of renting a car, offering a diverse
                        range of vehicles to suit every need. Whether you're planning a weekend getaway or a business
                        trip, our user-friendly interface and dedicated team ensure a seamless experience from start to
                        finish. Discover more about our commitment to quality service and customer satisfaction below.
                    </p>
                </div>
            </div>
            <div class="text-center mt-4 mb-5">
                <a class="btn btn-xl btn-outline-light" href="about.php">
                    Click for more!
                </a>
            </div>
        </div>
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright &copy; Perotiga 2024</small></div>
        </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>