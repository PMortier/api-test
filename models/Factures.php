<?php

class Factures{
    //connexion
    private $connexion;

    //Propriétés de l'objet dont on a besoin
    public $facture_id;
    public $commande_id;
    public $facture_datecreation;
    public $facture_echeance;
    public $facture_statut;

    // Propriétés banque
    public $banque_designation;
    public $banque_iban;
    public $banque_bicswift;
    
    // Propriétés fournisseur
    public $fournisseur_designation;
    public $fournisseur_logourl;
    public $fournisseur_statut;
    public $fournisseur_rue;
    public $fournisseur_cp;
    public $fournisseur_ville;
    public $fournisseur_telephone;
    public $fournisseur_siteweb;
    public $fournisseur_capital;
    public $fournisseur_siret;
    public $fournisseur_naf_ape;
    public $fournisseur_num_tva;

    // Propriétés client
    public $client_code;
    public $client_designation;
    public $client_statut;
    public $client_rue;
    public $client_cp;
    public $client_ville;
    
    // Propriétés reglement
    public $reglement_conditions;
    public $reglement_type;


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
        $sql = "SELECT i.facture_id, i.commande_id, c.client_code, r.reglement_conditions, f.fournisseur_designation, b.banque_designation FROM facture i, commande o, client c, reglement r, fournisseur f, banque b WHERE i.commande_id = o.commande_id AND o.client_id = c.client_id AND o.reglement_id = r.reglement_id AND o.fournisseur_id = f.fournisseur_id AND b.banque_id = f.banque_id AND i.commande_id = :commande_id";

        $query = $this->connexion->prepare($sql);

        // On attache le paramètre numero de commande
        $query->bindParam(':commande_id', $this->commande_id);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount()>0){
            $this->facture_id = $row['facture_id'];
            $this->commande_id = $row['commande_id'];
            $this->client_code = $row['client_code'];
            $this->reglement_conditions = $row['reglement_conditions'];
            $this->fournisseur_designation = $row['fournisseur_designation'];
            $this->banque_designation = $row['banque_designation'];
        }
           
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