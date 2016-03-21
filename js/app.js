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

//Gestion de module
    $('#checkModuleAll').toggle(function(){
        this.checked = true;
        $('.checkboxModule:checkbox').attr('checked','checked');
    },function(){
        this.checked = false;
        $('.checkboxModule:checkbox').removeAttr('checked');
    })
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
    //Fonction pour rechercher les fiches d'absences
    $('#changeModulesFiches').change(function() {
        var idModuleFic = $('#changeModulesFiches').val();
        $.get( "actions/viewfiches.php", { idModuleFic: idModuleFic })
            .done(function( data ) {
                var results = jQuery.parseJSON(data);
                $('#listFiches').empty();
                $(results).each(function(key, value) {
                    $('#listFiches').append(
                        "<tr>"+
                            "<td class='centeredTd checkbox'><a class='btn btn-blue' href='showfiche?id="+value.idabsences+"'><i class=\"fa fa-pencil\"></i></a></td>"+
                            "<td>"+value.dateabsences+"</td>"+
                            "<td>"+value.dureeabsences+" heure(s)</td>"+
                        "</tr>"
                    );
                })
            });
        return false;
    })
    //Affichage des option caché pour la forma et le dpt
    $('#changeModulesAbsence').change(function() {
        var idModuleAbs = $('#changeModulesAbsence').val();
        $.get( "actions/viewfiches.php", { idModuleAbs: idModuleAbs })
            .done(function( data ) {
                var results = jQuery.parseJSON(data);
                $('#hiddenFormDept').fadeIn();
                $('#changeGroupeAbs').prop('disabled', false);
                $(results).each(function(key, value) {
                    $('#departement').html('<option value="'+value.iddepartements+'">'+value.nomdepartements+'</option>');
                    $('#formation').html('<option value="'+value.idformations+'">'+value.nomformations+'</option>');
                });
            });
        return false;
    });

    //Changement d'excuse pour un etudiant selectionné ABSENT
    $('.changeExcuse').change(function() {
        var idEtudiant_excuse = $(this).attr('id');
        var idAbsence = $('#idAbsence').val();
        var valExcuse = $(this).val();
        $.get( "actions/viewfiches.php", { idEtudiant_excuse:idEtudiant_excuse, idAbsence:idAbsence, valExcuse:valExcuse })
            .done(function( data ) {
                console.log(data);
                return false;
            });
    });

    //Ajout du trombi apres choix du groupe
    $('#changeGroupeAbs').change(function() {
        var idGroupes = $('#changeGroupeAbs').val();
        var idFormations = $('#departement').val();
        var idDepartements = $('#formation').val();
        $('#departementId').attr('value', idFormations);
        $('#formationId').attr('value', idDepartements);
        $.get( "actions/viewfiches.php", { idGroupes: idGroupes, idDepartements: idDepartements, idFormations: idFormations })
            .done(function( data ) {
                var results = jQuery.parseJSON(data);
                $('#trombi').empty();
                var nbrEtu = 0;
                $(results).each(function(key, value) {
                    nbrEtu++;
                    $('#trombi').append(
                        '<div class="trombi-block text-center">'+
                            '<input type="checkbox" name="idEtuAbs[]" id="Etu'+value.idetudiants+'" value="'+value.idetudiants+'" />'+
                            '<label for="Etu'+value.idetudiants+'">'+
                                '<img src="etc/trombi/'+value.photourletudiants+'">'+
                            '</label>'+
                            '<div class="infoEtu" style="margin-bottom: 10px;">'+
                                '<strong>'+value.prenometudiants+'</strong><br>'+
                                '<small>'+value.nometudiants+'</small>'+
                            '</div>'+
                        '</div>'
                    );
                });
                $('#trombi').prepend('<h3>Nombre d\'etudiants : '+ nbrEtu + '</h3>');
                $('#hiddenSignature').fadeIn();
            });
        return false;
    })
});