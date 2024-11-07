<?php
require_once 'controllers/CommandeController.php';

$controller = new CommandeController();

if (isset($_POST['submit'])) {
    $detaillant = $_POST['detaillant'];
    $controller->afficherCommandes($detaillant);
} else {
    $controller->afficherCommandes();
}
?>