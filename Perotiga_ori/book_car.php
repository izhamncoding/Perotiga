<?php
session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: carlist.php");
    exit();
}

$car_id = $_GET['id'];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, brand, model FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $car = $result->fetch_assoc();
} else {
    echo "Car not found";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Car - Perotiga Sdn. Bhd</title>
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

    .navbar-nav .nav-link {
        color: #2E8B57;
    }

    .navbar-nav .nav-link:hover {
        color: #ffffff !important;
        background-color: transparent !important;
        outline: 2px solid #ffffff;
    }

    #bookcar {
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
                                href="login.php">Login</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-section bg-light text-dark mt-2" id="bookcar">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 class="text-center mb-4">Book <?php echo $car['brand'] . " " . $car['model']; ?></h2>
                    <form action="submit_proposal.php" method="post">
                        <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                        <div class="form-group mb-3">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ic">IC Number:</label>
                            <input type="text" class="form-control" id="ic" name="ic" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="address">Address:</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit Proposal</button>
                    </form>
                </div>
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