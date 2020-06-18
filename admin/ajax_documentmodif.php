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
        if (isset($_POST['document_id']) && isset($_POST['property']))
        {
            $documentManager = new DocumentManager($db);
            $downloadManager = new DownloadManager($db);
            
            //$modified_document = $documentManager->modify($param); // update table
            
            $document = $documentManager->get($_POST['document_id']); // objet $document créé dans get()

            if ($_POST['property'] == 'category_id') {// Si on change de catégorie
                // 1) Dans l'ancienne catégorie : on récupère la liste des documents dont le sort_number est plus élevé que le document déplacé
                $sort_number = $document->sort_number();
                $old_category_id = $document->category_id();
                $documents_to_go_down = $documentManager->getListToGoDown($document->condominium_id(), $old_category_id, $sort_number);
            }
            
            $method = 'set'.ucfirst($_POST['property']);
            if (method_exists($document, $method))
            {
                $document->$method($_POST['value'] ? $_POST['value'] : 0);
            }
            
            if ($_POST['property'] == 'category_id') {// Si on change de catégorie
                // 2) Dans la nouvelle catégorie : on récupère le sort_number le plus élevé et on donne ce sort_number + 1 au document déplacé
                $document->setSort_number($documentManager->getHighestSortNumber($document->condominium_id(), $_POST['value']) + 1);
            }
            
            $modified_document = $documentManager->update($document);
            if ($modified_document) {

                if ($_POST['property'] == 'category_id') {// Si on change de catégorie
                    // 3) Dans l'ancienne catégoriz, on diminue de 1 le sort_number des documents dont le sort_number est plus élevé que le document déplacé
                    foreach($documents_to_go_down as $document_to_go_down) {
                        $document_to_go_down->setSort_number($document_to_go_down->sort_number() - 1);
                        $documentManager->update($document_to_go_down);
                    }
                }

                $modified_document = $documentManager->get($_POST['document_id']);

                // Paires des propriétés de l'objet document retourné
                $modified_document_array = [];
                $modified_document_array['available'] = $modified_document->available();
                $modified_document_array['category_id'] = $modified_document->category_id();
                $modified_document_array['old_category_id'] = $old_category_id;
                $modified_document_array['category_name'] = $modified_document->category_name();
                $modified_document_array['old_category_name'] = $document->category_name();
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

                // Paire de retour de la propriété modifiée pour maj de la page
                $modified_document_array['modified_property'] = $_POST['property'];

                if (isset($_POST['scroll'])) {
                    $modified_document_array['scroll'] = 1;
                }

                $response = json_encode($modified_document_array);
                echo ($response);
                
            } else {
                throw new Exception('La modification n\'a pas pu être effectuée');
            }
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