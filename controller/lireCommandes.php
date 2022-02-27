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

    // On récupère les données
    $stmt = $commandes->getOrders();

    // On vérifie si on a au moins 1 commande
    if ($stmt->rowCount() > 0) {
        // On initialise un tableau associatif
        $tableauCommandes = [];
        $tableauCommandes['commandes'] = [];

        // On parcourt les commandes
        // Remarque : celà consommerait moins de faire 1 fetch par ligne plutôt que un fetchAll
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $result = [
                "commande_numero" => $commande_numero,
                "client_code" => $client_code,
                "fournisseur_designation" => $fournisseur_designation,
                "commande_datecreation" => $commande_datecreation,
                "commande_statut" => $commande_statut
            ];

            $tableauCommandes['commandes'][] = $result;
        }

        http_response_code(200);
        echo json_encode($tableauCommandes);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}



    


