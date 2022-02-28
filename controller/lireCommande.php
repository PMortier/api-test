<?php
// Headers requis
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

        // On vérifie si on a au moins 1 commande
        if ($commandes->commande_numero != null) {

            $result = [
                "commande_numero" => $commandes->commande_numero,
                "client_code" => $commandes->client_code,
                "fournisseur_designation" => $commandes->fournisseur_designation,
                "commande_datecreation" => $commandes->commande_datecreation,
                "commande_statut" => $commandes->commande_statut
            ];

            http_response_code(200);
            echo json_encode($result);
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
