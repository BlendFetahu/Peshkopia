<?php
include('db.php'); // Lidhja me bazën e të dhënave

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Kontrollo nëse fushat janë të mbushura
    if (empty($email) || empty($password)) {
        echo "<script>alert('Ju lutem plotësoni të gjitha fushat!'); window.location.href='validate_signup.php';</script>";
        exit();
    }

    // Kontrollo nëse emaili ekziston tashmë
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Ky email është i regjistruar!'); window.location.href='../html/reservation.html';</script>";
        exit();
    }

    $stmt->close();

    // Regjistro përdoruesin pa hashing për fjalëkalimin
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password); // Nuk përdorim password_hash

    if ($stmt->execute()) {
        echo "<script>alert('Regjistrimi u krye me sukses!'); window.location.href='../php/login.php';</script>";
    } else {
        echo "<script>alert('Gabim gjatë regjistrimit!'); window.location.href='../php/register.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up | Peshkopia</title>
    <link rel="stylesheet" href="../css/singup.css">
    <script defer src="../js/script1.js"></script>
</head>
<body>
    <div class="container">
        <!-- Connect form to validate_signup.php -->
        <form method="POST" class="signup" >
            <h2>Sign up</h2>

            <div class="input">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Shenoni Emailin tuaj" required>
            </div>
            
            <div class="input">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Shenoni Passwordin" required>
            </div>
            
            <div class="input">
                <label for="confirm">Confirm Password:</label>
                <input type="password" id="confirm" name="confirm_password" placeholder="Rishkruani Passwordin" required>
            </div>

            <div class="options">
                <p>Keni llogari ? <a href="/peshkopia/php/login.php">Kyçuni</a></p>
            </div>

            <button type="submit">Sign up</button>
        </form>
    </div>
</body>
</html>
