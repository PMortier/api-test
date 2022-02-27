<?php

class Factures{
    //connexion
    private $connexion;

    //Propriétés de l'objet dont on a besoin
    

    /**
     * Constructeur pour la connexion à la base de données
     * 
     * @param $db
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }
}