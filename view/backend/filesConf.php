<?php $title = 'Confirmation de fichier(s)'; ?>
<?php $bodyid = 'filesConf'; ?>
<?php ob_start(); ?>


<section class="container">
    <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-2">
                <h6><?php if(count($documents) == 0){echo('Aucun fichier à confirmer');}elseif(count($documents) == 1){echo('1 fichier à confirmer');}else{echo(count($documents)  . ' fichiers à confirmer');} ?> pour </h6>
            </div>
            <div class="col-sm-6">
                <h1><?= $condominium->name() ?></h1>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="text-right"><form method="post" name="formOpenCondo" id="formOpenCondo" action="index.php"><button id="submitOpenCondo" name="submitOpenCondo" class="btn btn-success" type="submit" title="Ouvrir cette copropriété" value="<?= $condominium->id() ?>">Retour à la copropriété</button></form></div>
            </div>
        </div>
    </div>
</section>
<?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>
<?php
if (empty($documents)) {
?>
<section class="container">
    <p class="text-muted">Aucun document à confirmer pour cette copropriété</p>
</section>
<?php    
} else {
?>
<section class="container-fluid">
    <div class="row">
<?php
    foreach ($documents as $document) {

    ?>
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div id="card-<?= $document->id() ?>" class="card bg-light mb-3">
                <form enctype="multipart/form-data" action="index.php" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="do_id" value="<?= $document->id() ?>">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6 p-1">
                                <a href="<?= $pdfdownload_dir . $document->file_name() ?>" target="_blank" class="btn p-1 btn-outline-info chr-btn-thumb fas fa-eye" title="Ouvrir le document dans un nouvel onglet"><img src="imagick.php?file=<?= $pdfdownload_dir . $document->file_name() ?>" class="img-fluid img-thumbnail">
                                </a>
                            </div>
                            <div class="col-sm-6 p-1">

                                <dl class="small">
                                    <dt>Nom du fichier&nbsp;:</dt>
                                    <dd><?= $document->file_name() ?></dd>
                                    <dt>Date de création&nbsp;:</dt>
                                    <dd><?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', 'Le $3/$2/$1 à $4h$5', $document->creation_time()) ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                                <div class="form-group">
                                    <label for="do_name-<?= $document->id() ?>">Nom du document*&nbsp;:</label>
                                    <input type="text" class="form-control form-control-sm" id="do_name-<?= $document->id() ?>" name="do_name" required>
                                   
                                    <span class="invalid-feedback">Ce champ est obligatoire</span>
                                </div>
                                <fieldset class="sag sag-bg-white px-2 pb-1">
                                    <legend>Catégorie*&nbsp;</legend>
                            
<?php
        if (empty($categories)) {
            echo('Ce formulaire ne peut pas fonctionner s\'il n\'existe pas de catégorie');
?>
                                    <script>
                                        let disableElts=['submitCreateDoc'];
                                    </script>
<?php
        } else {
            $nblines = 0;
            foreach ($categories as $category) {
?>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="do_category-<?= $category->id() ?>-<?= $document->id() ?>" name="do_category" value="<?= $category->id() ?>" required>
                                        <label class="custom-control-label" for="do_category-<?= $category->id() ?>-<?= $document->id() ?>"><?= $category->name() ?></label>
<?php
                if ($nblines == count($categories)-1) {
?>
                                        
                                        <span class="invalid-feedback ml-3">Ce choix est obligatoire</span>
<?php
                }
?>
                                    </div>
<?php
            $nblines++ ;

            } //END foreach category
        }
?>                            
                                </fieldset>
                                <fieldset class="sag sag-bg-white px-2 pb-1 mt-2">
                                    <legend>Type*&nbsp;</legend>
<?php
        if (empty($types))
        {
          echo('Ce formulaire ne peut pas fonctionner s\'il n\'existe pas de type');
?>
                                    <script>
                                        let disableElts=['submitCreateDoc'];
                                    </script>
<?php
        } else {
            $nblines = 0;
            foreach ($types as $type)
            {
?>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="do_type-<?= $type->id() ?>-<?= $document->id() ?>" name="do_type" value="<?= $type->id() ?>"<?= count($types) == 1 ? ' checked' : '' ?> required>
                                        <label class="custom-control-label" for="do_type-<?= $type->id() ?>-<?= $document->id() ?>"><?= $type->name() ?></label>
<?php
                if ($nblines == count($types)-1)
                {
?>
                                        
                                        <span class="invalid-feedback ml-3">Ce choix est obligatoire</span>
<?php
                }
?>
                                    </div>
<?php
                $nblines++ ;

            } //END foreach type
        }
?>                            
                                </fieldset>
                                <fieldset class="sag sag-bg-white px-2 pb-1 mt-3">
                                    <legend>Options&nbsp;:</legend>

                                        <div class="d-flex justify-content-around">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="do_available" id="do_available-<?= $document->id() ?>">
                                                <label class="custom-control-label" for="do_available-<?= $document->id() ?>">Publié</label>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="do_tracked" id="do_tracked-<?= $document->id() ?>">
                                                <label class="custom-control-label" for="do_tracked-<?= $document->id() ?>">Suivi</label>
                                            </div>
                                        </div>

                                </fieldset>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="#delModal-<?= $document->id() ?>" class="btn btn-warning chr-wait-for-load" data-toggle="modal" title="Supprimer ce document (avec confirmation)">Supprimer&hellip;</a>
                            <div style="display: table-cell">
                                <i class="fas fa-check fa-2x chr-purple d-none" style="vertical-align: bottom"></i>
                                <button type="submit"  id="submitConfFile" name="submitConfFile" class="btn btn-primary chr-wait-for-load submitConfFile" title="Enregistrer le nouveau document" disabled>Enregistrer</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div> 
                        <!-- The Modal -->
            <div class="modal fade" id="delModal-<?= $document->id() ?>">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p class="text-center"><strong><?= $document->name() ?></strong></p>
                            <p>Êtes-vous certain de vouloir supprimer ce document&nbsp;?</p>
                            <form name="deleteDocForm" name="deleteDocForm-<?= $document->id() ?>" id="deleteDocForm-<?= $document->id() ?>" action="index.php" method="post">
                                <input type="hidden" name="do_id" value="<?= $document->id() ?>">
                                <div class="form-group text-center">
                                    <button class="btn btn-danger btn-sm" type="submit" name="submitDeleteDoc" data-target="#delModal-<?= $document->id() ?>" data-toggle="modal">Oui, supprimer</button>
                                </div>
                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm  btn-outline-secondary" data-dismiss="modal">Non, annuler</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<?php
    } //END foreach document
?>
    </div>
</section>
<section class="container">
    <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-8">
            </div>
            <div class="col-sm-4 mt-2">
                <div class="text-right"><form method="post" name="formOpenCondo" id="formOpenCondo" action="index.php"><button id="submitOpenCondo" name="submitOpenCondo" class="btn btn-success" type="submit" title="Ouvrir cette copropriété" value="<?= $condominium->id() ?>">Retour à la copropriété <?= $condominium->name() ?></button></form></div>
            </div>
        </div>
    </div>
</section>

<?php
}
?>
    



<?php
$content = ob_get_clean();
require('template.php');
?>