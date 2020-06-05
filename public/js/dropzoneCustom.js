// JavaScript Document

function responseDeleteDocument(response) { 
    console.log('Après : ' + response + ' -  typeof : ' + typeof response);
}


// Get the template HTML and remove it from the document
var previewNode = document.querySelector('#template');
previewNode.id = '';
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);

var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: 'upload.php', // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: '#previews', // Define the container to display the previews
    clickable: '.fileinput-button', // Define the element that should be used as click trigger to select files
    maxFilesize: 10, // MB
    dictFileTooBig: 'Ce fichier est trop gros ({{filesize}} MB). Taille maximum des fichiers : {{maxFilesize}} MB.',
    acceptedFiles: 'application/pdf', // Equivalent à l'attribut accept.
    dictInvalidFileType: 'Il n\'est pas possible d\'envoyer ce type de fichier. Fichiers pris en charge : pdf.'
});

myDropzone.on("sending", function(file, xhr, formData) {
  // Will send the filesize along with the file as POST data.
  formData.append("condominium_id", condominium_id); //condominium_id
});

myDropzone.on('addedfile', function(file) {
    // Hookup the start button
    file.previewElement.querySelector('.start').onclick = function() {
        myDropzone.enqueueFile(file);
    };
});

// Update the total progress bar
myDropzone.on('totaluploadprogress', function(progress) {
    document.querySelector('#total-progress .progress-bar').style.width = progress + '%';
});

myDropzone.on('sending', function(file) {
    // Show the total progress bar when upload starts
    document.querySelector('#total-progress').style.opacity = '1';
    // And disable the start button
    file.previewElement.querySelector('.start').setAttribute('disabled', 'disabled');
    file.previewElement.querySelector('.btn-group').classList.add('d-none');
});

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on('queuecomplete', function(progress) {
    document.querySelector('#total-progress').style.opacity = '0';
});

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.

/*document.querySelector('#actions .start').onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED)); // la méthode enqueueFiles traite TOUS les fichiers.
};*/
// On veut respecter un délai d'au moins 1 seconde entre 2 fichers afin que le timestamp ajouté au nom de fichier soit différent, au cas ou 2 ou plusieurs fichiers portent le même nom :
document.querySelector('#actions .start').onclick = function() {
      // Retrieve selected files
    const acceptedFiles = myDropzone.getAcceptedFiles()
    for (let i = 0; i < acceptedFiles.length; i++) {
        setTimeout(function () {
            myDropzone.enqueueFile(acceptedFiles[i])
        }, i * 2000)
    }
};
document.querySelector('#actions .cancel').onclick = function() {
    myDropzone.removeAllFiles(true);
};

// Display additional information after a file uploaded.
myDropzone.on("success", function(file, response) {
    console.log('Après : ' + response + ' -  typeof : ' + typeof response);
    if (response.substr(1, 1) == '{') {
        let response_array = JSON.parse(response);
        file.previewElement.querySelector('.name').innerHTML = response_array['file_name'];
        file.previewElement.querySelector('.delete').id = response_array['id'];
    }
});

myDropzone.on('removedfile', function(file) {
    if (file.upload['progress'] == 100) { // si progress = 100 le fichier est uploadé.
        const document_id = file.previewElement.querySelector('.delete').id;
        ajaxGet('ajax_documentdelete.php?id=' + document_id, responseDeleteDocument);
    }
});

