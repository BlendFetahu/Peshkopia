<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>Invalid email format.</p>";
    } elseif (strlen($password) < 6) {
        echo "<p style='color:red;'>Password must be at least 6 characters long.</p>";
    } elseif ($password !== $confirm_password) {
        echo "<p style='color:red;'>Passwords do not match.</p>";
    } else {
        echo "<p style='color:green;'>Signup successful! (For now, no real database check)</p>";
    }
}
?>

