main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();	
}

function Principal(){

	Calendar.setup({
		inputField     :    "data",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "lancador"     // o id do botão que lançará o calendário
	});
	/////FORMATA O VALOR EM MOEDA//////
	Number.prototype.formatMoney = function(c, d, t){
    var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
    + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
	//_________________________________________________//

		
	$("fechar-button").style.display = "none";
	$("print-button").style.display = "none";
	
	var atracaoAtual = "null";
	var atracoesExcluidas = Array();
	var selectAtual = "null";
	var totalatracoes = 0;
	var http_request = false;	
	function makeRequest(url, cod)
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
		if(cod == 1)
		{
        	http_request.onreadystatechange = alertContents;
		}else{
			http_request.onreadystatechange = alertPrint;
		}
        http_request.open('GET', url, true);
        http_request.send(null);
    } 
	
	function alertContents() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) { 			
					var fSet = document.createElement("fieldset");	
					fSet.setAttribute("id", "org_grid");
					fSet.innerHTML = http_request.responseText;							
					var cid = $('org_grid');
					if(cid != null)
					{     					
						cid.parentNode.removeChild(cid);					
					}		
					$("valores").innerHTML = "";
					$("valores").appendChild(fSet);		
					
					if($("totalliquido").value > 0)
					{
						$("submit-button").style.display = "none";
						$("print-button").style.display = "";
						$("fechar-button").style.display = "";
					}else{
						$("submit-button").style.display = "";
						$("fechar-button").style.display = "none";
						$("print-button").style.display = "none";
					}					
            } else {
                alert('There was a problem with the request.');
            }
        }
    }	
	function alertPrint() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
				  alert("Impressão realizada com sucesso!");
			} else {        
				alert('There was a problem with the request.');
            }
        }
    }	
	function valoresCaixa()
	{
		
		$("submit-button").onclick = function()
		{			
			
			var usuario = document.getElementById("usuario");
			
			usuario = usuario.options[usuario.selectedIndex];
			
			var data = document.getElementById("data");
			
			if(usuario.value == "null")
			{
				alert("Selecione um usuário!");
				document.getElementById("usuario").focus();
				return false;
				
			}else{			
				preLoadImg = new Image();
				preLoadImg.src = "../_images/estrutura/loader.gif";
				$("valores").innerHTML = "<table width='120px'><br><font size=1>Aguarde, consultando...</font><br><img src='../_images/estrutura/loader.gif'></table>";
				makeRequest('ajax/valores-caixa.php?usuario='+usuario.value+'&data='+data.value, 1);
				return false;
			}			
		}
	}
	new valoresCaixa();
	
	function fecharCaixa()
	{
		
			$("fechar-button").onclick = function()
			{
				if(!confirm("Confirmar o fechamento do caixa na data informada?"))
				{
					return false;
				}
			}
		
	}
	new fecharCaixa();
	function imprimir()
	{
		$("print-button").onclick = function()
		{
			var usuario = document.getElementById("usuario");
			
			usuario = usuario.options[usuario.selectedIndex];
			
			var data = document.getElementById("data");
			
			if(usuario.value == "null")
			{
				alert("Selecione um usuário!");
				document.getElementById("usuario").focus();
				return false;				
			}else{			
				makeRequest('imprime-fechamento.php?usuario='+usuario.value+'&data='+data.value, 2);
				return false;
			}
		}
	}
	new imprimir();
	$("data").onchange = function()
	{
		$("submit-button").style.display = "";
		$("fechar-button").style.display = "none";
		$("print-button").style.display = "none";
	}
	
	$("usuario").onchange = function()
	{
		$("submit-button").style.display = "";
		$("fechar-button").style.display = "none";
		$("print-button").style.display = "none";
	}
		
}// JavaScript Document