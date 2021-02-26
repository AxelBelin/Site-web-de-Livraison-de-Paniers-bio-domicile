<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Consulter les paniers </title>
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
    
    h1 {
        text-align: center ;
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
        <form class="d-flex" method="post" action="rechercherPanier.php">
          <input class="form-control me-2" type="search" name="barre" placeholder="Rechercher un panier..." aria-label="Search">
          <button class="btn btn-outline-success" name="valider" type="submit">Rechercher</button>
        </form>
      </div>
    </div>
  </nav>
    </header>
    <br />
<main>
<div class="position-relative m-5">
  <h1>Consulter les paniers Bio</h1>
</div>
	<form method="post" action="">
		
		<table class="table">
		<thead>
			<tr>
			<th>Rechercher par nombre de produits dans le panier :</th>
			<th>Trier par poids maximum KG :</th>
			<th>limite de prix (en euros) :</th>
			</tr>
		</thead>
		<tbody>
				<tr>
				<td>
                    <input type="number" name="nbMaxProduits">
				</td>
				<td>
			<Select name="slectSaison">
					<option value="nulle">Séléctionnez un poids max KG...</option>
					<option value="1_5">1,5 KG</option>
					<option value="3">3 KG</option>
					<option value="5">5 KG</option>
                    <option value="8">8 KG</option>
                    <option value="10">10 KG</option>
			</select>
				</td>
				<td>
					<input type="number" name="limiteprix">
                </td>
                <td>
                    <input type="submit" class="btn btn-success" name="soumettre" value="soumettre">
                </td>
				</tr>
		</tbody>
		</table>
    </form>
    
    <div class="position-relative m-5">
    <div class="container">
      <br />
      <div class='row'>
    <?php
    // Affichage des produits : photo + description maquette
    require_once("../modeles/bd.php") ;
    require_once("../modeles/panier.php") ;
			$cobd = new BD("projettutore") ;
			$co = $cobd->connexion() ;

			$tva = 1.2 ;

			$reqProduits = "SELECT numPanier, nomImg, nomPanier, prixpanier, quantite FROM panier WHERE quantite > 2" ;
      $resultProuits = mysqli_query($co, $reqProduits) or die(mysqli_error($co)) ;
      
			if(mysqli_num_rows($resultProuits) >= 1)
			{
			  foreach($resultProuits as $panier)
			  {
          echo "<div class='col-lg-3'>" ;
            echo "<div class='position-relative m-5'>" ;
               echo "<img src='../img/".$panier['nomImg']."' class='bd-placeholder-img' width='140' height='140' alt='".$panier['nomPanier']."'>" ;
               echo "</div>" ;
               echo "<p></p>" ;
               echo "<p> Nom : ".$panier['nomPanier']."</p>" ;
               echo "<p> Prix unitaire : ".$tva*$panier['prixpanier']." &euro; TTC</p>" ;
               echo "<p> Quantité en stock : ".$panier['quantite']."</p>" ;
               echo "<p><form method='post' action='../controleurs/commanderPanier.php'>
        <label for='test'class='form-label'> quantité :</label>
        <input type='number' name='qte' min='1' max='".$panier['quantite']."'>
        <input id='prodId' name='prodId' type='hidden' value='".$panier['numPanier']."'>
        <p></p>
        <input type='submit' name='valid' class='btn btn-outline-primary' value='Commander'> </form></p>" ;
              echo "<p><a href='detailsDuPanier_Client.php?numPanier=".$panier['numPanier']."'><button class='btn btn-outline-primary'>Détails</button></a></p>" ;
              echo "</div>" ;
        }
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