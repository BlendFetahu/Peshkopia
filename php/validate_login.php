<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color:red;'>Invalid email format.</p>";
    } elseif (empty($password)) {
        echo "<p style='color:red;'>Password cannot be empty.</p>";
    } else {
        echo "<p style='color:green;'>Login successful! (For now, no real check is done)</p>";
    }
}
?>
