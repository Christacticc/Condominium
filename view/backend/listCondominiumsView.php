<?php $title = 'Liste des copropriétés'; ?>
<?php $bodyid = 'listCondominiumsView'; ?>


<?php ob_start(); ?>
<section class="container">
   <div class="card bg-light p-2 mb-4">
        <div class="row">
            <div class="col-sm-8">
                <h1>Liste des copropriétés</h1>
            </div>
            <div class="col-sm-4  mt-2">
                <div class="text-right"><a class="btn btn-success" href="?addcondo=1">Ajouter une copropriété</a></div>
            </div>
        </div>
    </div>
<?php if (isset($msg)){ echo '<p>', $msg, '</p>';} ?>

<?php
if (!empty($condominiums))
{
?>
    <table class="table table-sm table-striped table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Référence</th>
                <th>Nom</th>
                <th>Mot de passe</th>
                <th>Adresse 1 <span style="color:dimgrey">|</span> adresse 2</th>
                <th>Code Postal</th>
                <th>Ville</th>
                <th class="text-center">Msg.</th>
                <th class="text-center">Assemblée générale</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ($condominiums as $condominium)
    {
        $general_assemblyManager = new General_assemblyManager($db);
        $general_assembly = $general_assemblyManager->getWithCondominium($condominium->id());
?>
            <tr>
                <td><form method="post" name="formOpenCondo" id="formOpenCondo" action="index.php"><button id="submitOpenCondo" name="submitOpenCondo" class="btn btn-sm btn-success pl-0 pr-0" style="width: 90%;" type="submit" title="Ouvrir cette copropriété" value="<?= $condominium->id() ?>"><?= $condominium->internal_reference() ?></button></form></td>
                <td><?= $condominium->name() ?></td>
                <td><?= $condominium->password() ?></td>
                <td><?= htmlspecialchars($condominium->address_1()) ?><?= $condominium->address_2() ? '<span style="color:dimgrey;"> | </span>' . htmlspecialchars($condominium->address_2()) : '' ?></td>
                 <td><?= $condominium->postal_code() ?></td>
                <td><?= $condominium->city() ?></td>
                <td class="text-center"><?= $condominium->message() != '' ? '<i class="material-icons md-dark" data-toggle="popover" data-trigger="hover" data-content="' . $condominium->message() . '">message</i>' : '<i class="material-icons md-dark md-inactive">message</i>'; ?></td>
                <td class="text-center">
<?php
        if ($general_assembly)
        {
            if (date('Y-m-d H:i:s') <= $general_assembly->ga_time())
            {
 ?>
                    <i class="material-icons md-dark" data-toggle="popover" data-trigger="hover" data-content="Le <?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $general_assembly->ga_time()) ?><?= !preg_match('#[-0-9]{10} 00:00:00#', $general_assembly->ga_time()) ? ' à ' . preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$4h$5', $general_assembly->ga_time()) : ''?>">event</i><?php                    
                if(null !== $general_assembly->address_id())
                {
?>
                    <i class="material-icons md-dark" data-toggle="popover" data-trigger="hover" data-content="<?= $general_assembly->address_1() . ', '?><?= null !== $general_assembly->address_2() && '' !== $general_assembly->address_2() ? $general_assembly->address_2() . ', ' : '' ?><?= $general_assembly->postal_code() . ' ' . $general_assembly->city() ?><?= null !== $general_assembly->room() && '' !== $general_assembly->room() ? ' ' . $general_assembly->room() . '.' : '.' ?>">place</i><?php
                }
                else
                {
?>
                    <i class="material-icons md-dark md-inactive">place</i><?php                
                }
                if(null !== $general_assembly->webinar_url() && '' !== $general_assembly->webinar_url())
                {
?>
                    <a href="<?= $general_assembly->webinar_url() ?>" target="_blank" title="Rejoindre l'AG"><i style="cursor: pointer;" class="material-icons md-dark">laptop</i></a><?php
                }
                else
                {
?>
                    <i class="material-icons md-dark md-inactive">laptop</i><?php                
                }  
            }
            else // Date passée
            {
?>
                    <i class="material-icons md-dark md-inactive" data-toggle="popover" data-trigger="hover" data-content="Le <?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $general_assembly->ga_time()) ?><?= !preg_match('#[-0-9]{10} 00:00:00#', $general_assembly->ga_time()) ? ' à ' . preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$4h$5', $general_assembly->ga_time()) : ''?>">event</i>
                    <i class="material-icons md-dark md-inactive">place</i>
                    <i class="material-icons md-dark md-inactive">laptop</i><?php                    
                
            }
        }
        else
        {
?>
                <i class="material-icons md-dark md-inactive">minimize</i>
                <i class="material-icons md-dark md-inactive">minimize</i>
                <i class="material-icons md-dark md-inactive">minimize</i>
<?php                
        }
?>              </td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>
<?php
}
?>
</section>
<p>&nbsp;</p>
<?php
$content = ob_get_clean();
require('template.php');
?>