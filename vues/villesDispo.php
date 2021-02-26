<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title> Villes et quartiers disponibles </title>
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
		color: red;
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
	<div class="container">
		<div class="row">
		  <div class="col-lg-auto">
	  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<div class="container-fluid">
		  <a class="navbar-brand" href="accueil.html">Livraison Paniers Bio</a>
		  <div class="collapse navbar-collapse" id="navbarCollapse">
			<div class="position-absolute top-50 start-50 translate-middle">
			<ul class="navbar-nav me-auto mb-2 mb-md-0">
			  <li class="nav-item">
				<a class="nav-link" href="connexion.html">Se connecter</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="creerCompteProfil.html">Créer un compte</a>
			  </li>
			</ul>
			</div>
		  </div>
		</div>
	  </nav>
		  </div>
		</div>
	  </div>
	</header>
	<br />
  <main>
    <div class="position-relative m-5">
  	<h1>Voici les villes et leurs quarties dans lesquels les livrasions sont possibles</h1>
    </div>
		<table class="table table-bordered border-primary">
		<thead>
			<tr>
			    <th scope="col">Ville</th>
			    <th scope="col">Code Postal</th>
                <th scope="col">Quartiers</th>
                <th scope="col">Carte</th>
			</tr>
		</thead>
		<tbody>
			<?php
			require_once("../modeles/bd.php") ;
			$cobd = new BD("projettutore") ;
			$co = $cobd->connexion() ;

			$reqVilles = "SELECT DISTINCT ville.nomville, ville.CP, quartier.nomCartier, quartier.lienMaps FROM ville, quartier WHERE quartier.numVille = ville.numVille ORDER BY ville.nomville" ;
			$resultVilles = mysqli_query($co, $reqVilles) or die(mysqli_error($co)) ;
			if(mysqli_num_rows($resultVilles) >= 1)
			{
			  foreach($resultVilles as $ville)
			  {
				  echo "<tr>" ;
				  echo "<td>".$ville['nomville']."</td>" ;
				  echo "<td>".$ville['CP']."</td>" ;
				  echo "<td>".$ville['nomCartier']."</td>" ;
				  if($ville['lienMaps'] == null)
				  {
					echo "<td><a href='#'><button class='btn btn-outline-primary' disabled>Carte</button></a>" ;
				  } else {
					echo "<td><a href='".$ville['lienMaps']."'><button class='btn btn-outline-primary'>Carte</button></a>" ;
				  }
				  echo "</tr>" ;
			  }
			} else {
				echo "<h4> Aucune ville n'est disponible </h4>" ;
			}
			?>
		</tbody>
        </table>
  </main>
	<hr>
			<a class="help" href="">besoin d'aide?</a>
			<a class="prod" href="connexionProducteur.html">Espace Producteur</a>
			<a class="contact" href="">Contacts</a>
 </body>
</html>