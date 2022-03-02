<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Commandes.php';
    include_once '../models/Factures.php';

    // On instancie la bdd
    $database = new Database();
    $db = $database->getConnexion();

    // On instancie les commandes
    $commandes = new Commandes($db);

    // On récupère le numero de commande
    $input = $_GET['commande_numero'];

    if (!empty($input)) {
        // On passe le numero de commande
        $commandes->commande_numero = $input;

        // On récupère les données
        $commandes->getOrderByOrderNumber();

        // On vérifie si on a 1 commande
        if ($commandes->commande_numero != null) {

            $result = [
                "commande_id" => $commandes->commande_id,
                "commande_statut" => $commandes->commande_statut
            ];

            if ($result['commande_statut'] !== 'validée') {
                http_response_code(403);
                echo json_encode(["message" => "La commande n'a pas encore été validée"]);
            } else {
                $factures = new Factures($db);
                // On passe les données nécessaires à Factures
                $factures->commande_id = $result['commande_id'];
                // On fait la requête
                $factures->getInvoiceByOrderId();
                // On vérifie que la facture existe
                if($factures->facture_id !== null){
                    // Récupération des produits en envoyant l'id de commande
                    $produits = $commandes->getProductsByOrderId($result['commande_id']);
                    $tableauProduits = $produits->fetchAll(PDO::FETCH_ASSOC);
                    
                    $facture = [
                        "facture_id" => $factures->facture_id,
                        "facture_datecreation" => $factures->facture_datecreation,
                        "facture_echeance" => $factures->facture_echeance,
                        "facture_statut" => $factures->facture_statut,
                        "commande_id" => $factures->commande_id,
                        "commande_numero" => $factures->commande_numero,
                        "client_code" => $factures->client_code,
                        "client_designation" => $factures->client_designation,
                        "client_statut" => $factures->client_statut,
                        "client_rue" => $factures->client_rue,
                        "client_cp" => $factures->client_cp,
                        "client_ville" => $factures->client_ville,
                        "fournisseur_designation" => $factures->fournisseur_designation,
                        "fournisseur_logourl" => $factures->fournisseur_logourl,
                        "fournisseur_statut" => $factures->fournisseur_statut,
                        "fournisseur_rue" => $factures->fournisseur_rue,
                        "fournisseur_cp" => $factures->fournisseur_cp,
                        "fournisseur_ville" => $factures->fournisseur_ville,
                        "fournisseur_telephone" => $factures->fournisseur_telephone,
                        "fournisseur_siteweb" => $factures->fournisseur_siteweb,
                        "fournisseur_capital" => $factures->fournisseur_capital,
                        "fournisseur_siret" => $factures->fournisseur_siret,
                        "fournisseur_naf_ape" => $factures->fournisseur_naf_ape,
                        "fournisseur_num_tva" => $factures->fournisseur_num_tva,
                        "banque_designation" => $factures->banque_designation,
                        "banque_iban" => $factures->banque_iban,
                        "banque_bicswift" => $factures->banque_bicswift,
                        "reglement_conditions" => $factures->reglement_conditions,
                        "reglement_type" => $factures->reglement_type,
                        "produits commandés" => $tableauProduits
                    ];
                    http_response_code(200);
                    echo json_encode($facture);
                }else{
                    http_response_code(404);
                    echo json_encode(["message" => "Aucune facture n'a été trouvée"]);
                }
            }
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Aucune commande n'a été trouvée"]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Veuillez préciser le numero de commande"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}