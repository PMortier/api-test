SELECT i.facture_id, i.commande_id, c.client_code, r.reglement_conditions, f.fournisseur_designation, b.banque_designation FROM facture i, commande o, client c, reglement r, fournisseur f, banque b WHERE i.commande_id = o.commande_id AND o.client_id = c.client_id AND o.reglement_id = r.reglement_id AND o.fournisseur_id = f.fournisseur_id AND b.banque_id = f.banque_id AND i.commande_id =1;

SELECT o.commande_numero, p.produit_designation, op.commande_produit_quantite, op.commande_produit_pu_ht, t.tva_taux FROM produit p, commande_produit op, commande o, tva t, produit_tva pt WHERE op.commande_id = o.commande_id AND op.produit_id = p.produit_id AND pt.produit_tva_id = op.produit_tva_id AND pt.tva_id = t.tva_id AND o.commande_numero='2022-0025';