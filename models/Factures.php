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
        $sql = "SELECT i.facture_id, i.facture_datecreation, i.facture_echeance, i.facture_statut, i.commande_id, o.commande_numero, c.client_code, c.client_designation, c.client_statut, c.client_rue, c.client_cp, c.client_ville, r.reglement_conditions, r.reglement_type, f.fournisseur_designation, f.fournisseur_logourl, f.fournisseur_statut, f.fournisseur_rue, f.fournisseur_cp, f.fournisseur_ville, f.fournisseur_telephone, f.fournisseur_siteweb, f.fournisseur_capital, f.fournisseur_siret, f.fournisseur_naf_ape, f.fournisseur_num_tva, b.banque_designation, b.banque_iban, b.banque_bicswift FROM facture i, commande o, client c, reglement r, fournisseur f, banque b WHERE i.commande_id = o.commande_id AND o.client_id = c.client_id AND o.reglement_id = r.reglement_id AND o.fournisseur_id = f.fournisseur_id AND b.banque_id = f.banque_id AND i.commande_id = :commande_id";

        $query = $this->connexion->prepare($sql);

        // On attache le paramètre numero de commande
        $query->bindParam(':commande_id', $this->commande_id);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if($query->rowCount()>0){
            $this->facture_id = $row['facture_id'];
            $this->facture_datecreation = $row['facture_datecreation'];
            $this->facture_echeance = $row['facture_echeance'];
            $this->facture_statut = $row['facture_statut'];
            $this->commande_id = $row['commande_id'];
            $this->commande_numero = $row['commande_numero'];
            $this->client_code = $row['client_code'];
            $this->client_designation = $row['client_designation'];
            $this->client_statut = $row['client_statut'];
            $this->client_rue = $row['client_rue'];
            $this->client_cp = $row['client_cp'];
            $this->client_ville = $row['client_ville'];
            $this->reglement_conditions = $row['reglement_conditions'];
            $this->reglement_type = $row['reglement_type'];
            $this->fournisseur_designation = $row['fournisseur_designation'];
            $this->fournisseur_logourl = $row['fournisseur_logourl'];
            $this->fournisseur_statut = $row['fournisseur_statut'];
            $this->fournisseur_rue = $row['fournisseur_rue'];
            $this->fournisseur_cp = $row['fournisseur_cp'];
            $this->fournisseur_ville = $row['fournisseur_ville'];
            $this->fournisseur_telephone = $row['fournisseur_telephone'];
            $this->fournisseur_siteweb = $row['fournisseur_siteweb'];
            $this->fournisseur_capital = $row['fournisseur_capital'];
            $this->fournisseur_siret = $row['fournisseur_siret'];
            $this->fournisseur_naf_ape = $row['fournisseur_naf_ape'];
            $this->fournisseur_num_tva = $row['fournisseur_num_tva'];
            $this->banque_designation = $row['banque_designation'];
            $this->banque_iban = $row['banque_iban'];
            $this->banque_bicswift = $row['banque_bicswift'];
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