<?php
session_start();
session_unset(); // Pastron të gjitha variablat e sesionit
session_destroy(); // Shkatërron sesionin
header("Location: login.html"); // Redirekton në faqen e log-in
exit();
?>
