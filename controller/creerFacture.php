<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

            if($result['commande_statut'] === 'validée'){
                //Instructions si commande validée
                $facture = new Factures($db);
                // On passe les données nécessaires à Factures
                $facture->commande_id = $result['commande_id'];
                // On vérifie que la facture n'existe pas déjà
                $facture->getInvoiceByOrderId();
                if($facture->facture_id !=null){
                    http_response_code(403);
                    echo json_encode(["message" => "Une facture existe déjà pour cette commande"]);
                }else{
                    // On crée la facture
                    if ($facture->createInvoice()) {
                        http_response_code(200);
                        echo json_encode(["message" => "La facture a été créée"]);
                    } else {
                        http_response_code(503);
                        echo json_encode(["message" => "La facture n'a pas pu être créée"]);
                    }
                }
            }else{
                http_response_code(403);
                echo json_encode(["message" => "La commande n'a pas encore été validée"]);
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
