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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $proposal_id = $_POST['proposal_id'];
    $payment_id = $_POST['payment_id'];
    $action = $_POST['action'];

    $payment_status = $action == 'approve' ? 'Paid' : 'Not Paid';

    $sql = "UPDATE payments SET payment_status = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $payment_status, $payment_id);

    if ($stmt->execute()) {
        header("Location: proposal.php?message=Payment status updated successfully");
        exit();
    } else {
        echo "Error updating payment status: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
