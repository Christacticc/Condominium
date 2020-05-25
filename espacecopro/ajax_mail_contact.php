<?php
// On vérifie que la méthode POST est utilisée
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // On vérifie si le champ "recaptcha-response" contient une valeur
    if(empty($_POST['recaptcha-response']))
    {
        //echo('Token recaptcha manquant.');
        echo('not ok');
    }
    else
    {
        // On prépare l'URL
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LflGu8UAAAAAI_WAd427OZ3ot0tnZYuLLUGlEqk&response={$_POST['recaptcha-response']}";
        //clé secrete sagnimorte : 6LflGu8UAAAAAI_WAd427OZ3ot0tnZYuLLUGlEqk
        // On vérifie si curl est installé
        if(function_exists('curl_version'))
        {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        }
        else
        {
            // On utilisera file_get_contents
            $response = file_get_contents($url);
        }

        // On vérifie qu'on a une réponse
        if(empty($response) || is_null($response))
        {
            //echo('Réponse recaptcha vide.');
            echo('not ok');
       }
        else
        {
            $data = json_decode($response);
            if($data->success)
            {
                if(
                isset($_POST['forname']) && !empty($_POST['forname']) &&
                isset($_POST['name']) && !empty($_POST['name']) &&
                isset($_POST['email']) && !empty($_POST['email']) &&
                isset($_POST['condo']) &&
                isset($_POST['subject']) &&
                isset($_POST['message']) && !empty($_POST['message'])
                )
                {
                // On nettoie le contenu
                $forname = strip_tags($_POST['forname']);
                $name = strip_tags($_POST['name']);
                $email = strip_tags($_POST['email']);
                $condo = strip_tags($_POST['condo']);
                $subject = strip_tags($_POST['subject']);
                $message = nl2br(htmlspecialchars($_POST['message']));

                // Montage de l'email et envoi
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
                    $message_txt1 = "Prise de contact depuis le site Internet. Prenom : ".$forname.", Nom : ".$name.", Adresse e-mail : ".$email.", Copropriete : ".$copro.", Sujet : ".$subject.", Message : ".$message.". ";
                    $message_html1 = "<html><head></head><body><p style='padding-left:10px'>Prise de contact depuis le site Internet</p><p><span style='padding-left:10px'>Prénom : </span>".$forname."<br /><span style='padding-left:10px'>Nom : </span>".$name."<br /><span style='padding-left:10px'>Adresse e-mail : </span>".$email."<br><span style='padding-left:10px'>Copropriété : </span>".$copro."<br /><span style='padding-left:10px'>Sujet : </span>".$subject."<br><br><span style='padding-left:10px;margin-bottom:0'>Message :</span> </p><div style='padding:10px;border:#DDDDDD 3px solid'>".$message."</div></body></html>";
                    //==========

                    //=====Création de la boundary
                    $boundary1 = "-----=".md5(rand());
                    //==========

                    //=====Définition du sujet.
                    $subject1 = "POST Message site Internet : ".$subject;
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
                    $subject2 = "votre message a Sagnimorte Conseils : ".$subject;
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
                    mail($mail1,$subject1,$message1,$header1);
                    mail($mail2,$subject2,$message2,$header2);
                    //==========
                    echo('ok');

                }
                else
                {
                    echo('Données incomplètes');
                }
            }
            else
            {
                //echo('Réponse recaptcha negative.');
                echo('not ok');
            }
        }
    }
}
else
{
http_response_code(405);
echo 'Méthode non autorisée';
}