<?php
// Autoload
function loadClass($classname)
{
    set_include_path('../model/');
    require $classname . '.php';
}

spl_autoload_register('loadClass');

session_start(); //On appelle session_start APRÈS avoir enregistré l'autoload.

// A SUPPRIMMER
//    session_destroy();
//    header('Location: ');
//    exit();
// END A SUPPRIMER

if (isset($_POST['deconnection']))
{
    session_destroy();
    header('Location: .');
    exit();
}

require('../config/connect.php');
require('../config/vars.php');

$pdfdownload_dir = '../pdf/';//
$phodownload_dir = '../pho/';

$condominiumManager = new CondominiumManager($db);

if (isset($_GET['contact']) && $_GET['contact'] == 1)
{
    require('../view/frontend/contactForm.php');
}
elseif (isset($_GET['password']) && $_GET['password'] == 1)
{
    $fgtpw = 1;
    require('../view/frontend/contactForm.php');
}
else
{
    if (isset($_SESSION['condo'])) // Si la session perso existe, on restaure l'objet.
    {
        $categoryManager = new CategoryManager($db);
        $photoManager = new PhotoManager($db);
        $general_assemblyManager = new General_assemblyManager($db);
        $documentManager = new DocumentManager($db);
        $condominium_id = $_SESSION['condo'];
        $condominium = $condominiumManager->get($condominium_id);

        $photos = $photoManager->getList($condominium->id());
        $general_assembly = $general_assemblyManager->getWithCondominium($condominium->id());
        $categories = $categoryManager->getList();
        $documents = $documentManager->getList($condominium->id());
        $fiche = $documentManager->getFiche($condominium->id());
        $recent_documents = $documentManager->getListRecent($condominium->id());
        foreach ($categories as $category)
        {
            $category_var = $category->name();
            $$category_var = $documentManager->getListWithCategory($condominium_id, $category->id());
        }

        require('../view/frontend/espaceCoproView.php');

    }
    else // Si la session user n'existe pas, est-ce qu'on vient du formulaire d'identification ?
    {
        if (isset($_POST['member_name']) && isset($_POST['pwd'])) // Si on vient de remplir le formulaire d'identification.
        {
            $msg = '';

            // On vérifie que la méthode POST est utilisée
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                // On vérifie si le champ "recaptcha-response" contient une valeur
                if(empty($_POST['recaptcha-response']))
                {
                    $msg .= 'Votre demande n\'est pas valide';
                    require('../view/frontend/logginCoproView.php');
                }
                else
                {
                    // On prépare l'URL
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchakey}&response={$_POST['recaptcha-response']}";
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
                        $msg .= 'Votre demande n\'est pas acceptée';
                        require('../view/frontend/logginCoproView.php');
                   }
                    else
                    {
                        $data = json_decode($response);
                        if($data->success)
                        {
                            if(!empty($_POST['member_name']) && !empty($_POST['pwd']))
                            {
                                // On nettoie le contenu
                                $member_name = strip_tags($_POST['member_name']);
                                $pwd = strip_tags($_POST['pwd']);
                                // Ici on traite les données
                                if ($condominiumManager->valid($member_name, $pwd)) // Si l'identification est validée
                                {
                                    $condominium = $condominiumManager->getWithNamePassword($member_name, $pwd);
                                    $_SESSION['condo'] = $condominium->id();
                                    if (isset($_POST['remember_member'])) // Si la case remember_user est cochée
                                    {
                                        setcookie('remember_member', $condominium->name(), time() + 90*24*3600, null, null, false, true);
                                    }
                                    else{
                                        if (isset($_COOKIE['remember_member']))
                                        {
                                            setcookie('remember_member', '', time() - 3600, null, null, false, true);
                                        }
                                    }
                                    header('Location: index.php');
                                }
                                else  // Si l'identification n'est pas validée
                                {
                                    $msg .= 'Veuillez vérifer le nom de copropriété et le mot de passe. Au moins l\'un des deux n\'est pas valide';
                                    require('../view/frontend/logginCoproView.php');
                                }
                            }
                        }
                        else
                        {
                            $msg .= 'Votre demande n\'est pas acceptée';
                            require('../view/frontend/logginCoproView.php');
                        }
                    }
                }
            }
            else
            {
            http_response_code(405);
            echo 'Méthode non autorisée';
            }
            
            
 /*******/
            
        }
        else // On ne vient pas du formulaire d'identification
        {
            if (isset($_COOKIE['remember_member'])) // S'il y a un cookie, on appelle le formulaire prérempli.
            {
                $remember_member = $_COOKIE['remember_member'];
            }
            $msg = '';
//            $msg = '<i class="material-icons md-18 hidden-xs">arrow_back</i><i class="material-icons md-18 hidden-sm hidden-md hidden-lg">arrow_upward</i>&nbsp;Commencez à taper le nom ou un élément de l\'adresse de votre copropriété, puis choisissez dans la liste.';
            require('../view/frontend/logginCoproView.php');      
        }
    }
}
// À la fin on renseigne la variable session user
if (isset($user))
{
    $_SESSION['user'] = $user->id();
//    session_unset();
}

