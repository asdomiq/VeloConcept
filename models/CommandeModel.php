<?php

class CommandeModel
{
    private $conn;

    public function __construct()
    {
        // Connexion à la base de données
        $this->conn = new mysqli("localhost", "root", "", "veloconcept");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Récupérer toutes les commandes en attente de la base de données
    public function getCommandesEnAttente()
    {
        $sql = "SELECT p.reference, p.modele, p.type, p.stockqte, p.stockmaxi FROM produit p";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Récupérer les commandes d'un détaillant à partir du fichier XML
    public function getDetaillantCommandes($detaillantNum)
    {
        $xml = simplexml_load_file("models/cdes.xml");
        foreach ($xml->detaillant as $detaillant) {
            if ((string)$detaillant['numero'] === $detaillantNum) {
                return $detaillant->produit;
            }
        }
        return [];
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}
?>
