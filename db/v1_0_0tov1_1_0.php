<?php
/* Script de migration de la DB de v1.0.0 à v1.1.0

    1) Pour la fonctionnalité d'upload multi-fichiers : 
    Ajout d'un type "to confirm" et d'une catégorie "to confirm" 
    qui seront affectés aux documents upoladés par l'upload multi-fichiers, 
    avant qu'ils ne soient confirmés.
*/

require('../config/connect.php');

/*try {
    // Vérifier que le nouveau type "to confirm" n'existe pas déjà dans la table s_type.
    $p = $db->query('SELECT COUNT(*) FROM s_type WHERE ty_name = \'to confirm\'');
    if ($p->fetchColumn()) {
        throw new Exception('Le type "to confirm" existe déjà');
    } else {
        // Insérer le nouveau type "to confirm" dans la table s_type.
        $q = $db->prepare('INSERT INTO s_type(ty_name) VALUES (:name)');
        $q->bindValue(':name', 'to confirm');
        $q->execute();
        if ($_to_confirm_id = $db->lastInsertId()) {
            echo('Insertion du type "to confirm" ty_id = ' . $_to_confirm_id . '. Insertion réussie.<br>');
        } else {
                throw new Exception('Échec de l\'insertion du type');
        }
    }

    // Vérifier que la nouvelle catégorie "to confirm" n'existe pas déjà dans la table s_category.
    $p = $db->query('SELECT COUNT(*) FROM s_category WHERE ca_name = \'to confirm\'');
    if ($p->fetchColumn()) {
        throw new Exception('La catégorie "to confirm" existe déjà');
    } else {
        // Insérer le nouveau type "to confirm" dans la table s_type.
        $q = $db->prepare('INSERT INTO s_category(ca_name) VALUES (:name)');
        $q->bindValue(':name', 'to confirm');
        $q->execute();
        if ($_to_confirm_id = $db->lastInsertId()) {
            echo('Insertion de la catégorie "to confirm" ca_id = ' . $_to_confirm_id . '. Insertion réussie.<br>');
        } else {
                throw new Exception('Échec de l\'insertion de la catégorie');
        }
    }

}
    catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

/*  1) Pour la fonctionnalité de tri de l'ordre des documents : 
    
*/


try {
    // Liste des catégories
    $p = $db->query('SELECT ca_id FROM s_category WHERE ca_name <> \'to confirm\' ORDER BY ca_id');
    while ($row = $p->fetchColumn()) {
        $ca_id = $row;
        echo('$ca_id : ' . $ca_id . '<br>');
        // Liste des copros
        $q = $db->query('SELECT co_id FROM s_condominium ORDER BY co_id');
        while ($row2 = $q->fetchColumn()) {
            $co_id = $row2;
            echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$co_id : ' . $co_id . '<br>');
            // Liste des documents
            $r = $db->query('SELECT do_id FROM s_document WHERE do_fk_category_id = ' . $ca_id . ' AND do_fk_condominium_id = ' . $co_id . ' ORDER BY do_creation_time ASC');
            $i = 1;
            while ($row3 = $r->fetch()) {
                $do_id = $row3['do_id'];
                echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$do_id : ' . $do_id);
                // UPDATE des documents
                $s = $db->prepare('UPDATE s_document SET do_sort_number = :sort_number WHERE do_id = :do_id');
                $s->bindValue(':sort_number', $i);
                $s->bindValue(':do_id', $do_id);
                $s->execute();
                echo('sort_number : '. $i . ' - Update OK<br>');                
                $i ++ ;
            }
        }
    }
}
    catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}