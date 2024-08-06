<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perotiga Sdn. Bhd</title>
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

    .card-img-fixed {
        width: 100%;
        height: 200px;
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
                            href="profile.php">Profile</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                                href="login.php">Login</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 6rem;">
        <h2>Upload Car Information</h2>
        <form action="process_upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="form-group">
                <label for="model">Model:</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="form-group">
                <label for="car_age">Car Age:</label>
                <input type="number" class="form-control" id="car_age" name="car_age" required>
            </div>
            <div class="form-group">
                <label for="transmission">Transmission:</label>
                <select class="form-control" id="transmission" name="transmission" required>
                    <option value="Automatic">Automatic</option>
                    <option value="Manual">Manual</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fuel_type">Fuel Type:</label>
                <select class="form-control" id="fuel_type" name="fuel_type" required>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                    <option value="Hybrid">Hybrid</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price per Day (RM):</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="availability">Availability:</label>
                <select class="form-control" id="availability" name="availability" required>
                    <option value="1">Available</option>
                    <option value="0">Not Available</option>
                </select>
            </div>
            <div class="form-group">
                <label for="car_image">Car Image:</label>
                <input type="file" class="form-control-file" id="car_image" name="car_image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Upload Car</button>
        </form>
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
</body>

</html>