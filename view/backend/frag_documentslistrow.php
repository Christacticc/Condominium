<!-- Les 2 lignes de tableau d'un document dans la page d'un condominium -->
	<tr id="tr-<?= $document->id() ?>">
        <td class="td-view text-center p-1"  id="td-view-<?= $document->id() ?>" style="border-right: none">
            <form id="moveDocumentForm-<?= $document->id() ?>" class="moveDocumentForm">
                <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                <div class="btn-group btn-group-sm">
                    <button type="submit" class="btn btn-sm btn-primary semi-width moveDocument" name="up" <?= $i == 0 ? 'disabled' : '' ?>><?= $i == 0 ? '<i class="fas fa-minus"></i>' : '<i class="fas fa-arrow-up"></i>' ?>
                    </button>                
                    <button type="submit" class="btn btn-sm btn-primary semi-width  moveDocument" name="down" <?= $i == count($$category_var) - 1 ? 'disabled' : '' ?>><?= $i == count($$category_var) - 1 ? '<i class="fas fa-minus"></i>' : '<i class="fas fa-arrow-down"></i>' ?>
                    </button>                
                    <a id="opendoc-<?=$document->id() ?>" href="<?= $pdfdownload_dir . $document->file_name() ?>" target="_blank" class="btn btn-outline-info chr_opendoc" title="Ouvrir le document dans un nouvel onglet"><i class="far fa-eye"></i></a>
                    <button type="button" class="btn btn-outline-success popable" id="button-<?= $document->id() ?>" title="Modification du nom / Changement de catégorie / Suppression du document"><i class="fas fa-plus"></i></button>
                </div>
            </form>
        </td>
        <td class="small px-2 py-1"  id="td-name-<?= $document->id() ?>"><?= $document->name() ?></td>
        <td id="td-file_name-<?= $document->id() ?>" class="small px-2 py-1" style="line-height: 1"><span class="small"><?= $document->file_name() ?></span></td>
        <td id="td-creation_time-<?= $document->id() ?>" class="small text-center py-1"><?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $document->creation_time()) ?></td>
        <td id="td-modification_time-<?= $document->id() ?>" class="small text-center py-1"><?= preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3/$2/$1', $document->modification_time()) ?></td>
        <td id="td-type_name-<?= $document->id() ?>" class="text-center td-type py-1">
            <form>
                <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                <input type="hidden" name="property" value="type_id">

<?php
    if (!empty($types))
    {
?>
                <button id="typeChange-<?= $document->id() ?>" class="badge badge-outlined badge-pill badge-primary modifDocFormLevel1" title="Changer le type"><?= ucfirst($document->type_name()) ?></button>
                <select id="typeSelect<?= $document->id() ?>" class="d-none" name="value">
<?php
        foreach ($types as $type)
        {
            
?>
                    <option value="<?= $type->id() ?>"<?= $document->type_id() == $type->id() ? ' selected="selected"' : '' ?>><?= ucfirst($type->name()) ?></option>
<?php
        }
?>
                </select>
<?php            
    }
?>    
            </form>
        </td>
        <td id="td-available-<?= $document->id() ?>" class="text-center pl-3 pr-0 py-1" style="border-right: none">
            <form>
                <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                <input type="hidden" name="property" value="available">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input modifDocFormLevel1"  id="available-<?= $document->id() ?>" name="value" value="1"<?= $document->available() == 1 ? ' checked':'' ?>>
                    <label class="custom-control-label" for="available-<?= $document->id() ?>"></label>
                </div>
            </form>
        </td>
        <td id="td-available-icon-<?= $document->id() ?>" class="text-center pl-0 pr-3 py-1" style="border-left: none"><?= $document->available() == 1 ? '<i class="fas fa-globe-europe md-dark"></i>' : '<i class="fas fa-lock md-dark md-inactive"></i>' ?></td>
        <td id="td-tracked-<?= $document->id() ?>" class="text-center pl-3 pr-0 py-1" style="border-right: none">
            <form>
                <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                <input type="hidden" name="property" value="tracked">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input modifDocFormLevel1" id="tracked-<?= $document->id() ?>" name="value" value="1"<?= $document->tracked() == 1 ? ' checked':'' ?>>
                    <label class="custom-control-label" for="tracked-<?= $document->id() ?>"></label>
                </div>
            </form>
        </td>
        <td id="td-downloads-number-<?= $document->id() ?>" class="text-center pl-0 pr-3 py-1" style="border-left: none">
<?php
        if ($document->tracked() == 1)
        {
            if($downloads_count[$document->id()] === 0)
            {
?>
                <span class="badge badge-outlined badge-pill badge-secondary" title="Aucun téléchargement.">0</span>
<?php

            }
            else
            {
?>
                <a href="?dlview=doc&doc=<?= $document->id() ?>" class="badge badge-outlined badge-pill badge-success" title="Ouvrir la liste des téléchargements."><?= $downloads_count[$document->id()] ?></a>
<?php
            }
        }
          else
          {
?>
                <i class="fas fa-minus md-dark md-inactive"></i>            
<?php            
          }
?>
        </td>
    </tr>
    <tr id="modifDocDiv-<?= $document->id() ?>" class="d-none modifDocDiv">
        <td colspan="10" class="p-0 align-middle">
            <div class="row">
                <div class="col-sm-6 pr-1">
                    <form id="modifDocForm-<?= $document->id() ?>" action="index.php" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                        <input type="hidden" name="property" value="name">
                        <div class="input-group mt-1 mb-3 input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nom&nbsp;:</span>
                            </div>
                            <input type="text" class="form-control" name="value" value="<?= $document->name() ?>" required>
                            <div class="input-group-append">
                                <button id="nameChange-<?= $document->id() ?>" class="btn btn-primary modifDocFormLevel1" id=""><i class="fas fa-save" title="Enregistrer le nouveau nom"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4 pl-1">
                    <form id="modifDocForm-<?= $document->id() ?>" action="index.php" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="document_id" value="<?= $document->id() ?>">
                        <input type="hidden" name="property" value="category_id">
                        <div class="input-group mt-1 mb-3 input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Catégorie&nbsp;:</span>
                            </div>
                            <select class="custom-select" name="value">
        <?php
                foreach ($categories as $category)
                {

        ?>
                                <option value="<?= $category->id() ?>"<?= $document->category_id() == $category->id() ? ' selected="selected"' : '' ?>><?= $category->name() ?></option>
        <?php
                }
        ?>
                            </select>                        
                            <div class="input-group-append">
                                <button id="categoryChange-<?= $document->id() ?>" class="btn btn-primary modifDocFormLevel1" title="Enregistrer le changement de catégorie"><i class="fas fa-save"></i></button>
                                <button id="categoryChangeScroll-<?= $document->id() ?>" class="btn btn-primary modifDocFormLevel1" title="Enregistrer le changement de catégorie et défiler jusqu'au nouvel emplacement"><i class="fas fa-save"></i>&nbsp;<i class="fas fa-arrows-alt-v"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2 text-right">
                            <a href="#delModal-<?= $document->id() ?>" class="btn btn-warning btn-sm mt-1 mb-3" name="submitDeleteDoc" data-toggle="modal" title="Supprimer ce document (avec confirmation)">Supprimer&hellip;&nbsp;</a>
                </div>
            </div>
            <!-- The Modal -->
            <div class="modal fade" id="delModal-<?= $document->id() ?>">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                            
<?php
                if($downloads_count[$document->id()] === 0) {
?>                    
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p class="text-center"><strong><?= $document->name() ?></strong></p>
                            <p>Êtes-vous certain de vouloir supprimer ce document&nbsp;?</p>
                            <form name="deleteDocForm" name="deleteDocForm-<?= $document->id() ?>" id="deleteDocForm-<?= $document->id() ?>" action="index.php" method="post">
                                <input type="hidden" name="do_id" value="<?= $document->id() ?>">
                                <div class="form-group text-center">
                                    <button class="btn btn-danger btn-sm" type="submit" name="submitDeleteDoc" data-target="#delModal-<?= $document->id() ?>" data-toggle="modal">Oui, supprimer</button>
                                </div>
                            </form>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm  btn-outline-secondary" data-dismiss="modal">Non, annuler</button>
                        </div>
<?php
                } else {
?>                    
                        <!-- Modal body -->
                        <div class="modal-body">
                            <p class="text-center"><strong><?= $document->name() ?></strong></p>
                            <p>Pour supprimer cette copropriété, il faut au préalable supprimer toutes ses informations de téléchargements.</p>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn  btn-outline-secondary" data-dismiss="modal">Fermer</button>
                                <a href="?dlview=doc&doc=<?= $document->id() ?>" class="btn btn-success" title="Ouvrir la liste des téléchargements.">Téléchargements <span class="badge badge-pill badge-light"><?= $downloads_count[$document->id()] ?></span></a>
                            </div>
                        </div>
<?php                  
                }
?>                                      
                    </div>
                </div>
            </div>
        </td>
    </tr>
