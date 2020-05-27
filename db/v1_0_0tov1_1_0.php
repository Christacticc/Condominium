<?php
/* Script de migration de la DB de v1.0.0 à v1.1.0

    - Ajout d'un type "to confirm" et d'une catégorie "to confirm" 
    qui seront affectés aux documents upoladés par l'upload multi-fichiers, 
    avant qu'ils ne soient confirmés.
*/

require('../config/connect.php');

try {
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