
var btn = document.getElementById('btn');
var idDossier= document.getElementById('idDossier');
idDossier = idDossier.innerText.split("°")[1];


    btn.addEventListener("click", function (e) {

        e.preventDefault();

        printPage(Routing.generate('imprimer',{id:idDossier},true));


    });


    function closePrint () {
        document.body.removeChild(this.__container__);
    }
    function setPrint () {
        this.contentWindow.__container__ = this;
        this.contentWindow.onbeforeunload = closePrint;
        this.contentWindow.onafterprint = closePrint;
        this.contentWindow.focus(); // Required for IE
        this.contentWindow.print();
    }

    function printPage (sURL) {
        var oHiddFrame = document.createElement("iframe");
        oHiddFrame.onload = setPrint;
        oHiddFrame.style.visibility = "hidden";
        oHiddFrame.style.position = "fixed";
        oHiddFrame.style.right = "0";
        oHiddFrame.style.bottom = "0";
        oHiddFrame.src = sURL;
        document.body.appendChild(oHiddFrame);
    }




