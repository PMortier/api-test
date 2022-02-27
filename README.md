# api-test
Test mise en place d'une API de facturation en PHP

## endpoints provisoires réalisés

* ---/api-test/lireCommandes.php (GET)
* ---/api-test/lireCommandesClient.php?client_code=[code client] (GET)
* ---/api-test/lireCommande.php?commande_numero=[numero de commande] (GET)

## endpoints finaux envisagés

* ---/commandes (GET)
* ---/commandes/[code client] (GET)
* ---/commande/[numero de commande] (GET)
* ---/commande/valider/[numero de commande] (PUT)
* ---/commande/facture/[numero de commande] (POST)
* ---/facture/[numero de commande] (GET)

