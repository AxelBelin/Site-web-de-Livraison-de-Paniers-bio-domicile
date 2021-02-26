<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Voir les commandes des clients </title>
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

    html {
		position: absolute;
		height: 100%;
  		width: 100% ;
	}

    .terminer {
        display: flex;
        justify-content: center;
    }
			body {
	background-image :url("../img/test.jpg") ;
	background-size:cover;
	
	}

  form {
    /*border: 3px solid black ; */
    background-color: white ;
  }

  table {
    /*border: 3px solid black ; */
    background-color: white ;
  }

  thead {
    background-color: #C4C4C4;
  }
		h2{
		
		font-style:bold;
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
	<div class="position-relative m-5">
    <h1> Consulter les commandes des client</h1>
  </div>


  <form method="post" action="">

  <table class="table">
		<thead>
			<tr>
			<th>Trier par :</th>
			<th>Trier par état de commande</th>
            <th>Trier par :</th>
            <th>Rechercher par prix :</th>
			</tr>
		</thead>
		<tbody>
            <tr>
            <td>
            <label><input type="radio" name="groupe" value="groupe"/> Commande groupée</label><br />
			<label><input type="radio" name="seule" value="seule"/> commande pour un client</label><br />
</td>
<td>

		
			<Select name="slectEtat">
				<option value="null">Séléctionnez un état...</option>
				<option value="enCours">Livrasion en cours</option>
				<option value="enPreparation">En preparation</option>
                <option value="livree">Livrée</option>
                <option value="attente">En attente</option>
				</select>
</td>
<td>
			<label><input type="radio" name="ponctuelle" value="cponctuelle"/> Commande ponctuelle</label><br />
			<label><input type="radio" name="hebdo" value="chebdo"/> commande hebdomadaire</label><br />
</td>
<td>
			<label><input type="number" name="prix">euros</label>
</td>
<td>
			<input type="submit" class="btn btn-outline-success" name="soumettre" value="soumettre">
</td>
	</form>
</table>
<br />
	<table class="table table-bordered border-primary">
			<thead>
			<tr>
				<th scope="col"> Num commande</th>	
				<th scope="col"> Nb personnes groupe</th>	
				<th scope="col"> jour hebdo</th>
				<th scope="col"> Date commande</th>
				<th scope="col"> état</th>
				<th scope="col"> Détails</th>	
			</tr>
			  </thead>
			<tbody>
			  <tr>
				  <?php 
				  require_once("../modeles/bd.php") ;
				  $cobd = new BD("projettutore") ;
				  $co = $cobd->connexion() ;

				  $reqCommande = "SELECT commande.numCommande, client.groupe, jourlivrasion, datecommande, etatCommande FROM commande, client WHERE commande.numCommande = client.numCommande" ;
				  $VerifCommande = mysqli_query($co, $reqCommande) or die(mysqli_error($co)) ;
				  if(mysqli_num_rows($VerifCommande) >= 1)
				  {
					foreach($VerifCommande as $commande)
					{
						echo "<tr>" ;
						echo "<td>".$commande['numCommande']."</td>" ;
						echo "<td>".$commande['groupe']."</td>" ;
						echo "<td>".$commande['jourlivrasion']."</td>" ;
						echo "<td>".$commande['datecommande']."</td>" ;
						echo "<td>".$commande['etatCommande']. " <p></p>
						<form method='post' action='../controleurs/modifEtatCommande.php'>
						<select name='selectEtat'>
							<option value='nulle'>Séléctionnez l'état de la commande...</option>
							<option value='preparation'>en préparation</option>
							<option value='prete'>prête</option>
							<option value='Livraison'>Livraison en cours</option>
							<option value='livree'>Livrée</option>
						</select>
						<input id='prodId' name='prodId' type='hidden' value='".$commande['numCommande']."'>
						<input type='submit' class='btn btn-outline-warning' name='modifEtat' value='Modifier'></form>" ;
						echo "<td><form method='post' action='detailsCommande_Producteur.php'>
						<input id='prodId' name='prodDetailId' type='hidden' value='".$commande['numCommande']."'>
						<input type='submit' class='btn btn-primary' name='btnDetails' value='Détails'></form></td>" ;
						echo "</tr>" ;
					}
				  } else {
					  echo "<h4> Aucune commande n'a été passée </h4>" ;
				  }
				  ?>
			</tr>
			</tbody>
    </table>
</main>
<footer>
		<hr>
         <a class="help" href="">besoin d'aide ?</a>
         <a class="prod" href="connexionProducteur.html">Espace Producteur</a>
         <a class="contact" href="">Contacts</a>
</footer>

 </body>
 
</html>