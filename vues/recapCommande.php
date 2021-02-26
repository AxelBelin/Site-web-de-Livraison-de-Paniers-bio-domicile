<?php

session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Récapitulatif de la commande </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<style>

footer {
    display: flex;
    justify-content: center;
    padding: 15px;
    background-color:#C4C4C4 ;
	color: #fff;
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0 ;
	}

	.help {
		left: 20px;
    justify-content: center;
    padding: 15px;
	}

	.contact {
		right: 20px;
    justify-content: center;
    padding: 15px;
    }
    
    h1, h2, h3, h4 {
        text-align: center ;
		font-style:bold;
    }

    .titre {
        text-align: center ;
    }

    body {
      background-image :url("../img/test.jpg") ;
	    background-size:cover;
    }

    table, main {
    /*border: 3px solid black ; */
    background-color: white ;
  }

  thead {
    background-color: #C4C4C4;
  }

</style>
  </head>
   <body>
   <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="accueil.html">Livraison Paniers Bio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Espace Client</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Modifier mon pseudo</a></li>
            <li><a class="dropdown-item" href="#">Ajouter ou modifier un numéro de CB</a></li>
            <li><a class="dropdown-item" href="#">Mettre à jour mes coordonnées de livraison</a></li>
            <li><a class="dropdown-item" href="#">Mettre à jour mes coordonnées de contact</a></li>
            <li><a class="dropdown-item" href="../controleurs/deconnexionClient.php">Me déconnecter</a></li>
          </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="recapCommande.php">Passer commande</a>
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Consulter...</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="consulterProduits_Client.php">Consuter les produits</a></li>
            <li><a class="dropdown-item" href="consulterPaniers_Client.php">Consulter les paniers</a></li>
          </ul>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Rechercher un panier..." aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Rechercher</button>
        </form>
      </div>
    </div>
  </nav>
    </header>
    <br />
<main>
<div class="position-relative m-5">
  <h1>Recapitulatif de votre commande</h1>
</div>

	<h3> Les Paniers</h3>
	 <table class="table table-bordered border-primary">
			<thead>
			<tr>
				<th scope="col"> Nom</th>
				<th scope="col">Quantité</th>	
        <th scope="col">Prix TTC</th>
        <th scope="col">Ajouter / Retirer</th>
				<th scope="col"> Actions :</th>
			</tr>
			  </thead>
			 <tbody>
       <?php

			 require_once("../modeles/bd.php") ;
			 require_once("../modeles/panier.php") ;
			 require_once("../modeles/produit.php") ;
			 require_once("../modeles/client.php") ;
			 
			 $cobd = new BD("projettutore") ;
       $co = $cobd->connexion() ;
       
       if(isset($_SESSION['numClient']))
       {
        $tva = 1.2 ;
        $numClient = $_SESSION['numClient'] ;

        $reqRecupPanClient = "SELECT client.numCommande, panier.numPanier, panier.nomPanier, commandepanier.quantite, commande.prixtotalnet FROM panier, client, commandepanier, commande WHERE panier.numPanier = commandepanier.numPanier AND commandepanier.numCommande = commande.numCommande AND commande.numCommande = client.numCommande AND client.numClient = '$numClient'" ;
        $resultRecupPanClient = mysqli_query($co, $reqRecupPanClient) or die(mysqli_error($co)) ;
        
        if(mysqli_num_rows($resultRecupPanClient) >= 1)
        {
          foreach($resultRecupPanClient as $pan)
          {
            echo "<tr>" ;
            echo "<td>".$pan['nomPanier']."</td>" ;
            echo "<td>".$pan['quantite']."</td>" ;
            echo "<td>".$pan['prixtotalnet']." &euro;</td>" ;
            echo "<td><form method='post' action='../controleurs/ajouterQtePanierCommande.php'>
			      <input type='number' name='approvisionnerPanier' min='1' max='1000'>
            <input id='prodId' name='prodId' type='hidden' value='".$pan['numPanier']."'>
            <input id='prodId' name='numCo' type='hidden' value='".$pan['numCommande']."'>
            <input type='submit' class='btn btn-success' name='ajouterPaniers' value='+'></form>" ;
            echo "<p><form method='post' action='../controleurs/retirerQtePanierCommande.php'>
			      <input type='number' name='retirerPanier' min='1' max='".$pan['quantite']."'>
            <input id='prodId' name='prodRetId' type='hidden' value='".$pan['numPanier']."'>
            <input id='prodId' name='numCom' type='hidden' value='".$pan['numCommande']."'>
            <input type='submit' class='btn btn-danger' name='retirerPaniers' value='-'></form></p>" ;
			      echo "<td><a href='detailsDuPanier_Client.php?numPanier=".$pan['numPanier']."'><button class='btn btn-outline-warning' name='btnModifierPanier'>Modifier</button></a>
			      <a href='../controleurs/supprimerCommandePanier.php?numCommande=".$pan['numCommande']."'><button class='btn btn-outline-danger'>Suprimmer</button></a>" ;
            echo "</tr>" ;
          }
        } else {
          echo "<h4>Vous n'avez commandé aucun panier pour l'instant</h4>" ;
        }
      } else {
        die("veuillez vou reconnecter session expirée") ;
      }

    ?>
    
			 </tbody>
			 </table>
			 
	 <h3>Les Produits</h3>
			<table class="table table-bordered border-primary">
	 <thead>
			<tr>
				<th cope="col">Nom</th>	
				<th scope="col">Quantité(KG)</th>	
        <th scope="col">Prix TTC</th>
        <th scope="col">Ajouter / Retirer</th>
				<th scope="col">Actions :</th>
			</tr>
			  </thead>
			   <tbody>
         <?php

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;
require_once("../modeles/produit.php") ;
require_once("../modeles/client.php") ;

$cobd = new BD("projettutore") ;
$co = $cobd->connexion() ;

if(isset($_SESSION['numClient']))
{
 $tva = 1.2 ;
 $numClient = $_SESSION['numClient'] ;

 $reqRecupProdCli = "SELECT client.numCommande, produit.numProduit, produit.nomproduit, commandeproduit.quantite, commande.prixtotalnet FROM produit, client, commandeproduit, commande WHERE produit.numProduit = commandeproduit.numProduit AND commandeproduit.numCommande = commande.numCommande AND commande.numCommande = client.numCommande AND client.numClient = '$numClient'" ;
 $resultRecupProdCli = mysqli_query($co, $reqRecupProdCli) or die(mysqli_error($co)) ;
 
 if(mysqli_num_rows($resultRecupProdCli) >= 1)
 {
   foreach($resultRecupProdCli as $prod)
   {
     echo "<tr>" ;
     echo "<td>".$prod['nomproduit']."</td>" ;
     echo "<td>".$prod['quantite']."</td>" ;
     echo "<td>".$prod['prixtotalnet']." &euro;</td>" ;
     echo "<td><form method='post' action='../controleurs/ajouterQteProduitCommande.php'>
     <p>(<i>Exemple: 0.8</i>)</p>
     <input type='text' name='approvisionnerProduit'>
     <input id='prodId' name='prodId' type='hidden' value='".$prod['numProduit']."'>
     <input id='prodId' name='numCo' type='hidden' value='".$prod['numCommande']."'>
     <input type='submit' class='btn btn-success' name='ajouterProduit' value='+'></form>" ;
     echo "<p><form method='post' action='../controleurs/retirerQteProduitCommande.php'>
     <input type='text' name='retirerProduit'>
     <input id='prodId' name='prodRetId' type='hidden' value='".$prod['numProduit']."'>
     <input id='prodId' name='numCom' type='hidden' value='".$prod['numCommande']."'>
     <input type='submit' class='btn btn-danger' name='retirerPaniers' value='-'></form></p>" ;
     echo "<td><a href='consulterProduits_Client.php?numPanier=".$prod['numProduit']."'><button class='btn btn-outline-warning' name='btnModifierPanier'>Modifier</button></a>
     <a href='../controleurs/supprimerCommandeProduit.php?numCommande=".$prod['numCommande']."'><button class='btn btn-outline-danger'>Suprimmer</button></a>" ;
     echo "</tr>" ;
   }
 } else {
   echo "<h4>Vous n'avez commandé aucun produit pour l'instant</h4>" ;
 }
} else {
 die("veuillez vous reconnecter session expirée") ;
}

?>
			 </tbody>
	</table>
    </form>

    <h4>Total Commande TTC : <?php 
    if(isset($pan['prixtotalnet']))
    {
      $numCommande = $pan['numCommande'] ;
      $totalPaniers = $pan['prixtotalnet'] ;
      echo $totalPaniers."&euro;";
    }

    if(isset($prod['prixtotalnet']))
    {
      $numCommande = $prod['numCommande'] ;
      $totalProduits = $prod['prixtotalnet'] ;
      echo $totalProduits."&euro;";
    }
    
    ?></h4>
    <p></p>
    <br />
    <div class="container">
			<div class="row">
			  <div class="col-lg-auto">
				<div class="position-absolute start-50 translate-middle">
    <?php 
    if(isset($numCommande))
    {
      echo "<a href='configurationCommande.php?numCommande=".$numCommande."'><button class='btn btn-primary' name='btnPayement'> Détails et payements ></button></a>" ;
    } else {
      echo "<h4> Vous n'avez commandez aucun article pour le moment </h4>" ;
    }

    ?>
                </div>
                </div>
                </div>
                </div>
    
</main>
	<hr>
			<a class="help" href="">besoin d'aide?</a>
			<a class="prod" href="connexionProducteur.html">Espace Producteur</a>
			<a class="contact" href="">Contacts</a>
 </body>
</html>