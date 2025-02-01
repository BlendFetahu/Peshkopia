<?php
include('db.php'); // Lidhja me bazën e të dhënave

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Kontrollo nëse fushat janë të mbushura
    if (empty($email) || empty($password)) {
        echo "<script>alert('Ju lutem plotësoni të gjitha fushat!'); window.location.href='login.php';</script>";
        exit();
    }

    // Kontrollo nëse emaili ekziston
    $sql = "SELECT id, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password, $role);
        $stmt->fetch();

        // Kontrollo nëse fjalëkalimi është i saktë (pa hash)
        if ($password == $stored_password) {
            // Ky përdorues ka hyrë me sukses
            session_start();
            $_SESSION['user_id'] = $user_id;  // Ruaj ID-në e përdoruesit në sesion

            // Kontrollo rolin dhe dërgo përdoruesin në faqen përkatëse
            if ($role == 'admin') {
                echo "<script>alert('Jeni kyçur si admin!'); window.location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('Jeni kyçur me sukses!'); window.location.href='/peshkopia/html/reservation.html';</script>";
            }
        } else {
            echo "<script>alert('Fjalëkalimi i gabuar!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Ky email nuk është i regjistruar!'); window.location.href='login.php';</script>";
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
    <title>Log In | Peshkopia</title>
    <link rel="stylesheet" href="../css/login.css">
    <script defer src="/js/script.js"></script>
</head>
<body>
    
    <div class="container">
       
        <form class="log-in" method="POST" id="form" >

           <h2>Log In</h2>

           <div class="input">
            <label for="name"><b>Email:</b></label>
            <input type="email" id="email" name="email" placeholder="Shënoni Adresën tuaj" required>
           </div>

           <div class="input">
            <label for="password"><b>Password:</b></label>
            <input type="password" id="password" name="password" placeholder="Shënoni Fjalëkalimin">
           </div>

           <button type="submit">Kyçu</button>

           <div class="options">
            <p>Nuk keni llogari ? <a href="/peshkopia/php/register.php">Krijo llogarinë</a></p>
           </div>

        </form>

    </div>
</body>
</html>