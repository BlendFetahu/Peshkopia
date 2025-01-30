
<?php
include('db.php');

// Fshirja e rezervimeve
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_reservation_id'])) {
    $id = $_POST['delete_reservation_id'];
    $sql = "DELETE FROM rezervime WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Rezervimi u fshi me sukses!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gabim gjatë fshirjes!');</script>";
    }

    $stmt->close();
}

// Fshirja e mesazheve të kontaktit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_contact_id'])) {
    $id = $_POST['delete_contact_id'];
    $sql = "DELETE FROM kontaktet WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Mesazhi u fshi me sukses!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gabim gjatë fshirjes!');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="../css/dashboardstyle.css">
</head>
<body>
    <div class="container">
        <h1>Menaxhimi i Rezervimeve</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Emri</th>
                    <th>Data</th>
                    <th>Ora</th>
                    <th>Nr. Personave</th>
                    <th>Statusi</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM rezervime";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['emri']}</td>
                            <td>{$row['data']}</td>
                            <td>{$row['ora']}</td>
                            <td>{$row['numri_personave']}</td>
                            <td>{$row['statusi']}</td>
                            <td>
                                <a href='create_reservation.php?id={$row['id']}' class='btn-edit'>Ndrysho</a>

                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='delete_reservation_id' value='{$row['id']}'>
                                    <button type='submit' class='btn-delete' onclick='return confirm(\"A je i sigurt që dëshiron ta fshish këtë rezervim?\");'>Fshij</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nuk ka të dhëna.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h1>Mesazhet e Kontaktit</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Emri</th>
                    <th>Email</th>
                    <th>Mesazhi</th>
                    <th>Data</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM kontaktet";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['emri']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['mesazhi']}</td>
                            <td>{$row['data']}</td>
                            <td>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='delete_contact_id' value='{$row['id']}'>
                                    <button type='submit' class='btn-delete' onclick='return confirm(\"A je i sigurt që dëshiron ta fshish këtë mesazh?\");'>Fshij</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nuk ka të dhëna.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
