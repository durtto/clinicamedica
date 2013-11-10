main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){
	
	var http_request = false;	
	function makeRequest(url, cod){
		
	    http_request = false;
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');
                // See note below about this line
            }
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
       if(cod == 1)
	   {
		   http_request.onreadystatechange = alertContents;
	   }else if(cod == 2)
	   {
		   http_request.onreadystatechange = teste;
	   }
        http_request.open('GET', url, true);
        http_request.send(null);

    }

    function alertContents() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) { 			
					var fSet = document.createElement("fieldset");	
					fSet.setAttribute("id", "cepajax");
					fSet.innerHTML = http_request.responseText;							
					var cid = $('cepajax');
						
					
					$("cid-estado").appendChild(fSet);					
            } else {
                alert('There was a problem with the request.');
            }
        }
    }	

	
	///MESMA FUNÇÃO QUE A DE CIMA, MAS USADA NA EDIÇÃO, QUANDO O CEP JÁ VEM CARREGADO NO CAMPO///
	var value = $("cep").value;

	if(value.length == 8){
		/*preLoadImg = new Image();
		preLoadImg.src = "/decorcasa/_images/estrutura/loader.gif";
		$("cid-estado").innerHTML = "<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='/decorcasa/_images/estrutura/loader.gif'></center></table>";*/
		//busco os dados...
		makeRequest('../../componentes/cep-impressao.php?cep='+value, 1);
	}
	
	
}