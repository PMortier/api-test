# api-test
Test mise en place d'une API de facturation en PHP

## endpoints provisoires réalisés

* ---/api-test/lireCommandes.php (GET)
* ---/api-test/lireCommandesClient.php?client_code=[code client] (GET)
* ---/api-test/lireCommande.php?commande_numero=[numero de commande] (GET)
* ---/api-test/validerCommande.php?commande_numero=[numero de commande] (PUT)

## endpoints finaux envisagés

### Afficher toutes les commandes
---/commandes (GET)

### Afficher toutes les commandes d'un client via son code client
---/commandes/[code client] (GET)

### Afficher une commande via le numero de commande
---/commande/[numero de commande] (GET)

### Valider une commande en cours via le numero de commande
---/commande/valider/[numero de commande] (PUT)

### Créer la facture d'une commande validée via le numero de commande
---/commande/facture/[numero de commande] (POST)

### Afficher la facture d'une commande via le numero de commande
---/facture/[numero de commande] (GET)

