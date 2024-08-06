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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $car_id = $_POST['car_id'];
    $ic = $_POST['ic'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO proposals (user_id, car_id, ic, address, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'Pending', NOW(), NOW())");
    $stmt->bind_param("iiss", $user_id, $car_id, $ic, $address);

    if ($stmt->execute()) {
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO payments (car_id, payment_status) VALUES (?, 'Not Paid') ON DUPLICATE KEY UPDATE payment_status = 'Not Paid'");
        $stmt->bind_param("i", $car_id);

        if ($stmt->execute()) {
            $stmt->close();

            header("Location: proposal.php");
            exit();
        } else {
            echo "Error updating payment status: " . $stmt->error;
        }
    } else {
        echo "Error creating proposal: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
