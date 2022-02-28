SELECT i.facture_id, i.commande_id, c.client_code, r.reglement_conditions, f.fournisseur_designation, b.banque_designation FROM facture i, commande o, client c, reglement r, fournisseur f, banque b WHERE i.commande_id = o.commande_id AND o.client_id = c.client_id AND o.reglement_id = r.reglement_id AND o.fournisseur_id = f.fournisseur_id AND b.banque_id = f.banque_id AND i.commande_id =1;
