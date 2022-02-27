<?php
// Création d'un routeur dynamique avec les entrées utilisateur

// GET  | ---/commandes
// GET  | ---/commandes/:client_code
// GET  | ---/commande/:commande_numero
// PUT  | ---/commande/valider/:commande_numero
// POST | ---/commande/facture/:commande_numero
// GET  | ---/facture/:commande_numero

try{
    if(!empty($_GET['demande'])){
        // décomposition de l'url
        $url = explode("/", filter_var($_GET['demande'], FILTER_SANITIZE_URL));
        switch($url[0]){
            case "commandes":
                echo 'commandes';
            break;
            case "commande":
                echo 'commande';
            break;
            case "facture":
                echo 'facture';
            break;
            default : throw new Exception ("La demande n'est pas valide. Vérifiez l'url.");
        }
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


