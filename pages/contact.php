<?php
	require 'inc/bootstrap.php';
	App::needSessionStart();
	$db = App::getDatabase();

?>
<div class="content">
	<h1>Formulaire de contact : </h1>
	<p>
		Formulaire de contact e-mail direct depuis le site internet AppSense.
	</p>
	<form action="contact" method="post">
		<?php
			if(isset($_POST['destinataire']) AND isset($_POST['sujet']) AND isset($_POST['message'])){
				// Plusieurs destinataires
				$to  = $_POST['destinataire'];

				// Sujet
				$subject = $_POST['sujet'];

				// message
				$message = $_POST['message'];

				// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

				// En-têtes additionnels
				$headers .= "To: $to <$to>" . "\r\n";
				$headers .= 'From: '.$_SESSION["auth"]->nomutilisateurs.' < '.$_SESSION["auth"]->emailutilisateurs.' >'. "\r\n";

				// Envoi et verification
				$mailSend = mail($to, $subject, $message, $headers);
				if(!$mailSend) {
					echo "<p class='text-color-red'>Echec d'envoi de l'e-mail.</p>";
				} else {
					echo '<p class="text-color-green">Email envoyé ! </p>';
				}
			}
		?>
		<div class="input">
			<label for="destinataire">Destinataire</label>
			<select id="destinataire" name="destinataire">
				<?php
				$rangs = $db->query("SELECT * FROM rang")->fetchAll();
				foreach($rangs as $rang){
					echo "<optgroup label='$rang->nomrang'>";
					$users = $db->query("SELECT * FROM utilisateurs WHERE rang_idrang = $rang->idrang")->fetchAll();
					foreach($users as $user){
						echo "<option value='$user->emailutilisateurs'>$user->nomutilisateurs</option>";
					}
					echo '</optgroup>';
				}
				?>
			</select>

		</div>
		<div class="input">
			<label for="sujet">Sujet</label>
			<input class="input-text" type="text" id="sujet" name="sujet" placeholder="Ex : BUG/ERREUR">
		</div>

		<div class="input">
			<label for="message">Message</label>
			<textarea name="message" id="message" cols="30" rows="10" placeholder="Bonjour, "></textarea>
		</div>

		<div>
			<button type="submit" class="btn"><i class="fa fa-plus-square"></i> Envoyer</button>
		</div>
	</form>
</div>