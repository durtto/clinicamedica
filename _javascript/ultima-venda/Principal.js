main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();	
}

function Principal(){

	
	var atracaoAtual = "null";
	var atracoesExcluidas = Array();
	var selectAtual = "null";
	var totalatracoes = 0;
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
				alert("Reimpressão realizada com sucesso!");			
						
            } else {
                alert('There was a problem with the request.');
            }
        }
    }	
	$("reimprimir").onclick = function()
	{
		var inputs = document.getElementsByName("ingresso[]");
		var ingressos = new Array();
		for(var i = 0; i < inputs.length; i++)
		{
			if(inputs[i].checked)
			{
				ingressos[i] = inputs[i].value;			
			}
		}	
		var justificativa;
		var venda = document.getElementById("venda");
		if(ingressos.length == 0){
			alert("Você deverá selecionar ao menos um ingresso para reimprimir!");			
			return false;
		}else{
			justificativa = prompt("Informe a justificativa:", "");		
			if(justificativa)
			{
				makeRequest('imprime-ultimavenda.php?ingressos='+ingressos+"&venda="+venda.value+"&justificativa="+justificativa);
			}
		}
	}	
	
}// JavaScript Document