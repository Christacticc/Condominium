<?php $title = $condominium->name() ?>
<?php $bodyid = 'espaceCoproView'; ?>

<?php ob_start(); ?>

    <header class="container">
        <?php
include "nav.php";
?>
    </header>


    <div class="container"></div>
    <!--separator-->

    <section class="main container">
        <div class="row">
            <div class="col-xs-12 col-sm-2 orange un-un-sm">
                <div class="bloc-text">
                    <h1 style="margin-bottom: 5px">Mon espace copropriété</h1>
                    <form action="index.php" method="post" class="small"><button type="submit" id="deconnection" class="btn btn-link" name="deconnection">Déconnexion</button></form>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 gris-2 un-un-sm">
                <div class="bloc-text">
                    <h2 class="codo_name"><span class="internal_reference" style="color:#f39200"><?= $condominium->internal_reference() ?></span><br>
                        <?= $condominium->name() ?></h2>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 gris un-un-sm">
                <div class="bloc-text">
                    <p class="address"><?= $condominium->address_1() != '' ? $condominium->address_1() . '<br>' : '' ?><?= $condominium->address_2() != '' ? $condominium->address_2() . '<br>' : '' ?><?= $condominium->postal_code() . '<br>' ?><?= $condominium->city() ?></p>
                </div>
            </div>
            <div class="hidden-xs col-sm-6 blanc trois-un-sm">
<?php
    if ($general_assembly && $general_assembly->webinar_url())
    {
?>   
                <div class="bloc-text">
                    <h6 style="margin: 0 0 5px 0">Pour accéder à l'assemblée générale en visio :</h6>
                    <p class="small" style="margin-bottom: 5px"><strong><a href="<?= $general_assembly->webinar_url() ?>" target="_blank">Cliquez ici</a></strong> ou sur la flèche bleue du carré Visio. Une nouvelle fenêtre s'ouvre sur la plateforme <strong>zoom</strong>.</p>
                    <ul style="margin-bottom: 5px">
                        <li class="small">Soit vous accédez directement à votre assemblée générale (votre adresse e-mail peut vous être demandée), 
                        <li class="small">Soit un numéro de réunion vous est demandé. Entrez alors le numéro <strong><?= preg_replace('#^https:\/\/.*zoom\.us\/j\/([0-9]{9})#', '$1',  $general_assembly->webinar_url()) ?></strong>. Vous rejoingnez alors la réunion.</li>
                    </ul>
                        <p class="small">Pendant la réunion, vous pouvez intervenir dans la rubrique <strong>Q & R</strong>.</p>
                </div>
<?php
    }
?>    
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-2 green un-un">
                <div class="bloc-text">
                    <div class="pull-left" style="width: 40%;">
<?php
    if ($general_assembly)
    {
?>
                        <img src="../public/images/icones/twotone_event_available_black_48dp.png" class="img-responsive">
<?php                        
    }
                        else
                        {
?>                  
                        <img src="../public/images/icones/twotone_calendar_today_black_48dp.png" class="img-responsive">
<?php                            
                        }
?>                        
                    </div>
                    <p style="font-size: 1.2em; margin-bottom: 0.2em; font-weight: 700">AGENDA</p>
                    <p style="font-size: 1.2em; margin-bottom: 0em; text-align: right"><?= $general_assembly ? preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$4h$5', $general_assembly->ga_time()) . '&nbsp;' : '' ?></p>
                    <p style="font-size: 1.9em; margin-bottom: 0.2em; text-align: center"><?= $general_assembly ? preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $general_assembly->ga_time()) : '' ?></p>
                    <div class="clearfix"></div>
                    <p style="line-height: 1.2em; margin-bottom: 0.2em"><strong>Assemblée générale de copropriété</strong></p>
                </div>
            </div>
<!--            <div class="col-xs-8 col-sm-4 photo deux-un-sm deux-un-xs blue"><?= $photos[0] ? '<img class="img-responsive" src="' . $phodownload_dir . $photos[0]->file_name() . '">' : '' ?>
            </div>
-->
            <div class="col-xs-8 col-sm-4 photo deux-un-sm deux-un-xs blue"<?= $photos[0] ? ' style="background-image: url(\'' . $phodownload_dir . $photos[0]->file_name() . '\'); background-size:cover; background-position: 50%; background-repeat: no-repeat"' : '' ?>>
            </div>
            
            <div class="hidden-xs col-sm-4 orange deux-un-sm">
                <div class="bloc-text">
                    <h4>Infos copro&nbsp;:</h4>
                    <p><?= $condominium->message() ? $condominium->message() : '' ?></p>
                </div>
            </div>
        </div>
        <div class="row">
<div class="col-xs-4 visible-xs-block photo un-un blue"<?= $photos[1] ? ' style="background-image: url(\'' . $phodownload_dir . $photos[1]->file_name() . '\'); background-size:cover; background-position: 50%; background-repeat: no-repeat"' : '' ?>>
            </div>
            
            <div class="col-xs-4 col-sm-2 blanc un-un">
                <div class="bloc-text text-center">
                    <p style="line-height: 1.2em; margin-bottom: 0.2em"><strong>Assistez à votre assemblée générale en visio&nbsp;:</strong></p>
                    <img alt="" src="../public/images/icones/webinar_300x210.jpg" style="width: 60%">
                </div>
<?php
    if ($general_assembly && $general_assembly->webinar_url())
    {
?>        
        <a class="icone-link" href="<?= $general_assembly->webinar_url() ?>" target="_blank"><i class="fas fa-arrow-right"></i></a>
<?php
    }
?>    
            </div>
            <div class="col-xs-4 col-sm-2 gris un-un">
                <div class="bloc-text">
                    <p><span style="line-height: 1.2em; margin-bottom: 0.2em"><strong>...ou sur place</strong></span><?= $general_assembly && $general_assembly->address_1() != '' ? '<span style="line-height: 1.2em; margin-bottom: 0.2em"><strong>&nbsp;:<br></strong></span>' . $general_assembly->address_1() . '<br>' : '.' ?><?= $general_assembly && $general_assembly->address_2() != '' ? $general_assembly->address_2() . '<br>' : '' ?><?= $general_assembly ? $general_assembly->postal_code() . '<br>' : '' ?><?= $general_assembly ? $general_assembly->city() : '' ?><?= $general_assembly && $general_assembly->room() != '' ? '<br>' . $general_assembly->room() : '' ?></p>
                </div>
            </div>
<?php                        
    if ($fiche && $fiche->name() != '')
    {
?>
<?php
        if ($fiche->tracked() == 1)
        {        
?>
            <div class="col-xs-4 col-sm-2 gris-2 un-un" id="fiche">
                <div class="bloc-text">
                    <p>Fiche synthétique de la copropriété au <?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $fiche->creation_time()) ?>&nbsp;<i class="material-icons md-dark" style="font-size: 16px">alternate_email</i></p>
                </div>
                <a class="icone-link" id="downloadLink_s1-<?= $fiche->id() ?>" href="#downloadFormDiv_s1-<?= $fiche->id() ?>" data-toggle="modal"><i class="fas fa-arrow-right"></i></a>
            </div>
<?php
        }
        else
        {
?>
             <div class="col-xs-4 col-sm-2 gris-2 un-un">
               <div class="bloc-text">
                    <p>Fiche synthétique de la copropriété au <?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $fiche->creation_time()) ?></p>
                </div>
                <a class="icone-link" href="<?= $pdfdownload_dir . $fiche->file_name() ?>" target="_blank"><i class="fas fa-arrow-right"></i></a>
            </div>
<?php
        }
    }
?>
            <div class="visible-xs col-xs-8 orange deux-un">
                <div class="bloc-text">
                    <h4>Infos copro&nbsp;:</h4>
                    <p><?= $condominium->message() ? $condominium->message() : '' ?></p>
                </div>
            </div>            
            <div class="col-xs-12 col-sm-6 blanc trois-un-sm">
                <div class="bloc-text">
                    <p>Tous les documents sont disponibles en pdf. Pour consulter ou télécharger un document, cliquez sur son nom.<br>
                        Pour certains des documents, il vous sera demandé votre adresse e-mail afin de pouvoir les consulter(<i class="material-icons md-dark" style="font-size: 16px">alternate_email</i>).</p>
                </div>
            </div>
        </div>
        <div class="row">
<!--            <div class="hidden-xs col-sm-2 un-un blue">
                <?= $photos[1] ? '<img class="img-responsive" src="' . $phodownload_dir . $photos[1]->file_name() . '">' : '' ?>
            </div>
-->
            <div class="hidden-xs col-sm-2 un-un blue"<?= $photos[1] ? ' style="background-image: url(\'' . $phodownload_dir . $photos[1]->file_name() . '\'); background-size:cover; background-position: 50%; background-repeat: no-repeat"' : '' ?>>
            </div>
            <div class="col-xs-12 col-sm-10 blanc accordion">
                <div class="bloc-text">
                    <h2>Vos documents</h2>
                    <h4 class="h6">Documents les plus récents&nbsp;:</h4>

<?php                        
                        if ($recent_documents)
                        {
?>
                    <ul>
<?php                        
                            foreach($recent_documents as $document)
                            {
                                if ($document->tracked() == 1)
                                {
?>
                        
                        <li>
                            <a id="downloadLink_s2-<?= $document->id() ?>" data-toggle="modal" href="#downloadFormDiv_s2-<?= $document->id() ?>"><strong><?= $document->name() ?></strong>&nbsp;<i class="material-icons md-dark" style="font-size: 16px">alternate_email</i></a>
                            <div class="modal fade" id="downloadFormDiv_s2-<?= $document->id() ?>" role="dialog">
                                <div class="modal-dialog modal-sm">   
                                    <form name="downloadDocForm" method="post" action="index.php">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h5 class="modal-title"><?= $document->name() ?></h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="bloc-text ">
                                                    <div class="form-group form-group-sm"> 
                                                        <label class="control-label" for="e_mail-<?= $document->id() ?>" style="font-size: 0.85em; line-height: 1em;">Pour télécharger ce document, <br>veuillez entrer votre adresse e-mail&nbsp;:</label>
                                                        <input type=email class="form-control" placeholder="Entrez votre adresse e-mail" id="e_mail-<?= $document->id() ?>" name="e_mail" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group">
                                                    <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                                                    <button type="submit" name="downloadDocSubmit" class="btn btn-sag btn-sm btn-success">Envoyer</button>
                                                    <button type="button" class="btn btn-sag  btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                                </div>
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
                                    <li><a href="<?= $pdfdownload_dir . $document->file_name() ?>" target="_blank"><strong><?= $document->name() ?></strong></a></li>
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
  if (!empty($documents))
  {
?>
                   <div class="panel-group" id="accordion">
<?php
    foreach ($categories as $category)
    {
        $category_var = $category->name();
        if (!empty($$category_var))
        {
?>        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $category->position() ?>">Documents <?= $category->name() ?>s <span style="font-size: .8em; text-transform: none;">(<?= count($$category_var) > 1 ? count($$category_var) . ' documents' : count($$category_var) . ' document' ?>)</span></a>
                                </h4>
                            </div>
                            <div id="collapse<?= $category->position() ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
<?php
             foreach ($$category_var as $document)
            {
                if ($document->tracked() == 1)
                    {
    ?>
                                            <li>
                                                <a id="downloadLink_s3-<?= $document->id() ?>" data-toggle="modal" href="#downloadFormDiv_s3-<?= $document->id() ?>"><?= $document->name() ?>&nbsp;<i class="material-icons md-dark" style="font-size: 16px">alternate_email</i></a>
                                                <div class="modal fade" id="downloadFormDiv_s3-<?= $document->id() ?>" role="dialog">
                                                    <div class="modal-dialog modal-sm">   
                                                        <form name="downloadDocForm" method="post" action="index.php">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h5 class="modal-title"><?= $document->name() ?></h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="bloc-text ">
                                                                        <div class="form-group form-group-sm"> 
                                                                            <label class="control-label" for="e_mail-<?= $document->id() ?>" style="font-size: 0.85em; line-height: 1em;">Pour télécharger ce document, <br>veuillez entrer votre adresse e-mail&nbsp;:</label>
                                                                            <input type=email class="form-control" placeholder="Entrez votre adresse e-mail" id="e_mail-<?= $document->id() ?>" name="e_mail" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="btn-group">
                                                                        <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                                                                        <button type="submit" name="downloadDocSubmit" class="btn btn-sag btn-sm btn-success">Envoyer</button>
                                                                        <button type="button" class="btn btn-sag  btn-sm btn-default" data-dismiss="modal">Fermer</button>
                                                                    </div>
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
                                            <li><a href="<?=  $pdfdownload_dir . $document->file_name() ?>" target="_blank"><?= $document->name() ?></a></li>
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
}
?>                    
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- End .main.container-->
<?php                        
if ($fiche && $fiche->name() != '' && $fiche->tracked() == 1)
{
?>
    <div class="modal fade" id="downloadFormDiv_s1-<?= $fiche->id() ?>" role="dialog">
        <div class="modal-dialog modal-sm">   
            <form name="downloadDocForm" method="post" action="index.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title"><?= $fiche->name() ?></h5>
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
                        <div class="btn-group">
                            <input type="hidden" name="document_id" value="<?= $fiche->id() ?>">
                            <button type="submit" name="downloadDocSubmit" class="btn btn-sag btn-sm btn-success">Envoyer</button>
                            <button type="button" class="btn btn-sag  btn-sm btn-default" data-dismiss="modal">Fermer</button>
                        </div>
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