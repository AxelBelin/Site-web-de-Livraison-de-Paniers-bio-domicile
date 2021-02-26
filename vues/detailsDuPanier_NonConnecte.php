<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Le panier en détail </title>
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

  main {
    background-color: white ;
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
          <li class="nav-item">
            <a class="nav-link" href="connexion.html">Se connecter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="creerCompteProfil.html">Créer un compte</a>
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
<h1>Description du panier</h1>
<p class="titre">Connectez-vous pour commander</p>
</div>

<?php
// Affichage de la photo du panier en recuperant sont nom dans un get

require_once("../modeles/bd.php") ;
require_once("../modeles/panier.php") ;

$cobd = new BD("projettutore") ;
$co = $cobd->connexion() ;

if(isset($_GET["numPanier"]))
{
  $numPanier = $_GET["numPanier"] ;

      $reqProduits = "SELECT nomPanier, nomImg FROM panier WHERE numPanier = '$numPanier'" ;
      $resultProuits = mysqli_query($co, $reqProduits) or die(mysqli_error($co)) ;
      
			if(mysqli_num_rows($resultProuits) >= 1)
			{
			  foreach($resultProuits as $image)
			  {
          echo "<div class='text-center'>" ;
            echo "<img src='../img/".$image['nomImg']."' class='img-fluid' width='200' height='200' alt='".$image['nomPanier']."'>" ;
          echo "</div>" ;
        }
      } else {
        echo "<p><i>Pas d'image pour ce panier</i></p>" ;
      }
} else {
  die("erreur pas de panier sélectionné") ;
}
?>		

		<table class="table table-bordered border-primary">
			<thead>
				<tr>
					<th scope="col">Nom</th>
					<th scope="col">Nombre de produits</th>
					<th scope="col">Contenu</th>
					<th scope="col">Saison</th>
					<th scope="col">Poids(KG)</th>
					<th scope="col">Prix unitaire TTC</th>	
				</tr>
			</thead>
			<tbody>
        <?php

        $tva = 1.2 ;

        $reqInfosPanier = "SELECT panier.nomPanier, panier.nbProduit, compopanier.qteProduitParArt, produit.nomproduit, panier.saison, panier.poids, panier.prixpanier FROM panier, compopanier, produit WHERE panier.numPanier = compopanier.numPanier AND compopanier.numProduit = produit.numProduit AND panier.numPanier = '$numPanier'" ;
        $resultInfosPanier = mysqli_query($co, $reqInfosPanier) or die(mysqli_error($co)) ;
        
        if(mysqli_num_rows($resultInfosPanier) >= 1)
        {
          foreach($resultInfosPanier as $info)
          {
            echo "<tr>" ;
            echo "<td>".$info['nomPanier']."</td>" ;
            echo "<td>".$info['nbProduit']."</td>" ;
            echo "<td><p> - ".$info['nomproduit']."(".$info['qteProduitParArt']." KG)</p></td>" ;
            echo "<td>".$info['saison']."</td>" ;
            echo "<td>".$info['poids']."</td>" ;
            echo "<td>".$tva * $info['prixpanier']." &euro;</td>" ;
            echo "</tr>" ;
          }
        } else {
          $reqInfosPanSansContenu = "SELECT nomPanier, nbProduit, saison, poids, prixpanier FROM panier WHERE numPanier = '$numPanier'" ;
          $resultInfosPanSansCon = mysqli_query($co, $reqInfosPanSansContenu) or die(mysqli_error($co)) ;
        
        if(mysqli_num_rows($resultInfosPanSansCon) >= 1)
        {
          foreach($resultInfosPanSansCon as $info)
          {
            echo "<tr>" ;
            echo "<td>".$info['nomPanier']."</td>" ;
            echo "<td>".$info['nbProduit']."</td>" ;
            echo "<td><p><i>Produits non précisés : contenu secret</i></p></td>" ;
            echo "<td>".$info['saison']."</td>" ;
            echo "<td>".$info['poids']."</td>" ;
            echo "<td>".$tva * $info['prixpanier']." &euro;</td>" ;
            echo "</tr>" ;
          }
        } else {
          echo "<h4>Aucune information disponible sur ce panier</h4>" ;
        }
      }

      ?>
			</tbody>
        </table>
				<div class="text-center">
                <p>
                    <a href="consulterPaniers_NonConnecte.php"><button class="btn btn-primary">Retour</button></a>
                </p>
                </div>
          <hr>
			<a class="help" href="">besoin d'aide?</a>
			<a class="prod" href="connexionProducteur.html">Espace Producteur</a>
			<a class="contact" href="">Contacts</a>

</main>
 </body>
</html>