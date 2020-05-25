<?php $title = 'Ajout d\'une copropriété'; ?>
<?php $bodyid = 'condominiumAdd'; ?>
<?php ob_start(); ?>


<div class="container">
   <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-8">
                <h1><span class="">Ajout d'une copropriété</span></h1>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="text-right"><a class="btn btn-success" href="index.php">Retour à la liste des copropriétés</a></div>
            </div>
        </div>
    </div>
<?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>

    <form action="index.php" method="post" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-sm-6">
                <div class="card bg-light p-2">
                    <div class="form-group">
                        <label for="name">Nom*&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="name" placeholder="Entrez le nom de la copropriété" name="name" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ est obligatoire</div>
                    </div>
                    <div class="form-group">
                        <label for="address_1">Adresse 1&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="address_1" placeholder="Entrez la première partie de l'adresse" name="address_1">
                    </div>
                    <div class="form-group">
                        <label for="address_2">Adresse 2&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="address_2" placeholder="Entrez la seconde partie de l'adresse" name="address_2">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Code Postal*&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="postal_code" placeholder="Entrez le code postal à 5 chiffres" pattern="[0-9]{5}" maxlength="5" name="postal_code" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ est obligatoire</div>
                    </div>
                    <div class="form-group">
                        <label for="city">Ville*&nbsp;:</label>
                        <select class="form-control custom-select-sm" id="city" name="city" required>
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ est obligatoire</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card bg-light p-2">
                    <div class="form-group">
                        <label for="internal_reference">Référence interne*&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="internal_reference" placeholder="Entrez une référence à 6 chiffres"  pattern="[0-9]{6}" maxlength="6" name="internal_reference" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ est obligatoire</div>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe copropriétaire*&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="password" placeholder="Entrez un mot de passe pour l'accès des copropriétaires" name="password" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ est obligatoire</div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="text-right">
                        <div class="btn-group text-right">
                            <a class="btn btn-outline-secondary" href="index.php" title="Retour à la liste des copropriétés">Annuler</a>
                            <button type="submit" id="submitCreateCondo" name="submitCreateCondo" class="btn btn-primary" title="Enregistrer la nouvelle copropriété">Enregistrer</button>
                        </div>
                    </div>
                </div>
                <p>&nbsp;</p>
                <p id="message"></p>
            </div>
        </div>
    </form>
</div>


<?php
$content = ob_get_clean();
require('template.php');
?>