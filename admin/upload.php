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

$uploaded_type = 'to confirm';
$uploaded_category = 'to confirm';
$pdfupload_dir = '../pdf/'; // À modifier aussi dans les ajax_...

$condominiumManager = new CondominiumManager($db);
$documentManager = new DocumentManager($db);
$categoryManager = new CategoryManager($db);
$typeManager = new TypeManager($db);

if (!empty($_FILES) && isset($_POST['condominium_id'])) {
    $condominium = $condominiumManager->get($_POST['condominium_id']);
    $_SESSION['condominium'] = $condominium;

    if ($_FILES['file']['error'] != 0) {
        $msg = 'erreur : ' . $_FILES['file']['error'];
    }
    
    $tmp_file = $_FILES['file']['tmp_name']; 
    if( !is_uploaded_file($tmp_file) ) {
        $msg = 'Le fichier est introuvable.';
    } else {// il y a un fichier uploadé
        $file_type = $_FILES['file']['type'];

        if( !strstr($file_type, 'pdf')) {
            $msg = 'Le fichier n\'est pas un fichier pdf.';
        } else { // Le fichier est du bon type
            if ($_FILES ["file"] ["size"] > 100000000) {
                $msg = 'Le fichier est trop lourd.';
            } else { // le poids du fichier est correct
                include('clean_file_name.php');
                $file_name = clean_file_name($_FILES['file']['name']);
                if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $file_name) ) {
                    $msg='Nom de fichier non valide.';
                } else {
                    if (move_uploaded_file($tmp_file,$pdfupload_dir.$file_name )) {
                        $msg = 'L\'upload s\'est bien passé.';
                        // Récupérer les catégorie et type dont l'id n'est pas connu
                        $category = $categoryManager->getWithName($uploaded_category);
                        $type = $typeManager->getWithName($uploaded_type);
                        // Construire $param.
                        $param['available'] = 0;
                        $param['category_id'] = $category->id();
                        $param['condominium_id'] = $_POST['condominium_id'];
                        $param['file_name'] = $file_name;
                        $param['name'] = $file_name;
                        $param['tracked'] = 0;
                        $param['type_id'] = $type->id();
                        $document = new Document($param); // Créer le nouvel objet
                        $document = $documentManager->add($document);
                        // Paires des propriétés de l'objet document retourné
                        $document_array['file_name'] = $document->file_name();
                        $document_array['id'] = $document->id();

                        $response = json_encode($document_array);
                        //echo ($response);
//var_dump($document);
                    } else {
                        echo($msg);                            
                    }
                }
            }
        }
    }
    
    
} else {
    $msg = 'Les informations fournies n\'ont pas permis d\'enregistrer le nouveau document.';
    echo($msg);                            

}
