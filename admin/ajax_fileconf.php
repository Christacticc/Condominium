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
try {
    if (isset($_SESSION['user'])) { // Si la session perso existe, on restaure l'objet.
        $user = $_SESSION['user'];
        if (isset($_POST['do_name']) && isset($_POST['do_category']) && $_POST['do_category'] != '' && isset($_POST['do_type']) && $_POST['do_type'] != '') {//Les champs sont remplis
            $documentManager = new DocumentManager($db);
            $document = $documentManager->get($_POST['do_id']);
            $document->setAvailable(isset($_POST['do_available']) ? 1 : 0);
            $document->setCategory_id($_POST['do_category']);
            $document->setName($_POST['do_name']);
            $document->setTracked(isset($_POST['do_tracked']) ? 1 : 0);
            $document->setType_id($_POST['do_type']);
            $document->setSort_number($documentManager->getHighestSortNumber($document->condominium_id(), $_POST['do_category']) + 1);
            
            // Construire $param.
            //$param['id'] = $_POST['do_id'];
/*            $param['available'] = isset($_POST['do_available']) ? 1 : 0;
            $param['category_id'] = $_POST['do_category'];
            $param['name'] = $_POST['do_name'];
            $param['tracked'] = isset($_POST['do_tracked']) ? 1 : 0;
            $param['type_id'] = $_POST['do_type'];
            $param['sort_number'] = $documentManager->getHighestSortNumber($document->condominium_id(), $_POST['do_category']) + 1;
            $document = new Document($param);
*/            
            $modified_document = $documentManager->update($document);
            // Paires des propriétés de l'objet document retourné
            $modified_document_array['id'] = $modified_document->id();
            $response = json_encode($modified_document_array);
            echo ($response);
        } else {
            throw new Exception('Les informations fournies n\'ont pas permis d\'enregistrer le nouveau document pour ' .$condominium->name());
        }            

    } else {
        throw new Exception('Utilisateur non identifié.');
    }
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}