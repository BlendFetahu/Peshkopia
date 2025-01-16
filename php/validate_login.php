<?php
session_start(); // Starto sesionin

include('db.php'); // Lidhja me databazën

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kontrollimi i fushave bosh
    if (empty($username) || empty($password)) {
        echo "Please fill in both fields!";
        exit();
    }

    // Kërkimi i përdoruesit në databazë
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Invalid username or password!";
        exit();
    }

    $user = $result->fetch_assoc();

    // Verifikimi i fjalëkalimit
    if (!password_verify($password, $user['password'])) {
        echo "Invalid username or password!";
          exit();
    }

    // Ruajtja e sesionit
    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = true;

    // Ruajtja e cookies (nëse është selektuar 'Remember Me')
    if (isset($_POST['remember_me'])) {
        setcookie('username', $username, time() + (86400 * 30), "/"); // Cookie për 30 ditë
        setcookie('logged_in', 'true', time() + (86400 * 30), "/");
    }

    // Redirektimi pas kyçjes
    header("Location: index.html");
    exit();
}
?>