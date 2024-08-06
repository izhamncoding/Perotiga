<?php
session_start();
?>
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
    <style>.navbar {
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

    .card-text{
        margin-bottom: 5px;
    }
    .card-img-top {
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

    .page-section {
            background-color: #f8f9fa;
            min-height: 100vh;
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



    <section class="page-section bg-light text-dark mb-0" style="padding-bottom: 8.5rem;" id="carlist">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Car List</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <?php
                        if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3)) {
                            echo '<div class="col-md-12 text-md-right">
                                <a href="uploadcar.php" class="btn btn-primary btn-lg">Add Car</a>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "pdb";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, brand, model, car_age, price_per_day, availability, car_image_path FROM cars";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img class="card-img-top" src="<?php echo $row['car_image_path']; ?>" alt="Car Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['brand'] . " " . $row['model']; ?></h5>
                                    <p class="card-text">Car Age: <?php echo $row['car_age']; ?> years</p>
                                    <p class="card-text">Availability:
                                        <?php echo ($row['availability'] == 1) ? 'Available' : 'Not Available'; ?>
                                    </p>
                                    <p class="card-text">Price: RM<?php echo $row['price_per_day']; ?>/day</p>
                                    <a href="car_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View
                                        Details</a>

                                    <?php
                                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) {
                                        echo '<a href="book_car.php?id=' . $row['id'] . '" class="btn btn-success">Book</a>';
                                    }

                                    if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3)) {
                                        echo '<a href="edit_car.php?id=' . $row['id'] . '" class="btn btn-warning mr-1">Edit</a>';
                                        echo '<a href="delete_car.php?id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this car?\')">Delete</a>'; // Added mr-2 class here
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "0 results";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>

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