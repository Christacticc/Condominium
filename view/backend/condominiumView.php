<?php $title = 'Détails copropriété'; ?>
<?php $bodyid = 'condominiumView'; ?>

<?php ob_start(); ?>


<section id="condoInfos" class="container">
    <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-2">
                <h6>Informations<br>
d'une copropriété*&nbsp;:</h6>
            </div>
            <div class="col-sm-6">
                <h1><a class="popable" href="#" id="a-name" ><?= $condominium->name() ?></a></h1>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="text-right"><a class="btn btn-success" href="index.php">Retour à la liste des copropriétés</a></div>
            </div>
        </div>
    </div>
<?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="card bg-light p-2">
                <div class="row">
                    <div class="col-sm-3">
                        <span class="popable" id="span-address_1">Adresse 1&nbsp;:</span>
                    </div>
                    <div class="col-sm-9">
                        <a class="popable" href="#" id="a-address_1"><?= htmlspecialchars($condominium->address_1()) ?></a>
                    </div>              
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="popable" id="span-address_2">Adresse 2&nbsp;:</span>
                    </div>
                    <div class="col-sm-9">
                        <a class="popable" href="#" id="a-address_2"><?= htmlspecialchars($condominium->address_2()) ?></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="popable" id="span_2-postal_code">Code Postal*&nbsp;:</span>
                    </div>
                    <div class="col-sm-9">
                        <a class="popable" href="#" id="a_2-postal_code"><?= $condominium->postal_code() ?></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="popable" id="span_3-postal_code">Ville*&nbsp;:</span>
                    </div>
                    <div class="col-sm-9">
                        <a class="popable" href="#" id="a_3-postal_code"><?= $condominium->city() ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card bg-light p-2">
                <div class="row">
                    <div class="col-sm-6">
                        <span class="popable" id="span-internal_reference">Référence interne*&nbsp;:</span>
                    </div>
                    <div class="col-sm-6">
                        <a class="popable" href="#" id="a-internal_reference"><?= $condominium->internal_reference() ?></a>
                    </div>
                </div>
                <div class="row">                
                    <div class="col-sm-6">
                        <span class="popable" id="span-password">Mot de passe copropriétaire*&nbsp;:</span>
                    </div>
                    <div class="col-sm-6">
                        <a class="popable" href="#" id="a-password"><?= $condominium->password() ?></a>
                    </div>
                </div>
                <div class="row">                
                    <div class="col-sm-12">
                        <span class="popable" id="span-message">Infos copro&nbsp;:&nbsp;</span><a class="popable" href="#" id="a-message"><?= $condominium->message() ?></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col_sm_12">

                    <p id="msg"></p>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div id="modifDiv-name" class="modifDiv d-none mt-3">
                <form id="modifForm-name" action="index.php" method="post">
                    <div class="input-group mb-3 input-group-sm shadow">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nom de la copropriété&nbsp;:</span>
                        </div>
                        <input type="hidden" value="<?= $condominium->id() ?>">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $condominium->name() ?>" required>
                        <div class="input-group-append">
                            <a href="#" class="btn btn-outline-secondary" onClick="document.getElementById('modifDiv-name').classList.add('d-none')">Annuler</a>
                            <button class="btn btn-primary" type="submit" name="submitModifCondo" name="submitModifCondo">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="modifDiv-address_1" class="modifDiv d-none mt-3">
                <form id="modifForm-address_1" action="index.php" method="post">
                    <div class="input-group mb-3 input-group-sm shadow">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Adresse&nbsp;:</span>
                        </div>
                        <input type="hidden" value="<?= $condominium->id() ?>">
                        <input type="text" class="form-control" id="address_1" name="address_1" value="<?= $condominium->address_1() ?>">
                        <div class="input-group-append">
                            <a href="#" class="btn btn-outline-secondary" onClick="document.getElementById('modifDiv-address_1').classList.add('d-none')">Annuler</a>
                            <button class="btn btn-primary" type="submit" name="submitModifCondo" name="submitModifCondo">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="modifDiv-address_2" class="modifDiv d-none mt-3">
                <form id="modifForm-address_2" action="index.php" method="post">
                    <div class="input-group mb-3 input-group-sm shadow">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Complément d'adresse&nbsp;:</span>
                        </div>
                        <input type="hidden" value="<?= $condominium->id() ?>">
                        <input type="text" class="form-control" id="address_2" name="address_2" value="<?= $condominium->address_2() ?>">
                        <div class="input-group-append">
                            <a href="#" class="btn btn-outline-secondary" onClick="document.getElementById('modifDiv-address_2').classList.add('d-none')">Annuler</a>
                            <button class="btn btn-primary" type="submit" name="submitModifCondo" name="submitModifCondo">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="modifDiv-internal_reference" class="modifDiv d-none mt-3">
                <form id="modifForm-internal_reference" action="index.php" method="post">
                    <div class="input-group mb-3 input-group-sm shadow">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Référence interne&nbsp;:</span>
                        </div>
                        <input type="hidden" value="<?= $condominium->id() ?>">
                        <input type="text" class="form-control" id="internal_reference" name="internal_reference"  pattern="[0-9]{6}" maxlength="6" value="<?= $condominium->internal_reference() ?>" required>
                        <div class="input-group-append">
                            <a href="#" class="btn btn-outline-secondary" onClick="document.getElementById('modifDiv-internal_reference').classList.add('d-none')">Annuler</a>
                            <button class="btn btn-primary" type="submit" name="submitModifCondo" name="submitModifCondo">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="modifDiv-password" class="modifDiv d-none mt-3 shadow">
                <form id="modifForm-password" action="index.php" method="post">
                    <div class="input-group mb-3 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Mot de passe&nbsp;:</span>
                        </div>
                        <input type="hidden" value="<?= $condominium->id() ?>">
                        <input type="text" class="form-control" id="password" name="password" value="<?= $condominium->password() ?>" required>
                        <div class="input-group-append">
                            <a href="#" class="btn btn-outline-secondary" onClick="document.getElementById('modifDiv-password').classList.add('d-none')">Annuler</a>
                            <button class="btn btn-primary" type="submit" name="submitModifCondo" name="submitModifCondo">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="modifDiv-postal_code" class="modifDiv d-none mt-3">
                <form id="modifForm-postal_code" action="index.php" method="post">
                    <div class="input-group mb-3 input-group-sm shadow">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Code Postal&nbsp;:</span>
                        </div>
                        <input type="hidden" value="<?= $condominium->id() ?>">
                        <input type="text" class="form-control" pattern="[0-9]{5}" maxlength="5" id="postal_code" name="postal_code" style="max-width: 20%; width:20%;" value="<?= $condominium->postal_code() ?>" required>
                        <select class="form-control" id="city" name="city" required></select>
                        <div class="input-group-append">
                            <a href="#" class="btn btn-outline-secondary" onClick="document.getElementById('modifDiv-postal_code').classList.add('d-none')">Annuler</a>
                            <button class="btn btn-primary" type="submit" name="submitModifCondo" name="submitModifCondo">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="modifDiv-message" class="modifDiv d-none mt-3 shadow">
                <form id="modifForm-message" action="index.php" method="post">
                    <div class="input-group mb-3 input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Infos copro&nbsp;:</span>
                        </div>
                        <input type="hidden" value="<?= $condominium->id() ?>">
                        <textarea class="form-control" id="message" name="message" row="2" maxlength="255"><?= $condominium->message() ?></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onClick="document.getElementById('modifDiv-message').classList.add('d-none')">Annuler</button>
                            <button class="btn btn-primary" type="submit" name="submitModifCondo" name="submitModifCondo">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<section class="container">
   <div class="card bg-light p-2 mt-4 mb-0">
        <div class="row">
 
<?php
    if (isset($general_assembly))
    {
        ?>
           <div class="col-sm-6">
               <p><span class="h6">Assemblée générale</span> programmée le <span class="h5"><?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $general_assembly->ga_time()) ?></span><?= !preg_match('#[-0-9]{10} 00:00:00#', $general_assembly->ga_time()) ? ' à <span class="h5">' . preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$4h$5', $general_assembly->ga_time()) . '</span>.' : ''?></p>
                <p>Lieu&nbsp;:<?= is_string($general_assembly->address_1()) && $general_assembly->address_1() !== '' ? '<br>' . $general_assembly->address_1() : '' ?><?= is_string($general_assembly->address_2()) && $general_assembly->address_2() !== '' ? ', ' . $general_assembly->address_2() : '' ?><?= is_string($general_assembly->postal_code()) && $general_assembly->postal_code() !== '' ? ', ' . $general_assembly->postal_code(): '' ?><?= is_string($general_assembly->city()) && $general_assembly->city() !== '' ? ' ' . $general_assembly->city() : '' ?></p> 
            </div>
            <div class="col-sm-4">
<?php
        if (!is_null($general_assembly->room()))
        {
            ?>
                <p>Salle&nbsp;: <?= $general_assembly->room() ?></p>            
<?php
        }
        ?>
<?php
        if (!is_null($general_assembly->webinar_url()))
        {
            ?>
                <p>Webinaire&nbsp;: <br><span class="h5"><?= $general_assembly->webinar_url() ?></span></p>
<?php
        }
        ?>
            </div>
            <div class="col-sm-2 mt-2">
                <div class="text-right"><form method="post" name="formOpenGA" id="formOpenGA" action="index.php"><button id="submitOpenGA" name="submitOpenGA" class="btn btn-success" type="submit" title="Modifier l'assemblée générale" value="<?= $condominium->id() ?>">Modifier</button></form></div>
            </div>
                
<?php
    }
    else
    {
        ?>
            <div class="col-sm-12 mt-2">
                <div class="text-right"><form method="post" name="formOpenGA" id="formOpenGA" action="index.php"><button id="submitOpenGA" name="submitOpenGA" class="btn btn-success" type="submit" title="Programmer une assemblée générale" value="<?= $condominium->id() ?>">Programmer une assemblée générale</button></form></div>
            </div>

            <?php
    }
?>
        </div>
    </div>
</section>
<section class="container">
    <script>
const types = [];
    </script>
    <div class="card bg-light p-2 mt-4 mb-0" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-bottom: none">
        <div class="row">
            <div class="col-sm-4">
                <h1 class="h3"><span class="h6">Liste des documents</span></h1>
            </div>
            <div class="col-sm-8 my-2 text-right">
                <div class="btn-group">
                    <a class="btn btn-success" href="?adddoc=<?= $condominium->id() ?>">Ajouter un document</a>
                    <a class="btn btn-success" href="?adddocs=<?= $condominium->id() ?>">Ajouter des documents</a>
                    <a class="btn btn-outline-success" href="?confdocs=<?= $condominium->id() ?>">X docs. à confirmer</a>
                </div>
            </div>
        </div>
    </div>
<?php
  if (empty($documents))
  {
?>
    <p class="text-muted">Aucun document pour cette copropriété</p>
<?php    
  }
  else
  {
?>
    <table id="documents-table" class="table table-sm table-bordered">
<?php
    foreach ($categories as $category)
    {
        $category_var = $category->name();
?>
        <tbody id="tbody-<?= $category->id() ?>">
            <tr>
               <td colspan="10" class="bg-light py-2">
                   <h2 class="h6 text-center"><?= ucfirst($category->name()) ?></h2>
               </td>
            </tr>
<?php
        if (empty($$category_var))
        {
?>
            <tr>
                <td colspan="10" class="text-muted">Aucun document pour cette catégorie</td>
            </tr>
<?php
        }
        else
        {
?>
            <tr>
                <td class="small" style="border-right: none"></td>
                <td class="small" style="border-left: none; width: 310px"><strong>Nom</strong></td>
                <td class="small" style="width: 200px"><strong>Fichier</strong></td>
                <td class="small"><strong>Création</strong></td>
                <td class="small"><strong>Modification</strong></td>
                <td class="text-center small"><strong>Type</strong></td>
                <td class="text-center small" colspan="2"><strong>Publié</strong></td>
                <td class="text-center small" colspan="2"><strong>Suivi</strong></td>
            </tr>
            
<?php
            foreach ($$category_var as $document)
            {
                include('../view/backend/frag_documentslistrow.php');
            } //END foreach document
        } // END if category not empty
?>
        </tbody>            
<?php
    } //END foreach category
  }
    ?>
    </table>
</section>
<section class="container">
   <div class="card bg-light p-2 mt-4 mb-0">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="h3"><span class="h6">Liste des photos</span></h1>
            </div>
            <div class="col-sm-4  mt-2">
<?php
                if (count($photos) <= 1)
                {
?>                
                <div class="text-right"><a class="btn btn-success" href="?addpho=<?= $condominium->id() ?>">Ajouter une photo</a></div>
<?php
                }
    ?>
            </div>
        </div>
    </div>
<?php
  if (empty($photos))
  {
      echo('Aucune photo pour cette copropriété');   
  }
  else
  {
?>
    <table class="table table-sm table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Vignette</th>
                <th>Fichier</th>
<?php
      if (isset($photos[1]))
      {
?>
                <th class="text-center">
                <input type="hidden" id="ph_condominium_id" value="<?= $condominium->id() ?>">
                <span class="badge badge-primary" id="ph_reverse" style="cursor: pointer;">Position&nbsp;<i class="material-icons md-light" style="line-height: 0.2; transform: translateY(5px);cursor: pointer;">import_export</i></span>
                </th>
<?php                
      }
      else
      {
          ?>
                <th class="text-center">Position</th>
<?php                
      }
      ?>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
<?php
    $nblines = 0;
    foreach ($photos as $photo)
    {
        include('../view/backend/frag_photoslistrow.php');
        $nblines++ ;
    } //END foreach 
  }
    ?>
        </tbody>    
    </table>
</section>
<?php
    if ($_SESSION['user'] == 1)
    {
?>        
<section class="container">
   <div class="card bg-light p-2 mt-4 mb-0">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="text-right">
                    <a href="#delConModal-<?= $condominium->id() ?>" class="btn btn-warning" data-toggle="modal">Supprimer la copropriété <?= $condominium->name() ?>&nbsp;&hellip;</a>
                    <div class="modal fade" id="delConModal-<?= $condominium->id() ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body text-left">
                                    <p class="text-center"><strong><?= $condominium->name() ?></strong></p>
<?php
  if ((!isset($general_assembly)) && empty($photos) && empty($documents))
  {
?>
                                    <p>Êtes-vous certain de vouloir supprimer cette copropriété&nbsp;?</p>
                                    <form name="deleteConForm"  id="deleteConForm-<?= $condominium->id() ?>" action="index.php" method="post">
                                        <input type="hidden" name="co_id" value="<?= $condominium->id() ?>">
                                        <div class="form-group text-center">
                                            <button class="btn btn-danger btn-sm" type="submit" name="submitDeleteCon" data-target="#delConModal-<?= $condominium->id() ?>" data-toggle="modal">Oui, supprimer</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm  btn-outline-secondary" data-dismiss="modal">Non, ne pas supprimer</button>
                                </div>
<?php
  }
                       else
                       {
?>
                                <p>Pour supprimer cette copropriété, il faut au préalable supprimer toutes ses dépendances : assemblée générale, documents et photos.</p>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm  btn-outline-secondary" data-dismiss="modal">Fermer</button>
                                </div>
<?php
                       }
?>                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    }
?>
<p>&nbsp;</p>            
<?php
$content = ob_get_clean();
require('template.php');
?>