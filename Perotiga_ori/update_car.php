<?php
session_start();
include_once 'db_connection.php';

if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: index.php");
    exit();
}

$id = isset($_POST['id']) ? $_POST['id'] : '';
$brand = isset($_POST['brand']) ? $_POST['brand'] : '';
$model = isset($_POST['model']) ? $_POST['model'] : '';
$car_age = isset($_POST['car_age']) ? $_POST['car_age'] : '';
$availability = isset($_POST['availability']) ? $_POST['availability'] : 0; 
$price_per_day = isset($_POST['price_per_day']) ? $_POST['price_per_day'] : '';
$transmission = isset($_POST['transmission']) ? $_POST['transmission'] : '';
$fuel_type = isset($_POST['fuel_type']) ? $_POST['fuel_type'] : '';

$car_image_path = '';
if ($_FILES["car_image"]["size"] > 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["car_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["car_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    if ($_FILES["car_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && move_uploaded_file($_FILES["car_image"]["tmp_name"], $target_file)) {
        $car_image_path = $target_file;
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}

if (!empty($car_image_path)) {
    $sql = $conn->prepare("UPDATE cars SET brand = ?, model = ?, car_age = ?, availability = ?, price_per_day = ?, transmission = ?, fuel_type = ?, car_image_path = ? WHERE id = ?");
    $sql->bind_param("ssisdsssi", $brand, $model, $car_age, $availability, $price_per_day, $transmission, $fuel_type, $car_image_path, $id);
} else {
    $sql = $conn->prepare("UPDATE cars SET brand = ?, model = ?, car_age = ?, availability = ?, price_per_day = ?, transmission = ?, fuel_type = ? WHERE id = ?");
    $sql->bind_param("ssisdssi", $brand, $model, $car_age, $availability, $price_per_day, $transmission, $fuel_type, $id);
}

if (!$sql->execute()) {
    echo "Execute failed: (" . $sql->errno . ") " . $sql->error . "<br>";
} else {
    echo "Car details updated successfully.<br>";
    header("Location: carlist.php");
    exit();
}

$conn->close();
?>