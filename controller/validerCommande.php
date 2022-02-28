<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Commandes.php';

    // On instancie la bdd
    $database = new Database();
    $db = $database->getConnexion();

    // On instancie les commandes
    $commande = new Commandes($db);

    $input = $_GET['commande_numero'];

    if(!empty($input)){

        $commande->commande_numero = $input;

        if($commande->updateOrderStatusToValidated()){
            http_response_code(200);
            echo json_encode(["message"=>"La commande a été validée"]);
        }else{
            http_response_code(503);
            echo json_encode(["message"=>"La commande n'a pas pu être validée"]);
        }
    }

} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
