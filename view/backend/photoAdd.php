<?php $title = 'Ajout d\'une photo'; ?>
<?php $bodyid = 'photoAdd'; ?>
<?php ob_start(); ?>


<section class="container">
    <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-2">
                <h6>Ajout d'une<br>photo pour </h6>
            </div>
            <div class="col-sm-6">
                <h1><?= $condominium->name() ?></h1>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="text-right"><form method="post" name="formOpenCondo" id="formOpenCondo" action="index.php"><button id="submitOpenCondo" name="submitOpenCondo" class="btn btn-success" type="submit" title="Ouvrir cette copropriété" value="<?= $condominium->id() ?>">Retour à la copropriété</button></form></div>
            </div>
        </div>
    </div>
<?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>
    <div class="card bg-light p-2 mt-4 mb-4">
        <div class="card-body">
            <form enctype="multipart/form-data" action="index.php" method="post" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-sm-6">
                        <p>Upload d'un fichier image (jpg, jpeg ou png. Taille max. 5 Mo)&nbsp;:</p>
                        <div class="custom-file">
                            <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                            <input type="file" class="custom-file-input" name="ph_file" accept=".png, .jpg, .jpeg" required>
                            <label class="custom-file-label" for="ph_file">Choisissez ou déposez un fichier image</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right">
                        <p>&nbsp;</p>
                            <div class="btn-group text-right">
                                <button type="submit" id="submitCreatePho" name="submitCreatePho" class="btn btn-primary" title="Enregistrer le nouveau document">Enregistrer</button>
                            </div>
                        <p id="message"></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require('template.php');
?>