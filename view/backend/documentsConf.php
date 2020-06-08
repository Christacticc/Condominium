<?php $title = 'Confirmer des documents'; ?>
<?php $bodyid = 'documentsConf'; ?>

<?php ob_start(); ?>


<section id="condoInfos" class="container">
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
</section>
<section class="container">
    <script>
const types = [];
    </script>
    <div class="card bg-light p-2 mt-4 mb-0" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-bottom: none">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="h3"><span class="h6">Liste des documents à confirmer</span></h1>
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
        <tbody>
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
        </tbody>
            
<?php
    foreach ($documents as $document)
    {
        include('../view/backend/frag_toconfirmdocumentslistrow.php');
    } //END foreach document
?>
<?php
}
?>
    </table>
</section>
<p>&nbsp;</p>            
<?php
$content = ob_get_clean();
require('template.php');
?>