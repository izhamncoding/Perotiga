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

if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3)) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $proposal_id = $_GET['id'];

        $sql = "DELETE FROM proposals WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $proposal_id);

        if ($stmt->execute()) {
            header("Location: proposal.php");
            exit();
        } else {
            echo "Error deleting proposal: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Invalid proposal id";
    }
} else {
    echo "Unauthorized access";
}

$conn->close();
?>
