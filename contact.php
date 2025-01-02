<?php
$servername = "localhost";
$username = "root";  
$password = ""; 
$dbname = "laavaaprint";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
    $mobile_no = mysqli_real_escape_string($conn, $_POST['mobile-no']);
    $email_id = mysqli_real_escape_string($conn, $_POST['email-id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (empty($first_name) || empty($email_id) || empty($message)) {
        echo "<script>alert('Please fill in all the required fields.'); window.location.href = 'contact.html';</script>";
        exit;
    }

  
    $stmt = $conn->prepare("INSERT INTO msg (first_name, last_name, mobile_no, email_id, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $first_name, $last_name, $mobile_no, $email_id, $message);

  
    if ($stmt->execute()) {
       
        echo "<script>alert('Your message has been submitted successfully!'); window.location.href = 'contact.html';</script>";
    } else {
 
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
