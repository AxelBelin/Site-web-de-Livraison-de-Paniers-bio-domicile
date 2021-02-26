set serveroutput on;
-- Requêtes  permettant  de  raliser  chacune  des  fonctionnalits  de lapplication

-- modif ici
-- Vérifier qu'un compte existe
SELECT numCompte FROM Compte ;
SELECT c.numCLient, L.numLivreur FROM Client c, Livreur L WHERE c.numLivreur = L.numLivreur ;
SELECT numClient FROM Client ;
SELECT numLivreur FROM Livreur ;
-- Insrer un nouveau compte
INSERT INTO Compte VALUES(5, 'Client', 'indentifiant', 'motdepasse', 'numcb') ;
INSERT INTO Compte(numCompte, Profil, indentifiant, motdepasse) VALUES(6, 'Livreur', 'indentifiant2', 'motdepasse') ;
UPDATE Compte SET numcb = '01234xxx' WHERE numcompte = 5 ;
-- Insrer client + livreur
INSERT INTO Client(numClient, NOMCLIENT, prenomClient, mail, adresse, LIMITDEPRIX, tel, GROUPE, NUMCARTIER, NUMCOMPTE) VALUES(3, 'NOMCLIENT', 'prenomClient', 'mail', 'adresse', 12.5, 'tel', 3, 1, 5) ;
INSERT INTO Client(numClient, NOMCLIENT, prenomClient, mail, adresse, tel, GROUPE, NUMCARTIER, NUMCOMPTE) VALUES(4, 'NOMCLIENT', 'prenomClient', 'mail', 'adresse','tel', 3, 1, 5) ;
INSERT INTO Livreur(numLivreur, nomLivreur, prenomlivreur, tellivreur, mailLivreur, numCompte) VALUES(4, 'nomLivreur', 'prenomlivreur','tellivreur', 'maillivreur', 6) ;
-- Rcuprer les noms et numros de quartier et ville
SELECT q.numCartier, q.nomCartier, v.nomVille, v.CP FROM Quartier q, Ville v WHERE q.numVille = v.numVille ;
SELECT q.numCartier, q.nomCartier, v.CP FROM Quartier q, Ville v WHERE q.numVille = v.numVille AND v.nomVille LIKE '%Antony%' ;
-- Consulter des articles et des paniers
SELECT * FROM Produit ;
SELECT * FROM Panier ;
SELECT * FROM Produit WHERE Quantite > 0 ;
SELECT * FROM Panier WHERE Quantite > 0 ;
SELECT DISTINCT p.NOMPRODUIT, p.QUANTITE, p.PRIXPRODUIT, t.NOMTYPEPRODUIT, f.saison, f.categorie FROM Produit p, TypeProduit t, compoFamille c, famille f WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille ;
SELECT DISTINCT p.NOMPRODUIT, p.QUANTITE, p.PRIXPRODUIT, f.saison, f.categorie FROM Produit p, TypeProduit t, compoFamille c, famille f WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille AND t.NOMTYPEPRODUIT LIKE '%Fruit%';
SELECT DISTINCT p.NOMPRODUIT, p.QUANTITE, p.PRIXPRODUIT, t.NOMTYPEPRODUIT, f.categorie FROM Produit p, TypeProduit t, compoFamille c, famille f WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille AND f.saison LIKE '%hiver%';
SELECT DISTINCT p.NOMPRODUIT, p.QUANTITE, p.PRIXPRODUIT, t.NOMTYPEPRODUIT, f.saison FROM Produit p, TypeProduit t, compoFamille c, famille f WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille AND f.categorie LIKE '%soup%';
SELECT DISTINCT p.NOMPRODUIT, p.QUANTITE, p.PRIXPRODUIT, t.NOMTYPEPRODUIT, f.saison, f.categorie FROM Produit p, TypeProduit t, compoFamille c, famille f WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille AND p.NOMPRODUIT LIKE '%Carrot%';
-- Afficher toutes les infos sur les panier
SELECT DISTINCT pa.NOMPANIER, p.NOMPRODUIT, pa.QUANTITE, pa.nbProduit, pa.prixPanier, t.NOMTYPEPRODUIT, f.saison, f.categorie FROM Produit p, TypeProduit t, compoFamille c, famille f, Panier pa, CompoPanier cp WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille AND pa.numpanier = cp.numPanier AND cp.numProduit = p.numProduit ;
-- Affichage ligne par ligne
SELECT numPanier, nomPanier FROM Panier WHERE numPanier = 2 ;
SELECT quantite FROM Panier WHERE numPanier = 1 ;
SELECT nbProduit FROM Panier WHERE numPanier = 1 ;
SELECT prixPanier FROM Panier WHERE numPanier = 1 ;
-- rechercher un panier par nom
SELECT DISTINCT pa.NOMPANIER, p.NOMPRODUIT, pa.QUANTITE, pa.nbProduit, pa.prixPanier, t.NOMTYPEPRODUIT, f.saison, f.categorie FROM Produit p, TypeProduit t, compoFamille c, famille f, Panier pa, CompoPanier cp WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille AND pa.numpanier = cp.numPanier AND cp.numProduit = p.numProduit AND pa.NOMPANIER LIKE '%Hiver%' ;
-- rechercher un panier en fonction d'un nb de produits max contenu dans les paniers
SELECT DISTINCT pa.NOMPANIER, p.NOMPRODUIT, pa.QUANTITE, pa.prixPanier, t.NOMTYPEPRODUIT, f.saison, f.categorie FROM Produit p, TypeProduit t, compoFamille c, famille f, Panier pa, CompoPanier cp WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille AND pa.numpanier = cp.numPanier AND cp.numProduit = p.numProduit AND pa.nbProduit <= 10 ;
-- rechercher des paniers en fonction d'une quantit / poids max en Kg
SELECT DISTINCT pa.NOMPANIER, p.NOMPRODUIT, pa.nbProduit, pa.prixPanier, t.NOMTYPEPRODUIT, f.saison, f.categorie FROM Produit p, TypeProduit t, compoFamille c, famille f, Panier pa, CompoPanier cp WHERE p.NUMTYPEPRODUIT = t.NUMTYPEPRODUIT AND t.NUMTYPEPRODUIT = c.NUMTYPEPRODUIT AND c.numFamille = f.numFamille AND pa.numpanier = cp.numPanier AND cp.numProduit = p.numProduit AND pa.QUANTITE <= 5 ;
-- Dfinir / modifier une limite de prix pour un client donn
UPDATE Client SET limitdePrix = 10 WHERE numClient = 4 ;
-- SELECT p.* FROM Produit p, Client c, Commande co, CommandeProduit cp WHERE
SELECT * FROM Produit WHERE prixProduit <= 10 AND Quantite > 0 ;
SELECT * FROM Panier WHERE prixPanier <= 10 AND Quantite > 0 ;

-- Commander des articles et des paniers

-- Commande unique seule et groupe
SELECT * FROM Commande ;
SELECT * FROM CommandePanier ;
SELECT * FROM CommandeProduit ;
-- seul
INSERT INTO Commande VALUES(4, 0, null, 0, 'en prparation', SYSDATE, 10.5, 1.2, 12.6) ;
INSERT INTO CommandePanier VALUES(4, 1, 1) ; -- soit il commande un ou plusieurs paniers
INSERT INTO CommandeProduit VALUES(4, 2, 3) ; -- soit un ou pusieurs produits avec une quantite en kg
UPDATE Client SET numCommande = 4 WHERE numClient = 4 ; -- Maj de la table client avec le bon num de commande correspondant
SELECT numCB FROM Compte c, Client cl WHERE c.numCompte = cl.numCompte AND cl.numClient = 4 ;
-- groupe
UPDATE Client SET Groupe = 2 WHERE nomClient = 'tutu' AND prenomClient = 'toto' ; -- Group cre par un client
UPDATE Client SET Groupe = 2 WHERE nomClient = 'tete' AND prenomClient = 'tata' ; -- Groupe cre par un client
INSERT INTO Commande VALUES(5, 1, null, 0, 'en prparation', SYSDATE, 10.5, 1.2, 12.6) ;
INSERT INTO CommandePanier VALUES(5, 2, 2) ; -- soit le groupe commande un ou plusieurs paniers
INSERT INTO CommandeProduit VALUES(5, 1, 10) ; -- soit un ou pusieurs produits avec une quantite en kg
UPDATE Client SET numCommande = 5 WHERE numClient = 1 ; -- Maj de la table client avec le bon num de commande correspondant
UPDATE Client SET numCommande = 5 WHERE numClient = 2 ; -- Maj de la table client avec le bon num de commande correspondant
UPDATE Client SET Groupe = 2 WHERE numCommande = 5 ; -- groupe cre automatiquement
SELECT numCB FROM Compte c, Client cl WHERE c.numCompte = cl.numCompte AND cl.numClient = 1 ;
-- Commande hedbomadaire seule et groupe
-- seul
INSERT INTO Commande VALUES(6, 0, 'lundi', 1, 'en prparation', SYSDATE, 10.5, 1.2, 12.6) ;
INSERT INTO CommandePanier VALUES(6, 1, 1) ; -- soit il commande un ou plusieurs paniers
INSERT INTO CommandeProduit VALUES(6, 2, 3) ; -- soit un ou plusieurs produits avec une quantite en kg
UPDATE Client SET numCommande = 6 WHERE numClient = 3 ; -- Maj de la table client avec le bon num de commande correspondant
SELECT numCB, cl.numClient FROM Compte c, Client cl WHERE c.numCompte = cl.numCompte AND cl.numClient = 3 ;
-- groupe
INSERT INTO Commande VALUES(7, 1, 'mardi', 1, 'en prparation', SYSDATE, 10.5, 1.2, 12.6) ;
INSERT INTO CommandePanier VALUES(7, 2, 2) ; -- soit le groupe commande un ou plusieurs paniers
INSERT INTO CommandeProduit VALUES(7, 1, 10) ; -- soit un ou pusieurs produits avec une quantite en kg
UPDATE Client SET numCommande = 7 WHERE numClient = 1 ; -- Maj de la table client avec le bon num de commande correspondant
UPDATE Client SET numCommande = 7 WHERE numClient = 2 ; -- Maj de la table client avec le bon num de commande correspondant
UPDATE Client SET Groupe = 2 WHERE numCommande = 7 ; -- groupe cre automatiquement
SELECT numCB, cl.numClient FROM Compte c, Client cl WHERE c.numCompte = cl.numCompte AND cl.numClient = 2 ;

-- Voir les commandes des clients (livreur et producteur)

-- Livreur
-- commande seule et unique
-- Paniers
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 0 ;
-- Produits
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 0 ;
-- commande seule et hebdomadaire
-- Paniers
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 1 ;
-- Produits
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 1 ;
-- commandes goupes et uniques
-- Paniers
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 0 ;
-- Produits
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 0 ;
-- commandes goupes et hebdomadaire
-- Paniers
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 1 ;
-- Produits
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 1 ;

-- Producteur
-- commande seule et unique
-- Paniers
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.PRIXTOTAL, c.PRIXTOTALNET, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 0 ;
-- Produits
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.PRIXTOTAL, c.PRIXTOTALNET, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 0 ;
-- commande seule et hebdomadaire
-- Paniers
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, c.PRIXTOTAL, c.PRIXTOTALNET, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 1 ;
-- Produits
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, c.PRIXTOTAL, c.PRIXTOTALNET, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 1 ;
-- commandes goupes et uniques
-- Paniers
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.PRIXTOTAL, c.PRIXTOTALNET, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 0 ;
-- Produits
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.PRIXTOTAL, c.PRIXTOTALNET, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 0 ;
-- commandes goupes et hebdomadaire
-- Paniers
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, c.PRIXTOTAL, c.PRIXTOTALNET, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 1 ;
-- Produits
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, c.PRIXTOTAL, c.PRIXTOTALNET, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 1 ;

-- Consulter les coordonnes des clients (livreur)
SELECT c.NUMCLIENT, c.NOMCLIENT, c.PRENOMCLIENT, c.MAIL, c.ADRESSE, c.TEL, q.nomCartier, v.nomVille FROM Client c, Quartier q, Ville v WHERE c.numCartier = q.numCartier AND q.numVille = v.numVille AND c.numCommande = 1 ;

-- Voir les commandes prtes (livreur)
-- commande seule et unique
-- Paniers
SELECT c.NUMCOMMANDE, c.DATECOMMANDE, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 0 AND c.ETATCOMMANDE LIKE '%Prete  livrer%' ;
-- Produits
SELECT c.NUMCOMMANDE, c.DATECOMMANDE, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 0 AND c.ETATCOMMANDE LIKE '%Prete  livrer%' ;
-- commande seule et hebdomadaire
-- Paniers
SELECT c.NUMCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 1 AND c.ETATCOMMANDE LIKE '%Prete  livrer%' ;
-- Produits
SELECT c.NUMCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 0 AND c.HEBDOMADAIRE = 1 AND c.ETATCOMMANDE LIKE '%Prete  livrer%' ;
-- commandes goupes et uniques
-- Paniers
SELECT c.NUMCOMMANDE, c.DATECOMMANDE, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 0 AND c.ETATCOMMANDE LIKE '%Prete  livrer%' ;
-- Produits
SELECT c.NUMCOMMANDE, c.DATECOMMANDE, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 0 AND c.ETATCOMMANDE LIKE '%Prete  livrer%' ;
-- commandes goupes et hebdomadaire
-- Paniers
SELECT c.NUMCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, cp.numPanier, p.nomPanier, cp.quantite FROM Commande c, CommandePanier cp, Panier p WHERE c.numCommande = cp.numCommande AND cp.numPanier = p.numPanier AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 1 AND c.ETATCOMMANDE LIKE '%Prete  livrer%' ;
-- Produits
SELECT c.NUMCOMMANDE, c.DATECOMMANDE, c.JOURLIVRASION, cp.numProduit, p.nomProduit, cp.quantite FROM Commande c, CommandeProduit cp, Produit p WHERE c.numCommande = cp.numCommande AND cp.numProduit = p.numProduit AND c.COMMANDEGROUPE = 1 AND c.HEBDOMADAIRE = 1 AND c.ETATCOMMANDE LIKE '%Prete  livrer%' ;

-- Signaler une prise en charge dune livraison + Livrer la commande (livreur)

-- Changer l'Etat de la commande
UPDATE Commande SET ETATCOMMANDE = 'Livraison en cours' WHERE numcommande = 1 ;
-- Ajouter ou modifier le numro du livreur pour les clients ayant command la commande en question
UPDATE Client SET numLivreur = 2 WHERE numCommande = 2 ;
-- Ajout de la date de prise en charge et de livraison de la commande
UPDATE Livreur SET DATELIVRAISON = SYSDATE WHERE numLivreur = 2 ;
-- Une fois la commande livre rechanger l'Etat de la commande
UPDATE Commande SET ETATCOMMANDE = 'Livre' WHERE numcommande = 1 ;

-- Voir ltat des commandes (livreur et producteur)

-- Livreur
SELECT NUMCOMMANDE, ETATCOMMANDE FROM Commande ;

-- Producteur
SELECT NUMCOMMANDE, ETATCOMMANDE FROM Commande ;
-- Etat + livreur affect pour chaque commande
SELECT c.NUMCOMMANDE, c.ETATCOMMANDE, l.NUMLIVREUR, l.NOMLIVREUR, l.PRENOMLIVREUR, l.DATELIVRAISON FROM Commande c, Client cl, Livreur l WHERE c.NUMCOMMANDE = cl.NUMCOMMANDE AND cl.NUMLIVREUR = l.NUMLIVREUR ;

-- Grer les paniers et les produits avec Famille et type de produits (producteur)
INSERT INTO Famille VALUES(4, 'Automne', 'Categorie1') ;
INSERT INTO Famille VALUES(5, 'Printemps', 'Categorie1') ;
insert into TypeProduit values(1, 'Legume');
insert into TypeProduit values(2, 'Fruit');
insert into TypeProduit values(3, 'Autre');
insert into CompoFamille values(1, 4);
insert into CompoFamille values(1, 5);
insert into CompoFamille values(2, 4);
insert into CompoFamille values(2, 5);
-- Produit
-- Ajouter un Produit
INSERT INTO Produit VALUES(3, 'NOMPRODUIT', 5, 0.50, 1) ;
-- Maj un Produit
UPDATE Produit SET nomproduit = 'Courgette', prixproduit = 0.70 WHERE numproduit = 3 ;
UPDATE Produit SET nomproduit = 'Courgette' WHERE numproduit = 3 ;
UPDATE Produit SET prixproduit = 0.70 WHERE numproduit = 3 ;
-- Supprimer un produit
DELETE FROM CompoFamille WHERE numtypeproduit = 1 ;
DELETE FROM TypeProduit WHERE numtypeproduit = 1 ;
DELETE FROM CompoPanier WHERE numProduit = 1 ;
DELETE FROM CommandeProduit WHERE numProduit = 1 ;
DELETE FROM Produit WHERE numproduit = 1 ;
-- Panier
-- Ajouter un Panier
insert into Panier(NUMPANIER, NBPRODUIT, QUANTITE, PRIXPANIER) values (1,4,10, 6);
insert into Panier values (2, 'nomPanier', 5,4,8);
-- Maj un Panier
UPDATE Panier SET nomPanier = 'Panier Hiver', PRIXPANIER = 10, nbproduit = 6 WHERE NUMPANIER = 1 ;
UPDATE Panier SET nomPanier = 'Panier Hiver' WHERE NUMPANIER = 1 ;
UPDATE Panier SET PRIXPANIER = 10 WHERE NUMPANIER = 1 ;
UPDATE Panier SET nbproduit = 6 WHERE NUMPANIER = 1 ;
-- Supprimer un Panier
DELETE FROM CompoPanier WHERE numPanier = 1 ;
DELETE FROM CommandePanier WHERE numPanier = 1 ;
DELETE FROM Panier WHERE NUMPANIER = 1 ;

-- Approvisionner le stock (producteur)

-- Stock de produits
SELECT numProduit, quantite FROM produit WHERE numproduit = 1 ;
UPDATE Produit SET quantite = quantite + 5 WHERE numproduit = 1 ;
-- Stock de paniers
SELECT numPanier, quantite FROM Panier WHERE numPanier = 1 ;
UPDATE Panier SET quantite = quantite + 2 WHERE numPanier = 1 ;

-- Notifier quune commande est prte  tre livre + rinitialiser l'Etat d'une commande hebdomadaire chaque semaine (producteur)
UPDATE Commande SET ETATCOMMANDE = 'Prete  livrer' WHERE numcommande = 1 ;
-- Une fois la commande prte, Mj le stock de produits + paniers
-- Produit
-- Quantit finale = Quantite - qte du produit Commande
SELECT numProduit, quantite FROM produit WHERE numproduit = 1 ;
-- UPDATE Produit SET quantite = quantite - cp.quantite WHERE numproduit = 1 ; 
UPDATE Produit SET quantite = quantite - 2 WHERE numproduit = 1 ; -- exemple
-- Utilisation de la fonction destockage
declare
sf number := 0 ;
begin
sf := destockage(2, 1);
UPDATE Produit SET quantite = quantite - sf WHERE numproduit = 1 ;
end;
/
-- Panier
-- Quantit finale = Quantite - qte de panier Commande
SELECT numPanier, quantite FROM Panier WHERE numPanier = 1 ;
-- UPDATE Panier SET quantite = quantite - cp.quantite WHERE numPanier = 1 ;
UPDATE Panier SET quantite = quantite - 2 WHERE numPanier = 1 ; -- exemple
-- Utilisation de la fonction destockage
declare
sf number := 0 ;
begin
sf := destockage(2, 1);
UPDATE Panier SET quantite = quantite - sf WHERE numPanier = 1 ;
end;
/

-- Inserer villes + Quartiers dans lesquels les livraisons sont possibles

-- Villes
insert into Ville values(1,'nomVille1', 92160);
insert into ville values(2,'nomVille2', 91370);
-- Quartiers
SELECT numVille, nomVille FROM Ville ;
insert into Quartier values(1,'nomQuartierVille1', 1);
insert into Quartier values(2,'nomQuartierVille2',2);
