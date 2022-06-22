<section id="user_container" class="window<?php echo $this->isActive ? '' : ' inactive'; ?>">
	<article id="connect">
		<aside id="connectInfos">
			<div>
				<span class="icon-user"></span>
				<input id="email" type="text" name="email">
			</div>
			<div>
				<span class="icon-lock"></span>
				<input id="mdp" type="password" name="mdp">
			</div>
		</aside>
		<aside id="footerConnect">
			<p id="errorMessage"></p>
			<button id="connectBtn">Connexion</button>
			<div>
				<p>Vous n'avez pas de compte ?</p>
				<button id="createAccount">Créez-en un !</button>
			</div>
		</aside>
	</article>
	<article id="newUser">
		<aside id="content">
			<div id="generalInfos">
				<div class="customInput">
					<label>Intitulé du travail</label>
					<input type="text" name="workName" placeholder="Intitulé du travail">
				</div>
				<!-- <div class="separator">
					<span></span>
					<p>Informations générales</p>
					<span></span>
				</div> -->
				<div class="customInput">
					<label>Nom</label>
					<input type="text" name="fname" placeholder="Nom">
				</div>
				<div class="customInput">
					<label>Prénom</label>
					<input type="text" name="lname" placeholder="Prénom">
				</div>
				<!-- <div class="customInput">
					<label>Date de naissance</label>
					<div>
						<select name="birth_day"></select>
						<span>-</span>
						<select name="birth_month"></select>
						<span>-</span>
						<select name="birth_year"></select>
					</div>
					<input type="text" name="workName" placeholder="Intitulé du travail">
				</div>
				<div class="separator">
					<span></span>
					<p>Informations de connexion</p>
					<span></span>
				</div> -->
				<div class="customInput">
					<label>Adresse email</label>
					<input type="mail" name="email" placeholder="Adresse email">
				</div>
				<div class="customInput">
					<label>Mot de passe</label>
					<input type="password" name="password" placeholder="Mot de passe">
				</div>
				<div class="customInput">
					<label>Confirmez votre mot de passe</label>
					<input type="password" name="password_check" placeholder="Confirmez votre mot de passe">
				</div>
			</div>
			<div id="workInfos">
				<div id="daysWork">
					<h2>Quels jours travaillez-vous ?</h2>
					<div>
						<div>Lundi</div>
						<div>Mardi</div>
						<div>Mercredi</div>
						<div>Jeudi</div>
						<div>Vendredi</div>
						<div>Samedi</div>
						<div>Dimanche</div>
					</div>
				</div>
				<div id="fixedHours">
					<h2>Vos horaires sont ...</h2>
					<div>
						<div>
							<span class="icon-work-hours-same"></span>
							<p>Fixes</p>
						</div>
						<div>
							<span class="icon-work-hours-diff"></span>
							<p>Variables</p>
						</div>
					</div>
				</div>
				<div id="setHours">
					<div id="fixed">
						<h2>Saisir vos heures de travail ...</h2>
						<div id="setFixedHours">
							<div id="setBeginTime"></div>
							<div id="setBreakTime"></div>
							<div id="setWorkTime"></div>
							<div id="setEndTime"></div>
						</div>
					</div>
					<div id="diff">

					</div>
				</div>
			</div>
		</aside>
		<aside id="btnBottom">
        	<button>Suivant <i class="icon-arrow-down" style="transform: rotate(-90deg);"></i></button>
    	</aside>
		<aside id="progress">
			<p>Informations générales</p>
			<span></span>
			<p>Semaine</p>
			<span></span>
			<p>Jours</p>
			<span></span>
			<p>Horaires</p>
			<span></span>
			<p>Récapitulatif</p>
		</aside>
	</article>
</section>