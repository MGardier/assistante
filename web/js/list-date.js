var anneeMiseEnService = new Date();
var idDossier= document.getElementById('idDossier');
idDossier = idDossier.innerText.split("°")[1];
console.info(idDossier);
var notes = document.getElementById('notes');
anneeMiseEnService.setFullYear(2017);
anneeMiseEnService = anneeMiseEnService.getFullYear();
var now = new Date();
var annee = now.getFullYear();
var selectListDate = document.getElementById('select-list-date');
for(; anneeMiseEnService<annee+1;  anneeMiseEnService++){
    var option = document.createElement("option");

    option.text = anneeMiseEnService.toString();
    selectListDate.add(option);
}
selectListDate.addEventListener('change', function (e) {
    var idDossier= document.getElementById('idDossier');
    idDossier = idDossier.innerText.split("°")[1];
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
           notes.innerHTML= this.responseText;


            var supCollection = document.querySelectorAll('[data-boutonSupprimer5]');
            var id = document.getElementById('NOTE');

            for (var i = 0; i < supCollection.length; i++) {
                supCollection[i].addEventListener("click", function (e) {
                    e.preventDefault();
                    var idNote = id.value;
                    var r = confirm('Voulez vous vraiment supprimer le dossier ?');
                    if (r === true) {

                        var objetASupprimer = this.parentElement.parentElement;

                        var xhttp = new XMLHttpRequest();
                        //gestion de la réponse
                        xhttp.onreadystatechange = function () {
                            if (this.readyState === 4 && this.status === 200) {
                                objetASupprimer.parentElement.removeChild(objetASupprimer);

                            }
                        };
                        xhttp.open('GET', Routing.generate('delete_note',{id: idNote},true));
                        xhttp.send();

                    }
                })
            }
        }
    };

    var choice = selectListDate.selectedIndex;
    var v = selectListDate.options[choice].value;

    console.info(idDossier);
    xhr.open('GET',Routing.generate('list_notes_ajax',{id: idDossier, date: v},true));
    xhr.send();
});


