<?php $title = $condominium->name(); ?>
<?php $bodyid = 'espaceCoproView'; ?>
<?php ob_start(); ?>
<header class="container">
    <?php
include "nav.php";
?>
</header>
<section class="main container">
    <div class="card-deck">
        <div class="card"<?= $photos[0] ? ' style="background-image: url(\'' . $phodownload_dir . $photos[0]->file_name() . '\'); background-size:cover; background-position: 50%; background-repeat: no-repeat"' : '' ?>>
            <div class="card-body">
                <div class="card condo-bg-dark-transp">
                    <div class="card-body">
                        <p class="internal_reference text-white"><?= $condominium->internal_reference() ?></p>
                        <h2 class="codo_name text-white"><?= $condominium->name() ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="address"><span class="material-icons">apartment</span><?= $condominium->address_1() != '' ? $condominium->address_1() . '<br>' : '' ?><?= $condominium->address_2() != '' ? $condominium->address_2() . '<br>' : '' ?><?= $condominium->postal_code() . '<br>' ?><?= $condominium->city() ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5><span class="material-icons-outlined">announcement</span>Infos copro&nbsp;:</h5>
                <p><?= $condominium->message() ? $condominium->message() : '' ?></p>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header"><span class="material-icons">event</span>AGENDA</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
            <?php
if ($general_assembly)
{
?>
                    <p><span class="material-icons">groups</span>Votre <strong>assemblée générale de copropriété</strong> est planifiée pour le <span style="font-size: 1.1em"><?= $general_assembly ? preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $general_assembly->ga_time()) : '' ?></span> à <span style="font-size: 1.1em"><?= $general_assembly ? preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$4h$5', $general_assembly->ga_time()) . '&nbsp;' : '' ?></span></p>
            <?php                        
}
else
{
?>
                    <p><span class="material-icons">calendar_today</span>Pas d'évènement programmé pour le moment</p>
            <?php                            
}
?>
                </div>
                <div class="col-sm-4">
                    <p><span class="material-icons">place</span><strong>Venez y participer sur place&nbsp;:</strong></p>
                    <p><?= $general_assembly && $general_assembly->address_1() != '' ? $general_assembly->address_1() . '<br>' : '' ?><?= $general_assembly && $general_assembly->address_2() != '' ? $general_assembly->address_2() . '<br>' : '' ?><?= $general_assembly ? $general_assembly->postal_code() . '<br>' : '' ?><?= $general_assembly ? $general_assembly->city() : '' ?><?= $general_assembly && $general_assembly->room() != '' ? '<br>' . $general_assembly->room() : '' ?></p>
                </div>
                <div class="col-sm-4">
            <?php
if ($general_assembly && $general_assembly->webinar_url())
{
?>
                    <p><span class="material-icons">web</span><strong>Ou assistez à l'assemblée générale en visio&nbsp;:</strong></p>
                    <p>Quelques minutes avant l'heure de début, cliquez sur le bouton ci-dessous pour vous connecter. Une nouvelle fenêtre s'ouvrira vers la plateforme de visioconférence.</p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <a class="btn btn-primary mx-auto d-block" href="<?= $general_assembly->webinar_url() ?>" target="_blank"><span class="material-icons">login</span>Rejoindre l'assemblée générale<br>par visioconférence</a>
                    <p>Si un numéro de réunion vous est demandé, entrez ce numéro&nbsp;: <kbd><?= preg_replace('#^https:\/\/.*zoom\.us\/j\/([0-9]{9})#', '$1',  $general_assembly->webinar_url()) ?></kbd></p>
                </div>
                <div class="col-sm-8">
                    <p><a href="#"><span class="material-icons">help_outline</span>Cliquez ici pour obtenir de l'aide</a> sur le fonctionnement de la visioconférence.
                    <p><span class="material-icons-outlined">question_answer</span>Pendant la réunion, vous pourrez intervenir par écrit dans la rubrique <strong>Q&R</strong>.</p>
            <?php
}
?>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h2>Vos documents&nbsp;:</h2>
    <div class="card-deck">
        <div class="card">
            <div class="card-body">
                <h5>Documents les plus récents&nbsp;:</h5>
            <?php                        
if ($recent_documents)
{
?>
                <ul class="list-group list-group-flush">
                <?php                        
    foreach($recent_documents as $document)
    {
        if ($document->tracked() == 1)
        {
?>

                    <li class="list-group-item">
                        <a id="downloadLink_s2-<?= $document->id() ?>" data-toggle="modal" href="#downloadFormDiv_s2-<?= $document->id() ?>"><span class="material-icons">description</span><?= $document->name() ?>&nbsp;<span class="material-icons" style="font-size: 16px">alternate_email</span></a>
                        <div class="modal fade" id="downloadFormDiv_s2-<?= $document->id() ?>" role="dialog" aria-labelledby="modalLabel<?= $document->id() ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form name="downloadDocForm" method="post" action="index.php">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel<?= $document->id() ?>"><?= $document->name() ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="bloc-text ">
                                                <div class="form-group form-group-sm">
                                                    <label class="control-label" for="e_mail-<?= $document->id() ?>" style="font-size: 0.85em; line-height: 1em;">Pour télécharger ce document, <br>veuillez entrer votre adresse e-mail&nbsp;:</label>
                                                    <input type="email" class="form-control" placeholder="Entrez votre adresse e-mail" id="e_mail-<?= $document->id() ?>" name="e_mail" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                                            <button type="submit" name="downloadDocSubmit" class="btn btn-sm btn-success">Envoyer</button>
                                            <button type="button" class="btn  btn-sm btn-secondary" data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php
        }
        else
        {
?>
                    <li class="list-group-item"><a href="<?= $pdfdownload_dir . $document->file_name() ?>" target="_blank"><span class="material-icons">description</span><?= $document->name() ?></a></li>
                <?php                                    
        }
?>
                <?php                            
    }
?>
                </ul>
            <?php
}
else
{
?>
                <p>Aucun document pour cette copropriété</p>
            <?php
}   
?>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
            <?php                        
if ($fiche && $fiche->name() != '')
{
?>
            <?php
    if ($fiche->tracked() == 1)
    {        
?>
            <a class="icone-link" id="downloadLink_s1-<?= $fiche->id() ?>" href="#downloadFormDiv_s1-<?= $fiche->id() ?>" data-toggle="modal"><span class="material-icons">description</span>Fiche synthétique de la copropriété au <?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $fiche->creation_time()) ?>&nbsp;<span class="material-icons" style="font-size: 16px">alternate_email</span></a>
            <?php
    }
    else
    {
?>
            <a class="icone-link" href="<?= $pdfdownload_dir . $fiche->file_name() ?>" target="_blank"><span class="material-icons">description</span>Fiche synthétique de la copropriété au <?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $fiche->creation_time()) ?></a>
            <?php
    }
}
?>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
            Tous les documents sont disponibles en pdf. Pour consulter ou télécharger un document, cliquez sur son nom.<br>
                Le téléchargement de certains documents, au nom desquels est accolée une arobase <span class="material-icons md-dark mr-0" style="font-size: 16px">alternate_email</span>, est suivi et votre adresse e-mail vous sera demandé pour pouvoir les consulter.
            </div>
        </div>
        
    </div>
    <br>
    <div class="card-deck">
        <div class="card border-0">
    <h4>Tous les documents</h4>
<?php
if (!empty($documents))
{
?>
    <div class="accordion" id="accordion">
                <?php
    foreach ($categories as $category)
    {
        $category_var = $category->name();
        if (!empty($$category_var))
        {
?>
                <div class="card mx-0">
                    <div class="card-header">
                        <a class="card-link" data-toggle="collapse" href="#collapse<?= $category->position() ?>">Documents <?= $category->name() ?>s <span style="font-size: .8em; text-transform: none;">(<?= count($$category_var) > 1 ? count($$category_var) . ' documents' : count($$category_var) . ' document' ?>)</span></a>
                    </div>
                    <div id="collapse<?= $category->position() ?>" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php
            foreach ($$category_var as $document)
            {
                if ($document->tracked() == 1)
                {
?>
                                <li class="list-group-item">
                                    <a id="downloadLink_s3-<?= $document->id() ?>" data-toggle="modal" href="#downloadFormDiv_s3-<?= $document->id() ?>"><span class="material-icons">description</span><?= $document->name() ?>&nbsp;<span class="material-icons" style="font-size: 16px">alternate_email</span> </a>
                                    <div class="modal fade" id="downloadFormDiv_s3-<?= $document->id() ?>" role="dialog" aria-labelledby="modalLabel<?= $document->id() ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form name="downloadDocForm" method="post" action="index.php">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel<?= $document->id() ?>"><?= $document->name() ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="bloc-text ">
                                                            <div class="form-group form-group-sm">
                                                                <label class="control-label" for="e_mail-<?= $document->id() ?>" style="font-size: 0.85em; line-height: 1em;">Pour télécharger ce document, <br>veuillez entrer votre adresse e-mail&nbsp;:</label>
                                                                <input type="email" class="form-control" placeholder="Entrez votre adresse e-mail" id="e_mail-<?= $document->id() ?>" name="e_mail" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                                                        <button type="submit" name="downloadDocSubmit" class="btn btn-sm btn-success">Envoyer</button>
                                                        <button type="button" class="btn  btn-sm btn-secondary" data-dismiss="modal">Fermer</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <?php                        
                }
                else
                {
?>
                                <li class="list-group-item"><a href="<?=  $pdfdownload_dir . $document->file_name() ?>" target="_blank"><span class="material-icons">description</span><?= $document->name() ?></a></li>
                                <?php
                }
            } //END foreach document
?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
        }
    } //END foreach category
    ?>
    </div>
    <?php
}       
?>
        </div>
        <div class="card d-none d-md-flex" <?= $photos[1] ? ' style="background-image: url(\'' . $phodownload_dir . $photos[1]->file_name() . '\'); background-size:cover; background-position: 50%; background-repeat: no-repeat"' : '' ?>>
        </div>
    </div>
<br><br>
</section> <!-- End .main.container-->
<?php                        
if ($fiche && $fiche->name() != '' && $fiche->tracked() == 1)
{
?>
<div class="modal fade" id="downloadFormDiv_s1-<?= $fiche->id() ?>" role="dialog" aria-labelledby="modalLabel<?= $fiche->id() ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form name="downloadDocForm" method="post" action="index.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel<?= $fiche->id() ?>"><?= $fiche->name() ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="bloc-text ">
                        <div class="form-group form-group-sm">
                            <label class="control-label" for="e_mail-<?= $fiche->id() ?>" style="font-size: 0.85em; line-height: 1em;">Pour télécharger ce document, <br>veuillez entrer votre adresse e-mail&nbsp;:</label>
                            <input type="email" class="form-control" placeholder="Entrez votre adresse e-mail" id="e_mail-<?= $fiche->id() ?>" name="e_mail" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="document_id" value="<?= $fiche->id() ?>">
                    <button type="submit" name="downloadDocSubmit" class="btn btn-sm btn-success">Envoyer</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
}
$content = ob_get_clean();
require('template.php');
?>
