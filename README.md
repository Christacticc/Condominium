# Condominium

Migration v1.0.0 à v1.1.0

1) Faire 1 sauvegarde intégrale du site distant avec ses images, documents et base de donnée.

2) Modifier à la main les fichiers :
 - config/connect.php pour les paramètres de connexion,
 - admin/index.php pour les paramètres de recaptcha,
 - espacecopro/index.php pour les paramètres de recaptcha,

3) Vérifier et modifier si nécessaire les fichiers :
 - View/backend/logginFormView.php pour les paramètres de recaptcha,
 - View/fronend/logginCoproView.php pour les paramètres de recaptcha,
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
- Dans view/frontend/espacecoproView.php : mettre des icônes de catégorie devant chaque document recent et dans les titres des onglets de catégorie.
- Dans view/frontend/espacecoproView.php : mettre les vignettes imagick au survol des documents.
- Dans view/backend/frag_documentslistrow.php : mettre les vignettes imagick au survol des boutons d'ouverture des documents eye._
- Réorganiser les fichiers pour faciliter les migration : connexion, recaptcha...
- Appliquer une architecture MVC.
- Installer l'appli sur un cloud pour SAAS.