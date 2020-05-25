// JavaScript Document
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
          console.log('Coucou3');
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

/*== Script du datalist member_feed lors de la frappedans l'input member_name BEGIN********/
function responseMemberDeal(response)
{
    if (response.substr(0, 2) == '[{')
        {
            const member_name = document.getElementById('member_name');
            const member_feed = document.getElementById('member_feed');
            document.getElementById('member_name').setCustomValidity('');
            const response_array = JSON.parse(response);
            let display = '';
            let nb_options = 0;
            for (let response_line of response_array)
            {
                let current_option = document.createElement('option');
                current_option.id = 'option' + response_line['id'];
                current_option.value = response_line['name'];
                current_option.appendChild(document.createTextNode(response_line['name']));
                member_feed.appendChild(current_option);
                member_feed.size = nb_options + 1;
                member_feed.size = 10;
                member_feed.style.padding = 'inherit';
                member_feed.style.height = 'auto';
                member_feed.style.borderWidth = '1px';

                current_option.addEventListener('click', function (event) {
                    member_name.value = current_option.value;
                    member_feed.size = 0;
                    member_feed.style.padding = 0;
                    member_feed.style.height = 0;
                    member_feed.style.borderWidth = 0;
                    let detail = '<strong>' + response_line['name'] + '</strong><br>';
                    if (response_line['address_1'] != '' && response_line['address_1'] != null)
                        {
                            detail += response_line['address_1'] + '<br>';
                        }
                    if (response_line['address_2'] != '' && response_line['address_2'] != null)
                        {
                            detail += response_line['address_2'] + '<br>';
                        }
                    detail += response_line['postal_code'] + ' ' + response_line['city'];
                    let message = document.createElement('p');
                    message.id = 'message';
                    message.innerHTML = detail;
                    document.getElementById('message_container').innerHTML = '';
                    document.getElementById('message_container').appendChild(message);
                    document.getElementById('pwd').focus();
                });
                
                nb_options ++;
            }

            document.getElementById('member_feed').size = nb_options + 1;
            document.getElementById('member_name').setCustomValidity('');

        }
    else
    {
        document.getElementById('member_feed').innerHTML = "";
        document.getElementById('member_name').setCustomValidity(response);
        document.getElementById('message').innerHTML = response;
    }
}

if (document.getElementById('member_name'))
    {
        document.getElementById('member_name').focus();

            if (document.getElementById('member_feed'))
            {
                const member_feed = document.getElementById('member_feed');
                member_feed.size = 0;
                member_feed.style.padding = 0;
                member_feed.style.height = 0;
                member_feed.style.borderWidth = 0;
                document.getElementById('member_name').focus;

            }
            document.getElementById('member_name').addEventListener('input', function (event) {
                const entry = event.target.value;
                document.getElementById('member_feed').innerHTML = "";
                if (entry.length >= 2) {
                    ajaxGet('ajax_memberfeed.php?e=' + entry, responseMemberDeal);
                }
                else
                {
                    const member_feed = document.getElementById('member_feed');
                    member_feed.innerHTML = "";
                    member_feed.size = 0;
                    member_feed.style.padding = 0;
                    member_feed.style.height = 0;
                    member_feed.style.borderWidth = 0;
                }
            });

    }
/*== Script de remplissage automatique du SELECT city - line_5 lors de la frappe END********/
/*== Script de soumission du formulaire de téléchargement BEGIN********/
function responseDownloadDoc(response) { 
    console.log('Après : ' + response + ' -  typeof : ' + typeof response);
    if (response.substr(0, 1) == '{')
        {
            const response_array = JSON.parse(response);
            let document_id = response_array['document_id'];
            let document_name = response_array['document_name'];
            let document_link = '../pdf/' + response_array['document_file_name'];
            let document_type_id = response_array['document_type_id'];
            let creation_time = response_array['document_creation_time'];
            creation_time = creation_time.replace(/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/, '$3/$2/$1');
            // mettre le lien du document dans les 3 zones : fiche, documents récents et liste générale.
            // Fiche synthétique
            if (document_type_id == 1)
                {
                    document.getElementById('fiche').innerHTML = 
                        '<div class="bloc-text">' +
                        '<p>Fiche synthétique de la copropriété au ' + creation_time +  '</p>' +
                        '</div>' +
                        '<a class="icone-link" href="' + document_link +'" target="_blank"><i class="fas fa-arrow-right"></i></a>'
                }
            // Documents récents
            if (document.getElementById('downloadLink_s2-' + document_id))
                {
                    document.getElementById('downloadLink_s2-' + document_id).innerHTML = '<strong>' + document_name + '</strong>';
                    document.getElementById('downloadLink_s2-' + document_id).href = document_link;
                    document.getElementById('downloadLink_s2-' + document_id).setAttribute('data-toggle', '');
                    document.getElementById('downloadLink_s2-' + document_id).setAttribute('target', '_blank');
                }
            // Liste générale
            if (document.getElementById('downloadLink_s3-' + document_id))
                {
                    document.getElementById('downloadLink_s3-' + document_id).innerHTML = '<strong>' + document_name + '</strong>';
                    document.getElementById('downloadLink_s3-' + document_id).href = document_link;
                    document.getElementById('downloadLink_s3-' + document_id).setAttribute('data-toggle', '');                    
                    document.getElementById('downloadLink_s3-' + document_id).setAttribute('target', '_blank');
                }            
            // afficher le message dans le formulaire 
            let form_array = document.getElementsByClassName('modal');
            for(let form of form_array)
                {
                    if (getComputedStyle(form).display == 'block')
                        {
                            let opened_form = form;
                            opened_form.querySelector('.modal-body .bloc-text').innerHTML =
                                '<pstyle="font-size: 0.85em; line-height: 1em;"><strong>Merci,<br>Vous pouvez fermer cette fenêtre et télécharger votre document en cliquant à nouveau dessus.</strong></p>';
                            let button = opened_form.querySelector('button[type="submit"]');
                            button.parentElement.removeChild(button);
                        }
                }
        }
}



const formArray = document.getElementsByName('downloadDocForm');
for (let dowload_form of formArray)
    {
        dowload_form.addEventListener('submit', function(e) {
            e.preventDefault()
            let message = '';
            let ajax = ''
            let submitedForm = e.target;
            let document_id = submitedForm.querySelector('input[type="hidden"]').value;
            let e_mail_address = submitedForm.querySelector('input[type="email"]').value;
            if (/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(e_mail_address)) {
                ajax = '?document_id=' + document_id + '&e_mail_address=' + e_mail_address;
                ajaxGet('ajax_download_e_mail.php' + ajax, responseDownloadDoc);
            
            } else {
                message = 'Adresse e-mail invalide.';
            }

        });
    }
/*== Script de soumission du formulaire de téléchargement END********/

/*== Script d'envoi du mail de contact POST BEGIN'********/
function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
function responseContact(response)
{
    console.log('Après : ' + response + ' -  typeof : ' + typeof response + ' - substr : ' + response.substr(0, 2));
    if (response == 'ok')
        {
            document.getElementById('contact-form').parentElement.removeChild(document.getElementById('contact-form'));
            document.getElementById('contact-merci').classList.remove('invisible');
        }
    else
        {
            document.getElementById('contact-merci').innerHTML = '<p>L\'envoi du formulaire a échoué.</p>';
            document.getElementById('contact-merci').classList.remove('invisible');
            
        }
}

if (document.querySelector('#contact-form FORM'))
    {
        const formElement = document.querySelector('#contact-form FORM');
        formElement.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(formElement);
            
            
            console.log(formData);
            ajaxPost('ajax_mail_contact.php', formData, responseContact);
        });
    }
/*== Script d'envoi du mail de contact POST END'********/



