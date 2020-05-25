<?php $title = 'Ajout d\'un document'; ?>
<?php $bodyid = 'documentAdd'; ?>
<?php ob_start(); ?>


<section class="container">
    <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-2">
                <h6>Ajout d'un<br>document pour </h6>
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
                        <div class="form-group">
                            <label for="do_name">Nom*&nbsp;:</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Entrez le nom du document" name="do_name" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div>
                        <fieldset class="sag sag-bg-white px-2 pb-1">
                            <legend>Catégorie*</legend>
                            
<?php
  if (empty($categories))
  {
      echo('Ce formulaire ne peut pas fonctionner s\'il n\'existe pas de catégorie');
      ?>
                            <script>
                                let disableElts=['submitCreateDoc'];
                            </script>
<?php
  }
  else
  {
    $nblines = 0;
    foreach ($categories as $category)
    {
            ?>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="category<?= $category->id() ?>" name="do_category" value="<?= $category->id() ?>" required>
                                <label class="custom-control-label" for="category<?= $category->id() ?>"><?= $category->name() ?></label>
<?php
                if ($nblines == count($categories)-1)
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
  }
  else
  {
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

    } //END foreach category
  }
        ?>                            
                        </fieldset>
                    </div>
                    <div class="col-sm-6">
                        <p>Upload d'un fichier pdf (taille max. 100 Mo)*&nbsp;:</p>
                        <div class="custom-file">
                            <input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
                            <input type="file" class="custom-file-input" name="do_file" accept="application/pdf" required>
                            <label class="custom-file-label" for="do_file">Choisissez ou déposez un fichier</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div>
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
                </div>
            </form>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require('template.php');
?>