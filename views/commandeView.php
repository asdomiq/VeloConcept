<?php require_once "models/CommandeModel.php"; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes | VeloConcept</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Gestion des commandes | VeloConcept</h1>
        <form method="post" action="">
            <div class="form-group">
                <select name="detaillant" id="detaillant" class="form-control">
                    <option value="">-- Choisir un détaillant --</option>
                    <?php
                    // Chargement des détaillants depuis le fichier XML
                    $xml = simplexml_load_file("models/cdes.xml");

                    // Vérification du détaillant sélectionné
                    $selectedDetaillant = isset($_POST['detaillant']) ? $_POST['detaillant'] : '';

                    // Boucle sur les détaillants pour les afficher dans la liste déroulante
                    foreach ($xml->detaillant as $detaillant):
                        $numero = (string) $detaillant['numero'];
                    ?>
                        <option value="<?php echo $numero; ?>"
                            <?php echo ($selectedDetaillant == $numero) ? 'selected' : ''; ?>>
                            <?php echo $numero; ?> - <?php echo $detaillant->nom; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-custom">Valider</button>
        </form>

        <?php
        // Affichage des commandes à préparer si des produits existent
        if (!empty($produits)): ?>
            <h2>Commandes à préparer pour le détaillant <?php echo htmlspecialchars($selectedDetaillant); ?></h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Nom</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $produit): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($produit->reference); ?></td>
                            <td><?php echo htmlspecialchars($produit->nom); ?></td>
                            <td><?php echo htmlspecialchars($produit->qte); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <h2>Commandes en attente</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Modèle</th>
                    <th>Type</th>
                    <th>Stock</th>
                    <th>Stock max</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commandesAttente as $commande): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($commande['reference']); ?></td>
                        <td><?php echo htmlspecialchars($commande['modele']); ?></td>
                        <td><?php echo htmlspecialchars($commande['type']); ?></td>
                        <td><?php echo htmlspecialchars($commande['stockqte']); ?></td>
                        <td><?php echo htmlspecialchars($commande['stockmaxi']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button id="download-pdf-btn" class="btn btn-green">Télécharger la commande en PDF</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

    <script src="script.js"></script> <!-- Inclusion du fichier JavaScript -->
</body>

</html>