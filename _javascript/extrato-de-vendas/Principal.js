main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();	
}

function Principal()
{
	
	Calendar.setup({
		inputField     :    "inicio",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "lancador"     // o id do botão que lançará o calendário
	}); 
	
	Calendar.setup({
		inputField     :    "fim",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "launcher"     // o id do botão que lançará o calendário
	});
	
	var inputs = document.getElementsByTagName("input");	
	
	var http_request = false;	
	function makeRequest(url)
	{
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
		
        http_request.onreadystatechange = alertContents;		
        http_request.open('GET', url, true);
        http_request.send(null);
    }
	function alertContents() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
				alert("Impressão enviada!");
			} else {
			alert('There was a problem with the request.');
            }
        }
    }	
	function enviaImpressao()
	{		
		for(var i = 0; i < inputs.length; i++)
		{	
			if(inputs[i].id == "imprimir-extrato"){				
				inputs[i].onclick = function()
				{				
					var classes = this.className.split(" ");
					for(var j = 0; j < classes.length; j++){
						if(classes[j].substring(0, "action:".length) == "action:")
						{										
							makeRequest(classes[j].substring("action:".length));
							
						}
					}				
				}
			}
		}		
	}
	new enviaImpressao();	
	
}