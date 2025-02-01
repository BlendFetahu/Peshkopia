
<?php
include('db.php');


// Kontrollojmë për dërgimin e formularit të kontaktit
if (isset($_POST['submit_message'])) {
    $emri = $_POST['emri'];
    $email = $_POST['email'];
    $mesazhi = $_POST['mesazhi'];

    // Ruajmë të dhënat në databazë për formularin e kontaktit
    if (!empty($emri) && !empty($email) && !empty($mesazhi)) {
        $sql = "INSERT INTO kontaktet (emri, email, mesazhi, data) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $emri, $email, $mesazhi);

        if ($stmt->execute()) {
            echo "<script>alert('Mesazhi u dërgua me sukses!'); window.location.href='../html/index2.html';</script>";
        } else {
            echo "<script>alert('Gabim gjatë dërgimit të mesazhit.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Ju lutemi plotësoni të gjitha fushat!');</script>";
    }
}

// Kontrollojmë për dërgimin e formularit të rezervimit
if (isset($_POST['submit_reservation'])) {
    $data = $_POST['data'];
    $emri = $_POST['emri'];
    $ora = $_POST['koha']; // Ndryshojmë nga 'koha' në 'ora'
    $numri_personave = $_POST['teftuarit']; // Sigurohu që në formë të jetë 'teftuarit'
    $statusi = "Ne Pritje"; // Vendosim statusin default

    // Kontrollojmë nëse të gjitha fushat janë mbushur
    if (!empty($data) && !empty($emri) && !empty($ora) && !empty($numri_personave)) {
        
        // SQL për futjen e të dhënave
        $sql = "INSERT INTO rezervime (`data`, emri, ora, numri_personave, statusi) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssis", $data, $emri, $ora, $numri_personave, $statusi);


        if ($stmt->execute()) {
            echo "<script>alert('Rezervimi u dërgua me sukses!');window.location.href='../html/reservation.html';</script>";
            // header("Location: reservation.html"); 
            exit();
        } else {
            die("Gabim gjatë dërgimit të rezervimit: " . $stmt->error);
        }

        $stmt->close();
    } else {
        echo "<script>alert('Ju lutemi plotësoni të gjitha fushat për rezervimin!');</script>";
    }
}



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

        <a href="insert_reservation.php">
    <button style="background-color: #007bff; color: white; padding: 12px 20px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">Shto Rezervim</button>
</a>

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
