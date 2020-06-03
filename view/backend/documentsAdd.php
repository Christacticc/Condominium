<?php $title = 'Ajout de document(s)'; ?>
<?php $bodyid = 'documentsAdd'; ?>
<?php $pagehead1 = '<link href="../vendor/dropzone-5.7.0/dist/dropzone.css" rel="stylesheet">'; ?>
<?php $pagehead2 = '<script src="../vendor/dropzone-5.7.0/dist/dropzone.js"></script>
    <script>
        Dropzone.autoDiscover = false;

    </script>

    <style>
        html,
        body {
            height: 100%;
        }

        #actions {
            margin: 2em 0;
        }


        /* Mimic table appearance */
        div.table {
            display: table;
        }

        div.table .file-row {
            display: table-row;
        }

        div.table .file-row>div {
            display: table-cell;
            vertical-align: top;
            border-top: 1px solid #ddd;
            padding: 8px;
        }

        div.table .file-row:nth-child(odd) {
            background: #f9f9f9;
        }

        /* The total progress gets shown by event listeners */
        #total-progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the progress bar when finished */
        #previews .file-row.dz-success .progress {
            opacity: 0;
            transition: opacity 0.3s linear;
        }

        /* Hide the delete button initially */
        #previews .file-row .delete {
            display: none;
        }

        /* Hide the start and cancel buttons and show the delete button */

        #previews .file-row.dz-success .start,
        #previews .file-row.dz-success .cancel {
            display: none;
        }

        #previews .file-row.dz-success .delete {
            display: block;
        }

    </style>

'; ?>
<?php ob_start(); ?>


<section class="container">
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
    <div class="card bg-light p-2 mt-4 mb-4">
        <div class="card-body">
            <p>Déposez des fichiers sur la page ou cliquez sur le bouton <em>Ajouter des fichiers</em>.</p>
            <div id="actions" class="row">

                <div class="col-sm-5">
                    <!-- The global file processing state -->
                    <span class="fileupload-process">
                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </span>
                </div>
                <div class="col-sm-7 text-right">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <div class="btn-group">
                        <span class="btn btn-success fileinput-button">
                            <span>Ajouter des fichiers...</span>
                        </span>
                        <button type="submit" class="btn btn-primary start">
                            <span>Envoyer tout</span>
                        </button>
                        <button type="reset" class="btn btn-warning cancel">
                            <span>Enlever tout</span>
                        </button>
                    </div>
                </div>

            </div>








            <div class="table table-striped files" id="previews">

                <div id="template" class="file-row">
                    <!-- This is used as the file preview template -->
                    <div class="d-none">
                        <span class="preview"><img data-dz-thumbnail /></span>
                    </div>
                    <div class="col-sm-4">
                        <p class="name" data-dz-name></p>
                        <strong class="error text-danger" data-dz-errormessage></strong>
                    </div>
                    <div class="col-sm-2">
                        <p class="size" data-dz-size></p>
                    </div>
                    <div class="col-sm-4">
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </div>
                    <div class="col-sm-2 text-right">
                        <div class="btn-group">
                            <button class="btn btn-primary start">
                                <span>Envoyer</span>
                            </button>
                            <button data-dz-remove class="btn btn-warning cancel">
                                <span>Enlever</span>
                            </button>
                            <button data-dz-remove class="btn btn-danger delete">
                                <span>Supprimer le fichier</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <script>
                // Get the template HTML and remove it from the document
                var previewNode = document.querySelector("#template");
                previewNode.id = "";
                var previewTemplate = previewNode.parentNode.innerHTML;
                previewNode.parentNode.removeChild(previewNode);

                var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
                    url: "upload.php", // Set the url
                    thumbnailWidth: 80,
                    thumbnailHeight: 80,
                    parallelUploads: 20,
                    previewTemplate: previewTemplate,
                    autoQueue: false, // Make sure the files aren't queued until manually added
                    previewsContainer: "#previews", // Define the container to display the previews
                    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
                });

                myDropzone.on("addedfile", function(file) {
                    // Hookup the start button
                    file.previewElement.querySelector(".start").onclick = function() {
                        myDropzone.enqueueFile(file);
                    };
                });

                // Update the total progress bar
                myDropzone.on("totaluploadprogress", function(progress) {
                    document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
                });

                myDropzone.on("sending", function(file) {
                    // Show the total progress bar when upload starts
                    document.querySelector("#total-progress").style.opacity = "1";
                    // And disable the start button
                    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
                });

                // Hide the total progress bar when nothing's uploading anymore
                myDropzone.on("queuecomplete", function(progress) {
                    document.querySelector("#total-progress").style.opacity = "0";
                });

                // Setup the buttons for all transfers
                // The "add files" button doesn't need to be setup because the config
                // `clickable` has already been specified.
                document.querySelector("#actions .start").onclick = function() {
                    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
                };
                document.querySelector("#actions .cancel").onclick = function() {
                    myDropzone.removeAllFiles(true);
                };

            </script>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();
require('template.php');
?>
