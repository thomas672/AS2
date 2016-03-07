$(function() {
    $('#nom').change(function(){
        $.ajax({
            url: "actions/ajoutermodules?code="+$('#code').val()+"&nom="+$('#nom').val()+"&dpt="+$('#dpt').val()+"&ue="+$('#ue').val(),
            cache:false,
            success:function(html){
                $("#loader").fadeIn(120);
                $("#accueil").append(html);
                $("#loader").fadeOut(120);
            },
            error:function(XMLHttpRequest,textStatus, errorThrown){
                alert('Erreur lors du chargement, verifier votre connexion internet !');
                navigator.app.exitApp();
            }
        })
    })

});