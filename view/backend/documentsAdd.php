<?php $title = 'Ajout de document(s)'; ?>
<?php $bodyid = 'documentsAdd'; ?>
<?php ob_start(); ?>
<script>
    const condominium_id = <?= $condominium->id() ?>;
</script>
<section class="container">
    <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-2">
                <h6>Ajout de<br>document(s) pour </h6>
            </div>
            <div class="col-sm-6">
                <h1><?= $condominium->name() ?></h1>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="text-right">
                    <form method="post" name="formOpenCondo" id="formOpenCondo" action="index.php"><button id="submitOpenCondo" name="submitOpenCondo" class="btn btn-success" type="submit" title="Ouvrir cette copropriété" value="<?= $condominium->id() ?>">Retour à la copropriété</button></form>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>
    <div class="card bg-light p-2 mt-4 mb-4">
        <div class="card-body">
            <p>Déposez des fichiers sur la page ou cliquez sur le bouton <em>Ajouter des fichiers</em>.</p>
            <div id="actions" class="row">

                <div class="col-sm-5">
                    <!-- The global file processing state -->
                    <span class="fileupload-process">
                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </span>
                </div>
                <div class="col-sm-7 text-right">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <div class="btn-group">
                        <span class="btn btn-success fileinput-button">
                            <span>Ajouter des fichiers...</span>
                        </span>
                        <button type="submit" class="btn btn-primary start">
                            <span>Envoyer tout</span>
                        </button>
                        <button type="reset" class="btn btn-warning cancel">
                            <span>Enlever tout</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table table-striped files" id="previews">

                <div id="template" class="file-row">
                    <!-- This is used as the file preview template -->
                    <div class="d-none">
                        <span class="preview"><img data-dz-thumbnail /></span>
                    </div>
                    <div class="col-sm-4">
                        <p class="name" data-dz-name></p>
                        <strong class="error text-danger" data-dz-errormessage></strong>
                    </div>
                    <div class="col-sm-2">
                        <p class="size" data-dz-size></p>
                    </div>
                    <div class="col-sm-4">
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </div>
                    <div class="col-sm-2 text-right">
                        <div class="btn-group">
                            <button class="btn btn-primary start" title="Enregistrer le fichier sur le serveur">
                                <span>Envoyer</span>
                            </button>
                            <button data-dz-remove class="btn btn-warning cancel" title="Enlever le fichier de la liste">
                                <span>Enlever</span>
                            </button>
                        </div>
                        <button data-dz-remove class="btn btn-danger delete w-100" title="Supprimer le fichier du serveur">
                            <span>Supprimer</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require('template.php');
?>
