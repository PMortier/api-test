<?php

class Factures{
    //connexion
    private $connexion;

    //Propriétés de l'objet dont on a besoin
    public $facture_id;
    public $facture_datecreation;
    public $facture_echeance;
    public $facture_statut;
    public $commande_id;

    /**
     * Constructeur pour la connexion à la base de données et le passage du numero de commande
     * 
     * @param $db
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * Lire une facture à partir du numero de client
     * 
     */
    public function getInvoiceByOrderId(){
        $sql = "SELECT i.facture_id, i.commande_id FROM facture i, commande o WHERE i.commande_id = o.commande_id AND i.commande_id = :commande_id";

        $query = $this->connexion->prepare($sql);

        // On attache le paramètre numero de commande
        $query->bindParam(':commande_id', $this->commande_id);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->facture_id = $row['facture_id'];
    }

    /**
     * Créer une facture à partir d'une commande validée
     * 
     */
    public function createInvoice()
    {
        $sql = "INSERT INTO facture SET commande_id=:commande_id, facture_datecreation=NOW(), facture_echeance=ADDDATE(NOW(),7),facture_statut='à régler'";

        $query = $this->connexion->prepare($sql);

        $query->bindParam(':commande_id', $this->commande_id);

        if($query->execute()){
            return true;
        }

        return false;
    }
}