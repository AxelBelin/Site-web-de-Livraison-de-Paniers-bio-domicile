set serveroutput on;

Create Table Famille(
numFamille number(4) primary key,
saison varchar(30) not null,
categorie VARCHAR(30) not null
);

Create table TypeProduit(
numTypeProduit number(4) primary key,
nomtypeproduit varchar(30)not null
);

Create table Compte(
numCompte number(4) primary key,
profil varchar(30) not null,
indentifiant varchar(30) not null,
motdepasse varchar(30) not null,
numCB varchar(30)
);

Create table Ville (
numVille number(4) primary key,
nomville varchar(30) not null,
CP NUMBER(5) NOT NULL
);

Create table Panier (
numPanier number(4) primary key,
nomPanier VARCHAR2(60),
nbProduit varchar(30) not null,
quantite number(4) not null,
prixpanier number(4) not null,
CONSTRAINT CK_nbProduit_Panier CHECK(nbProduit > 0),
CONSTRAINT CK_quantite_Panier CHECK(quantite >= 0),
CONSTRAINT CK_prixpanier_Panier CHECK(prixpanier > 0)
);

Create table Commande(
numCommande number(4) primary key,
commandegroupe number(1),
jourlivrasion varchar(30),
hebdomadaire number(1),
etatCommande VARCHAR2(60),
datecommande DATE not null, --Trigger
prixTotal float(32) not null,
TVA float(4) NOT NULL,
prixtotalnet float(30) not null,
CONSTRAINT CK_prixTotal_Commande CHECK(prixtotal > 0),
CONSTRAINT CK_TVA_Commande CHECK(TVA >= 1),
CONSTRAINT CK_prixtotalnet_Commande CHECK(prixtotalnet >= prixtotal)
);

Create table CompoFamille (
numTypeProduit number(4)not null,
numFamille number(4)not null,
constraint pk_compofamille PRIMARY KEY(numTypeProduit, numFamille),
constraint FK_cftypeproduit foreign key (numTypeProduit) references TypeProduit,
constraint FK_cffamille foreign key (numFamille) references Famille
);

Create table CommandePanier (
numCommande number(4),
numPanier number(4),
quantite number(4) not null,
constraint pk_commandepanier PRIMARY KEY(numCommande, numPanier),
constraint FK_cpcommander foreign key (numCommande) references Commande,
constraint FK_cppanier foreign key (numPanier) references Panier,
CONSTRAINT CK_quantite_CommandePanier CHECK(quantite >= 1)
);

create table Quartier (
numCartier number(4) primary key,
nomCartier varchar(30) not null,
numVille number(4),
constraint FK_ville foreign key(numVille) references Ville
);

create table Livreur (
numLivreur number(4) primary key,
nomlivreur VARCHAR2(60) not null,
prenomLivreur VARCHAR2(50) NOT NULL,
datelivraison DATE, --Trigger
telLivreur varchar(30) not null,
mailLivreur varchar(100) not null,
numCompte number(4),
constraint FK_livcompte foreign key(numCompte) References Compte
);

create table Produit (
numProduit number(4) primary key,
nomproduit varchar(30) not null,
quantite number(4),
prixproduit float(4) not null,
numTypeProduit number(4),
constraint FK_protypeproduit foreign key (numTypeProduit) references TypeProduit,
CONSTRAINT CK_quantite_Produit CHECK(quantite >= 0),
CONSTRAINT CK_prixproduit_Produit CHECK(prixproduit > 0)
);

create table CompoPanier(
numPanier number(4) not null,
numProduit number(4) not null,
constraint pk_compopanier primary key(numPanier, numProduit),
constraint FK_cpapanier foreign key(numPanier) references Panier,
constraint FK_cpaproduit foreign key(numProduit) references Produit
);

create table CommandeProduit (
numCommande number(4) not null,
numProduit number(4) not null,
quantite number(4) not null,
constraint pk_commandeproduit primary key(numCommande, numProduit),
constraint FK_coprocommande foreign key(numCommande) references Commande,
constraint FK_coproproduit foreign key(numProduit) references Produit,
CONSTRAINT CK_quantite_CommandeProduit CHECK(quantite >= 1)
);

create table Client (
numClient number(4) primary key,
nomclient varchar(30) not null,
prenomclient varchar(30) not null,
mail varchar(100) not null,
adresse varchar(100) not null,
limitdeprix float(4),
tel varchar(30) not null,
groupe number(4),
numLivreur number(4),
numCommande number(4),
numCartier number(4),
numCompte number(4),
constraint FK_clilivreur foreign key(numLivreur) references Livreur,
constraint FK_clicommande foreign key(numCommande) references Commande,
constraint FK_clicartier foreign key(numCartier) references Quartier,
constraint FK_clicompte foreign key (numCompte) references Compte,
CONSTRAINT CK_groupe_Client CHECK(groupe >= 2),
CONSTRAINT CK_limitdeprix_Client CHECK(limitdeprix >= 1)
);

----INSERT 

--1.Famille
insert into Famille  values (1,'été', 'fruit rouge');
insert into Famille values(2,'hiver', 'soup');
insert into Famille values(3,'été','gateaux aux fraise');

--2.TypeProduit
insert into TypeProduit values(1, 'Legume');
insert into TypeProduit values(2, 'Fruit');

--3.Produit
insert into Produit values (1, 'Fraise', 5, 2,1);
insert into Produit values (2, 'Carrot', 5, 2,2);

--4.CompoFamille
insert into CompoFamille values(1,1);
insert into CompoFamille values (2,2);
insert into CompoFamille values (1,3);

--5.Panier
insert into Panier(NUMPANIER, NBPRODUIT, QUANTITE, PRIXPANIER) values (1,4,10, 6);
insert into Panier values (2, 'Panier Hiver', 5,4,8);

--6.CompoPanier
Insert into CompoPanier values (1,1);
Insert into CompoPanier values (1,2);
Insert into CompoPanier values (2,1);
Insert into CompoPanier values (2,2);

--7. Commande
Insert into Commande values(8, 0,null, 0, 'Livree', '11-10-2020',20,1.2,25);
insert into Commande Values(9,0,'mardi',1, 'Prete à livrer', '12/25/2020',12,1.2,26);
insert into Commande values(10,1,null,null, 'Livraison en cours', '12/21/2020',15,1.2,17);

--8. CommandePanier
insert into CommandePanier values(1,1,2);
insert into CommandePanier values(2,2,2);

--9. CommandeProduit
insert into CommandeProduit values(1,2,2);
insert into CommandeProduit values(2,1,3);
--10. Ville
insert into Ville values(1,'Antony', 92160);
insert into ville values(2,'Sceaux', 92162);
--11. Quartier
insert into Quartier values(1,'Les Baconnets', 1);
insert into Quartier values(2,'Les Balgis',2);

--12. Compte
insert into Compte values (1,'natsu', 'Livreur', '123455Nat','78965464465');
insert into Compte values (2,'tsuna', 'Livreur', '54321Ust','7896464652798');
insert into Compte values (3,'toto', 'Client', 'toto123','789646454652798');
insert into Compte values (4,'tata', 'Client', 'tata321','7896464454652798');
--13. Livreur
insert into Livreur values(1,'ENDTURISMA', 'Nauval', '12/29/2020', '123456878','end13@end.com',1);
insert into Livreur values(3,'end13', 'Axel', '12/27/2020', '87654321','end12@end.com',2);
--14 Client
insert into Client Values(1, 'tutu', 'toto','toto123@t.com', '888 rue tto',10,'707012', 2, 1,1,2,3);
insert into Client Values(2, 'tete', 'tata','tata321@t.com', '777 rue tta',8,'707012', 3, 1,2,1,4);
---DROP TABLE
drop table Client;
drop table CommandeProduit;
drop table CompoPanier;
drop table Produit;
drop table Livreur;
drop table Quartier;
drop table CommanderPanier;
drop table CommandePanier;
drop table CompoFamille;
drop table Commande;
drop table Panier;
drop table Ville;
drop table Compte;
drop table TypeProduit;
drop table Famille;

---Vérification contenu des tables
Select * from Client;
Select * from CommandeProduit;
Select * from CompoPanier;
Select * from Produit;
Select * from Livreur;
Select * from Quartier;
Select * from CommandePanier;
Select * from CompoFamille;
Select * from Commande;
Select * from Panier;
Select * from Ville;
Select * from Compte;
Select * from TypeProduit;
Select * from Famille;

---VUES---
--1. Vue Client
Create view VueClient as
select *
FROM Client;
--2. Vue CommandeProduit
Create view VueCommandeProduit as
Select *
from CommandeProduit;
--3. vue CompoPanier
Create view VueCompoPanier as 
Select *
from CompoPanier;
--4. Vue Produit
Create View VueProduit as 
Select *
from Produit;
--5. vue Livreur
Create view VueLivreur as
Select * 
From Livreur;
--6. vue Quartier
Create view VueQuartier as
Select * 
from Quartier;
--7. vue CommandePanier
Create View VueCommandePanier as
Select * 
from CommandePanier;
--8. Vue CompoFamille
Create view VueCompoFamille as
Select * 
from CompoFamille;
--9. vue Commande
Create view VueCommande as
Select * 
from Commande;
--10. vue Panier
Create view VuePanier as
Select * 
from Panier;
--11. vue Ville
Create view VueVille as 
Select * 
from Ville;
--12. vue Compte
Create view VueCompte as
Select numCompte, profil, indentifiant 
From Compte;
--13. vue TypeProduit
Create view VueTypeProduit as
Select *
from TypeProduit;
--14. vue Famille
Create view VueFamille as
Select * 
from Famille;

---Drop View
drop view VueClient;
drop view VueCommandeProduit;
drop view VueCompoPanier;
drop view VueProduit;
drop view VueLivreur;
drop view VueQuartier; 
drop view VueCommandePanier;   
drop view VueCompoFamille;
drop view VueCommande;
drop view VuePanier;
drop view VueVille;
drop view VueCompte;
drop view VueTypeProduit;  
drop view VueFamille;

-- Vérification contenu des vues
select * from VueClient;
select * from VueCommandeProduit;
select * from VueCompoPanier;
select * from VueProduit;
select * from VueLivreur;
select * from VueQuartier; 
select * from VueCommandePanier;   
select * from VueCompoFamille;
select * from VueCommande;
select * from VuePanier;
select * from VueVille;
select * from VueCompte;
select * from VueTypeProduit;  
select * from VueFamille;

-- Triggers / déclencheurs

-- Table produit
create or replace function nomProd(numProd Produit.numProduit%type)
return VARCHAR
is
nom varchar(30) ;
Begin
SELECT nomProduit into nom
FROM Produit
WHERE numProduit = numProd ;
return nom ;
end;
/
-- select nomProd(1) from dual;
create or replace function destockage(qteAEnlever Produit.quantite%type, numProd Produit.numProduit%type)
return VARCHAR
is
qteFinale number(4) ;
Begin
SELECT quantite into qteFinale
FROM Produit
WHERE numProduit = numProd ;
qteFinale := qteFinale - qteAEnlever ;
return qteFinale ;
end;
/
-- select destockage(2, 1) from dual ;
-- Version message d'alerte : 2 triggers
CREATE OR REPLACE TRIGGER MessageQteProduit
Before update
on Produit for each row
declare
numPro number(4) := :new.numProduit ;
begin
if :new.quantite = 0
    then dbms_output.put_line('Attention, il ne reste plus aucun produit numéro '||numPro||' en stock') ;
end if;
end;
/

CREATE OR REPLACE TRIGGER MessageMemeNomProduit
Before insert
on Produit for each row
declare
nb number :=0;
begin
select count(*) into nb
from Produit
where :old.nomproduit = :new.nomproduit ; -- ou When
if nb > 0 then
dbms_output.put_line('Attention, un produit ayant ce nom existe deja');
end if;
end;
/
-- Version bloquante du Trigger : MessageQteProduit
CREATE OR REPLACE TRIGGER blocQteProduit
Before update
on Produit for each row
begin
if :new.quantite < 0
    then raise_application_error(-20001, 'Alerte, plus de stock disponible pour ce produit');
end if;
end;
/

-- Tests des triggers sur la table Produit
UPDATE Produit SET quantite = 0 WHERE numProduit = 1 ;

-- Table Panier

-- Version message d'alerte
CREATE OR REPLACE TRIGGER MessageQtePanier
Before update
on Panier for each row
declare
numPan number(4) := :new.numPanier ;
begin
if :new.quantite = 0
    then dbms_output.put_line('Attention, il ne reste plus aucun Panier numéro '||numPan||' en stock') ;
end if;
end;
/

-- Version bloquante du Trigger : MessageQtePanier
CREATE OR REPLACE TRIGGER blocQtePanier
Before update
on Panier for each row
begin
if :new.quantite < 0
    then raise_application_error(-20002, 'Alerte, ce panier nest plus disponible en stock') ;
end if;
end;
/

-- Tests des triggers sur la table Panier
UPDATE Panier SET quantite = 0 WHERE numPanier = 1 ;
UPDATE Panier SET quantite = -1 WHERE numPanier = 1 ;

-- Table Livreur

-- Version message d'alerte : 2 triggers
CREATE OR REPLACE TRIGGER MessageSansDateLivraison
Before Insert
on Livreur for each row
declare
nomLiv VARCHAR2(60) := :new.nomlivreur ;
begin
if :new.dateLivraison is null
    then dbms_output.put_line('Livreur '||nomLiv||' sans livraison') ;
end if;
end;
/

CREATE OR REPLACE TRIGGER MessageDateLivraison
Before update
on Livreur for each row
declare
nomLiv VARCHAR2(60) := :new.nomlivreur ;
begin
if months_between (:old.dateLivraison, :new.dateLivraison) > 1
    then dbms_output.put_line('Le livreur '||nomLiv||' na pas fait de livraison depuis plus dun mois') ;
end if;
end;
/
-- Version bloquante des Triggers
CREATE OR REPLACE TRIGGER BlocLivraisonEnCours
Before Update
on Livreur for each row
begin
if :new.dateLivraison < :old.dateLivraison
    then raise_application_error(-20003, 'Livraison déja en cours ou date incohérente saisie');
end if;
end;
/

CREATE OR REPLACE TRIGGER BlocDateLivraison
Before update
on Livreur for each row
begin
if months_between (:old.dateLivraison, :new.dateLivraison) > 1
    then raise_application_error(-20004, 'Le livreur na pas fait de livraison depuis plus dun mois') ;
end if;
end;
/

-- Tests des triggers sur la table Livreur
insert into Livreur (numLivreur, nomlivreur, prenomLivreur, telLivreur, mailLivreur, numCompte) values(2,'end12', 'Axel', '87654321','end12@end.com',2);
UPDATE Livreur SET dateLivraison = '11/28/2019' WHERE numLivreur = 1 ;

-- Table Commande

-- Version message d'alerte : 2 Triggers
CREATE OR REPLACE TRIGGER MessageMauvaiseDateCommande
Before INSERT or update
on Commande for each row
begin
if :new.datecommande > SYSDATE
    then dbms_output.put_line('Attention, date incohérente') ;
end if;
end;
/

CREATE OR REPLACE TRIGGER MessageDateCommande
Before update
on Commande for each row
declare
numComm number(4) := :new.numCommande ;
begin
if months_between (:old.datecommande, :new.datecommande) > 1
    then dbms_output.put_line('Attention, tentative de changement de date de commande de plus dun mois sur la commande '||numComm) ;
end if;
end;
/

-- Version bloquante des Triggers
CREATE OR REPLACE TRIGGER BlocMauvaiseDateCommande
Before INSERT or update
on Commande for each row
begin
if :new.datecommande > SYSDATE
    then raise_application_error(-20005, 'Attention, date de commande incohérente');
end if;
end;
/

CREATE OR REPLACE TRIGGER BlocDateCommande
Before update
on Commande for each row
begin
if months_between (:old.datecommande, :new.datecommande) > 1
    then raise_application_error(-20006, 'Alerte, tentative de changement de date dune commande de plus dun mois') ;
end if;
end;
/

-- Tests des triggers sur la table Commande
insert into Commande Values(2,0,'mardi',1,'Prete à livrer', '02/28/2021',12,1.2,15);
UPDATE Commande SET datecommande = '11-10-2020' WHERE numCommande = 1 ;