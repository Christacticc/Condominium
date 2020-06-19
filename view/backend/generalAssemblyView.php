<?php
//generalAssemblyView.php : création et modification d'assemblée générale

if (isset($general_assembly))
{
    $title = 'Détails d\'une assemblée générale';    
}
else
{
    $title = 'Ajout d\'une assemblée générale';
}
?>
<?php $bodyid = 'generalAssemblyView'; ?>
<?php ob_start(); ?>

<div class="container">
   <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-3">
                <h6>Programmation d'une<br>assemblée générale pour</h6>
            </div>
            <div class="col-sm-4">
                <h1 class="h4"><?= $condominium->name() ?></h1>
            </div>
            <div class="col-sm-5 mt-2">
                <div class="text-right">
                    <form method="post" name="formOpenCondo" id="formOpenCondo" action="index.php">
                        <div class="btn-group">
                            <a class="btn btn-success" href="index.php">Liste des copropriétés</a>
                            <button id="submitOpenCondo" name="submitOpenCondo" class="btn btn-success" type="submit" title="Retour à <?= $condominium->name() ?>" value="<?= $condominium->id() ?>">Retour à la copropriété</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>

    <form action="index.php" method="post" class="needs-validation" novalidate>
        <input type="hidden" id="address_1_1" value="<?= General_assembly::ADDRESS_1_1 ?>">
        <input type="hidden" id="address_2_1" value="<?= General_assembly::ADDRESS_2_1 ?>">
        <input type="hidden" id="postal_code_1" value="<?= General_assembly::POSTAL_CODE_1 ?>">
        <input type="hidden" id="city_1" value="<?= General_assembly::CITY_1 ?>">
        <input type="hidden" id="address_1_2" value="<?= General_assembly::ADDRESS_1_2 ?>">
        <input type="hidden" id="address_2_2" value="<?= General_assembly::ADDRESS_2_2 ?>">
        <input type="hidden" id="postal_code_2" value="<?= General_assembly::POSTAL_CODE_2 ?>">
        <input type="hidden" id="city_2" value="<?= General_assembly::CITY_2 ?>">
        <input type="hidden" id = "condominium_id" name="condominium_id" value="<?= $condominium->id() ?>">
        <div class="row">
            <div class="col-sm-6">
                <div class="card bg-light p-2">
                    <div class="form-group">                    
                        <label>Lieu de l'assemblée générale&nbsp;:</label>
                        <div class="btn-group w-100">
                            <button type="button" class="btn btn-outline-primary btn-sm fill-addr" id="fillAddr1"><?= General_assembly::NAME_1 ?></button>
                            <button type="button" class="btn btn-outline-primary btn-sm fill-addr" id="fillAddr2"><?= General_assembly::NAME_2 ?></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm fill-addr" id="resetAddr">Ré-initialiser l'adresse</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address_1">Adresse 1&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="address_1" placeholder="Entrez la première partie de l'adresse" name="address_1" value="<?= isset($general_assembly) ? $general_assembly->address_1() : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="address_2">Adresse 2&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="address_2" placeholder="Entrez la seconde partie de l'adresse" name="address_2" value="<?= isset($general_assembly) ? $general_assembly->address_2() : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Code Postal&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="postal_code" placeholder="Entrez le code postal à 5 chiffres" pattern="[0-9]{5}" maxlength="5" name="postal_code" value="<?= isset($general_assembly) ? $general_assembly->postal_code() : '' ?>">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ doit comporter 5 chiffres</div>
                    </div>
                    <div class="form-group">
                        <label for="city">Ville (- Lieu-dit)&nbsp;:</label>
                        <select class="form-control custom-select-sm" id="city" name="city">
                        </select>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ est obligatoire</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card bg-light p-2">
                    <div class="form-group">
                        <label for="room">Précision pour la salle&nbsp;:</label>
                        <input type="text" class="form-control form-control-sm" id="room" placeholder="Entrez une information sur la salle" name="room" value="<?= isset($general_assembly) ? $general_assembly->room() : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="webinar_url">URL du webinaire&nbsp;:</label>
                        <input type="url" class="form-control form-control-sm" id="webinar_url" placeholder="Coller l'URL du webinaire" name="webinar_url" pattern="https?://.+\.[a-z]{2,}.+" value="<?= isset($general_assembly) ? $general_assembly->webinar_url() : "" ?>">
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="day">Date*&nbsp;:</label>
                        <input type="date" class="form-control form-control-sm" id="day" name="day"
                           value="<?= isset($general_assembly) ? preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$1-$2-$3', $general_assembly->ga_time()) : "" ?>" min="2020-01-01" max="2050-12-31" pattern="^(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}$" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ doit être au format jj/mm/aaaa</div>
                    </div>
                    <div class="form-group col-sm-4 offset-sm-1">
                        <label for="hours">Heure&nbsp;:</label>
                        <input type="time" class="form-control form-control-sm" id="hours" name="hours"
                           value="<?= isset($general_assembly) ? (preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$4:$5', $general_assembly->ga_time())) : "" ?>" pattern="^(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9])$">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Ce champ doit être au format hh:mm</div>
                    </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="text-right">
                        <div class="btn-group text-right">
                            <button id="submitOpenCondo2" name="submitOpenCondo" class="btn btn-outline-secondary" type="submit" form="formOpenCondo" title="Retour à <?= $condominium->name() ?>" value="<?= $condominium->id() ?>">Annuler</button>
                            <button type="submit" id="submitCreateGA" name="submitCreateGA" class="btn btn-primary" title="Enregistrer l'assemblée générale'">Enregistrer</button>
<?php
    if (isset($general_assembly))
    {
        ?>
                            <a href="#delModal-<?= $general_assembly->id() ?>" class="btn btn-warning" name="submitDeleteGA" data-toggle="modal" title="Supprimer cette assemblée générale (avec confirmation)">Supprimer&hellip;</a>

<?php                            
    }
    ?>
                        </div>
                    </div>
                    <p id="message"></p>
                </div>
            </div>
        </div>
    </form>
<?php
    if (isset($general_assembly))
    {
        ?>
    
    <!-- The Modal -->
    <div class="modal fade" id="delModal-<?= $general_assembly->id() ?>">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center"><span class="h6">Vous supprimez une assemblée générale</span> programmée <br>le <span class="h5"><?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $general_assembly->ga_time()) ?></span><?= !preg_match('#[-0-9]{10} 00:00:00#', $general_assembly->ga_time()) ? ' à <span class="h5">' . preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$4h$5', $general_assembly->ga_time()) . '</span>' : ''?> <br>pour <br><span class="h5"><?= $general_assembly->condominium_name() ?></span></p>
                    <form name="deleteGAForm-<?= $general_assembly->id() ?>" id="deleteGAForm-<?= $general_assembly->id() ?>" action="index.php" method="post">
                        <input type="hidden" name="co_id" value="<?= $condominium->id() ?>">
                        <div class="form-group text-center">
                            <button class="btn btn-danger btn-sm" type="submit" name="submitDeleteGA" data-target="#delModal-<?= $general_assembly->id() ?>" data-toggle="modal">Oui, supprimer</button>
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
<?php                            
    }
    ?>
    
    
</div>


<?php
$content = ob_get_clean();
require('template.php');
?>