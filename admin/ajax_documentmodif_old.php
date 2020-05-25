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
        
        if (isset($_GET['id']) && isset($_GET['name']))
        {
            $param = $_GET;            
            $documentManager = new DocumentManager($db);
            $downloadManager = new DownloadManager($db);
            $modified_document = $documentManager->modify($param);
            $modified_document_array['available'] = $modified_document->available();
            $modified_document_array['category_id'] = $modified_document->category_id();
            $modified_document_array['category_name'] = $modified_document->category_name();
            $modified_document_array['condominium_id'] = $modified_document->condominium_id();
            $modified_document_array['condominium_name'] = $modified_document->condominium_name();
            $modified_document_array['condominium_internal_reference'] = $modified_document->condominium_internal_reference();
            $modified_document_array['creation_time'] = $modified_document->creation_time();
            $modified_document_array['file_name'] = $modified_document->file_name();
            $modified_document_array['id'] = $modified_document->id();
            $modified_document_array['modification_time'] = $modified_document->modification_time();
            $modified_document_array['name'] = $modified_document->name();
            $modified_document_array['sort_number'] = $modified_document->sort_number();
            $modified_document_array['tracked'] = $modified_document->tracked();
            $modified_document_array['type_id'] = $modified_document->type_id();
            $modified_document_array['type_name'] = $modified_document->type_name();
            $modified_document_array['downloads_count'] = $downloadManager->countWithDoc($modified_document->id());

            $response = json_encode($modified_document_array);
            echo ($response);
        }
        else
        {
            throw new Exception('Données insuffisantes pour effectuer la modification');
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