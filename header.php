
	



<header>
	<?php

	if (isset($_SESSION['login'])) {
	?>

		<div>

			<span class="title"></span>
			<input class="burger" type="checkbox">

			<nav>
				<input type="search" placeholder="Rechercher...">
				<a href="index.php">Accueil</a>
				<a href="discussion.php">Conversation</a>
				<a href="profil.php">Profil</a>
				<a href="deconnexion.php">Déconnexion</a>
			</nav>

		</div>

	<?php

	} else {
	?>

		<div class="menu">

			<span class="title">Moulin à Parole</span>
			<input class="burger" type="checkbox">

			<nav>
			
				<input type="search" placeholder="Rechercher...">
				<a href="index.php">Accueil</a>
				<a href="connexion.php">Connexion</a>
				<a href="inscription.php">Inscription</a>
			</nav>

		</div>

		
	<?php
	}
	?>

</header>

