<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Gérer les stocks </title>
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

    table {
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
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Espace Producteur</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Modifier mon identifiant</a></li>
            <li><a class="dropdown-item" href="../controleurs/deconnexionProducteur.php">Me déconnecter</a></li>
          </ul>
		  </li>
		  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Ajouter une article</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
				<li><a class="dropdown-item" href="ajouterfamille.html">Ajouter une famille de produits</a></li>
            <li><a class="dropdown-item" href="ajouterproduit.html">Ajouter un produit</a></li>
			</ul>  
		</li>
		  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Gérer panier</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="ajouterpanier.html">Ajouter un panier</a></li>
            <li><a class="dropdown-item" href="composerPanier.php">Composer un panier</a></li>
			</ul>  
		</li>
          <li class="nav-item">
            <a class="nav-link" href="gererStock.php">Gérer les stocks</a>
		  </li>
		  <li class="nav-item">
            <a class="nav-link" href="consulterCommande_Producteur.php" id="navbarDropdown">Consulter les commandes</a>
		  </li>
		  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Ajouter une ville</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="ajouterVille.html">Ajouter une Ville</a></li>
            <li><a class="dropdown-item" href="ajouterQuartier.php">Ajouter un quartier</a></li>
			</ul>  
		</li>
        </ul>
      </div>
    </div>
  </nav>
    </header>
    <br />
<main>
	<div class="position-relative m-5">
    <h1> Récapitulatif de votre Stock</h1>
  </div>

    <h3> Les Paniers</h3>
    
    <form method="post" action="">
	 <table class="table table-bordered border-primary">
			<thead>
			<tr>
				<th scope="col"> Nom</th>	
				<th scope="col"> Quantité Stock</th>	
				<th scope="col"> Prix unitaire HT</th>
				<th scope="col"> Approvisionner Stock</th>
				<th scope="col"> Autres Actions :</th>
			</tr>
			  </thead>
			 <tbody>
			 <?php
			 require_once("../modeles/bd.php") ;
			 require_once("../modeles/panier.php") ;
			 require_once("../modeles/produit.php") ;
			 require_once("../modeles/producteur.php") ;
			 
			 $cobd = new BD("projettutore") ;
			 $co = $cobd->connexion() ;

			$reqInfosPan = "SELECT numPanier, nomPanier, quantite, prixpanier FROM panier ORDER BY nomPanier" ;
          	$resultInfosPan = mysqli_query($co, $reqInfosPan) or die(mysqli_error($co)) ;
        
        if(mysqli_num_rows($resultInfosPan) >= 1)
        {
          foreach($resultInfosPan as $info)
          {
            echo "<tr>" ;
            echo "<td>".$info['nomPanier']."</td>" ;
            echo "<td>".$info['quantite']."</td>" ;
			echo "<td>".$info['prixpanier']." &euro;</td>" ;
			echo "<td><form method='post' action='../controleurs/approvisionnerStockPanier.php'>
			<input type='number' name='approvisionnerPanier' min='1' max='1000'>
			<input id='prodId' name='prodId' type='hidden' value='".$info['numPanier']."'>
			<input type='submit' class='btn btn-success' name='ajouterPaniers' value='+'></form></td>" ;
			echo "<td><a href='detailsDuPanier_Client.php?numPanier=".$info['numPanier']."'><button class='btn btn-outline-warning' name='modifPanier'>Modifier</button></a>
			<a href='../controleurs/supprimerPanierEntier.php?numPanier=".$info['numPanier']."'><button class='btn btn-outline-danger'>Suprimmer</button></a>" ;
            echo "</tr>" ;
          }
        } else {
          echo "<h4>Aucun panier en stock</h4>" ;
        }

		?>
			 </tbody>
			 </table>
			 
	 <h3> Les Produits</h3>	
			<table class="table table-bordered border-primary">
	 <thead>
			<tr>
				<th scope="col"> Nom</th>	
				<th scope="col"> Quantité en Stock en KG</th>
				<th scope="col"> Prix au KG HT</th>
				<th scope="col"> Approvisionner Stock en KG</th>
				<th scope="col"> Autres Actions :</th>
			</tr>
			  </thead>
			   <tbody>

			   <?php

			   $reqInfosPro = "SELECT numProduit, nomproduit, quantite, prixproduit FROM produit" ;
			   $resultInfosPro = mysqli_query($co, $reqInfosPro) or die(mysqli_error($co)) ;
		 
		 if(mysqli_num_rows($resultInfosPro) >= 1)
		 {
		   foreach($resultInfosPro as $pro)
		   {
			 echo "<tr>" ;
			 echo "<td>".$pro['nomproduit']."</td>" ;
			 echo "<td>".$pro['quantite']."</td>" ;
			 echo "<td>".$pro['prixproduit']." &euro;</td>" ;
			 echo "<td><form method='post' action='../controleurs/approvisionnerStockProduit.php'>
			 <p>(<i>Exemple: 0.8</i>)</p>
			 <input type='text' name='approvisionnerProduit'>
			 <input id='prodId' name='produitId' type='hidden' value='".$pro['numProduit']."'>
			 <input type='submit' class='btn btn-success' name='ajouterProduit' value='+'>
			 </form></td>" ;
			 echo "<td><a href='Page.php?numProduit=".$pro['numProduit']."'><button class='btn btn-outline-warning' name='modifProduit'>Modifier</button></a>
			 <a href='../controleurs/supprimerProduitEntier.php?numProduit=".$pro['numProduit']."'><button class='btn btn-outline-danger' name='supprimmerProduit'>Suprimmer</button></a></td>" ;
			 echo "</tr>" ;
		   }
		 } else {
		   echo "<h4>Aucun panier en stock</h4>" ;
		 }
		?>

			 </tbody>
	</table>
    </form>
</main>
		<hr>
         <a class="help" href="">besoin d'aide?</a>
         <a class="prod" href="connexionProducteur.html">Espace Producteur</a>
         <a class="contact" href="">Contacts</a>
 </body>
 
</html>