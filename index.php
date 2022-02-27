<?php

// GET  | ---/commandes
// GET  | ---/commandes/:client_code
// GET  | ---/commande/:commande_numero
// PUT  | ---/commande/valider/:commande_numero
// POST | ---/commande/facture/:commande_numero
// GET  | ---/facture/:commande_numero

try{
    if(!empty($_GET['demande'])){
        echo "test";
    } else {
        throw new Exception("Problème de récupération de données.");
    }
}catch(Exception $e){
    $erreur = [
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($erreur);
}


