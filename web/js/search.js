var search_bar = document.getElementById('search');

search_bar.addEventListener('keyup', function (event) {
    if (event.keyCode === 13) {
        search();
    }
});

function search() {


    var value = search_bar.value;

    if (value === null || value === "") {

        location.reload();

    }
    // console.info(value);
    var v = value.split(' ');
    var date = value.split('-');


    if (!(value.indexOf() === -1)) {

        v.replace("-", "_")
    }
    // console.info(v);
    var xhr = new XMLHttpRequest();

    if (!(date[2] == null)){

        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var tab_principale = document.getElementById('tab_list');
                console.info(document.getElementById('tab_list'));
                tab_principale.innerHTML = this.responseText;


                var supCollection = document.querySelectorAll('[data-boutonImprimer]');

                for (var i = 0; i < supCollection.length; i++) {
                    supCollection[i].addEventListener("click", function (e) {
                        e.preventDefault();
                        var td_id = this.parentElement.parentElement.firstElementChild.innerHTML;
                        printPage(Routing.generate('imprimer',{id:td_id},true));


                        printPage(Routing.generate('imprimerAll',{},true));

                    });


                }}
        };
        xhr.open('GET', Routing.generate('searchDate',{annee:date[0] ,mois:date[1],jour:date[2]},true) );
        xhr.send();



    }


    else{
    if (!(v[1] == null)) {
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var tab_principale = document.getElementById('tab_list');
                tab_principale.innerHTML = this.responseText;


                var supCollection = document.querySelectorAll('[data-boutonImprimer]');

                for (var i = 0; i < supCollection.length; i++) {
                    supCollection[i].addEventListener("click", function (e) {
                        e.preventDefault();
                        var td_id = this.parentElement.parentElement.firstElementChild.innerHTML;
                        printPage(Routing.generate('imprimer',{id:td_id},true));


                        printPage(Routing.generate('imprimerAll',{},true));

                    });


            }}
        };
        xhr.open('GET', Routing.generate('search',{v0:v[0] ,v1:v[1]},true) );
        xhr.send();
    }
    else {
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var tab_principale = document.getElementById('tab_list');
                tab_principale.innerHTML = this.responseText;


                var supCollection = document.querySelectorAll('[data-boutonImprimer]');

                for (var i = 0; i < supCollection.length; i++) {
                    supCollection[i].addEventListener("click", function (e) {
                        e.preventDefault();
                        var td_id = this.parentElement.parentElement.firstElementChild.innerHTML;
                        printPage(Routing.generate('imprimer',{id:td_id},true));


                        printPage(Routing.generate('imprimerAll',{},true));

                    });

                }
            }
        };
        xhr.open('GET', Routing.generate('searchNom',{v0:v[0]},true));
        xhr.send();
    }}
}


function closePrint() {
    document.body.removeChild(this.__container__);
}

function setPrint() {
    this.contentWindow.__container__ = this;
    this.contentWindow.onbeforeunload = closePrint;
    this.contentWindow.onafterprint = closePrint;
    this.contentWindow.focus(); // Required for IE
    this.contentWindow.print();
}

function printPage(sURL) {
    var oHiddFrame = document.createElement("iframe");
    oHiddFrame.onload = setPrint;
    oHiddFrame.style.visibility = "hidden";
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.src = sURL;
    document.body.appendChild(oHiddFrame);
}




