<?php
include('db.php');
?>

<?php
// Kontrollo nëse ID është dhënë në URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Gabim: ID mungon ose është i pavlefshëm.");
}

$id = $_GET['id'];

// Merr të dhënat për këtë rezervim nga baza e të dhënave duke përdorur deklaratë të përgatitur
$stmt = $conn->prepare("SELECT * FROM rezervime WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$reservation = $result->fetch_assoc();

if (!$reservation) {
    die("Gabim: Rezervimi nuk u gjet.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Merr të dhënat e reja nga formulari
    $emri = $_POST['emri'];
    $data = $_POST['data'];
    $ora = $_POST['ora'];
    $numri_personave = $_POST['numri_personave'];
    $telefoni = $_POST['telefoni'];
    $statusi = $_POST['statusi'];

    // Validoni të dhënat (opsionale, por e rekomanduar)
    if (empty($emri) || empty($data) || empty($ora)) {
        die("Gabim: Ju lutemi plotësoni të gjitha fushat e kërkuara.");
    }

    // Update rezervimin në bazën e të dhënave duke përdorur deklaratë të përgatitur
    $update_stmt = $conn->prepare("UPDATE rezervime SET emri = ?, data = ?, ora = ?, numri_personave = ?, telefoni = ?, statusi = ? WHERE id = ?");
    $update_stmt->bind_param("sssissi", $emri, $data, $ora, $numri_personave, $telefoni, $statusi, $id);

    if ($update_stmt->execute()) {
        header("Location: ../dashboard/dashboard.php?update=success");
        exit();
    } else {
        echo "Gabim gjatë përditësimit: " . $update_stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Përditëso Rezervimin</title>
    <!-- Lidhja me stilin CSS -->
    <link rel="stylesheet" href="../css/create_reservationstyle.css">
</head>
<body>

    <div class="container">
        <h2>Përditëso Rezervimin</h2>
<form method="POST" action="">
    <label for="emri">Emri:</label>
    <input type="text" name="emri" value="<?php echo $reservation['emri']; ?>" required><br>

    <label for="data">Data:</label>
    <input type="date" name="data" value="<?php echo $reservation['data']; ?>" required><br>

    <label for="ora">Ora:</label>
    <input type="time" name="ora" value="<?php echo $reservation['ora']; ?>" required><br>

    <label for="numri_personave">Numri i personave:</label>
    <input type="number" name="numri_personave" value="<?php echo $reservation['numri_personave']; ?>" required><br>

    <label for="telefoni">Telefoni:</label>
    <input type="text" name="telefoni" value="<?php echo isset($reservation['telefoni']) ? $reservation['telefoni'] : ''; ?>"> <br>


    <label for="statusi">Statusi:</label>
    <select name="statusi">
        <option value="Ne Pritje" <?php if ($reservation['statusi'] == 'Ne Pritje') echo 'selected'; ?>>Ne Pritje</option>
        <option value="Konfirmuar" <?php if ($reservation['statusi'] == 'Konfirmuar') echo 'selected'; ?>>Konfirmuar</option>
        <option value="Anulluar" <?php if ($reservation['statusi'] == 'Anulluar') echo 'selected'; ?>>Anulluar</option>
    </select><br>

    <button type="submit">Përditëso</button>
</form>
