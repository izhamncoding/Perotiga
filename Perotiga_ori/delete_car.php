<?php
session_start();

if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $car_id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);

    if ($stmt->execute()) {
        header("Location: carlist.php");
        exit();
    } else {
        $delete_error = "Error deleting car: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $delete_error = "Invalid request.";
}

if (isset($delete_error)) {
    $_SESSION['delete_error'] = $delete_error;
    header("Location: carlist.php");
    exit();
}
?>