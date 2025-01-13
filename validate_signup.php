<?php
session_start(); // Fillon sesionin
include('db.php'); // Lidhja me databazën

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validimi bazik
    if (empty($username) || empty($password)) {
        echo "All fields are required!";
        exit();
    }

    // Kontrollo përdoruesin në databazë
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 0) {
        echo "Invalid username or password!";
        exit();
    }

    $user = $result->fetch_assoc();

    // Verifikimi i fjalëkalimit
    if ($password !== $user['password']) {
        echo "Invalid username or password!";
        exit();
    }

    // Ruaj në session
    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = true;

    // Nëse 'Remember Me' është selektuar, ruaj cookies
    if (isset($_POST['remember_me'])) {
        setcookie('username', $username, time() + (86400 * 30), "/"); // Cookie për 30 ditë
        setcookie('logged_in', 'true', time() + (86400 * 30), "/");
    }

    // Redirekto pas log-in
    header("Location: index.html"); // Ose çdo faqe tjetër që dëshiron
    exit();
}
?>
