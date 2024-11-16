<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "laavaaprint");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];

    $query = "INSERT INTO user (email, password) VALUES ('$email', '$password')";
    if ($conn->query($query) === TRUE) {
        header("Location: user.html");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
