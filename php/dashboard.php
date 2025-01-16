<?php
include('../db/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="css/dashboardstyle.css">
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
                <!-- Këtu do të ngarkohen të dhënat me PHP -->
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
                                <a href='edit_reservation.php?id={$row['id']}' class='btn-edit'>Ndrysho</a>
                                <a href='delete_reservation.php?id={$row['id']}' class='btn-delete'>Fshij</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nuk ka të dhëna.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pjesa per menaxhimin e formes kontaktoni neve -->
        <h1>Mesazhet e Kontaktit</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Emri</th>
            <th>Email</th>
            <th>Mesazhi</th>
            <th>Data</th>
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
                 <a href="create_reservation/create_reservation.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Ndrysho</a>
                 <a href="delete_reservation.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Fshij</a>                    
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nuk ka të dhëna.</td></tr>";
        }
        ?>
    </tbody>
</table>

    </div>
</body>
</html>