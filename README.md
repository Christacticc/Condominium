# Condominium

Condominium permet au syndic professionnel de mettre les informations et documents de la copropriété à la disposition des copropriétaires sur un espace web dédié.

Si vous êtes syndic de copropriété professionnel, l'application Condominium est faite pour vous.
Elle vous permet d'administrer un "espace copropriétaire" sous forme d'une page web qui peut être intégrée à votre site Internet.

Au moyen d'une plateforme d'administration simple et complète, vous y mettez les informations permanentes et temporaires de toutes les copropriétés que vous gérez, des photos, un agenda.
Vous y uploadez les documents financiers, juridiques et techniques qui seront disponibles en téléchargement.
Vous y mettez également les informations nécessaires pour rejoindre la prochaine assemblée générale, physiquement ou par web-conférence.  

Accès simplifié :
Vous ne souhaitez pas que cet espace copropriétaire soit intégré à votre ERP, ni devoir gérer les accès copropriétaires individuellement : 
L' accès à l'espace copropriétaire se fait simplement avec le nom de la copropriété et un mot de passe commun à ses copropriétaires.

La démonstration en ligne est en accès libre ici: 
http://tacticc.com/Condominium/admin/index.php

Contact : christophe.ribault@tacticc.tech


Migration v1.0.0 à v1.1.0

0) Prévenir le client

1) Faire 1 sauvegarde intégrale du site distant avec ses images, documents et base de donnée.

2) Modifier à la main les fichiers :
 - config/connect.php pour les paramètres de connexion,
 - admin/index.php pour les paramètres de recaptcha,
 - espacecopro/index.php pour les paramètres de recaptcha,

3) Vérifier et modifier si nécessaire les fichiers :
 - View/backend/logginFormView.php pour les paramètres de recaptcha,
 - View/frontend/logginCoproView.php pour les paramètres de recaptcha,
 - includes/headlinks pour les favicons
 
 4) vérifier le dossier public/images
 
 5) Copier les fichiers :
 - admin/* sauf index.php
 - db/v1_0_0tov1_1_0.php
 - espacecopro/* sauf index.php
 - model/*
 - public/css/*
 - public/js/*
 - vendor/drozone-5.7.0
 - view/backend/* sauf logginFormView.php
 - view/frontend/* sauf logginCoproView.php
 
 6) uploader db/v1_0_0tov1_1_0.php
  - l'exécuter pour ugrader la base
  - vérifier la base
 
 7) Uploader les autres fichiers copiés
  - tester l'appli back et front
 
 
 Todo 
- Remplacer Bootstrap 3 par Bootstrap 4 dans le front.
- Dans view/frontend/espacecoproView.php : mettre des icônes de catégorie devant chaque document recent et dans les titres des onglets de catégorie.
- Dans view/frontend/espacecoproView.php : mettre les vignettes imagick au survol des documents.
- Dans view/backend/frag_documentslistrow.php : mettre les vignettes imagick au survol des boutons d'ouverture des documents eye.
- Réorganiser les fichiers pour faciliter les migration : connexion, recaptcha...
- Appliquer une architecture MVC : scinder le fichier admin/index.php en plusieurs contrôleurs et en faire un routeur.
- Installer l'appli sur un cloud pour SAAS.