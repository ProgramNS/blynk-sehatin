<?php
session_start();

// Replace with your actual username and password
$valid_username = 'sehatin';
$valid_password = 'sehatin123';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        // Set session variable or any other login logic
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Redirect to monitoring page
        header("Location: monitoring.php");
        exit();
    } else {
        // Login failed
        echo "Invalid username or password.";
    }
}