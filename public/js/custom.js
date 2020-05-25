// JavaScript Document

function redimensionner(selecteur){
    var hauteur=0;
    $(selecteur).each(function(){
        if($(this).height()>hauteur) hauteur = $(this).height();
    });
    
    $(selecteur).each(function(){ $(this).height(hauteur); });
}

function unUn()
{

    if (($(".navbar-toggle").css ("display") == "none")) { // Pour les devices autre que smartphone
        var colsm3width = $(".main").width()/4;
        var colsm6width = $(".main").width()/2;
        $(".col-sm-3").css ({"max-width" : colsm3width});
        $(".col-sm-6").css ({"max-width" : colsm6width});
        $(".deux-un-sm").height($(".deux-un-sm").width()/2);    
        $(".un-un-sm").height($(".un-un-sm").width());
        $(".trois-un-sm").height($(".trois-un-sm").width()/3);
        $(".quatre-un-sm").height($(".quatre-un-sm").width()/4);
    }
    else{
        $(".deux-un-xs").height($(".deux-un-xs").width()/2);    
        $(".un-un-xs").height($(".un-un-xs").width());
        $(".trois-un-xs").height($(".trois-un-xs").width()/3);
        $(".quatre-un-xs").height($(".quatre-un-xs").width()/4);


    }
    $(".deux-un").height($(".deux-un").width()/2);    
    $(".un-un").height($(".un-un").width());
    $(".trois-un").height($(".trois-un").width()/3);
    $(".quatre-un").height($(".quatre-un").width()/4);
    $(".demi-hauteur").height($(".demi-hauteur").parent().height()/2);
}

$(document).ready(function(){
    unUn();
});

window.onorientationchange = function (){
        unUn();
};
window.addEventListener('resize', function(event){
        unUn();
});

   // Hauteur video
    function videoHeight(){
                $("IFRAME.video").height($("IFRAME.video").width()/300*169);
        }
        
        $(document).ready(function(){
                videoHeight();
        });
        
        window.onorientationchange = function (){
                videoHeight();
        }
        window.onresize = function (){
                videoHeight();
        }
        
        
//chargement du formulaire de recherche dans cercle
$(document).ready(function(){
        $("#recherche").load("cercle-recherche.php");
});


$('SELECT.filtres').change(function(e) {
    var activite = $('#sel-activite').val();
    var implantation = $('#sel-implantation').val();
    var secteur = $('#sel-secteur').val();
    var service = $('#sel-service').val();
    var infos = '';
    if (activite != '') {
        infos += '.activite-'+activite;
    }
    if (implantation != '') {
        infos += '.implantation-'+implantation;
    }
    if (secteur != '') {
        infos += '.secteur-'+secteur;
    }
    if (service != '') {
        infos += '.service-'+service;
    }
    $('TR.ligne-presta').hide (400);
    if (infos != '') {
        $(infos).show(400);
        $("#btrecherche").show(400);
    }
    else {
        $('TR.ligne-presta').show (400);
        $("#btrecherche").hide(400);
    }
});
$("#btrecherche").bind("click", function(event) {
    $('SELECT.filtres').val('');
    $('TR.ligne-presta').show (400);
    $("#btrecherche").hide(400);
});
$(document).ready(function(){
    $('SELECT.filtres').val('');
    $("#btrecherche").hide(400);
});
