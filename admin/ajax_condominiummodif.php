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
try{
    if (isset($_SESSION['user'])) // Si la session perso existe, on restaure l'objet.
    {
        $user = $_SESSION['user'];
        
        if (isset($_GET['id']))
        {
            if (isset($_GET['postal_code']) && isset($_GET['city']) && $_GET['city'] != '...' )
            {
                // Construire $param.
                $param = $_GET;
                $city_line_5 = explode(' - ', $param['city']);
                $param['city'] = $city_line_5[0];
                $param['line_5'] = isset($city_line_5[1]) ? $city_line_5[1] : "";
            }
            elseif (((isset($_GET['internal_reference'])) && (($_GET['internal_reference']) != '')) || ((isset($_GET['password'])) && (($_GET['password']) != '')) || ((isset($_GET['name'])) && (($_GET['name']) != ''))  || (isset($_GET['address_1'])) || (isset($_GET['address_2'])) || (isset($_GET['message'])))
            {
                $param = $_GET;
            }
            else
            {
                throw new Exception('Données insuffisantes pour effectuer la modification');
            }
            $condominiumManager = new CondominiumManager($db);
            $modified_condominium = $condominiumManager->modify($param);
            $modified_condominium_array['id'] = $modified_condominium->id();
            $modified_condominium_array['internal_reference'] = $modified_condominium->internal_reference();
            $modified_condominium_array['message'] = $modified_condominium->message();
            $modified_condominium_array['name'] = $modified_condominium->name();
            $modified_condominium_array['password'] = $modified_condominium->password();
            $modified_condominium_array['address_id'] = $modified_condominium->address_id();
            $modified_condominium_array['address_1'] = $modified_condominium->address_1();
            $modified_condominium_array['address_2'] = $modified_condominium->address_2();
            $modified_condominium_array['postal_code_id'] = $modified_condominium->postal_code_id();
            $modified_condominium_array['postal_code'] = $modified_condominium->postal_code();
            $modified_condominium_array['city'] = $modified_condominium->city();
            $modified_condominium_array['line_5'] = $modified_condominium->line_5();
            $response = json_encode($modified_condominium_array);
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
    echo $response;
}
    catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

