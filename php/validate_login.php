<?php
session_start(); // Starto sesionin për të ruajtur të dhënat e përdoruesit
include('db.php'); // Përfshi skedarin për lidhjen me databazën

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Kontrollo nëse forma është dërguar me metodën POST
    $email = $_POST['username']; // Merr email-in nga forma (username tani është email)
    $password = $_POST['password']; // Merr fjalëkalimin nga forma

    // Kontrollo nëse fushat janë bosh
    if (empty($email) || empty($password)) {
        echo "Please fill in both fields!";
        exit(); // Ndalo ekzekutimin nëse ndonjë fushë është bosh
    }

    // Kërkimi i përdoruesit në databazë me email
    $query = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Nëse përdoruesi nuk ekziston në databazë
    if ($result->num_rows == 0) {
        echo "Invalid email or password!";
        exit();
    }

    $user = $result->fetch_assoc(); // Merr të dhënat e përdoruesit

    // Verifikimi i fjalëkalimit të hash-uar nga databaza
    if (!password_verify($password, $user['password'])) {
        echo "Invalid email or password!";
        exit();
    }

    // Ruajtja e të dhënave të përdoruesit në sesion
    $_SESSION['username'] = $email; // Ruaj emailin në sesion
    $_SESSION['logged_in'] = true; // Shëno përdoruesin si të kyçur
    $_SESSION['role'] = $user['role']; // Ruaj rolin e përdoruesit

    // Redirektimi në bazë të rolit
    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard.php"); // Nëse është admin, ridrejto te dashboardi i adminit
    } else {
        header("Location: index.html"); // Nëse është përdorues i thjeshtë, ridrejto te index.html
    }
    exit(); // Ndalo ekzekutimin pas redirektimit

    // Ruajtja e cookies nëse është selektuar "Remember Me"
    if (isset($_POST['remember_me'])) {
        setcookie('username', $email, time() + (86400 * 30), "/"); // Ruaj email-in për 30 ditë
        setcookie('logged_in', 'true', time() + (86400 * 30), "/"); // Ruaj statusin e kyçjes për 30 ditë
    }
}
?>
