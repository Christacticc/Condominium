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
try
{
    if (isset($_SESSION['user'])) // Si la session perso existe, on restaure l'objet.
    {
        $user = $_SESSION['user'];
        
        if (isset($_GET['id']))
        {
            $photoManager = new PhotoManager($db);
            $photos = $photoManager->getList($_GET['id']);
            foreach ($photos as $photo)
            {
               if ($photo->position() == 1)
                {
                    $photo->setPosition(2);
                }
                else{
                    $photo->setPosition(1);
                }
                $photoManager->update($photo);
            }

            $nb_photos = 0;
            foreach($photos as $photo)
            {
                $photo_array['id'] = $photo->id();
                $photo_array['condominium_id'] = $photo->condominium_id();
                $photo_array['condominium_name'] = $photo->condominium_name();
                $photo_array['file_name'] = $photo->file_name();                    $photo_array['position'] = $photo->position();

                $photos_array[$nb_photos] = $photo_array;
                $nb_photos ++;
            }
            
            $response = json_encode($photos_array);
            echo($response);
        }
        else
        {
            throw new Exception('Données insuffisantes pour effectuer la suppression');
        }
        
    }
    else
    {
        throw new Exception('Utilisateur non identifié.');
    }
}
catch(Exception $e) 
{
    echo 'Erreur : ' . $e->getMessage();
}