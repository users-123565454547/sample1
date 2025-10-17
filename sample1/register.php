<?php
include 'connection/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists!'); window.location.href='register.html';</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please log in.'); window.location.href='register.html';</script>";
        } else {
            echo "<script>alert('Registration failed.'); window.location.href='register.html';</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
