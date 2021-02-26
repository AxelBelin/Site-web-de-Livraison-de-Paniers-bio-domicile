<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Composer un panier </title>
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
    <h1>Composez le contenu de votre panier</h1>
</div>

<div class="container">
	<div class="row">
	  <div class="col-lg-auto">
		<div class="position-absolute top-50 start-50 translate-middle">
  <form class="ajouter" method="post" action="../controleurs/ajouterProduitPanierProd.php">
	<div class="mb-3">
    <br />
    <p></p>
		<p>
            <h4>Ajouter un produit dans un panier</h4>
				<label for="lblNomPanier" class="form-label">Nom du panier à traiter : *</label>
                <Select class="form-select" name="nomPanier">
                    <option value="nulle">Sélectionnez le nom du panier...</option>
                    <?php
                        require_once("../modeles/bd.php") ;
                        $cobd = new BD("projettutore") ;
                        $co = $cobd->connexion() ;

                        $reqRecupNomPaniers = "SELECT numPanier, nomPanier FROM panier" ;
                        $resultRecupNomPaniers = mysqli_query($co, $reqRecupNomPaniers) or die(mysqli_error($co)) ;
                        foreach($resultRecupNomPaniers as $panier)
                        {
                            echo "<option value='".$panier['numPanier']."'>".$panier['nomPanier']."</option>" ;
                        }
                    ?>
                </select>
		</p>
		</div>
		<div class="mb-3">
			<p>
				<label for="lblNomPanier" class="form-label">Nom du produit à ajouter au panier : *</label>
                <Select name="nomProduit">
					<option value="nulle">Sélectionnez le nom du produit...</option>
					<?php
                        require_once("../modeles/bd.php") ;
                        $cobd = new BD("projettutore") ;
                        $co = $cobd->connexion() ;

                        $reqRecupProduits = "SELECT numProduit, nomproduit FROM produit" ;
                        $resultRecupProduits = mysqli_query($co, $reqRecupProduits) or die(mysqli_error($co)) ;
                        foreach($resultRecupProduits as $produit)
                        {
                            echo "<option value='".$produit['numProduit']."'>".$produit['nomproduit']."</option>" ;
                        }
                    ?>
                </select>
					<label for="lblnpProd" class="form-label">Quantité en KG (<i>exemple: 8.3 KG</i>) : *</label>
					<input type="text" name="qteProduit">
			</p>
            </div>
		<div class="mb-3">
    <div class="text-center">
				<p>
			<input type="submit" class="btn btn-success" name="ajouter" value="Ajouter +">
				</p>
        </div>
    </div>
    </form>
    
    <form class="supprimer" method="post" action="../controleurs/supprimerPanierProd.php">
    <div class="mb-3">
    <p></p>
    <br />
    <p></p>
		<p>
                <h4>Supprimer un produit d'un panier</h4>
				<label for="lblNomPanier" class="form-label">Nom du panier à traiter : *</label>
                <Select class="form-select" name="nomPanier">
                    <option value="nulle">Sélectionnez le nom du panier...</option>
                    <?php
                        require_once("../modeles/bd.php") ;
                        $cobd = new BD("projettutore") ;
                        $co = $cobd->connexion() ;

                        $reqRecupNomPaniers = "SELECT numPanier, nomPanier FROM panier" ;
                        $resultRecupNomPaniers = mysqli_query($co, $reqRecupNomPaniers) or die(mysqli_error($co)) ;
                        foreach($resultRecupNomPaniers as $panier)
                        {
                            echo "<option value='".$panier['numPanier']."'>".$panier['nomPanier']."</option>" ;
                        }
                    ?>
                </select>
		</p>
		</div>
		<div class="mb-3">
			<p>
				<label for="lblNomPanier" class="form-label">Nom du produit à supprimer du panier : *</label>
                <Select name="nomProduit">
					<option value="nulle">Sélectionnez le nom du produit...</option>
					<?php
                        require_once("../modeles/bd.php") ;
                        $cobd = new BD("projettutore") ;
                        $co = $cobd->connexion() ;

                        $reqRecupProduits = "SELECT numProduit, nomproduit FROM produit" ;
                        $resultRecupProduits = mysqli_query($co, $reqRecupProduits) or die(mysqli_error($co)) ;
                        foreach($resultRecupProduits as $produit)
                        {
                            echo "<option value='".$produit['numProduit']."'>".$produit['nomproduit']."</option>" ;
                        }
                    ?>
                </select>
			</p>
        </div>
        <p> NB : tous les champs sont obligatoires</p>
    <div class="mb-3">
    <div class="text-center">
				<p>
			<input type="submit" class="btn btn-danger " name="suprimer" value="Suprimer -">
				</p>
    </div>
    </div>
    </form>

	<p>
		<a class="terminer" href="gererStock.php"><button class="btn btn-primary">Terminer</button></a>
	</p>
</div>
</div>
</div>
</div>
</main>
<footer>
	<hr>
	 <a class="help" href="">besoin d'aide?</a>
	 <a class="prod" href="connexionProducteur.html">Espace Producteur</a>
	 <a class="contact" href="">Contacts</a>
</footer>
 </body>
</html>