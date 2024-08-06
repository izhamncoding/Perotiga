<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$brand = $_POST['brand'];
$model = $_POST['model'];
$car_age = $_POST['car_age'];
$availability = $_POST['availability'];
$transmission = $_POST['transmission'];
$fuel_type = $_POST['fuel_type'];
$price = $_POST['price'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["car_image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["car_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }
}

if ($_FILES["car_image"]["size"] > 500000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}

if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
} else {
    if (move_uploaded_file($_FILES["car_image"]["tmp_name"], $target_file)) {
        $sql = $conn->prepare("INSERT INTO cars (brand, model, car_age, availability, transmission, fuel_type, price_per_day, car_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if (!$sql->bind_param("ssisssds", $brand, $model, $car_age, $availability, $transmission, $fuel_type, $price, $target_file)) {
            echo "Binding parameters failed: (" . $sql->errno . ") " . $sql->error . "<br>";
        }

        if (!$sql->execute()) {
            echo "Execute failed: (" . $sql->errno . ") " . $sql->error . "<br>";
        } else {
            echo "New car record created successfully.<br>";

            $last_id = $conn->insert_id;
            $result = $conn->query("SELECT * FROM cars WHERE id = $last_id");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "ID: " . $row["id"] . " - Brand: " . $row["brand"] . " - Model: " . $row["model"] . " - Car Age: " . $row["car_age"] . " - Availability: " . $row["availability"] . " - Transmission: " . $row["transmission"] . " - Fuel Type: " . $row["fuel_type"] . " - Price: " . $row["price_per_day"] . " - Image Path: " . $row["car_image_path"] . "<br>";
                }
            } else {
                echo "No results found.<br>";
            }

            header("Location: carlist.php");
            exit();
        }
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}

$conn->close();
?>