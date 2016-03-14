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
                                "<td class='centeredTd'><a href='modifieretudiant?id="+value.idetudiants+"' class='btn btn-blue'><i class=\"fa fa-pencil\"></i></a> <a href='modifieretudiant?idDELETE="+value.idetudiants+"' class='btn btn-red'><i class=\"fa fa-trash-o\"></i></a></td>"+
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
    $('#addGroupe').click(function() {
        var dossier = $('#numDossier').val();
        var idformation = $('#idForma').val();
        var iddepartement = $('#idDept').val();
        var idgroupe = $('#groupe').val();
        $.get( "actions/addGroupeEtu.php", { dossier: dossier, iddepartement: iddepartement, idformation: idformation, idgroupe: idgroupe, add: 1})
            .done(function( data ) {
                var results = jQuery.parseJSON(data);
                $('#groupeEtu').empty();
                $(results).each(function(key, value) {
                    $('#groupeEtu').append(
                        "<tr>"+
                            "<td><button class='btn btn-red DellGroupeEtu' id='"+value.idgroupes+"'><i class='fa fa-trash'></i></button></td>"+
                            "<td>"+value.idgroupes+"</td>"+
                            "<td>"+value.nomgroupes+"</td>"+
                        "</tr>"
                    );
                })
            });
        return false;
    })
//on supprimer un groupe si besoin
    $('#groupeEtu').on('click', '.DellGroupeEtu', function(e){
        var dossier = $('#numDossier').val();
        var idformation = $('#idForma').val();
        var iddepartement = $('#idDept').val();
        var idgroupe = $(this).attr('id');
        $.get( "actions/addGroupeEtu.php", { dossier: dossier, iddepartement: iddepartement, idformation: idformation, idgroupe: idgroupe, dell: 1})
            .done(function( data ) {
                var results = jQuery.parseJSON(data);
                $('#groupeEtu').empty();
                $(results).each(function(key, value) {
                    $('#groupeEtu').append(
                        "<tr>"+
                        "<td class='checkbox'><button class='btn btn-red DellGroupeEtu' id='"+value.idgroupes+"'><i class='fa fa-trash'></i></button></td>"+
                        "<td class='checkbox'>"+value.idgroupes+"</td>"+
                        "<td>"+value.nomgroupes+"</td>"+
                        "</tr>"
                    );
                })
            });
        return false;
    });
});