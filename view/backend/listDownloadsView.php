<?php $title = 'Liste des téléchargement'; ?>
<?php $bodyid = 'listDownloadsView'; ?>
<?php ob_start(); ?>


<section class="container">
    <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-2">
                <h6>Liste des téléchargements pour</h6>
            </div>
            <div class="col-sm-6">
                <h5><?= '<strong>' . $condominium->name() . '</strong> / ' . $document->name() ?></h5>
            </div>
            <div class="col-sm-4 mt-2">
                <div class="text-right"><form method="post" name="formOpenCondo" id="formOpenCondo" action="index.php"><button id="submitOpenCondo" name="submitOpenCondo" class="btn btn-success" type="submit" title="Ouvrir cette copropriété" value="<?= $condominium->id() ?>">Retour à la copropriété</button></form></div>
            </div>
        </div>
    </div>
<?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>
    <div class="card bg-light p-2 mt-4 mb-4">
        <div class="card-body">
            <form action="index.php" method="post" class="needs-validation" novalidate>
                <input type="hidden" name="condominium_id" value="<?= $condominium->id() ?>">
                <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select-checkbox" id="select-all">
                                    <label class="custom-control-label" for="select-all">&nbsp;Sélectionner tout</label>
                                </div>
                            </th>
                            <th>Adresse e-mail</th>
                            <th>Date et heure</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
foreach ($downloads as $download)
{
?>    
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select-checkbox select-one-checkbox" id="select-<?= $download->id() ?>" name="select-<?= $download->id() ?>" value="<?= $download->id() ?>">
                                    <label class="custom-control-label" for="select-<?= $download->id() ?>">&nbsp;Sélectionner</label>
                                </div>
                            </td>
                            <td><?= $download->e_mail_address() ?></td>
                            <td><?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', 'Le $3/$2/$1 à $4h$5', $download->dl_time()) ?></td>
                        </tr>
<?php
}
?>                        
                    </tbody>
                    <tfoot class="font-weight-bold">
                        <tr>
                            <td class="pt-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select-checkbox" id="select-all-2">
                                    <label class="font-weight-bold custom-control-label" for="select-all">&nbsp;Sélectionner tout</label>
                                </div>
                            </td>
                            <td class="text-right font-weight-bold pt-4"><p>Supprimer immédiatement les téléchargement sélectionnés&nbsp;:</p></td>
                            <td class="text-right pt-4">
                                <button class="btn btn-danger" type="submit" name="submitDeleteDownload">Supprimer</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require('template.php');
?>