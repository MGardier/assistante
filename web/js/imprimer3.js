
var btn = document.getElementById('btn2');
var idDossier= document.getElementById('idDossier');
idDossier = idDossier.innerText.split("°")[1];


var selectListDate = document.getElementById('select-list-date');


btn.addEventListener("click", function (e) {

    var choice = selectListDate.selectedIndex;
    var v = selectListDate.options[choice].value;
    console.info(v);
    e.preventDefault();

    printPage(Routing.generate('imprimerNotes',{id: idDossier, date: v},true));


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




