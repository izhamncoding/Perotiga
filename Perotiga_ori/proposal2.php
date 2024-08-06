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

$proposals = [];

if (isset($_SESSION['user_role'])) {
    $user_role = $_SESSION['user_role'];

    if ($user_role == 1) {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT p.id, u.username AS user_name, c.brand, c.model, p.status, p.created_at, p.updated_at, MAX(pay.payment_status) AS payment_status, MAX(pay.id) AS payment_id, p.car_id
            FROM proposals p
            INNER JOIN users u ON p.user_id = u.id
            INNER JOIN cars c ON p.car_id = c.id
            LEFT JOIN payments pay ON p.car_id = pay.car_id
            WHERE p.user_id = ?
            GROUP BY p.id";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    } else if ($user_role == 2 || $user_role == 3) {
        $sql = "SELECT p.id, u.username AS user_name, c.brand, c.model, p.status, p.created_at, p.updated_at, MAX(pay.payment_status) AS payment_status, MAX(pay.id) AS payment_id, p.car_id
            FROM proposals p
            INNER JOIN users u ON p.user_id = u.id
            INNER JOIN cars c ON p.car_id = c.id
            LEFT JOIN payments pay ON p.car_id = pay.car_id
            GROUP BY p.id";

        $stmt = $conn->prepare($sql);
    }

    if ($stmt) {
        if ($user_role == 1) {
            $stmt->bind_param("i", $user_id);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $proposals[] = $row;
        }

        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
    }
}

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
    .navbar-nav .nav-link {
        color: #2E8B57;
    }

    .navbar-nav .nav-link:hover {
        color: #ffffff !important;
        background-color: transparent !important;
        outline: 2px solid #ffffff;
    }

    #proposal {
        min-height: calc(100vh - 56px);
        margin-top: 3.5rem;
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

    <div class="container-fluid" style="padding:0;">
        <section class="page-section bg-light" id="proposal" style="">
            <div class="container">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Proposal List</h2>
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                </div>
                <div class="row justify-content-center">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Car</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Payment</th>
                                    <th scope="col">Status</th>
                                    <?php if ($user_role == 2 || $user_role == 3): ?>
                                        <th scope="col">Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($proposals as $key => $proposal): ?>
                                    <tr>
                                        <th scope="row"><?php echo $key + 1; ?></th>
                                        <td><?php echo htmlspecialchars($proposal['user_name']); ?></td>
                                        <td><?php echo htmlspecialchars($proposal['brand'] . " " . $proposal['model']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($proposal['created_at']); ?></td>
                                        <td>
                                            <?php if ($user_role == 1 && isset($proposal['payment_status'])): ?>
                                                <a href="payment.php?payment_id=<?= $proposal['payment_id'] ?>&car_id=<?= $proposal['car_id']; ?>&brand=<?= urlencode($proposal['brand']); ?>&model=<?= urlencode($proposal['model']); ?>"
                                                    class="btn btn-primary">View Payment</a>
                                            <?php elseif ($user_role == 1): ?>
                                                <span class="text-muted">Payment not available</span>
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($proposal['payment_status'] ?? 'Not Paid'); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($proposal['status']); ?></td>
                                        <?php if ($user_role == 2 || $user_role == 3): ?>
                                            <td class="d-flex justify-content-center">
                                                <a style="margin-right: 7px;"
                                                    href="edit_proposal.php?id=<?php echo $proposal['id']; ?>"
                                                    class="btn btn-primary d-flex justify-content-start">Edit</a>
                                                <a href="delete_proposal.php?id=<?php echo $proposal['id']; ?>"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this proposal?')">Delete</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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