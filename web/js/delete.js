



var supCollection = document.querySelectorAll('[data-boutonSupprimer]');

        for (var i = 0; i < supCollection.length; i++) {
            supCollection[i].addEventListener("click", function (e) {
                e.preventDefault();
        var td_id = this.parentElement.parentElement.firstElementChild.innerHTML;
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
            xhttp.open('GET', Routing.generate('delete_dossier',{id: td_id},true));
            xhttp.send();
        }
    })
}


