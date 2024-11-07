<?php
require_once 'models/CommandeModel.php';

class CommandeController
{
    private $model;

    public function __construct()
    {
        $this->model = new CommandeModel();
    }

    public function afficherCommandes()
    {
        // Récupération des commandes en attente
        $commandesAttente = $this->model->getCommandesEnAttente();
        $produits = [];

        if (isset($_POST['submit']) && !empty($_POST['detaillant'])) {
            $detaillant = $_POST['detaillant'];
            $produits = $this->model->getDetaillantCommandes($detaillant);
        }

        // Appeler la vue avec les données
        require_once 'views/commandeView.php';
    }
}
