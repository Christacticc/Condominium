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
    if (isset($_GET['e']))
    {
        $condominiumManager = new CondominiumManager($db);
        $members = $condominiumManager->getListWithEntry($_GET['e']);
        if(is_array($members))
        {
            $nb_members = 0;
            $member_array = [];
            $members_array = [];
            foreach($members as $member)
            {
                $member_array['id'] = $member->id();
                $member_array['name'] = $member->name();
                $member_array['address_1'] = $member->address_1();
                $member_array['address_2'] = $member->address_2();
                $member_array['postal_code'] = $member->postal_code();
                $member_array['city'] = $member->city();
                $members_array[$nb_members] = $member_array;
                $nb_members ++;
            }
            $response = json_encode($members_array);
        }
        else
        {
            $response = '';
        }
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

