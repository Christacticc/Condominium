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

try{
    if (isset($_GET['document_id']) && isset($_GET['e_mail_address']))
    {
        $downloadManager = new DownloadManager($db);
        $param['document_id'] = $_GET['document_id'];
        $param['e_mail_address'] = $_GET['e_mail_address'];
        $download = new Download($param);
        $download = $downloadManager->add($download);
        $documentManager = new DocumentManager($db);
        $document = $documentManager->get($download->document_id());
        $dowload_array['document_id'] = $download->document_id();
        $dowload_array['document_name'] = $document->name();
        $dowload_array['document_file_name'] = $document->file_name();        
        $dowload_array['document_creation_time'] = $document->creation_time();        
        $dowload_array['document_type_id'] = $document->type_id();        
        
        $response = json_encode($dowload_array);
    }
    else
    {
        throw new Exception('Veuillez entrer le nom de votre copropriété ou une partie de son adresse.');
    }
    echo $response;
}
    catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

