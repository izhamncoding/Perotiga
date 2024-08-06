<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "pdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$payment_id = $_GET['payment_id'] ?? null;
$car_id = $_GET['car_id'] ?? null;
$brand = $_GET['brand'] ?? null;
$model = $_GET['model'] ?? null;

$sql_car = "SELECT * FROM cars WHERE id = ?";
$stmt_car = $conn->prepare($sql_car);
$stmt_car->bind_param("i", $car_id);
$stmt_car->execute();
$result_car = $stmt_car->get_result();

if ($result_car->num_rows > 0) {
    $car = $result_car->fetch_assoc();
} else {
    $car = null;
}

$stmt_car->close();

$total_cost = 0;
$rental_days = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rental_days'])) {
    $rental_days = $_POST['rental_days'];
    if ($car) {
        $car_price_per_day = $car['price_per_day'];
        $total_cost = $rental_days * $car_price_per_day;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Rental Payment</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
</head>

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

    <div class="container-fluid" style="padding:0;">
        <section class="page-section bg-light" id="payment">
            <div class="container">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Rental Payment</h2>
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10 col-sm-12">
                        <div class="card my-4">
                            <h5 class="card-header bg-primary text-white">
                                <?php echo htmlspecialchars($brand . " " . $model); ?>
                            </h5>
                            <div class="card-body">
                                <form method="post"
                                    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?payment_id=" . urlencode($payment_id) . "&car_id=" . urlencode($car_id) . "&brand=" . urlencode($brand) . "&model=" . urlencode($model); ?>">
                                    <div class="mb-3">
                                        <label for="rental_days" class="form-label">Rental Days</label>
                                        <input type="number" class="form-control" id="rental_days" name="rental_days"
                                            value="<?php echo htmlspecialchars($rental_days); ?>" required>
                                    </div>
                                    <?php if ($car): ?>
                                        <div class="mb-3">
                                            <label class="form-label">Car Details</label>
                                            <p><strong>Brand:</strong> <?php echo htmlspecialchars($car['brand']); ?></p>
                                            <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                                            <p><strong>Price per Day:</strong>
                                                RM<?php echo htmlspecialchars($car['price_per_day']); ?></p>
                                            <p><strong>Total Cost:</strong> RM<?php echo htmlspecialchars($total_cost); ?>
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-danger">Car details not found.</p>
                                    <?php endif; ?>
                                    <p style="margin-bottom: 0px;">**Please note that payment is required in person at our office.</p>
                                    <p>**Click here to see the <a href="about.php">address</a></p>
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-md-6 text-center">
                                                <button class="btn btn-primary mr-md-2 mb-3 mb-md-0">Calculate Total Cost</button>
                                                <a href="proposal.php" class="btn btn-secondary">Back to Proposal Page</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>