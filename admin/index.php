<?php
// Autoload
function loadClass($classname)
{
    set_include_path('../model/');
    require $classname . '.php';
}

spl_autoload_register('loadClass');

session_start(); //On appelle session_start APRÈS avoir enregistré l'autoload.

if (isset($_GET['deconnection']))
{
    session_destroy();
    header('Location: .');
    exit();
}

require('../config/connect.php');

$pdfupload_dir = '../pdf/'; // À modifier aussi dans les ajax_...
$phoupload_dir = '../pho/'; // À modifier aussi dans les ajax_...
$pdfdownload_dir = '../pdf/';
$phodownload_dir = '../pho/';
$uploaded_type = 'to confirm';
$uploaded_category = 'to confirm';
$excluded_types = array($uploaded_type); // Array des types à exclure des listes
$excluded_categories = array($uploaded_category); // Array des catégories à exclure des listes
$userManager = new UserManager($db);
if (isset($_SESSION['user'])) // Si la session perso existe, on restaure l'objet.
{
    $user_id = $_SESSION['user'];
    $user = $userManager->get($user_id);
    $user_name = $user->name();

    if (isset($_GET['admin'])) // Si on veux ouvrir la page d'administration
    {
        if ($user_id == 1)
        {
            $categoryManager = new CategoryManager($db);
            $typeManager = new TypeManager($db);
            $documentManager = new DocumentManager($db);
            $user1 = $userManager->get(1);
            $user2 = $userManager->get(2);
    //            $categories = $categoryManager->getList();
            $categories = $categoryManager->getListExcluded($excluded_categories);
    //            $types = $typeManager->getList();
            $types = $typeManager->getListExcluded($excluded_types);
            require('../view/backend/admin.php');
        }
        else
        {
            require('../view/backend/listCondominiumsView.php');
        }
    }
    elseif (isset($_GET['addcondo'])) // Si on veux ajouter une coproriété
    {
        require('../view/backend/condominiumAdd.php');
    }
    elseif (isset($_GET['adddoc'])) // Si on veux ajouter un document
    {
        $condominiumManager = new CondominiumManager($db);
        $condominium = $condominiumManager->get($_GET['adddoc']);
        $categoryManager = new CategoryManager($db);
        $typeManager = new TypeManager($db);
//            $categories = $categoryManager->getList();
        $categories = $categoryManager->getListExcluded($excluded_categories);
//            $types = $typeManager->getList();
        $types = $typeManager->getListExcluded($excluded_types);
        $_SESSION['condominium'] = $condominium;

        require('../view/backend/documentAdd.php');
    }
    elseif (isset($_GET['adddocs'])) // Si on veux ajouter des documents
    {
        $condominiumManager = new CondominiumManager($db);
        $condominium = $condominiumManager->get($_GET['adddocs']);
        $categoryManager = new CategoryManager($db);
        $typeManager = new TypeManager($db);
        $existUploadedCategory = $categoryManager->existUploadedCategory($uploaded_category);
        $existUploadedType = $typeManager->existUploadedType($uploaded_type);
        if (!$existUploadedCategory || !$existUploadedType ) {
            $msg .= 'L\'upload par glisser déposé ne peut pas fonctionner car la catégorie ' . $uploaded_category . ' ou/et le type ' . $uploaded_type . ' n\'existe(nt) pas dans la base' . $dbname . '.';
        }
        $_SESSION['condominium'] = $condominium;

        require('../view/backend/documentsAdd.php');
    }
    elseif (isset($_GET['confdocs'])) // Si on veux confirmer des documents
    {
        $condominiumManager = new CondominiumManager($db);
        $condominium = $condominiumManager->get($_GET['confdocs']);
        $categoryManager = new CategoryManager($db);
        $typeManager = new TypeManager($db);
//            $categories = $categoryManager->getList();
        $categories = $categoryManager->getListExcluded($excluded_categories);
//            $types = $typeManager->getList();
        $types = $typeManager->getListExcluded($excluded_types);
        $_SESSION['condominium'] = $condominium;

        require('../view/backend/documentConf.php');
    }
    elseif (isset($_GET['addpho'])) // Si on veux ajouter une photo
    {
        $condominiumManager = new CondominiumManager($db);
        $condominium = $condominiumManager->get($_GET['addpho']);
        $_SESSION['condominium'] = $condominium;

        require('../view/backend/photoAdd.php');
    }
    elseif (isset($_GET['dlview']))
    {
        if ($_GET['dlview'] == 'doc')
        {
            $condominiumManager = new CondominiumManager($db);
            $documentManager = new DocumentManager($db);
            $downloadManager = new DownloadManager($db);
            $document = $documentManager->get($_GET['doc']);
            $condominium = $condominiumManager->get($document->condominium_id());
            $downloads = $downloadManager->getList($_GET['doc']);

            require('../view/backend/listDownloadsView.php');
        }
    }
    else // Rien dans $_GET
    {
        $condominiumManager = new CondominiumManager($db);
        $documentManager = new DocumentManager($db);
        $general_assemblyManager = new General_assemblyManager($db);
        $photoManager = new PhotoManager($db);
        $downloadManager = new DownloadManager($db);

        if (isset($_POST['submitOpenCondo'])) { // Si on veux ouvrir une copropriété en modification.
            $condominium = $condominiumManager->get($_POST['submitOpenCondo']);
            $documents = $documentManager->getList($_POST['submitOpenCondo']);
            $photos = $photoManager->getList($_POST['submitOpenCondo']);
            $categoryManager = new CategoryManager($db);
            $typeManager = new TypeManager($db);
//            $categories = $categoryManager->getList();
            $categories = $categoryManager->getListExcluded($excluded_categories);
//            $types = $typeManager->getList();
            $types = $typeManager->getListExcluded($excluded_types);
            
            if (!empty($documents)) {
                $downloads_count = [];
                foreach ($documents as $document) {
                 $downloads_count[$document->id()] = $downloadManager->countWithDoc($document->id());
                }
            }

            if ($general_assemblyManager->existsWithCondominium($_POST['submitOpenCondo']))
            {
                $general_assembly = $general_assemblyManager->getWithCondominium($_POST['submitOpenCondo']);
            }
            
            foreach ($categories as $category) {
                $category_var = $category->name();
                $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
            }
            
            require('../view/backend/condominiumView.php');
            $_SESSION['condominium'] = $condominium;
        } elseif (isset($_POST['submitCreateCondo'])) {
            if (isset($_POST['name']) && isset($_POST['postal_code']) && isset($_POST['city']) && $_POST['city'] != '...' && isset($_POST['internal_reference']) && isset($_POST['password'])) {
                // Construire $param
                $param = $_POST;
                array_pop($param);
                $city_line_5 = explode(' - ', $param['city']);
                $param['city'] = $city_line_5[0];
                $param['line_5'] = isset($city_line_5[1]) ? $city_line_5[1] : "";
                $param['featured'] = isset($_POST['featured']) ? 1 : 0;
                $param['internal_reference'] = (string) $_POST['internal_reference'];
                
                $condominium = new Condominium($param); // Créer le nouvel objet
                                
                // Vérifier que la copro est valide et n'existe pas déjà.
                if (!$condominium->validName())
                {
                    $msg = 'Le nom choisi est invalide.';
                    unset($condominium);
                    require('../view/backend/condominiumAdd.php');
                }
                elseif ($condominiumManager->existsName($condominium->name()))
                {
                    $msg = 'Une copropriété existante porte déjà ce nom.';
                    unset($condominium);
                    require('../view/backend/condominiumAdd.php');
                }
                else
                {
                    if (!$condominium->validInternal_reference())
                    {
                        
                        $msg = 'La référence interne choisie est invalide : ' . $condominium->internal_reference();
                        unset($condominium);
                        require('../view/backend/condominiumAdd.php');
                    }
                    elseif ($condominiumManager->existsInternal_reference($condominium->internal_reference()))
                    {
                        $msg = 'Une copropriété existante porte déjà cette référence interne.';
                        unset($condominium);
                        require('../view/backend/condominiumAdd.php');
                    }
                    else
                    {
                        $condominium = $condominiumManager->add($condominium);
                        
                        $photos = $photoManager->getList($condominium->id());
                        require('../view/backend/condominiumView.php');
                        $_SESSION['condominium'] = $condominium;
                   }
                }
            }
            else
            {
                $msg = 'Les informations fournies n\'ont pas permis de créer la nouvelle copropriété.';
                require('../view/backend/condominiumAdd.php');
            }
        }
        elseif (isset($_POST['submitCreateDoc']))
        {
            if (isset($_SESSION['condominium']))
            {
            $condominium = $_SESSION['condominium'];
            }
            
            if (isset($_POST['do_name']) && isset($_POST['do_category']) && $_POST['do_category'] != '' && isset($_FILES['do_file'])) //Les champs sont remplis
            {
                if ($_FILES['do_file']['error'] != 0)
                {
                    $msg = 'erreur : ' . $_FILES['do_file']['error'];
                }
                
                $tmp_file = $_FILES['do_file']['tmp_name']; 
                if( !is_uploaded_file($tmp_file) ) 
                {
                    $msg = 'Le fichier est introuvable pour ' .$condominium->name();
                }
                else // il y a un fichier uploadé
                {
                    $file_type = $_FILES['do_file']['type'];

                    if( !strstr($file_type, 'pdf'))
                    {
                        $msg = 'Le fichier n\'est pas un fichier pdf pour ' .$condominium->name();
                    }
                    else // Le fichier est du bon type
                    {
                        if ($_FILES ["do_file"] ["size"] > 100000000)
                        {
                            $msg = 'Le fichier est trop lourd pour ' .$condominium->name();
                        }                        
                        else // le poids du fichier est correct
                        {
                            include('clean_file_name.php');
                            $file_name = clean_file_name($_FILES['do_file']['name']);
                            if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $file_name) )
                            {
                                $msg='Nom de fichier non valide pour ' .$condominium->name();
                            }
                            else
                            {
                                if (move_uploaded_file($tmp_file,$pdfupload_dir.$file_name ))
                                {
                                    $msg = 'L\'upload s\'est bien passé pour ' .$condominium->name();
                                    // Construire $param.
                                    $param['available'] = isset($_POST['do_available']) ? 1 : 0;
                                    $param['category_id'] = $_POST['do_category'];
                                    $param['condominium_id'] = $condominium->id();
                                    $param['file_name'] = $file_name;
                                    $param['name'] = $_POST['do_name'];
                                    $param['tracked'] = isset($_POST['do_tracked']) ? 1 : 0;
                                    $param['type_id'] = $_POST['do_type'];
                                    $document = new Document($param); // Créer le nouvel objet
                                    $document = $documentManager->add($document);
                                    
                                    $_SESSION['condominium'] = $condominium;

                                    if ($general_assemblyManager->existsWithCondominium($condominium->id()))
                                    {
                                        $general_assembly = $general_assemblyManager->getWithCondominium($condominium->id());
                                    }
                                    $documents = $documentManager->getList($document->condominium_id());
                                    
                                    $photos = $photoManager->getList($condominium->id());
                                    $categoryManager = new CategoryManager($db);
                                    $typeManager = new TypeManager($db);
                        //            $categories = $categoryManager->getList();
                                    $categories = $categoryManager->getListExcluded($excluded_categories);
                        //            $types = $typeManager->getList();
                                    $types = $typeManager->getListExcluded($excluded_types);
                                    foreach ($categories as $category)
                                    {
                                        $category_var = $category->name();
                                        $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
                                    }
                                    
                                    require('../view/backend/condominiumView.php');
                                }
                            }
                        }
                    }
                }

            } else {
                $msg = 'Les informations fournies n\'ont pas permis d\'enregistrer le nouveau document pour ' .$condominium->name();
                $categoryManager = new CategoryManager($db);
                $typeManager = new TypeManager($db);
        //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                $_SESSION['condominium'] = $condominium;

                require('../view/backend/documentAdd.php');
            }            
        }
        elseif (isset($_POST['submitCreatePho']))
        {
            if (isset($_SESSION['condominium']))
            {
                $condominium = $_SESSION['condominium'];
            }
            
            if (isset($_FILES['ph_file'])) //Les champs sont remplis
            {
                if ($_FILES['ph_file']['error'] != 0)
                {
                    $msg = 'erreur : ' . $_FILES['ph_file']['error'];
                }
                
                $tmp_file = $_FILES['ph_file']['tmp_name']; 
                if( !is_uploaded_file($tmp_file) ) 
                {
                    $msg = 'Le fichier est introuvable pour ' .$condominium->name();
                }
                else // il y a un fichier uploadé
                {
                    $file_type = $_FILES['ph_file']['type'];

                    if(!strstr($file_type, 'png') && !strstr($file_type, 'jpg') && !strstr($file_type, 'jpeg'))
                    {
                        $msg = 'Le fichier n\'est pas un fichier jpg, jpeg ou png pour ' .$condominium->name();
                    }
                    else // Le fichier est du bon type
                    {
                        if ($_FILES ["ph_file"] ["size"] > 5000000)
                        {
                            $msg = 'Le fichier est trop lourd pour ' .$condominium->name();
                        }                        
                        else // le poids du fichier est correct
                        {
                            include('clean_file_name.php');
                            $file_name = clean_file_name($_FILES['ph_file']['name']);
                            if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $file_name) )
                            {
                                $msg='Nom de fichier non valide pour ' .$condominium->name();
                            }
                            else
                            {
                                if (move_uploaded_file($tmp_file,$phoupload_dir.$file_name ))
                                {
                                    $msg = 'L\'upload s\'est bien passé pour ' .$condominium->name();
                                    // Construire $param.
                                    // Combien y-a-t-il déjà de photo pour cette copro ?
                                    $count = $photoManager->count($condominium->id());
                                    if ($count == 0)
                                    {
                                        $param['position'] = 1;
                                    }
                                    elseif($count == 1)
                                    {
                                        $param['position'] = 2;
                                    }
                                    else
                                    {
                                        $msg='Il n\est pas possible d\enregistrer plus de 2 photo pour une copropriété';
                                        exit();
                                    }
                                    $param['condominium_id'] = $condominium->id();
                                    $param['file_name'] = $file_name;
                                    
                                    $photo = new Photo($param); // Créer le nouvel objet                                    
                                    $photo = $photoManager->add($photo);
                                    
                                    $_SESSION['condominium'] = $condominium;

                                    if ($general_assemblyManager->existsWithCondominium($condominium->id()))
                                    {
                                        $general_assembly = $general_assemblyManager->getWithCondominium($condominium->id());
                                    }

                                    $documents = $documentManager->getList($photo->condominium_id());
                                    
                                    $photos = $photoManager->getList($photo->condominium_id());
                                    $categoryManager = new CategoryManager($db);
                                    $typeManager = new TypeManager($db);
                        //            $categories = $categoryManager->getList();
                                    $categories = $categoryManager->getListExcluded($excluded_categories);
                        //            $types = $typeManager->getList();
                                    $types = $typeManager->getListExcluded($excluded_types);
                                    foreach ($categories as $category)
                                    {
                                        $category_var = $category->name();
                                        $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
                                    }
                                    
                                    require('../view/backend/condominiumView.php');
                                }
                            }
                        }
                    }
                }

            }
            else
            {
                $msg = 'Les informations fournies n\'ont pas permis d\'enregistrer la nouvelle photo pour ' .$condominium->name();
                require('../view/backend/photoAdd.php');
            }            
        }
        elseif (isset($_POST['submitOpenGA'])) // Si on veux ouvrir une copropriété en modification.
        {
            $condominium = $condominiumManager->get($_POST['submitOpenGA']);
            if ($general_assemblyManager->existsWithCondominium($_POST['submitOpenGA']))
            {
                $general_assembly = $general_assemblyManager->getWithCondominium($_POST['submitOpenGA']);
            }                                        
            require('../view/backend/generalAssemblyView.php');
            $_SESSION['condominium'] = $condominium;
        }
        elseif (isset($_POST['submitCreateGA']))
        {
            $condominium = $condominiumManager->get($_POST['condominium_id']);
            if ($general_assemblyManager->existsWithCondominium($_POST['condominium_id']))
            {
                $general_assembly = $general_assemblyManager->getWithCondominium($_POST['condominium_id']);
                $general_assembly_id = $general_assembly->id();
                $action = 'modification';
            }
            else
            {
                $action = 'creation';
            }
            
            if (isset($_POST['day']) && ((isset($_POST['postal_code']) && isset($_POST['city']) && $_POST['city'] != '...') || (!isset($_POST['postal_code'])) || $_POST['postal_code'] == ''))
            {
                // Construire $param.
                $param = $_POST;
                array_pop($param); // Retirer l'élément submit à la fin du tableau.

                // Séparer les attributs city et line_5.
                if (isset($param['city']))
                {
                $city_line_5 = explode(' - ', $param['city']); 
                $param['city'] = $city_line_5[0];
                $param['line_5'] = isset($city_line_5[1]) ? $city_line_5[1] : "";                    
                }
                
                // Contrôler le format et Concaténer la date et l'heure
                if (!preg_match('#^(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))$#', $param['day']))
                {
                    if (!preg_match
                    ('#^(?:(?:0[1-9]|[12][0-9])[\/\\-. ]?(?:0[1-9]|1[0-2])|(?:30[\/\\-. ]?(?:0[13-9]|1[0-2]))|(?:31[\/\\-. ]?(?:0[13578]|1[02])))[\/\\-. ]?(?:19|20)[0-9]{2}$#', $param['day']))
                    {
                        $msg = '"' . $param['day'] . '" n\'est pas une date valide';
                    }
                    else
                    {
                        $param['ga_time'] = preg_replace('#^(\d{2})[\/\\-. ]?(\d{2})[\/\\-. ]?(\d{4})$#', '$3-$2-$1', $param['day']);
                        if (isset($param['hours']) && $param['hours'] != '')
                        {
                            if (!preg_match('#^(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])$#', $param['hours']))
                            {
                                $msg = 'L\'heure doit être au format spécifié';
                            }
                            else
                            {
                                $param['ga_time'] .= ' ' . $param['hours'] . ':00';
                            }
                        }
                        else
                        {
                            $param['ga_time'] .= ' 00:00:00';
                        }

                    }    
                }
                else
                {
                    $param['ga_time'] = $param['day'];
                    if (isset($param['hours']) && $param['hours'] != '')
                    {
                        if (!preg_match('#^(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])$#', $param['hours']))
                        {
                            $msg = 'L\'heure doit être au format spécifié';
                        }
                        else
                        {
                            $param['ga_time'] .= ' ' . $param['hours'] . ':00';
                        }
                    }
                    else
                    {
                        $param['ga_time'] .= ' 00:00:00';
                    }
                }
                unset($param['hours']);
                unset($param['day']);
                
                if (!isset($msg))
                {
                    if ($action == 'modification')
                    {
                        $param['id'] = $general_assembly_id;
                        $general_assembly = new General_assembly($param); // Créer le nouvel objet
                        $general_assembly = $general_assemblyManager->update($general_assembly);
                    }
                    else
                    {
                        $general_assembly = new General_assembly($param); // Créer le nouvel objet
                        $general_assembly = $general_assemblyManager->add($general_assembly);
                    }
                    $condominium = $condominiumManager->get($general_assembly->condominium_id());
                    $general_assembly = $general_assemblyManager->getWithCondominium($condominium->id());
                    
                    $photos = $photoManager->getList($condominium->id());
                    
                    $documents = $documentManager->getList($condominium->id());
                    $categoryManager = new CategoryManager($db);
                    $typeManager = new TypeManager($db);
        //            $categories = $categoryManager->getList();
                    $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                    $types = $typeManager->getListExcluded($excluded_types);
                    foreach ($categories as $category)
                    {
                        $category_var = $category->name();
                        $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
                    }
                    
                    require('../view/backend/condominiumView.php');
                    $_SESSION['condominium'] = $condominium;
                }
                else
                {
                    $condominium = $condominiumManager->get($_POST['condominium_id']);
                    require('../view/backend/generalAssemblyView.php');
                }
            }
            else
            {
                if ($action == 'modification')
                {
                $msg = 'Les informations fournies n\'ont pas permis de modifier le programmation de l\'assemblée générale.';
                }
                else
                {
                $msg = 'Les informations fournies n\'ont pas permis de programmer l\'assemblée générale.';
                }
                $condominium = $condominiumManager->get($_POST['condominium_id']);
                require('../view/backend/generalAssemblyView.php');
            }
        }
        elseif (isset($_POST['submitDeleteGA']))
        {
            $condominiumManager = new CondominiumManager($db);
            $general_assemblyManager = new General_assemblyManager($db);
            $general_assembly = $general_assemblyManager->getWithCondominium($_POST['co_id']);
            $condominium = $condominiumManager->get($_POST['co_id']);
            if ($general_assembly)
            {
                $count = $general_assemblyManager->delete($general_assembly->id());
                if ($count == 1)
                {
                    unset($general_assembly);
                    $photos = $photoManager->getList($condominium->id());
                    $documents = $documentManager->getList($condominium->id());
                    $categoryManager = new CategoryManager($db);
                    $typeManager = new TypeManager($db);
        //            $categories = $categoryManager->getList();
                    $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                    $types = $typeManager->getListExcluded($excluded_types);
                    foreach ($categories as $category)
                    {
                        $category_var = $category->name();
                        $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
                    }

                    require('../view/backend/condominiumView.php');
                }
                else
                {
                    $msg = 'Un problème est survenu pendant la suppression';
                    $photos = $photoManager->getList($condominium->id());
                    $documents = $documentManager->getList($condominium->id());
                    $categoryManager = new CategoryManager($db);
                    $typeManager = new TypeManager($db);
        //            $categories = $categoryManager->getList();
                    $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                    $types = $typeManager->getListExcluded($excluded_types);
                    foreach ($categories as $category)
                    {
                        $category_var = $category->name();
                        $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
                    }

                    require('../view/backend/condominiumView.php');
                    
                } 
            }
            else
            {
                $msg = 'Un problème est survenu pendant la suppression';
                $photos = $photoManager->getList($condominium->id());
                $categoryManager = new CategoryManager($db);
                $typeManager = new TypeManager($db);
    //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
    //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                foreach ($categories as $category)
                {
                    $category_var = $category->name();
                    $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
                }

                require('../view/backend/condominiumView.php');
            } 
        }
        elseif (isset($_POST['submitDeletePho']))
        {
            $condominiumManager = new CondominiumManager($db);
            $photoManager = new PhotoManager($db);
            $photo = $photoManager->get($_POST['ph_id']);
            $condominium = $condominiumManager->get($photo->condominium_id());
            $count = $photoManager->delete($photo->id());
            if ($count == 1)
            {
                unlink($phoupload_dir . $photo->file_name());
                unset($photo);
                $photos = $photoManager->getList($condominium->id());
                // s'il reste une photo, passer sa position à 1.
                if ($photoManager->count($condominium->id()))
                {
                    $photo1 = $photos[0];
                    if ($photo1->position() == 2)
                    {
                        $photo1->setPosition(1);
                        $photoManager->update($photo1);
                    }
                }
               if ($general_assemblyManager->existsWithCondominium($condominium->id()))
                {
                    $general_assembly = $general_assemblyManager->getWithCondominium($condominium->id());
                }
                 
                $documents = $documentManager->getList($condominium->id());                
                $categoryManager = new CategoryManager($db);
                $typeManager = new TypeManager($db);
    //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
    //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                foreach ($categories as $category)
                {
                    $category_var = $category->name();
                    $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
                }

                require('../view/backend/condominiumView.php');
            }
            else
            {
                $msg = 'Un problème est survenu pendant la suppression';
            }
        }
        elseif (isset($_POST['submitDeleteCon']))
        {
            $condominiumManager = new CondominiumManager($db);
            $condominium_id = $_POST['co_id'];
            $condominium = $condominiumManager->get($condominium_id);
            $photoManager = new PhotoManager($db);
            $photos = $photoManager->getList($_POST['co_id']);
            $documentManager = new DocumentManager($db);
            $documents = $documentManager->getList($_POST['co_id']);
            $general_assemblyManager = new General_assemblyManager($db);
            $addressManager = new AddressManager($db);
            $address_id = $condominium->address_id();
            
            
        
            if (!$general_assemblyManager->existsWithCondominium($condominium_id) && empty($documents) && empty($photos))
            {
                $count = $condominiumManager->delete($condominium_id);
                
                if ($count == 1)
                {
                    //Si l'adresse n'est pas utilisée ailleurs, supprimer l'adresse
                    
                    if (($condominiumManager->countAddress_id($address_id) == 0) && ($general_assemblyManager->countAddress_id($address_id) == 0)) // Si l'adresse n'est pas utilisée ailleurs, on la supprime
                    {
                        $addressManager->delete($address_id);
                    }

                    unset($condominium);
                    $condominiums = $condominiumManager->getList();        // Récupérer la liste des copros.
                    if (empty($condominiums))
                    {
                        $msg = 'Aucune copropriété à afficher';
                    }
                    unset($_SESSION['condominium']);
                    require('../view/backend/listCondominiumsView.php');
                }
            }
            else
            {
                $msg = 'Un problème est survenu pendant la suppression';
            }
        }
        elseif (isset($_POST['submitModifUser1']))
        {
            if( preg_match('#^.{4,}$#', $_POST['name']) )
            {
                $param = $_POST;
                array_pop($param);
                $param['id'] = 1;
                $usermodif = new User($param);
                $userManager->update($usermodif);                
            }
            else
            {
                $msg = 'Les informations ne sont pas au bon format';
                
            }
            if ($user_id == 1) // Session
            {
                $categoryManager = new CategoryManager($db);
                $typeManager = new TypeManager($db);
                $user1 = $userManager->get(1);
                $user2 = $userManager->get(2);
        //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                $user = $userManager->get($user_id);
                $user_name = $user->name();

                require('../view/backend/admin.php');
            }
            else
            {
                require('../view/backend/listCondominiumsView.php');
            }

        }
        elseif (isset($_POST['submitModifUser2']))
        {
            if( preg_match('#^.{4,}$#', $_POST['name']) )
            {
                $param = $_POST;
                array_pop($param);
                $param['id'] = 2;
                $usermodif = new User($param);
                $userManager->update($usermodif);                
            }
            else
            {
                $msg = 'Les informations ne sont pas au bon format';
                
            }
            if ($user_id == 1) // Session
            {
                $categoryManager = new CategoryManager($db);
                $typeManager = new TypeManager($db);
                $user1 = $userManager->get(1);
                $user2 = $userManager->get(2);
        //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                require('../view/backend/admin.php');
            }
            else
            {
                require('../view/backend/listCondominiumsView.php');
            }
         }
        elseif (isset($_POST['deleteCategory']))
        {
            $categoryManager = new CategoryManager($db);
            $nbDocs = $documentManager->countWithCategory($_POST['id']);
            if ($nbDocs == 0)
            {
                if ($categoryManager->count() > 1)
                {
                    // quel est la position de la category à supprimer ?
                    // List des categories dont la position est supérieure -> diminiuer leur position de 1
                    $categoryToDelete = $categoryManager->get($_POST['id']);
                    $positionToDelete = $categoryToDelete->position(); 
                    $categoryManager->delete($_POST['id']);
                    $categories = $categoryManager->getList();
                    foreach($categories as $category)
                    {
                        if ($category->position() > $positionToDelete)
                        {
                            $category->setPosition($category->position() - 1);
                            $categoryManager->update($category);
                        }
                    }
                }
                else
                {
                    $msg = 'Il n\'est pas possible de supprimer la catégorie s\'il n\'en reste qu\'une';
                }
                if ($user_id == 1) // Session
                {
                    $typeManager = new TypeManager($db);
                    $user1 = $userManager->get(1);
                    $user2 = $userManager->get(2);
            //            $categories = $categoryManager->getList();
                    $categories = $categoryManager->getListExcluded($excluded_categories);
            //            $types = $typeManager->getList();
                    $types = $typeManager->getListExcluded($excluded_types);
                    require('../view/backend/admin.php');
                }
                else
                {
                    require('../view/backend/listCondominiumsView.php');
                }

            }
            else
            {
                $msg = 'Il n\'est pas possible de supprimer une catégorie si un ou des documents appartiennent à cette catégorie';
            }
        }
        elseif (isset($_POST['moveUpCategory']))
        {
            $categoryManager = new CategoryManager($db);

            
            
            // quel est la position de la category à déplacer ?
            // Quelle est la catégorie dont la position est  immédiatement inférieure -> augmenter sa position de 1 leur position de 1
            $categoryToMoveUp = $categoryManager->get($_POST['id']);
            $positionToDecrease = $categoryToMoveUp->position();
            $categoryToMoveDown = $categoryManager->getWithPosition($positionToDecrease - 1);
            $categoryToMoveUp->setPosition(99);
            $categoryManager->update($categoryToMoveUp);
            $categoryToMoveDown->setPosition($positionToDecrease);
            $categoryManager->update($categoryToMoveDown);
            $categoryToMoveUp->setPosition($positionToDecrease - 1);
            $categoryManager->update($categoryToMoveUp);
            $categories = $categoryManager->getList();

            if ($user_id == 1) // Session
            {
                $typeManager = new TypeManager($db);
                $user1 = $userManager->get(1);
                $user2 = $userManager->get(2);
        //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                require('../view/backend/admin.php');
            }
            else
            {
                require('../view/backend/listCondominiumsView.php');
            }

        }
        elseif (isset($_POST['createCategory']))
        {
            if( preg_match('#^.{4,}$#', $_POST['name']) )
            {
                $categoryManager = new CategoryManager($db);
                if (!$categoryManager->existsWithName($_POST['name']))
                {
                    $param = $_POST;
                    array_pop($param);
                    $param['name'] = strtolower($param['name']);
                    $param['position'] = $categoryManager->maxPosition() + 1;
                    $category = new Category($param);
                    $category = $categoryManager->add($category);
                }
                else
                {
                    $msg = 'Cette catégorie existe déjà';
                }
            }
            else
            {
                $msg = 'Les informations ne sont pas au bon format';
                
            }
            if ($user_id == 1) // Session
            {
                $categoryManager = new CategoryManager($db);
                $typeManager = new TypeManager($db);
                $user1 = $userManager->get(1);
                $user2 = $userManager->get(2);
        //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                require('../view/backend/admin.php');
            }
            else
            {
                require('../view/backend/listCondominiumsView.php');
            }
        }
        elseif (isset($_POST['deleteType']))
        {
            $typeManager = new TypeManager($db);
            $nbDocs = $documentManager->countWithType($_POST['id']);
            if ($nbDocs == 0)
            {
                if ($typeManager->count() > 1)
                {
                    $count = $typeManager->delete($_POST['id']);
                }
                else
                {
                    $msg = 'Il n\'est pas possible de supprimer le type s\'il n\'en reste qu\'un';
                }
                if ($user_id == 1) // Session
                {
                    $categoryManager = new CategoryManager($db);
                    $typeManager = new TypeManager($db);
                    $user1 = $userManager->get(1);
                    $user2 = $userManager->get(2);
            //            $categories = $categoryManager->getList();
                    $categories = $categoryManager->getListExcluded($excluded_categories);
            //            $types = $typeManager->getList();
                    $types = $typeManager->getListExcluded($excluded_types);
                    require('../view/backend/admin.php');
                }
                else
                {
                    require('../view/backend/listCondominiumsView.php');
                }

            }
            else
            {
                $msg = 'Il n\'et pas possible de supprimer un type si un ou des documents appartiennent à ce type';
            }
        }
        elseif (isset($_POST['createType']))
        {
            if( preg_match('#^.{4,}$#', $_POST['name']) )
            {
                $typeManager = new TypeManager($db);
                if (!$typeManager->existsWithName($_POST['name']))
                {
                    $param = $_POST;
                    array_pop($param);
                    $param['name'] = strtolower($param['name']);
                    $type = new Type($param);
                    $type = $typeManager->add($type);
                }
                else
                {
                    $msg = 'Ce type existe déjà';
                }
            }
            else
            {
                $msg = 'Les informations ne sont pas au bon format';
                
            }
            if ($user_id == 1) // Session
            {
                $categoryManager = new CategoryManager($db);
                $user1 = $userManager->get(1);
                $user2 = $userManager->get(2);
        //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
        //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                require('../view/backend/admin.php');
            }
            else
            {
                require('../view/backend/listCondominiumsView.php');
            }
        }
        elseif (isset($_POST['submitDeleteDownload']))
        {
            $downloadManager = new DownloadManager($db);
            $param = $_POST;
            $button = array_pop($param); // Bouton valid
            $condominium_id = array_shift($param);
            $document_id = array_shift($param);
            foreach($param as $id)
            {
                $downloadManager->delete($id);
            }
            $document = $documentManager->get($document_id);
            $condominium = $condominiumManager->get($condominium_id);
            $remaining_count = $downloadManager->countWithDoc($document->id());
            if ($remaining_count == 0)
            {
                $documents = $documentManager->getList($condominium_id);
                $photos = $photoManager->getList($condominium_id);
                $categoryManager = new CategoryManager($db);
                $typeManager = new TypeManager($db);
    //            $categories = $categoryManager->getList();
                $categories = $categoryManager->getListExcluded($excluded_categories);
    //            $types = $typeManager->getList();
                $types = $typeManager->getListExcluded($excluded_types);
                foreach ($categories as $category)
                {
                    $category_var = $category->name();
                    $$category_var = $documentManager->getListByCategory($condominium->id(), $category->id());
                }
                
                if ($general_assemblyManager->existsWithCondominium($condominium_id))
                {
                    $general_assembly = $general_assemblyManager->getWithCondominium($condominium_id);
                }
                if (!empty($documents))
                {
                    $downloads_count = [];
                    foreach ($documents as $document)
                    {
                        $downloads_count[$document->id()] = $downloadManager->countWithDoc($document->id());
                    }
                }
                require('../view/backend/condominiumView.php');                
            }
            else
            {
                $downloads = $downloadManager->getList($document_id);
                require('../view/backend/listDownloadsView.php');                
            }
        }
        else // Rien dans $_POST.
        {
            $condominiums = $condominiumManager->getList();        // Récupérer la liste des copros.
            if (empty($condominiums))
            {
                $msg = 'Aucune copropriété à afficher';
            }
            unset($_SESSION['condominium']);
            require('../view/backend/listCondominiumsView.php');
        }
    }
}
else // Si la session user n'existe pas, est-ce qu'on vient du formulaire d'identification ?
{

    if (isset($_POST['username']) && isset($_POST['pwd'])) // Si on vient de remplir le formulaire d'identification.
    {
        $msg = '';
        
        // On vérifie que la méthode POST est utilisée
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // On vérifie si le champ "recaptcha-response" contient une valeur
            if(empty($_POST['recaptcha-response']))
            {
                $msg .= 'Demande non valide';
                require('../view/backend/logginFormView.php');
            }
            else
            {
                // On prépare l'URL
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LdC--4UAAAAACU9a4nqU-hmxWcIOS9SoWkxNj6x&response={$_POST['recaptcha-response']}";
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
                    $msg .= 'Demande non acceptée';
                    require('../view/backend/logginFormView.php');
                }
                else
                {
                    $data = json_decode($response);
                    if($data->success)
                    {
                        if(!empty($_POST['username']) && !empty($_POST['pwd']))
                        {
                            // On nettoie le contenu
                            $username = strip_tags($_POST['username']);
                            $pwd = strip_tags($_POST['pwd']);

                            // Ici vous traitez vos données
                            if ($userManager->valid($username, $pwd)) // Si l'identification est validée
                            {
                                $user = $userManager->getWithNamePassword($username, $pwd);
                                $_SESSION['user'] = $user->id();
                                if (isset($_POST['remember_user'])) // Si la case remember_user est cochée
                                {
                                    setcookie('remember_user', $user->name(), time() + 90*24*3600, null, null, false, true);
                                }
                                else{
                                    if (isset($_COOKIE['remember_user']))
                                    {
                                        setcookie('remember_user', '', time() - 3600, null, null, false, true);
                                    }
                                }
                                header('Location: index.php');
                            }
                            else 
                            {
                                $msg .= 'Veuillez vérifer le nom d\'utilisateur et le mot de passe. Au moins l\'un des deux n\'est pas valide';
                                require('../view/backend/logginFormView.php');

                            }
                        }
                    }
                    else
                    {
                    $msg .= 'Demande non acceptée';
                    require('../view/backend/logginFormView.php');
                    }
                }
            }
        }
        else
        {
            http_response_code(405);
            echo 'Méthode non autorisée';
        }        

        
        /**************************/

    }
    else // On ne vient pas du formulaire d'identification
    {
        if (isset($_COOKIE['remember_user'])) // S'il y a un cookie, on appelle le formulaire prérempli.
        {
            $remember_user = $_COOKIE['remember_user'];
        }
        require('../view/backend/logginFormView.php');
    }
}



// À la fin on reseigne la variable session user
if (isset($user))
{
    $_SESSION['user'] = $user->id();
//    session_unset();
}

