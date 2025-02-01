<?php
// Lidhja me databazën
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Merr të dhënat nga forma
    $emri = $_POST['emri'];
    $data = $_POST['data'];
    $ora = $_POST['ora'];
    $numri_personave = $_POST['numri_personave'];
    $statusi = $_POST['statusi'];

    // Krijo komandën SQL për të shtuar rezervimin
    $sql = "INSERT INTO rezervime (emri, data, ora, numri_personave, statusi) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $emri, $data, $ora, $numri_personave, $statusi);

    // Ekzekuto komandën dhe verifiko nëse është kryer me sukses
    if ($stmt->execute()) {
        echo "<script>alert('Rezervimi u krijua me sukses!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gabim gjatë krijimit të rezervimit!');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krijo Rezervim</title>
    <link rel="stylesheet" href="../css/insert_reservationstyle.css"> 
</head>
<body>
    <div class="container">
        <h2>Krijo Rezervim</h2>
        <form method="POST" action="">
            <label for="emri">Emri:</label>
            <input type="text" name="emri" required><br>

            <label for="data">Data:</label>
            <input type="date" name="data" required><br>

            <label for="ora">Ora:</label>
            <input type="time" name="ora" required><br>

            <label for="numri_personave">Numri i personave:</label>
            <input type="number" name="numri_personave" required><br>

            <label for="statusi">Statusi:</label>
            <input type="text" name="statusi" required><br>

            <button type="submit">Shto Rezervim</button>
        </form>
    </div>
</body>
</html>
