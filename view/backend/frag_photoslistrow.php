            <tr id="photo-<?= $photo->id() ?>">
                <td class="w-25"><img class="img-fluid" src="<?= $phodownload_dir . $photo->file_name() ?>"></td>
                <td class="small"><?= $photo->file_name() ?></td>
                <td class="ph-position text-center"><?= $photo->position() ?></td>
                <td class="text-right">
                    <a href="#delPhoModal-<?= $photo->id() ?>" class="btn btn-sm btn-warning" name="submitDeleteDoc" data-toggle="modal" title="Supprimer cette photo (avec confirmation)">Supprimer...</a>
                    <div class="modal fade" id="delPhoModal-<?= $photo->id() ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body text-left">
                                    <div class="row">
                                        <div class="col-4">
                                            <img class="img-fluid" src="<?= $phodownload_dir . $photo->file_name() ?>">
                                        </div>
                                        <div class="col-8">
                                            <p>Êtes-vous certain de vouloir supprimer cette photo&nbsp;?</p>
                                            <form name="deletePhoForm"  id="deletePhoForm-<?= $photo->id() ?>" action="index.php" method="post">
                                                <input type="hidden" name="ph_id" value="<?= $photo->id() ?>">
                                                <div class="form-group text-center">
                                                    <button class="btn btn-danger btn-sm" type="submit" name="submitDeletePho" data-target="#delPhoModal-<?= $photo->id() ?>" data-toggle="modal">Oui, supprimer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm  btn-outline-secondary" data-dismiss="modal">Non, annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
