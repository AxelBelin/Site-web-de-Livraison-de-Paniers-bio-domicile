<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Validation Commande </title>
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
		position: absolute;
		left: 20px;
	}

	.contact {
		position: absolute;
		right: 20px;
    }
    
    h1, h3, h4 {
        text-align: center ;
    }

    .titre {
        text-align: center ;
    }

    .formCli {
		padding: 5px;
		margin: 5px;
		height: 200px;
  		width: auto ;
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
  <h1>Encore quelques détails avant de pouvoir payer...</h1>
  <h3> Votre Commande</h3>
</div>
	 <table class="table table-bordered border-primary">
			<thead>
			<tr>
				<th scope="col"> Numero de commande</th>	
				<th scope="col"> Nombre Total d'article / Quantité d'articles en KG</th>	
				<th scope="col"> Total Commande TTC</th>
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

if(isset($_GET["numCommande"]))
{
  $numCommande = $_GET["numCommande"] ;

      $reqVerifPanier = "SELECT commandepanier.quantite, commande.prixtotalnet FROM commande, commandepanier WHERE commandepanier.numCommande = commande.numCommande AND commande.numCommande = '$numCommande'" ;
      $resultVerifPanier = mysqli_query($co, $reqVerifPanier) or die(mysqli_error($co)) ;

      if(mysqli_num_rows($resultVerifPanier) >= 1)
			{
			  foreach($resultVerifPanier as $panier)
			  {
          echo "<tr>" ;
          echo "<td>".$numCommande."</td>" ;
          echo "<td>".$panier['quantite']."</td>" ;
          echo "<td>".$panier['prixtotalnet']."</td>" ;
          echo "</tr>" ;
        }
      } else {
          $reqProduits = "SELECT commandeproduit.quantite, commande.prixtotalnet FROM commande, commandeproduit WHERE commandeproduit.numCommande = commande.numCommande AND commande.numCommande = '$numCommande'" ;
          $resultProuits = mysqli_query($co, $reqProduits) or die(mysqli_error($co)) ;
      
			if(mysqli_num_rows($resultProuits) >= 1)
			{
			  foreach($resultProuits as $produit)
			  {
          echo "<tr>" ;
          echo "<td>".$numCommande."</td>" ;
          echo "<td>".$produit['quantite']." KG</td>" ;
          echo "<td>".$produit['prixtotalnet']."</td>" ;
          echo "</tr>" ;
        }
      } else {
        die("aucune commande selectionnée") ;
      }
      }
} else {
  die("erreur impossible de valider la commande") ;
}
?>
			 </tbody>
             </table>

             <br />

             <div class="container">
			<div class="row">
			  <div class="col-lg-auto">
				<div class="position-absolute top-50 start-50 translate-middle">
        <br />
    <form class="formCli" method="post" action="../controleurs/validationCommandeClient.php">
    <div class="mb-3">
				<p>
                    <label for="lblgroupe" class="form-label">Choisir * :</label>
                    <p></p>
                    <input type="radio" name="choixGroupe" value="groupee">
                    <label>Commande groupée</label>
                    <p></p>
                    <input type="radio" name="choixGroupe" value="seule">
                    <label>commande pour un client</label>
                </p>
    </div>
    <div class="mb-3">
				<p>
                    <label for="lblhebdo" class="form-label">Choisir * :</label>
                    <p></p>
                    <input type="radio" name="choixHebdo" value="ponctuelle">
                    <label>Commande ponctuelle</label>
                    <p></p>
                    <input type="radio" name="choixHebdo" value="hebdo">
                    <label>Commande Hebdomadaire (Vous serez livré chaque semaine au jour que vous aurez saisi)</label>
                </p>
    </div>
    <div class="mb-3">
			<p>
                <label for="lblJour" class="form-label">Quel jour?</label>
	            <p>(Le jour de la semaie auquel vous souhaitez être livré si cette commande est hebdomadaire)</p>
	            <Select name="selectJour">
							<option value="nulle">Séléctionnez un jour de la semaine...</option>
							<option value="lundi">lundi</option>
							<option value="mardi">mardi</option>
							<option value="mecredi">mecredi</option>
							<option value="jeudi">jeudi</option>
							<option value="vendredi">vendredi</option>
                </select>
            </p>
    </div>
    <div class="mb-3">
			<p>
                <label for="lblNbPeronnes" class="form-label">Combien êtes-vous ?</label>
	            <p>(Le nombre de personnes du groupe si vous faîtes partie d'un groupe)</p>
                <input type="number" name="nbGroupe" min="2" max="60">
            </p>
        </div>
        <input id="prodId" name="prodId" type="hidden" value="<?php echo $numCommande ?>">
    <p>NB : Les champs suivis de * sont obligatoires</p>
    <p>
        <input type="submit" class="btn btn-outline-primary" name="payer" value="Valider et payer >">
    </p>
    <hr>
		<a class="help" href="">besoin d'aide?</a>
		<br />
		<a class="prod" href="connexionProducteur.html">Espace Producteur</a>
		<a class="contact" href="">Contacts</a>
</form>
</div>
</div>
</div>
</div>
</main>
 </body>
</html>