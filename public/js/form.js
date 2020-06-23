// JavaScript Document


/*==  Fonction ucfirst******************************************/
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
/*==  Fonction d'actualisation des boutons up et down lors des déplacements et changements de catégorie des documents */
function disableButtons(tbodyElement){
    const upArray = tbodyElement.querySelectorAll('button[name="up"]');
    const downArray = tbodyElement.querySelectorAll('button[name="down"]');
    upArray.forEach(function(item) {
       if (item == upArray[0]) {
           item.innerHTML = '<i class="fas fa-minus"></i>';
           item.disabled = true;
       } else {
           item.innerHTML = '<i class="fas fa-arrow-up"></i></i>';
           item.disabled = false;
       }
    });
    downArray.forEach(function(item) {
       if (item == downArray[downArray.length - 1]) {
           item.innerHTML = '<i class="fas fa-minus"></i>';
           item.disabled = true;
       } else {
           item.innerHTML = '<i class="fas fa-arrow-down"></i>';
           item.disabled = false;
       }
    });
}


/*== Scripts Bootstraps BEGIN **********************************/
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    const forms = document.getElementsByClassName('needs-validation');
      
    // Loop over them and prevent submission
    const validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

// Popover pour affichage des messages sur la liste des copros
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});

// The name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
/*== Scripts Bootstraps END **********************************/


/*== Script de rétablissement des boutons lorsque le document est chargé pour la page filesConf BEGIN**************/
/*document.addEventListener('DOMContentLoaded', (event) => {
    console.log('DOM fully loaded and parsed');
});*/
window.addEventListener('load', (event) => {
//    console.log('document fully loaded and parsed');
    const elementsToEnable = document.getElementsByClassName('chr-wait-for-load');
    Array.prototype.forEach.call(elementsToEnable, function(elementToEnable) {
        elementToEnable.disabled = false;
    });
    
});
/*== Script de rétablissement des boutons lorsque le document est chargé pour la page filesConf END****************/
//                                                TODO

/*window.addEventListener('load', (event) => {
//    console.log('document fully loaded and parsed');
    const elementsToPopover = document.getElementsByClassName('chr-opendoc');
    Array.prototype.forEach.call(elementsToPopover, function(elementToPopover) {
        let elementToPopoverSplit = elementToPopover.split('-');
        const documentId = elementToPopoverSplit[1];

        elementToPopover.setAttribute('
    });
    
});
*/
/*== Script de création des popover d'affimage des vignettes sur la page condominiumView BEGIN**************/

/*== Script de création des popover d'affimage des vignettes sur la page condominiumView END**************/


/*== Script de remplissage automatique du SELECT city - line_5 lors de la frappe BEGIN********/
function responsePostalCodeDeal(response) { // ****************************TO DO Ajouter la gestion des spinners
    //   console.log('Après : ' + response + ' -  typeof : ' + typeof response + ' - substr : ' + response.substr(0, 2));
    if (response.substr(0, 2) == '[{')
        {
        document.getElementById('postal_code').setCustomValidity('');
        const response_array = JSON.parse(response);
        let display;
        // Si une seule ligne >>> renseigner la city dans une option. désactiver le <select>
        // Si plusieurs lignes >>> concaténer city et line_5 dans un champs city_line_5, créer une <option> par city_line_5 plus une vide en haut.
        if (response_array.length == 1)
            {
                display = '<option>...</option><option>' + response_array[0].city + '</option>';
            }
        else
            {
                display = '<option>...</option>'
                for (let response_line of response_array)
                {
                    display +=  '<option>' + response_line.city;
                    if (response_line.line_5)
                        {
                            display += ' - ' + response_line.line_5;                        
                        }
                     display += '</option>';
                }
            }

        document.getElementById('city').innerHTML = display;   
        document.getElementById('city').setCustomValidity('');

        }
    else
    {
        document.getElementById('city').innerHTML = "";
        document.getElementById('postal_code').setCustomValidity(response);
        document.getElementById('message').innerHTML = response;
    }
}

// Créer les options des SELECT en fonction du code postal saisi :
// 1) Vérification des caractères et de la longueur du code pendant la saisie
if (document.getElementById('postal_code'))
    {
        document.getElementById('postal_code').addEventListener('input', function (e) {
            const postal_code = e.target.value;
            document.getElementById('message').innerHTML = "";

            if (postal_code.length == 5) {
                console.log('Avant : ' + postal_code);
                ajaxGet('ajax_cityfinder.php?pc=' + postal_code, responsePostalCodeDeal);
            }
            else{
                document.getElementById('city').innerHTML = "";
            }
        });
        
    }
/*== Script de remplissage automatique du SELECT city - line_5 lors de la frappe END********/


/*== Script de remplissage automatique du SELECT city - line_5 pour formulaire de modif BEGIN********/
function responsePostalCodeDeal_modif(response) { // ****************************TO DO Ajouter la gestion des spinners
 //   console.log('Après : ' + response + ' -  typeof : ' + typeof response + ' - substr : ' + response.substr(0, 2));
    if (response.substr(0, 2) == '[{')
        {
        document.getElementById('postal_code').setCustomValidity('');
        const response_array = JSON.parse(response);
        let display;
        // Si une seule ligne >>> renseigner la city dans une option.
        // Si plusieurs lignes >>> concaténer city et line_5 dans un champs city_line_5, créer une <option> par city_line_5 plus une vide en haut.
        if (response_array.length == 1)
            {
                display = '<option>...</option><option>' + response_array[0].city + '</option>';
            }
        else
            {
                display = '<option>...</option>'
                for (let response_line of response_array)
                {
                    display +=  '<option>' + response_line.city;
                    if (response_line.line_5)
                        {
                            display += ' - ' + response_line.line_5;                        
                        }
                     display += '</option>';
                }
            }

        document.getElementById('city').innerHTML = display;   
        document.getElementById('city').setCustomValidity('');

        }
    else
    {
        document.getElementById('city').innerHTML = "";
        document.getElementById('postal_code').setCustomValidity(response);
        document.getElementById('message').innerHTML = response;
    }
}

function responsePostalCodeDeal_GA(response) { // ****************************TO DO Ajouter la gestion des spinners
 //   console.log('Après : ' + response + ' -  typeof : ' + typeof response + ' - substr : ' + response.substr(0, 2));
    if (response.substr(0, 2) == '[{')
        {
        document.getElementById('postal_code').setCustomValidity('');
        const response_array = JSON.parse(response);
        let display;
        display = '<option>...</option><option selected>' + response_array[0].city + '</option>';

        document.getElementById('city').innerHTML = display;   
        document.getElementById('city').setCustomValidity('');

        }
    else
    {
        document.getElementById('city').innerHTML = "";
        document.getElementById('postal_code').setCustomValidity(response);
        document.getElementById('message').innerHTML = response;
    }
}

if (document.getElementById('postal_code'))
    {
        const postal_code = document.getElementById('postal_code').value;
        if (postal_code.length == 5)
        {
            if (document.getElementById('condominiumView')) 
            {
                ajaxGet('ajax_cityfinder.php?pc=' + postal_code, responsePostalCodeDeal_modif);
            }
            if (document.getElementById('generalAssemblyView')) 
            {
                ajaxGet('ajax_cityfinder.php?pc=' + postal_code, responsePostalCodeDeal_GA);
            }
        }
        else
        {
            document.getElementById('city').innerHTML = "";
        }
    }

/*== Script de remplissage automatique du SELECT city - line_5 pour formulaire de modif END********/

/*== Script d'envoi du formulaire de création de document BEGIN********/

/* TO DO */

/*== Script d'envoi du formulaire de création de document END********/

/*== Script d'envoi des formulaires de modification de condominium BEGIN********/
function responseModifDeal(response) { // ****************************
    //   console.log('Après : ' + response + ' -  typeof : ' + typeof response);
    if (response.substr(0, 1) == '{')
        {
            const response_array = JSON.parse(response);
            document.getElementById('a-name').innerHTML = response_array['name'];
            document.getElementById('a-address_1').innerHTML = response_array['address_1'];
            document.getElementById('a-address_2').innerHTML = response_array['address_2'];
            document.getElementById('a_2-postal_code').innerHTML = response_array['postal_code'];
            document.getElementById('a_3-postal_code').innerHTML = response_array['city'];
            document.getElementById('a-internal_reference').innerHTML = response_array['internal_reference'];
            document.getElementById('a-password').innerHTML = response_array['password'];
           document.getElementById('a-message').innerHTML = response_array['message'];
        }
    else
        {
             document.getElementById('msg').innerHTML = response;
        }
    
    
    const modifDivArray = document.getElementsByClassName('modifDiv');
    for (let j = 0; j < modifDivArray.length; j++)
        {
            let formElement = modifDivArray[j];                    
            if (!formElement.classList.contains("d-none"))
                {
                    formElement.classList.add('d-none');
                }
        }
}

const modifDivArray = document.getElementsByClassName('modifDiv');
for (let i = 0; i < modifDivArray.length; i++)
    {
        let modifDivId = modifDivArray[i].id;
        let modifFormId = 'modifForm-' + modifDivId.slice(modifDivId.indexOf('-') + 1);
        let modifForm = document.getElementById(modifFormId);
        modifForm.addEventListener('submit', function (e) {
            e.preventDefault()
            let message = '';
            let ajax = ''
            let submitedForm = e.target;
            console.log ('modifFormId : ' + submitedForm.id);
            console.log('modifDivId : ' + modifDivId);
//            console.log('length : ' + submitedForm.querySelectorAll('input, select').length);
            if (submitedForm.querySelectorAll('input, select, textarea').length == 2)
                {    
                    if (submitedForm.querySelectorAll('input, select, textarea')[1].required) 
                    {
                        if( submitedForm.querySelectorAll('input, select, textarea')[1].value == 0)
                            {
                                message = 'Ce champ doit être rempli';        
                            }
                        else
                            {
                                ajax = '?id=' + submitedForm.querySelectorAll('input, select, textarea')[0].value + '&' + submitedForm.querySelectorAll('input, select, textarea')[1].name + '=' + submitedForm.querySelectorAll('input, select, textarea')[1].value;
                                console.log('ajx 214 : ' + ajax);
                            }
                    }
                    else // Not required.
                        {
                            ajax = '?id=' + submitedForm.querySelectorAll('input, select, textarea')[0].value + '&' + submitedForm.querySelectorAll('input, select, textarea')[1].name + '=' + submitedForm.querySelectorAll('input, select, textarea')[1].value;
                            console.log('ajx 220 : ' + ajax);
                        }
                }
            else if (submitedForm.querySelectorAll('input, select').length == 3) // length 3 donc code postal
                {
                    if (submitedForm.id == 'modifForm-postal_code')
                        {
                            if (document.getElementById('postal_code').value == '')
                                {
                                    message = 'Ce champ doit être rempli';
                                }
                            else
                                {
                                    ajax = '?id=' + submitedForm.querySelectorAll('input')[0].value + '&postal_code=' + document.getElementById('postal_code').value;
                                    console.log('ajx 234 : ' + ajax);
                                }
                            if (document.getElementById('city').value == '')
                                {
                                    message = 'Ce champ doit être rempli';
                                }
                                    ajax += '&city=' + document.getElementById('city').value;
                                    console.log('ajax 241 : ' + ajax);
                        }
                }
            if (message == '')
                {                    
                    ajaxGet('ajax_condominiummodif.php' + ajax, responseModifDeal);
                }
            else
                {
                    echo(message);
                }
        });

    }


/*== Script d'envoi des formulaires de modification de condominium END********/

/*== Script d'envoi des formulaires de confirmation de fichier BEGIN********/
function responseConfirmFile(response) { 
    //   console.log('Après : ' + response + ' -  typeof : ' + typeof response);
    if (response.substr(0, 1) == '{') {
        let response_array = JSON.parse(response);
        let documentId = response_array['id'];
        let card = document.getElementById('card-' + documentId);
        card.classList.add('chr-outline-purple');
        let button = card.getElementsByTagName('button')[0];
        button.innerHTML = 'Réenregistrer';
        let check = card.getElementsByTagName('i')[0];
        check.classList.remove('d-none');
    }
}

const formConfFileArray = document.querySelectorAll('#filesConf .needs-validation');
for (let i = 0; i < formConfFileArray.length; i++) {
    formConfFileArray[i].addEventListener('submit', function (e) {
        e.preventDefault();
        const formElement = e.target;
        if (formElement.checkValidity() === false) {
            e.stopPropagation;
        } else {
            const formData = new FormData(formElement);
/*            for(var pair of formData.entries()) {
               console.log(pair[0]+ ', '+ pair[1]);
            }
*/
            ajaxPost('ajax_fileconf.php', formData, responseConfirmFile);

        }
    });
}
/*== Script d'envoi des formulaires de confirmation de fichier END********/
                                          
                                          
/*== Script d'envoi des formulaires de modification de document BEGIN********/
function responseModifDocument(response) { 
    //   console.log('Après : ' + response + ' -  typeof : ' + typeof response);
    if (response.substr(0, 1) == '{') {
        let response_array = JSON.parse(response);
        let documentId = response_array['id'];
        let modified_property = response_array['modified_property'];
        let formId = 'modifDocDiv-' + documentId; // le formulaire à refermer pour name et category
        let modifDocElement = document.getElementById(formId);
        let buttonElement = document.getElementById('button-' + documentId);
        switch (modified_property) {
            case 'type_id':
                let button = document.getElementById('typeChange-' + documentId);
                button.classList.remove('badge-secondary');
                button.classList.add('badge-chr-purple');
                button.disabled = false;
                break;
            case 'available':
                let availableIconeTD = document.getElementById('td-available-icon-' + documentId);
                if (response_array['available'] == 1) {
                    availableIconeTD.innerHTML = '<i class="fas fa-globe-europe md-dark chr-purple"></i>';
                }
                else {
                    availableIconeTD.innerHTML = '<i class="fas fa-lock md-dark md-inactive chr-purple"></i>';                
                }
                break;
            case 'tracked':
                let downloadsTD = document.getElementById('td-downloads-number-' + documentId);
                if (response_array['tracked'] == 1) {
                    if (response_array['downloads_count'] == 0) {
                        downloadsTD.innerHTML = '<span class="badge badge-outlined badge-pill badge-chr-purple">' + response_array['downloads_count'] +'</span>';
                    }
                    else {
                        downloadsTD.innerHTML = '<a href="?dlview=doc&doc=' + documentId +'" class="badge badge-outlined badge-pill badge-chr-purple" title="Ouvrir la liste des téléchargements.">' + response_array['downloads_count'] + '</a>'; 
                    }
                }
                else {
                    downloadsTD.innerHTML = '<i class="fas fa-minus md-dark md-inactive chr-purple"></i>'
                }
                break;                
            case 'name':
                let nameTD = document.getElementById('td-name-' + documentId);
                nameTD.innerHTML = response_array['name'];
                nameTD.classList.add('text-chr-purple');
                modifDocElement.classList.add('d-none');
                buttonElement.innerHTML = '<i class="fas fa-plus"></i>';
                break;                
            case 'category_id':
                modifDocElement.classList.add('d-none');
                let trId = 'tr-' + documentId; // le formulaire à refermer pour name et category
                let trElement = document.getElementById(trId);
                trElement.classList.add('chr-outline-purple');

                // Insérer les 2 tr du document en haut de la nouvelle catégorie
                const tbodyId = 'tbody-' + response_array['category_id'];
                const tbodyElement = document.getElementById(tbodyId);
                const firstElement = tbodyElement.children[2];
                tbodyElement.insertBefore(trElement, firstElement);
                tbodyElement.insertBefore(modifDocElement, firstElement);
                // mettre à jour la validité des boutons up et down
                disableButtons (tbodyElement);
                //mettre à jour le nombre de documents dans le titre 
                let nbDocuments = tbodyElement.querySelectorAll('TR[id]').length / 2;
                let titleTR = tbodyElement.children[0];
                titleTR.firstElementChild.firstElementChild.innerText = capitalizeFirstLetter(response_array['category_name']) + ' (' + nbDocuments + ')';
                //mettre à jour la ligne d'entête des colonnes de la catégorie
                if (nbDocuments == 0) {
                    titleTR.nextElementSibling.innerHTML = '<td class="text-muted" colspan="10">Aucun document pour cette catégorie</td>';
                } else {
                    titleTR.nextElementSibling.innerHTML = '<td class="small" style="border-right: none"></td><td class="small" style="border-left: none; width: 310px"><strong>Nom</strong></td><td class="small" style="width: 200px"><strong>Fichier</strong></td><td class="small"><strong>Création</strong></td><td class="small"><strong>Modification</strong></td><td class="text-center small"><strong>Type</strong></td><td class="text-center small" colspan="2"><strong>Publié</strong></td><td class="text-center small" colspan="2"><strong>Suivi</strong></td>';
                }
                
                // mettre à jour la validité des boutons up et down dans l'ancienne catégorie
                const old_tbodyId = 'tbody-' + response_array['old_category_id'];
                const old_tbodyElement = document.getElementById(old_tbodyId);
                disableButtons (old_tbodyElement);
                // mettre à jour le bouton d'ouverture du second TR
                buttonElement.innerHTML = '<i class="fas fa-plus"></i>';                
                //mettre à jour le nombre de documents dans le titre dans l'ancienne catégorie
                nbDocuments = old_tbodyElement.querySelectorAll('TR[id]').length / 2;
                titleTR = old_tbodyElement.children[0];
                titleTR.firstElementChild.firstElementChild.innerText = capitalizeFirstLetter(response_array['old_category_name']) + ' (' + nbDocuments + ')';
                //mettre à jour la ligne d'entête des colonnes de l'ancienne catégorie
                if (nbDocuments == 0) {
                    titleTR.nextElementSibling.innerHTML = '<td class="text-muted" colspan="10">Aucun document pour cette catégorie</td>';
                } else {
                    titleTR.nextElementSibling.innerHTML = '<td class="small" style="border-right: none"></td><td class="small" style="border-left: none; width: 310px"><strong>Nom</strong></td><td class="small" style="width: 200px"><strong>Fichier</strong></td><td class="small"><strong>Création</strong></td><td class="small"><strong>Modification</strong></td><td class="text-center small"><strong>Type</strong></td><td class="text-center small" colspan="2"><strong>Publié</strong></td><td class="text-center small" colspan="2"><strong>Suivi</strong></td>';
                }
                
                
                if (typeof response_array['scroll'] !== 'undefined') {
                    trElement.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                }
                break;
        }
    }
}

const modifDocFormLevel1Array = document.getElementsByClassName('modifDocFormLevel1');
for (let i = 0; i < modifDocFormLevel1Array.length; i++) {
    modifDocFormLevel1Array[i].addEventListener('click', function (e) {
        const clickedElement = e.target;
        if (clickedElement.closest('BUTTON')) {
            e.preventDefault();
        }
        const clickedId = clickedElement.id;
        const documentId = clickedId.slice(clickedId.indexOf('-') + 1);
        const formElement = clickedElement.closest('FORM');
        if (clickedId.slice(0, clickedId.indexOf('-')) == 'typeChange') {   
            const select = document.getElementById('typeSelect' + documentId);
            let indexAfter = select.selectedIndex + 1;
            select.selectedOptions[0].removeAttribute('selected');
            if (indexAfter === select.options.length) {
                indexAfter = 0;
            }
            select.options[indexAfter].setAttribute("selected", "selected");
            clickedElement.innerText = select.selectedOptions[0].label;
            clickedElement.classList.remove('badge-primary');
            clickedElement.classList.add('badge-secondary');
            clickedElement.disabled = true;
        }
        const formData = new FormData(formElement);
        if (clickedElement.closest('BUTTON')) {
            var clickedButtonId = clickedElement.closest('BUTTON').id;
            if (clickedButtonId.slice(0, clickedButtonId.indexOf('-')) == 'categoryChangeScroll') {
                formData.append('scroll', 1);
            }
        }
        ajaxPost('ajax_documentmodif.php', formData, responseModifDocument);
    });
}


/*== Script d'envoi des formulaires de modification de document END********/

/*== Script de déplacement de document BEGIN********************************/
function responseMoveDocument(response) { 
    //   console.log('Après : ' + response + ' -  typeof : ' + typeof response);
    if (response.substr(0, 1) == '{') {
        let response_array = JSON.parse(response);
        let documentToMoveUpId = response_array['documentToMoveUp_id'];
        let documentToMoveDownId = response_array['documentToMoveDown_id'];
        
        let tbodyId = 'tbody-' + response_array['category_id'];
        let tbodyElement = document.getElementById(tbodyId);
        let referenceTRElement = document.getElementById('tr-' + response_array['documentToMoveDown_id']);
        let trElement = document.getElementById('tr-' + response_array['documentToMoveUp_id']);
        let modifDocElement = document.getElementById('modifDocDiv-' + response_array['documentToMoveUp_id']);
        tbodyElement.insertBefore(trElement, referenceTRElement);
        tbodyElement.insertBefore(modifDocElement, referenceTRElement); 
        disableButtons (tbodyElement);
    }
}

const moveDocumentFormArray = document.getElementsByClassName(' moveDocument');
for (let i = 0; i < moveDocumentFormArray.length; i++) {
    moveDocumentFormArray[i].addEventListener('click', function (e) {
        e.preventDefault();
        const clickedElement = e.target;
        if (clickedElement.closest('BUTTON')) {
            e.preventDefault();
        }
        const formElement = clickedElement.closest('FORM');
        const formData = new FormData(formElement);
        formData.append('movement', clickedElement.closest('BUTTON').name);

        ajaxPost('ajax_documentmove.php', formData, responseMoveDocument);
    });
}
/*== Script de déplacement de document END****************************************/


/*== Script d'envoi des formulaires de suppression de document BEGIN********/
function responseDeleteDocDeal(response) { 
//       console.log('Après : ' + response + ' -  typeof : ' + typeof response);
    if (/[0-9]+/.test(response)) {
        if (document.getElementById('condominiumView')) { // Page Copropriété
            let tr1 = document.getElementById('tr-' + response); 
            let tr2 = document.getElementById('modifDocDiv-' + response);
            let tbodyElement = tr1.parentNode;
            if (tr1.parentNode) {
                tr1.parentNode.removeChild(tr1);
            }
            if (tr2.parentNode) {
                tr2.parentNode.removeChild(tr2);
            }
            disableButtons (tbodyElement);
            //mettre à jour le nombre de documents dans le titre 
            let nbDocuments = tbodyElement.querySelectorAll('TR[id]').length / 2;
            let titleTR = tbodyElement.children[0];
            let categoryName = titleTR.firstElementChild.firstElementChild.innerText;
            titleTR.firstElementChild.firstElementChild.innerText = categoryName.replace(/^((.)+\s)\(\d+\)$/,  '$1 (' + nbDocuments + ')');
            //mettre à jour la ligne d'entête des colonnes de la catégorie
            if (nbDocuments == 0) {
                titleTR.nextElementSibling.innerHTML = '<td class="text-muted" colspan="10">Aucun document pour cette catégorie</td>';
            } else {
                titleTR.nextElementSibling.innerHTML = '<td class="small" style="border-right: none"></td><td class="small" style="border-left: none; width: 310px"><strong>Nom</strong></td><td class="small" style="width: 200px"><strong>Fichier</strong></td><td class="small"><strong>Création</strong></td><td class="small"><strong>Modification</strong></td><td class="text-center small"><strong>Type</strong></td><td class="text-center small" colspan="2"><strong>Publié</strong></td><td class="text-center small" colspan="2"><strong>Suivi</strong></td>';
            }
        } else if (document.getElementById('filesConf')){
            let card = document.getElementById('card-' + response);
            let delModal = document.getElementById('delModal-' + response);
            if (card.parentNode) {
                card.parentNode.removeChild(card);
            }
            if (delModal.parentNode) {
                delModal.parentNode.removeChild(delModal);
            }
        }
    } else {
         document.getElementById('msg').innerHTML = response;
    }

    const modifDocDivArray = document.getElementsByClassName('modifDocDiv');
    for (let j = 0; j < modifDocDivArray.length; j++) {
        let formElement = modifDocDivArray[j];                    
        if (!formElement.classList.contains("d-none")) {
            formElement.classList.add('d-none');
        }
    }
}

const deleteDocFormArray = document.getElementsByName('deleteDocForm');
for (let i = 0; i < deleteDocFormArray.length; i++) {
    let deleteDocFormId = deleteDocFormArray[i].id;
    let deleteDocForm = document.getElementById(deleteDocFormId);
    deleteDocForm.addEventListener('submit', function (e) {
        e.preventDefault();
        let submitedForm = e.target;
        let submitedFormArray = submitedForm.querySelectorAll('input');            
        let ajax = '?id=' + submitedFormArray[0].value;
        ajaxGet('ajax_documentdelete.php' + ajax, responseDeleteDocDeal);
    });
}

/*== Script d'envoi des formulaires de suppression de document END********/


/*== Script d'envoi d'inversion de position de photo BEGIN********/
function responseReversePhoDeal(response) { 
    //   console.log('Après : ' + response + ' -  typeof : ' + typeof response);
        if (response.substr(0, 2) == '[{')
        {
            const response_array = JSON.parse(response);
            for (let response_line of response_array)
            {
                document.querySelector('#photo-' + response_line.id + ' .ph-position').innerHTML = response_line.position;
            }
        }
    else
        {
             document.getElementById('msg').innerHTML = response;
        }

    const modifDocDivArray = document.getElementsByClassName('modifDocDiv');
    for (let j = 0; j < modifDocDivArray.length; j++)
        {
            let formElement = modifDocDivArray[j];                    
            if (!formElement.classList.contains("d-none"))
                {
                    formElement.classList.add('d-none');
                }
        }
}

if (document.getElementById('ph_reverse'))
    {
        document.getElementById('ph_reverse').addEventListener('click', function (e) {
            e.preventDefault();
            let ajax = '?id=' + document.getElementById('ph_condominium_id').value;
            ajaxGet('ajax_photoreverse.php' + ajax, responseReversePhoDeal);
        });
    }

/*== Script d'envoi d'inversion de position de photo END********/


/*== Script d'ouverture/fermeture des formulaires de modification de condominium ou de document BEGIN********/
// Ouvrir le formulaire correspondant au champ à modifier :
const popableArray = document.getElementsByClassName('popable');
for (let i = 0; i < popableArray.length; i++) {
        let eltId = popableArray[i].id;
        let eltIdSplit = eltId.split('-');
        const prefixes = ['a','a_1','a_2','a_3', 'span', 'span_1', 'span_2', 'span_3'];
        if (prefixes.indexOf(eltIdSplit[0]) !== -1) {
            let formId = 'modifDiv-' + eltIdSplit[1];
            document.getElementById(eltId).addEventListener('click', function (e) {
                const modifDivArray = document.getElementsByClassName('modifDiv');
                for (let j = 0; j < modifDivArray.length; j++) {
                    let formElement = modifDivArray[j];
                    if (!formElement.classList.contains("d-none")) {
                            formElement.classList.add('d-none');
                    }
                }
                document.getElementById(formId).classList.remove('d-none');
            });            
        }
        else if (eltIdSplit[0] == 'button') // pour modification de document
            {
                let formId = 'modifDocDiv-' + eltIdSplit[1];
                let buttonElement = document.getElementById('button-' + eltIdSplit[1]);
                let modifDocElement = document.getElementById(formId);
                document.getElementById(eltId).addEventListener('click', function () {
                    if (!modifDocElement.classList.contains("d-none")) { 
                        modifDocElement.classList.add('d-none');
                        buttonElement.innerHTML = '<i class="fas fa-plus"></i>';
                        buttonElement.title = 'Modification du nom / Changement de catégorie / Suppression du document';
                    } else {
                        modifDocElement.classList.remove('d-none');
                        buttonElement.innerHTML = '<i class="fas fa-minus"></i>';
                        buttonElement.title = "Fermer le volet";
                    }
                });                
            }

    }
/*== Script d'ouverture/fermeture des formulaires de modification de condominium ou de document END********/


/*== Script de remplissage de l'adresse de l'AG par une adresse prédéterminée BEGIN********/
const fillAddrArray = document.getElementsByClassName('fill-addr'); 
for (let i = 0; i < fillAddrArray.length; i++)
    {
        let fillAddr = fillAddrArray[i];
        fillAddr.addEventListener('click', function (e) {
            let clickedButton = e.target;
            const clickedButtonId = clickedButton.id;
            if (clickedButtonId == 'fillAddr1')
                {
                    document.getElementById('address_1').value = document.getElementById('address_1_1').value;
                    document.getElementById('address_2').value = document.getElementById('address_2_1').value;
                    document.getElementById('postal_code').value = document.getElementById('postal_code_1').value;
                    document.getElementById('city').innerHTML = '<option>...</option><option selected>' + document.getElementById('city_1').value + '</option>';
                }
            else if (clickedButtonId == 'fillAddr2')
                {
                    document.getElementById('address_1').value = document.getElementById('address_1_2').value;
                    document.getElementById('address_2').value = document.getElementById('address_2_2').value;
                    document.getElementById('postal_code').value = document.getElementById('postal_code_2').value;
                    document.getElementById('city').innerHTML = '<option>...</option><option selected>' + document.getElementById('city_2').value + '</option>';
                                    }
            else if (clickedButtonId == 'resetAddr')
                {
                    document.getElementById('address_1').value = '';
                   document.getElementById('address_2').value = '';
                    document.getElementById('postal_code').value = '';
                    document.getElementById('city').innerHTML = '';
                }
        });
    }
        

/*== Script de remplissage de l'adresse de l'AG par une adresse prédéterminée END********/


/*== Script de mise au format jj/mm/dddd de la date préremplie d'une AG dans Safari qui ne prend pas en charge l'input type date BEGIN********/
if (document.getElementById('day'))
    {
        const test = document.createElement('input'); // On teste si l'élément <input type="date">
        test.type = 'date'; // se transforme en <input type="text">
        if(test.type === 'text') // Si c'est le cas, cela signifie que l'élément n'est pas pris en charge
            {
                const dayValue = document.getElementById('day').value;
                document.getElementById('day').value = dayValue.replace(/^(\d{4})-(\d{2})-(\d{2})$/, '$3/$2/$1');
            }
    }


/*== Script de mise au format jj/mm/dddd de la date préremplie d'une AG dans Safari qui ne prend pas en charge l'input type date END********/


/*== Script d'invalidation du formulaire si des champs ne sont pas présents BEGIN********/
window.addEventListener("DOMContentLoaded", (e) => {
    if (typeof disableElts !== 'undefined')
        {
            disableElts.forEach(elementToDisable => document.getElementById(elementToDisable).disabled = true);
        }
  });
/*== Script d'invalidation du formulaire si des champs ne sont pas présents END********/

/*== Script de sélection de toutes les cases à cocher BEGIN********/
if (document.getElementById('select-all'))
    {
        const select_all = document.getElementById('select-all');
        select_all.addEventListener('change', function(e) {
            const form = e.target.closest('FORM');
            const checkboxes = form.querySelectorAll('.select-checkbox');
            if (select_all.checked)
                {
                    for(let i=0; i<checkboxes.length; i++)
                        {
                            checkboxes[i].indeterminate = false;
                            checkboxes[i].checked = true;
                        }
                }
            else
                {
                    for(let i=0; i<checkboxes.length; i++)
                        {
                            checkboxes[i].indeterminate = false;
                            checkboxes[i].checked = false;
                        }
                }            
        });
    }

if (document.getElementsByClassName('select-one-checkbox'))
{
    const checkboxes = document.getElementsByClassName('select-one-checkbox');
        for(let i=0; i<checkboxes.length; i++)
            {
                checkboxes[i].addEventListener('click', function(e) {
                    console.log('clic');
                    let yes = 0;
                    let no = 0;
                    for(let i=0; i<checkboxes.length; i++)
                        {
                            if (checkboxes[i].checked)
                                {
                                    yes ++ ;
                                }
                            else
                                {
                                    no ++ ;
                                }
                        }
                    if (yes == checkboxes.length)
                        {
                            document.getElementById('select-all').indeterminate = false;
                            document.getElementById('select-all-2').indeterminate = false;
                            document.getElementById('select-all').checked = true;
                            document.getElementById('select-all-2').checked = true;
                        }
                    else if (no == checkboxes.length)
                        {
                            document.getElementById('select-all').indeterminate = false;
                            document.getElementById('select-all-2').indeterminate = false;
                            document.getElementById('select-all').checked = false;
                            document.getElementById('select-all-2').checked = false;
                        }
                    else
                        {
                            document.getElementById('select-all').indeterminate = true;
                            document.getElementById('select-all-2').indeterminate = true;
                        } 
                });
            }
    
}

/*== Script de sélection de toutes les cases à cocher END********/



/*
// 3) Traitement de la réponse du serveur
function dealReponseDetails() {
    console.log('deal');
	if(objQuery.readyState == 1){
			document.getElementById("condo_city").innerHTML ="<option>Chargement...</option>"
	}
	else {
		if(objQuery.readyState == 4){ //la valeur 4 de la propriété readyState correspond à COMPLETED, c.a.d. que la transmission des données est terminée.
			document.getElementById("condo_city").innerHTML = objQuery.responseText; // responseText : propriété de objRequete qui contient la réponse retournée par le serveur.
		}
	}
}

*/