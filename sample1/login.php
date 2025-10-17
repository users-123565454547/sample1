<?php
session_start();
include 'connection/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['first_name'];
            header("Location: dashboard.php"); // create later
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='register.html';</script>";
        }
    } else {
        echo "<script>alert('Email not found!'); window.location.href='register.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
