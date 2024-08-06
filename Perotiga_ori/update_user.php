<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, address=? WHERE id=?");
    $stmt->bind_param("sssi", $username, $email, $address, $id);

    if ($stmt->execute()) {
        echo "User updated successfully";
        $stmt->close();
        header("Location: userlist.php");
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

$conn->close();
?>