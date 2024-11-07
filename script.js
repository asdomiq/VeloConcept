document.getElementById("download-pdf-btn").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Récupérer le numéro du détaillant sélectionné
    const detaillant = document.getElementById("detaillant").value;
    if (!detaillant) {
        alert("Veuillez sélectionner un détaillant");
        return; // Arrêter si aucun détaillant n'est sélectionné
    }

    // Variables pour le positionnement
    const pageWidth = doc.internal.pageSize.getWidth();
    let y = 20; // Position initiale verticale

    // Fonction pour centrer le texte
    function centerText(text, yPos, fontSize = 16) {
        doc.setFontSize(fontSize);
        const textWidth = doc.getTextWidth(text);
        doc.text(text, (pageWidth - textWidth) / 2, yPos);
    }

    // Titre principal centré "Facture de Commande"
    centerText("Facture de Commande | VeloConcept", 35, 22);
    y += 25;

    // Informations détaillant
    centerText("Détaillant numéro: " + detaillant, y);
    y += 10;
    centerText("Date: " + new Date().toLocaleDateString(), y);
    y += 10;

    // Titre centré "Commandes à préparer"
    centerText("Commandes à préparer", y);
    y += 10;

    // Récupérer les données de la table "Commandes à préparer"
    let tableData1 = [];
    let table1 = document.querySelector('table').querySelectorAll('tr');
    table1.forEach(row => {
        let rowData = [];
        row.querySelectorAll('td, th').forEach(cell => {
            rowData.push(cell.textContent.trim());
        });
        tableData1.push(rowData);
    });

    // Générer le tableau avec AutoTable (Commandes à préparer)
    doc.autoTable({
        head: [tableData1[0]], // Première ligne comme en-tête
        body: tableData1.slice(1), // Les autres lignes comme contenu
        startY: y,
        theme: 'striped', // Utilisation d'un thème alterné pour les lignes
        headStyles: {
            halign: 'center',
            fillColor: [41, 128, 185] // Couleur de l'en-tête
        },
        bodyStyles: {
            halign: 'center'
        },
        columnStyles: {
            0: { cellWidth: 30 }, // Référence
            1: { cellWidth: 50 }, // Nom
            2: { cellWidth: 20 }  // Quantité
        },
        styles: {
            fontSize: 10, // Police un peu plus petite
            overflow: 'linebreak',
            cellPadding: 2 // Réduire le padding
        },
        margin: { left: 30, right: 30 } // Ajustement pour centrer le tableau
    });

    // Ajuster la position après le premier tableau
    y = doc.lastAutoTable.finalY + 20; // Position après le tableau

    // Ajouter une ligne entre les tableaux
    doc.setLineWidth(0.5);
    doc.line(10, y, pageWidth - 10, y); // Ligne horizontale
    y += 10;

    // Titre centré "Commandes en attente"
    centerText("Commandes en attente", y);
    y += 10;

    // Récupérer les données de la table "Commandes en attente"
    let tableData2 = [];
    let table2 = document.querySelectorAll('table')[1].querySelectorAll('tr');
    table2.forEach(row => {
        let rowData = [];
        row.querySelectorAll('td, th').forEach(cell => {
            rowData.push(cell.textContent.trim());
        });
        tableData2.push(rowData);
    });

    // Générer le tableau avec AutoTable (Commandes en attente)
    doc.autoTable({
        head: [tableData2[0]], // Première ligne comme en-tête
        body: tableData2.slice(1), // Les autres lignes comme contenu
        startY: y,
        theme: 'striped',
        headStyles: {
            halign: 'center',
            fillColor: [41, 128, 185]
        },
        bodyStyles: {
            halign: 'center'
        },
        columnStyles: {
            0: { cellWidth: 25 }, // Référence
            1: { cellWidth: 30 }, // Modèle
            2: { cellWidth: 25 }, // Type
            3: { cellWidth: 25 }, // Stock
            4: { cellWidth: 25 }  // Stock max
        },
        styles: {
            fontSize: 10, // Police un peu plus petite
            overflow: 'linebreak',
            cellPadding: 2 // Réduire le padding
        },
        margin: { left: 30, right: 30 }
    });

    // Ajouter une ligne entre les tableaux
    y = doc.lastAutoTable.finalY + 20;
    doc.setLineWidth(0.5);
    doc.line(10, y, pageWidth - 10, y); // Ligne horizontale
    y += 10;

    // Ajouter une note de bas de page
    centerText("Merci pour votre commande.", y, 14);
    y += 10;
    centerText("VeloConcept | www.veloconcept.com", y, 12);

    // Sauvegarder le PDF
    doc.save("facture_detaillant_" + detaillant + ".pdf");
});
