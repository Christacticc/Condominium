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
/*        
        echo('ajax_documentmodifLevel1 $_POST<pre>');
        var_dump($_POST);
        echo('</pre>');
*/
        if (isset($_POST['document_id']) && isset($_POST['movement'])) {
            $documentManager = new DocumentManager($db);
            if ($_POST['movement']== 'up') {
                // quel est le numéro de tri du document à déplacer ? augmanter son numéro de 1
                // Quelle est le document dont le numéro est  immédiatement plus grand ?  -> diminuer son numéro de 1
                $documentToMoveUp = $documentManager->get($_POST['document_id']);
                $documentToMoveDown = $documentManager->getWithCondominiumCategorySortNumber($documentToMoveUp->condominium_id(), $documentToMoveUp->category_id(), $documentToMoveUp->sort_number() + 1);
                
            } elseif ($_POST['movement'] == 'down') {
                $documentToMoveDown = $documentManager->get($_POST['document_id']);
                $documentToMoveUp = $documentManager->getWithCondominiumCategorySortNumber($documentToMoveDown->condominium_id(), $documentToMoveDown->category_id(), $documentToMoveDown->sort_number() - 1);
                
            } else {
                throw new Exception('Informations insuffisantes pour effectuer le déplacement.');
            }

            $numberTop = $documentToMoveDown->sort_number(); 
            $documentToMoveDown->setSort_number(10000);
            $documentManager->update($documentToMoveDown);
            $documentToMoveUp->setSort_number($numberTop);
            $documentManager->update($documentToMoveUp);
            $documentToMoveDown->setSort_number($numberTop - 1);
            $documentManager->update($documentToMoveDown);
                
            $moved_array['documentToMoveUp_id'] = $documentToMoveUp->id();
            $moved_array['documentToMoveDown_id'] = $documentToMoveDown->id();
            $moved_array['category_id'] = $documentToMoveUp->category_id();
            $response = json_encode($moved_array);
            echo($response);
                
        }
        else
        {
            throw new Exception('Données insuffisantes pour effectuer le déplacement.');
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