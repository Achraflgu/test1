<?php
if (!defined("SERVEUR")) {
    define("SERVEUR", "localhost");
}

if (!defined("BASE")) {
    define("BASE", "damm");
}

if (!defined("USER")) {
    define("USER", "root");
}

if (!defined("MDP")) {
    define("MDP", "");
}

$conn = mysqli_connect(SERVEUR, USER, MDP, BASE) or die("Erreur" . mysqli_error($conn));
?>
