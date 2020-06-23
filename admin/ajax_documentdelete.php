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

$pdfupload_dir = '../pdf/';

$userManager = new UserManager($db);
try
{
    if (isset($_SESSION['user'])) // Si la session perso existe, on restaure l'objet.
    {
        $user = $_SESSION['user'];
        
        if (isset($_GET['id']))
        {
            $documentManager = new DocumentManager($db);
            $document = $documentManager->get($_GET['id']);
            if ($sort_number = $document->sort_number()) {
                $documents_to_go_down = $documentManager->getListToGoDown($document->condominium_id(), $document->category_id(), $sort_number);
                $count = $documentManager->delete($_GET['id']);
                if ($count == 1)
                {
                    foreach($documents_to_go_down as $document_to_go_down) {
                        $document_to_go_down->setSort_number($document_to_go_down->sort_number() - 1);
                        $documentManager->update($document_to_go_down);
                    }
                    $response = $_GET['id'];
                    unlink($pdfupload_dir . $document->file_name());
                    unset($document);
                    echo ($response);
                }
                else
                {
                    echo ('Un problème est survenu pendant la suppression : response = ' . $response);
                }
                
            } else {
                $count = $documentManager->delete($_GET['id']);
                if ($count == 1)
                {
                    $response = $_GET['id'];
                    unlink($pdfupload_dir . $document->file_name());
                    unset($document);
                    echo ($response);
                }
                else
                {
                    echo ('Un problème est survenu pendant la suppression : response = ' . $response);
                }
                
            }
            
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