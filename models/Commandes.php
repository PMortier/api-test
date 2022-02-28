<?php

class Commandes {
    //connexion
    private $connexion;

    //propriétés de l'objet dont on a besoin
    public $client_id;
    public $client_code;
    public $fournisseur_designation;
    public $commande_numero;
    public $commande_datecreation;
    public $commande_statut;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * Lecture de toutes les commandes
     * 
     */
    public function getOrders()
    {
        $sql = "SELECT o.commande_numero, c.client_code, f.fournisseur_designation, o.commande_datecreation, o.commande_statut FROM commande o, client c, fournisseur f WHERE o.client_id = c.client_id AND o.fournisseur_id = f.fournisseur_id ORDER BY o.commande_datecreation DESC";

        $query = $this->connexion->prepare($sql);

        $query->execute();

        return $query;
    }

    /**
     * Lecture de toutes les commandes d'un client via son code client
     * 
     */
    public function getOrdersByClientNumber(){
        $sql = "SELECT o.commande_numero, c.client_code, f.fournisseur_designation, o.commande_datecreation, o.commande_statut FROM commande o, client c, fournisseur f WHERE o.client_id = c.client_id AND o.fournisseur_id = f.fournisseur_id AND c.client_code = :client_code ORDER BY o.commande_datecreation DESC";
        
        $query = $this->connexion->prepare($sql);
        
        // On attache le paramètre code client
        $query->bindParam(':client_code', $_GET['client_code']);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->client_code = $row['client_code'];
        $this->commande_numero = $row['commande_numero'];
        $this->fournisseur_designation = $row['fournisseur_designation'];
        $this->commande_datecreation = $row['commande_datecreation'];
        $this->commande_statut = $row['commande_statut'];

    }

    /**
     * Lecture d'une commande en fonction du numéro de commande
     * 
     */
    public function getOrderByOrderNumber(){
        $sql = "SELECT o.commande_numero, c.client_code, f.fournisseur_designation, o.commande_datecreation, o.commande_statut FROM commande o, client c, fournisseur f WHERE o.client_id = c.client_id AND o.fournisseur_id = f.fournisseur_id AND o.commande_numero = :commande_numero";

        $query = $this->connexion->prepare($sql);

        // On attache le paramètre numero de commande
        $query->bindParam(':commande_numero', $_GET['commande_numero']);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->client_code = $row['client_code'];
        $this->commande_numero = $row['commande_numero'];
        $this->fournisseur_designation = $row['fournisseur_designation'];
        $this->commande_datecreation = $row['commande_datecreation'];
        $this->commande_statut = $row['commande_statut'];

    }

    /**
     * Valider une commande via le numero de commande 
     * 
     */
    public function updateOrderStatusToValidated(){
        $sql = "UPDATE commande SET commande_statut = 'validée' WHERE commande_numero = :commande_numero";

        $query = $this->connexion->prepare($sql);

        // On attache le paramètre numero de commande
        $query->bindParam(':commande_numero', $this->commande_numero);

        if($query->execute() && $query->rowCount() > 0){
            return true;
        }

        return false;
    }
    
}