<?php
if ($_GET) {
	if (isset($_GET['forname'])){
		$forname = $_GET['forname'];
	}
	if (isset($_GET['name'])){
		$name = $_GET['name'];
	}
	if (isset($_GET['email'])){
		$email = $_GET['email'];
	}
	if (isset($_GET['copro'])){
		$copro = $_GET['copro'];
	}
	if (isset($_GET['sujet'])){
		$sujet = $_GET['sujet'];
	}
	if (isset($_GET['message'])){
		$message = $_GET['message'];
	}
	
	//$mail1 = 'gestion@sagnimortegestion.fr,christophe.ribault@tacticc.com'; // Déclaration de l'adresse de destination.
	$mail1 = ' c.ribault@gmail.com'; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail1)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne1 = "\r\n";
	}
	else
	{
		$passage_ligne1 = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt1 = "Prise de contact depuis le site Internet. Prenom : ".$forname.", Nom : ".$name.", Adresse e-mail : ".$email.", Copropriete : ".$copro.", Sujet : ".$sujet.", Message : ".$message.". ";
	$message_html1 = "<html><head></head><body><p style='font-size:10px;padding-left:10px'>Prise de contact depuis le site Internet</p><p style='font-size:12px'><span style='font-size:10px;padding-left:10px'>Prénom : </span>".$forname."<br /><span style='font-size:10px;padding-left:10px'>Nom : </span>".$name."<br /><span style='font-size:10px;padding-left:10px'>Adresse e-mail : </span>".$email."<br><span style='font-size:10px;padding-left:10px'>Copropriété : </span>".$copro."<br /><span style='font-size:10px;padding-left:10px'>Sujet : </span>".$sujet."<br><br><span style='font-size:10px;padding-left:10px'>Message :</span> </p><div style='font-size:12px;padding:10px;border:#DDDDDD 3px solid'>".$message."</div></body></html>";
	//==========
	 
	//=====Création de la boundary
	$boundary1 = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet1 = "Message site Internet : ".$sujet;
	//=========
	 
	//=====Création du header de l'e-mail.
	$header1 = "From: \"Sagnimorte Conseils\"<gestion@sagnimortegestion.fr>".$passage_ligne1;
	$header1.= "Reply-to: \"Sagnimorte Conseils\" <gestion@sagnimortegestion.fr>".$passage_ligne1;
	$header1.= "MIME-Version: 1.0".$passage_ligne1;
	$header1.= "Content-Type: multipart/alternative;".$passage_ligne1." boundary=\"$boundary1\"".$passage_ligne1;
	//==========
	 
	//=====Création du message.
	$message1 = $passage_ligne1."--".$boundary1.$passage_ligne1;
	//=====Ajout du message au format texte.
	$message1.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne1;
	$message1.= "Content-Transfer-Encoding: 8bit".$passage_ligne1;
	$message1.= $passage_ligne1.$message_txt1.$passage_ligne1;
	//==========
	$message1.= $passage_ligne1."--".$boundary1.$passage_ligne1;
	//=====Ajout du message au format HTML
	$message1.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne1;
	$message1.= "Content-Transfer-Encoding: 8bit".$passage_ligne1;
	$message1.= $passage_ligne1.$message_html1.$passage_ligne1;
	//==========
	$message1.= $passage_ligne1."--".$boundary1."--".$passage_ligne1;
	$message1.= $passage_ligne1."--".$boundary1."--".$passage_ligne1;
	//==========


	$mail2 = $email.',c.ribault@gmail.com' ; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail2)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne2 = "\r\n";
	}
	else
	{
		$passage_ligne2 = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	//==========
	$message_txt2 = $forname." ".$name." Bonjour. Nous vous remercions pour votre message auquel nous accorderons toute notre attention. Cordiales salutation. L'équipe Sagnimorte Conseils.";
	$message_html2 = "<html><head></head><body><p>".$forname." ".$name."</p><p>Bonjour,</p><p>Nous vous remercions pour votre message auquel nous accorderons toute notre attention.</p><p>Cordiales salutations,</p><p>L'équipe Sagnimorte Conseils</p><br><br><table border='0' cellpadding='10px'><tr><td><img src='https://sagnimorteconseils.fr/public/images/logos/SAGNIMORTE-CONSEILS_logo_325x90.png' width='325' height='90' alt='Sagnimorte Conseils' /></td><td><p>Sagnimorte Conseils<br />12 place Mal LYAUTEY - 69006 LYON<br />R.C.S. 48403960700029 APE - 6831Z<br /><strong>Tél. 04 78 52 86 65 - Fax. 09 55 72 86 65</strong><br /><a text-decoration:none' href='gestion@sagnimortegestion.fr'>gestion@sagnimortegestion.fr</a></p></td></tr></table></body></html></body></html>";
	//=====Création de la boundary
	$boundary2 = "-----=".md5(rand());
	//==========
	 
	//=====Définition du sujet.
	$sujet2 = "votre message a Sagnimorte Conseils : ".$sujet;
	//=========
	 
	//=====Création du header de l'e-mail.
	$header2 = "From: \"Sagnimorte Conseils\"<gestion@sagnimortegestion.fr>".$passage_ligne2;
	$header2.= "Reply-to: \"Sagnimorte Conseils\"<gestion@sagnimortegestion.fr>".$passage_ligne2;
	$header2.= "MIME-Version: 1.0".$passage_ligne2;
	$header2.= "Content-Type: multipart/alternative;".$passage_ligne2." boundary=\"$boundary2\"".$passage_ligne2;
	//==========
	 
	//=====Création du message.
	$message2 = $passage_ligne2."--".$boundary2.$passage_ligne2;
	//=====Ajout du message au format texte.
	$message2.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne2;
	$message2.= "Content-Transfer-Encoding: 8bit".$passage_ligne2;
	$message2.= $passage_ligne2.$message_txt2.$passage_ligne2;
	//==========
	$message2.= $passage_ligne2."--".$boundary2.$passage_ligne2;
	//=====Ajout du message au format HTML
	$message2.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne2;
	$message2.= "Content-Transfer-Encoding: 8bit".$passage_ligne2;
	$message2.= $passage_ligne2.$message_html2.$passage_ligne2;
	//==========
	$message2.= $passage_ligne2."--".$boundary2."--".$passage_ligne2;
	$message2.= $passage_ligne2."--".$boundary2."--".$passage_ligne2;
	//==========

	//=====Envoi de l'e-mail.
	mail($mail1,$sujet1,$message1,$header1);
	mail($mail2,$sujet2,$message2,$header2);
	//==========
    echo('ok');
}
?>