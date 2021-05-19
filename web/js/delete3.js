var supCollection = document.querySelectorAll('[data-boutonSupprimer4]');


for (var i = 0; i < supCollection.length; i++) {
    supCollection[i].addEventListener("click", function (e) {
        e.preventDefault();
        var id = document.getElementById('piece');
        var idP = id.value;
        var r = confirm('Voulez vous vraiment supprimer le dossier ?');
        if (r === true) {

            var objetASupprimer = this.parentElement.parentElement;

            var xhttp = new XMLHttpRequest();
            //gestion de la réponse
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    objetASupprimer.parentElement.removeChild(objetASupprimer);
                    location.reload();
                }
            };
            xhttp.open('GET', Routing.generate('delete_PieceJointe',{id: idP},true));
            xhttp.send();
        }
    })
}


