<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Descriptif de commande </title>
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

    .col-lg-3 {
      border: 1px solid black ;
      background-color: white ;
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
<main>
    <br />
	<div class="position-relative m-5">
    <h1> Déscriptif de la commande n°<?php echo $_POST['prodDetailId'] ?></h1>
  </div>

		 <h3> Les Paniers</h3>
	 <table class="table table-bordered border-primary">
			<thead>
			<tr>
				<th scope="col"> Nom</th>	
				<th scope="col"> Quantité </th>	
				<th scope="col"> Prix HT</th>
				<th scope="col"> Contenu<th>
			</tr>
        </thead>
        <tbody>
          <?php
          require_once("../modeles/bd.php") ;
          require_once("../modeles/panier.php") ;
          require_once("../modeles/client.php") ;
          
          $numCommande = $_POST['prodDetailId'] ;

          $cobd = new BD("projettutore") ;
          $co = $cobd->connexion() ;

        $reqRecupInfosPanier = "SELECT numPanier, quantite FROM commandepanier WHERE numCommande = '$numCommande'" ;
        $resultRecupInfosPanier = mysqli_query($co, $reqRecupInfosPanier) or die(mysqli_error($co)) ;
        
        if(mysqli_num_rows($resultRecupInfosPanier) >= 1)
        {
          foreach($resultRecupInfosPanier as $pan)
          {
            $numPanier = $pan['numPanier'] ;
            $qte = $pan['quantite'] ;
          }

          $reqInfosPanier = "SELECT panier.nomPanier, compopanier.qteProduitParArt, produit.nomproduit, panier.prixpanier FROM panier, compopanier, produit WHERE panier.numPanier = compopanier.numPanier AND compopanier.numProduit = produit.numProduit AND panier.numPanier = '$numPanier'" ;
        $resultInfosPanier = mysqli_query($co, $reqInfosPanier) or die(mysqli_error($co)) ;
        
        if(mysqli_num_rows($resultInfosPanier) >= 1)
        {
          foreach($resultInfosPanier as $info)
          {
            echo "<tr>" ;
            echo "<td>".$info['nomPanier']."</td>" ;
            echo "<td>".$qte."</td>" ;
            echo "<td>".$info['prixpanier']." &euro;</td>" ;
            echo "<td><p> - ".$info['nomproduit']."(".$info['qteProduitParArt']." KG)</p></td>" ;
            echo "</tr>" ;
          }
        } else {
          echo "<h4>Aucun panier dans cette commande</h4>" ;
        }

        } else {
          echo "<h4> erreur impossible de récupérer les infos du panier </h4>" ;
        }

          ?>
  
        </tbody>
      </table>
              
     <h3> Les Produits</h3>	
     
     <table class="table table-bordered border-primary">
	 <thead>
			<tr>
				<th scope="col"> Nom</th>	
				<th scope="col"> Quantité en KG</th>	
				<th scope="col"> Prix HT</th>
				
			</tr>
        </thead>
        <tbody>
          <?php

          $reqRecupInfosProduit = "SELECT produit.nomproduit, commandeproduit.quantite, produit.prixproduit FROM commandeproduit, produit WHERE produit.numProduit = commandeproduit.numProduit AND commandeproduit.numCommande = '$numCommande'" ;
          $resultRecupInfosProduit = mysqli_query($co, $reqRecupInfosProduit) or die(mysqli_error($co)) ;
          
          if(mysqli_num_rows($resultRecupInfosProduit) >= 1)
          {
            foreach($resultRecupInfosProduit as $prod)
            {
              echo "<tr>" ;
              echo "<td>".$prod['nomproduit']."</td>" ;
              echo "<td>".$prod['quantite']."</td>" ;
              echo "<td>".$prod['prixproduit']." &euro;</td>" ;
              echo "</tr>" ;
            }
          } else {
            echo "<h4>Aucun produit dans cette commande</h4>" ;
          }

          ?>
        </tbody>
			  </table>
			 <h3> Coordonnées Client + Livreur</h3>		
			 <table class="table table-bordered border-primary">
	 <thead>
			<tr>
				<th scope="col"> Client</th>	
				<th scope="col"> Livreur</th>	
        </thead>
        <tbody>
          <?php

          $reqRecupCoo = "SELECT nomclient, prenomclient, adresse, CP FROM client, quartier, ville WHERE client.numCartier = quartier.numCartier AND quartier.numVille = ville.numVille AND client.numCommande = '$numCommande'" ;
          $resultRecupCoo = mysqli_query($co, $reqRecupCoo) or die(mysqli_error($co)) ;
          
          if(mysqli_num_rows($resultRecupCoo) >= 1)
          {
            foreach($resultRecupCoo as $client)
            {
              echo "<tr>" ;
              echo "<td>" ;
              echo "<p> - Nom : ".$client['nomclient']."</p>" ;
              echo "<p> - Prénom : ".$client['prenomclient']."</p>" ;
              echo "<p> - adresse : ".$client['adresse']."</p>" ;
              echo "<p> - Code Postal : ".$client['CP']."</p>" ;
              echo "</td>" ;
              echo "<td>" ;
              echo "<p> - Nom : </p>" ;
              echo "<p> - Prénom : </p>" ;
              echo "<p> - mail : </p>" ;
              echo "<p> - tél : </p>" ;
              echo "</td>" ;
              echo "</tr>" ;
            }
          } else {
            echo "<h4>Impossible de récupérer les coordonnées du client</h4>" ;
          }
          ?>
        </tbody>
              </table>

              <h4>Total commande : <?php

              $tva = 1.2 ;

              if(isset($info['prixpanier']))
              {
                $prixUnitaireHTPan = $info['prixpanier'] ;
                $prixTotalHTPan = $qte * $prixUnitaireHTPan ;

                $prixTotalTTCpan = $prixTotalHTPan * $tva ;

                echo $prixTotalTTCpan."&euro; TTC | ".$prixTotalHTPan."&euro; HT";
              }
          
              if(isset($prod['prixproduit']))
              {
                $prixUnitaireHTProd = $prod['prixproduit'] ;
                $prixTotalHTProd =  $prod['quantite'] * $prixUnitaireHTProd ;

                $prixTotalTTCProd = $prixTotalHTProd * $tva ;

                echo $prixTotalTTCProd."&euro; TTC | ".$prixTotalHTProd."&euro; HT";
              }
              ?></h4>
              <p></p>

              <div class="text-center">
	<a href="consulterCommande_Producteur.php"><button class="btn btn-primary"> < Retour</button></a>
  <button class="btn btn-primary "> Mettre un rappel chaque semaine(hebdomadaire)</button>
              </div>
	
	</main>
		<hr>
         <a class="help" href="">besoin d'aide?</a>
         <a class="prod" href="connexionProducteur.html">Espace Producteur</a>
         <a class="contact" href="">Contacts</a>
 </body>
</html>