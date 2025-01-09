<?php
include('../db/db.php');
?>

<?php
// Merr ID-në e rezervimit që duhet të fshihet
$id = $_GET['id'];

// Fshi rezervimin nga baza e të dhënave
$sql = "DELETE FROM rezervime WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "Rezervimi është fshirë!";
} else {
    echo "Gabim: " . $conn->error;
}
?>