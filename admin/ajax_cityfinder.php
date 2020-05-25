<?php
// Autoload
function loadClass($classname)
{
    set_include_path('../model/');
    require $classname . '.php';
}

spl_autoload_register('loadClass');

session_start(); //On appelle session_start APRÈS avoir enregistré l'autoload.

require('../config/connect.php');

$userManager = new UserManager($db);
try{
    if (isset($_SESSION['user'])) // Si la session perso existe, on restaure l'objet.
    {
        $user = $_SESSION['user'];

        if (isset($_GET['pc']))
        {
            $response = 'code : ' . $_GET['pc'] . ' - Session : ' . $_SESSION['user'] . '<br>';
            $postal_codeManager = new Postal_codeManager($db);
            $postal_codes = $postal_codeManager->getCities($_GET['pc']);
            
            if(is_array($postal_codes))
            {
                $nb_codes = 0;
                foreach($postal_codes as $postal_code)
                {
                    $postal_code_array['id'] = $postal_code->id();
                    $postal_code_array['postal_code'] = $postal_code->postal_code();
                    $postal_code_array['city'] = $postal_code->city();
                    $postal_code_array['line_5'] = $postal_code->line_5();

                    $postal_codes_array[$nb_codes] = $postal_code_array;
                    $nb_codes ++;
                }
                $response = json_encode($postal_codes_array);
            }
            else
            {
                throw new Exception($_GET['pc'] . ' n\'est pas un code postal existant actuellement.');
            }
        }
        else
        {
            throw new Exception('Veuillez entrer un code postal.');
        }
    }
    else
    {
        throw new Exception('Utilisateur non identifié.');
    }
    echo $response;
}
    catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

