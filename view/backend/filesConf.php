<?php $title = 'Confirmation de fichier(s)'; ?>
<?php $bodyid = 'filesConf'; ?>
<?php ob_start(); ?>


<section class="container">
    <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-2">
                <h6>Confirmation de<br>fichier(s) pour </h6>
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
    <p class="text-muted">Aucun document pour cette copropriété</p>
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
            <div class="card bg-light mb-3">
                <form enctype="multipart/form-data" action="index.php" method="post" class="needs-validation" novalidate>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="<?= $pdfdownload_dir . $document->file_name() ?>" target="_blank" class="btn btn-outline-info chr-btn-thumb" title="Ouvrir le document dans un nouvel onglet"><img src="imagick.php?file=<?= $pdfdownload_dir . $document->file_name() ?>" class="img-fluid img-thumbnail">
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <label>Nom du fichier&nbsp;:</label>
                                <div class="card bg-light p-1"><?= $document->file_name() ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                                <div class="form-group">
                                    <label for="do_name">Nom du document*&nbsp;:</label>
                                    <input type="text" class="form-control form-control-sm" name="do_name" required>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Ce champ est obligatoire</div>
                                </div>
                                <fieldset class="sag sag-bg-white px-2 pb-1">
                                    <legend>Catégorie*</legend>
                            
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
                                        <input type="radio" class="custom-control-input" id="category<?= $category->id() ?>" name="do_category" value="<?= $category->id() ?>" required>
                                        <label class="custom-control-label" for="category<?= $category->id() ?>"><?= $category->name() ?></label>
<?php
                if ($nblines == count($categories)-1) {
?>
                                        <div class="valid-feedback ml-3"></div>
                                        <div class="invalid-feedback ml-3">Ce choix est obligatoire</div>
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
                                    <legend>Type*&nbsp;:</legend>
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
                                        <input type="radio" class="custom-control-input" id="type<?= $type->id() ?>" name="do_type" value="<?= $type->id() ?>"<?= count($types) == 1 ? ' checked' : '' ?> required>
                                        <label class="custom-control-label" for="type<?= $type->id() ?>"><?= $type->name() ?></label>
<?php
                if ($nblines == count($types)-1)
                {
?>
                                        <div class="valid-feedback ml-3"></div>
                                        <div class="invalid-feedback ml-3">Ce choix est obligatoire</div>
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
                                    <div class="row">
                                        <div class="col-sm-4 offset-sm-2 text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="do_available" id="do_available">
                                                <label class="custom-control-label" for="do_available">Publié</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="do_tracked" id="do_tracked">
                                                <label class="custom-control-label" for="do_tracked">Suivi</label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="text-right mt-4">
                                    <div class="btn-group text-right">
                                        <button type="submit" id="submitCreateDoc" name="submitCreateDoc" class="btn btn-primary" title="Enregistrer le nouveau document">Enregistrer</button>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <p id="message"></p>
                    </div>
                </form>
            </div> 
        </div>
<?php
    } //END foreach document
?>
    </div>
</section>
<?php
}
?>
    



<?php
$content = ob_get_clean();
require('template.php');
?>