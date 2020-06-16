// JavaScript Document
function ajaxPost(url, formData, callback) {
    var req = new XMLHttpRequest();
    req.open('POST', url);
    req.addEventListener('load', function () {
        if (req.status === 200) {
            // Appelle la fonction callback en lui passant la réponse de la requête
            callback(req.responseText);
            
        } else {
            console.error(req.status + " " + req.statusText + " " + url);
        }
    });
    req.addEventListener('error', function () {
        console.error('Erreur réseau avec l\'URL' + url);
    });
    // Display the key/value pairs
    for (var pair of formData.entries()) {
    }
    req.send(formData);
}