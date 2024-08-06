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

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: proposal.php");
    exit();
}

$proposal_id = intval($_GET['id']);

$sql = "SELECT p.id, u.username AS user_name, c.brand, c.model, p.status, p.created_at, p.updated_at, MAX(pay.payment_status) AS payment_status, MAX(pay.id) AS payment_id
        FROM proposals p
        INNER JOIN users u ON p.user_id = u.id
        INNER JOIN cars c ON p.car_id = c.id
        LEFT JOIN payments pay ON p.car_id = pay.car_id
        WHERE p.id = $proposal_id
        GROUP BY p.id";

$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $proposal = $result->fetch_assoc();
} else {
    header("Location: proposal.php");
    exit();
}

$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;

if (!is_numeric($user_role) || ($user_role != 2 && $user_role != 3)) {
    header("Location: proposal.php");
    exit();
}

$status_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_status = '';
    if (isset($_POST['approve'])) {
        $new_status = 'Approved';
        updateProposalStatus($conn, $proposal_id, $new_status, 'Paid');
        header("Location: proposal.php?message=Proposal approved successfully");
        exit();
    } elseif (isset($_POST['reject'])) {
        $new_status = 'Rejected';
        updateProposalStatus($conn, $proposal_id, $new_status, 'Not Paid');
        header("Location: proposal.php?message=Proposal rejected successfully");
        exit();
    } elseif (isset($_POST['delete'])) {
        $delete_sql = "DELETE FROM proposals WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        if ($stmt) {
            $stmt->bind_param("i", $proposal_id);
            if ($stmt->execute()) {
                header("Location: proposal.php?message=Proposal deleted successfully");
                exit();
            } else {
                $status_message = "Error deleting proposal: (" . $stmt->errno . ") " . $stmt->error;
            }
        } else {
            $status_message = "Error preparing statement: (" . $conn->errno . ") " . $conn->error;
        }
    }
}

function updateProposalStatus($conn, $proposal_id, $new_status, $payment_status)
{
    global $status_message;

    $conn->begin_transaction();
    try {
        $update_status_sql = "UPDATE proposals SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($update_status_sql);
        if ($stmt) {
            $stmt->bind_param("si", $new_status, $proposal_id);
            if (!$stmt->execute()) {
                throw new Exception("Error updating proposal status: (" . $stmt->errno . ") " . $stmt->error);
            }
        } else {
            throw new Exception("Error preparing proposal statement: (" . $conn->errno . ") " . $conn->error);
        }

        $update_payment_sql = "UPDATE payments SET payment_status = ? WHERE car_id = (SELECT car_id FROM proposals WHERE id = ?) AND id = (SELECT MAX(id) FROM payments WHERE car_id = (SELECT car_id FROM proposals WHERE id = ?))";
        $stmt = $conn->prepare($update_payment_sql);
        if ($stmt) {
            $stmt->bind_param("sii", $payment_status, $proposal_id, $proposal_id);
            if (!$stmt->execute()) {
                throw new Exception("Error updating payment status: (" . $stmt->errno . ") " . $stmt->error);
            }
        } else {
            throw new Exception("Error preparing payment statement: (" . $conn->errno . ") " . $conn->error);
        }

        $conn->commit();
        $status_message = "Proposal and payment status updated successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        $status_message = $e->getMessage();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Perotiga Sdn. Bhd - Edit Proposal</title>
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

    #editProposal {
        min-height: 100vh;
        padding: 11.1rem 0;
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

    <div class="container-fluid" style="padding:0;">
        <section class="page-section bg-light" id="editProposal" style="padding: 11.1rem">
            <div class="container">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Edit Proposal</h2>
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                </div>
                <?php if (!empty($status_message)): ?>
                    <div class="alert alert-info text-center"><?php echo $status_message; ?></div>
                <?php endif; ?>
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%;">User</th>
                                    <td><?php echo htmlspecialchars($proposal['user_name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Car</th>
                                    <td><?php echo htmlspecialchars($proposal['brand'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($proposal['model'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Date</th>
                                    <td><?php echo htmlspecialchars($proposal['created_at'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td><?php echo htmlspecialchars($proposal['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Payment Status</th>
                                    <td><?php echo htmlspecialchars($proposal['payment_status'], ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if ($user_role == 2 || $user_role == 3): ?>
                            <form method="post">
                                <input type="submit" name="approve" class="btn btn-success mr-2" value="Approve">
                                <input type="submit" name="reject" class="btn btn-danger mr-2" value="Reject">
                                <input type="submit" name="delete" class="btn btn-danger" value="Delete Proposal"
                                    onclick="return confirm('Are you sure you want to delete this proposal?');">
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
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