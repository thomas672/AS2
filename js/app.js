$(function() {
//Fonction qui permet de rechercher automatiquement un etudiants
    $(".autocompletEtu").keyup(function() {
        var MIN_LENGTH = 3;
        var dossier = $("#dossier").val();
        var nom = $("#nom").val();
        var prenom = $("#prenom").val();
        if (dossier.length >= MIN_LENGTH || nom.length >= MIN_LENGTH || prenom.length >= MIN_LENGTH) {
            $.get( "actions/searchEtudiant.php", { dossier: dossier, prenom: prenom, nom: nom } )
                .done(function( data ) {
                    var results = jQuery.parseJSON(data);
                    $('#listEtu').empty();
                    $(results).each(function(key, value) {
                        console.log(value);
                        $('#listEtu').append(
                            "<tr>"+
                                "<td>S | M</td>"+
                                "<td class='centeredTd'>"+value.idetudiants+"</td>"+
                                "<td>"+value.nometudiants+"</td>"+
                                "<td>"+value.prenometudiants+"</td>"+
                                "<td class='centeredTd'><img width='40' src='etc/trombi/"+value.photourletudiants+"'></td>"+
                            "</tr>"
                        );
                    })
                });
        }
    });

//Fonction pour ajouter un groupe à un etudiant
    //verification qu'un numero de dossier soit attribué
    $('#numDossier').keyup(function() {
        var MIN_LENGTH = 4;
        var dossier = $('#numDossier').val();
        if (dossier.length >= MIN_LENGTH){
            $.get( "actions/searchEtudiant.php", { dossier: dossier, prenom: prenom, nom: nom } )
                .done(function( data ) {
                    var results = jQuery.parseJSON(data);
                    $('#listEtu').empty();
                    $(results).each(function(key, value) {
                        console.log(value);
                        $('#listEtu').append(
                            "<tr>"+
                            "<td>S | M</td>"+
                            "<td class='centeredTd'>"+value.idetudiants+"</td>"+
                            "<td>"+value.nometudiants+"</td>"+
                            "<td>"+value.prenometudiants+"</td>"+
                            "<td class='centeredTd'><img width='40' src='etc/trombi/"+value.photourletudiants+"'></td>"+
                            "</tr>"
                        );
                    })
                });
            }
        }
    })
});