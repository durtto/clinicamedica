main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();	
}

function Principal(){

	
	/////FORMATA O VALOR EM MOEDA//////
	Number.prototype.formatMoney = function(c, d, t){
    var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
    + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
	//_________________________________________________//

		
	$("pagar-button").style.display = "none";
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
										
					if($("saldo").value > 0)
					{
						$("submit-button").style.display = "none";
						$("pagar-button").style.display = "";
					}else{
						$("submit-button").style.display = "";
						$("pagar-button").style.display = "none";
					}
					
            } else {
                alert('There was a problem with the request.');
            }
        }
    }	
	
	
	var inputs = document.getElementsByTagName("input");
	var guia, agencia;
	var cont = 0;
	for(var i = 0; i < inputs.length; i++){		
		if(inputs[i].getAttribute("type") == "radio" && inputs[i].getAttribute("name") == "guiaouagencia")
		{					
			if(inputs[i].value == "1")	
			
				guia = inputs[i];
			else if(inputs[i].value == "2")
				agencia = inputs[i];				
		}
	}
	
	var dom = new DOM();
	var condicaoAtual;
	var condicoes = document.getElementsByName("guiaouagencia");
	for(i=0; i<condicoes.length; i++)
	{
		if(condicoes[i].checked)
		{
			condicaoAtual = condicoes[i].value;
		}
	}

	if(condicaoAtual == "1")
	{
		$("guia-field").style.display = "";		
		$("agencia-field").style.display = "none";
		
	}else if(condicaoAtual == "n")
	{		
		$("guia-field").style.display = "none";		
		$("agencia-field").style.display = "";
	}
	
	guia.onclick = function()
	{		
		$("submit-button").style.display = "";
		$("pagar-button").style.display = "none";
		if(this.checked){			
			$("guia-field").style.display = "";	
			$("agencia-field").style.display = "none";
			$("agencia").value = "";
			condicaoAtual = 1;
		}
	}
	
	agencia.onclick = function()
	{			
		$("submit-button").style.display = "";
		$("pagar-button").style.display = "none";
		if(this.checked)
		{			
			$("agencia-field").style.display = "";
			$("guia-field").style.display = "none";	
			$("guia").value = "";
			condicaoAtual = 2;
		}
	}
	
	function pagarComissao()
	{		
		$("submit-button").onclick = function()
		{			
			var campo;
			if(condicaoAtual == "1")
			{
				campo = document.getElementById("guia");
			}else{				
				campo = document.getElementById("agencia");
			}
			if(campo.value == "null" || campo.value == "undefined" || campo.value == "")
			{
				alert("Informe o código do "+campo.name+"!");
				document.getElementById(campo.id).focus();
				return false;
				
			}else{			
				preLoadImg = new Image();
				preLoadImg.src = "../_images/estrutura/loader.gif";
				$("valores").innerHTML = "<table width='120px'><br><font size=1>Aguarde, consultando...</font><br><img src='../_images/estrutura/loader.gif'></table>";
				makeRequest('ajax/valores-comissao.php?'+campo.name+"="+campo.value, 1);
				return false;
			}			
		}
	}
	new pagarComissao();
	
	function confirmarPgto()	
	{			
		$("pagar-button").onclick = function()
		{
			if($("saldo") == null)
			{ 
				return false;
			}else{
				
				if($("valorpago").value == "")
				{ 
					alert("Informe o valor que deseja efetuar o pagamento!");
					$("valorpago").focus();
					return false;
				}else{
					if(!confirm("Confirmar o pagamento das comissões na data informada?"))
					{
						return false;
					}
				}
			}
		}
		
	}
	new confirmarPgto();
	
		
	
}// JavaScript Document