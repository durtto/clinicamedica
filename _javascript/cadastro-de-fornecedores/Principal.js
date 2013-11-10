main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){
	//new CombosEnderecoDinamico("endPadraoCep", "paiPadraoPais", "estPadraoEstado", "estPadraoNome", "cidPadraoCidade");
	//new CombosEnderecoDinamico("endCobrancaCep", "paiCobrancaPais", "estCobrancaEstado", "estCobrancaNome", "cidCobrancaCidade");
	
	//--
	
	//escondo os campos variáveis... exibo somente o que interessa
	$("campos-fisica").style.display = "none";
	$("campos-juridica").style.display = "none";
	
	//--
	
	var inputs = $("form-fornecedores").getElementsByTagName("input");
	var tipoDeCliente = Array();
	var fisicaRadio, juridicaRadio;
	var cont = 0;
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].getAttribute("type") == "radio" && inputs[i].getAttribute("name") == "tipoDeFornecedor"){
			tipoDeCliente[cont++] = inputs[i];
			
			if(inputs[i].value == "fisica")
				fisicaRadio = inputs[i];
			else if(inputs[i].value == "juridica")
				juridicaRadio = inputs[i];
		}
	}
	/*
	alert(inputs[i].value);
	
	tipoDeCliente = tipoDeCliente[0];
	var esconderTipo = "campos-" + tipoDeCliente.value;
	*/
	var tipoDePessoaAtual = document.getElementsByName("tipoDeFornecedor")[0].checked ? "fisica" : "juridica";
	var esconderTipo = "campos-" + tipoDePessoaAtual;
	$(esconderTipo).style.display = "";
	
	var dom = new DOM();
	
	if(tipoDePessoaAtual == "fisica"){
		dom.removeClass($("pesNomeFantasia"), "onsubmit:notnull");
		dom.removeClass($("pesjRazaosocial"), "onsubmit:notnull");
		dom.removeClass($("pesjNomepessoacontato"), "onsubmit:notnull");
		dom.removeClass($("pesjCnpj"), "onsubmit:notnull");
		dom.removeClass($("pesjInscricaoestadual"), "onsubmit:notnull");
	}
	else{
		dom.removeClass($("pesNome"), "onsubmit:notnull");
		dom.removeClass($("pesfCpf"), "onsubmit:notnull");
		dom.removeClass($("pesfRg"), "onsubmit:notnull");
	}
	
	//--
	
	fisicaRadio.onclick = function(){
		if(this.checked){
			$("campos-fisica").style.display = "";
			$("campos-juridica").style.display = "none";
			
			//removo as classes
			dom.removeClass($("pesNomeFantasia"), "onsubmit:notnull");
			dom.removeClass($("pesjRazaosocial"), "onsubmit:notnull");
			dom.removeClass($("pesjNomepessoacontato"), "onsubmit:notnull");
			dom.removeClass($("pesjCnpj"), "onsubmit:notnull");
			dom.removeClass($("pesjInscricaoestadual"), "onsubmit:notnull");
			
			//adiciono as classes
			dom.addClass($("pesNome"), "onsubmit:notnull");
//			dom.addClass($("pesfCpf"), "onsubmit:notnull");
//			dom.addClass($("pesfRg"), "onsubmit:notnull");
		}
	}
	
	juridicaRadio.onclick = function(){
		if(this.checked){
			$("campos-fisica").style.display = "none";
			$("campos-juridica").style.display = "";
			
			//removo as classes
			dom.removeClass($("pesNome"), "onsubmit:notnull");
			dom.removeClass($("pesfCpf"), "onsubmit:notnull");
			dom.removeClass($("pesfRg"), "onsubmit:notnull");
			
			//adiciono as classes
			dom.addClass($("pesNomeFantasia"), "onsubmit:notnull");
//			dom.addClass($("pesjRazaosocial"), "onsubmit:notnull");
//			dom.addClass($("pesjNomepessoacontato"), "onsubmit:notnull");
//			dom.addClass($("pesjCnpj"), "onsubmit:notnull");
//			dom.addClass($("pesjInscricaoestadual"), "onsubmit:notnull");
		}
	}
	
	
	//----------------------------------------------------------
/*	
	$("enderecoPadraoAba").className += " selecionada"; 
	$("enderecoCobranca").style.display = "none";

	
	
	$("enderecoPadraoAba").onclick = function(){
		$("enderecoPadrao").style.display = "";
		$("enderecoCobranca").style.display = "none";
		$("enderecoCobrancaAba").className = $("enderecoCobrancaAba").className.substring(0, $("enderecoCobrancaAba").className.length - " selecionada".length);
		this.className += " selecionada";
	}
	
	
	$("enderecoCobrancaAba").onclick = function(){
		$("enderecoPadrao").style.display = "none";
		$("enderecoCobranca").style.display = "";
		$("enderecoPadraoAba").className = $("enderecoPadraoAba").className.substring(0, $("enderecoPadraoAba").className.length - " selecionada".length);
		this.className += " selecionada";
	}*/
	
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
					if(cid != null)
					{     					
						cid.parentNode.removeChild(cid);					
					}		
					$("cid-estado").innerHTML = "";
					$("cid-estado").appendChild(fSet);					
            } else {
                alert('There was a problem with the request.');
            }
        }
    }	
	$("cep").onkeyup = function() {		
		var value = this.value;
		if(value.length == 8){			
			$("cep").blur();
			preLoadImg = new Image();
			preLoadImg.src = "./../_images/estrutura/loader.gif";
			$("cid-estado").innerHTML = "<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='/decorcasa/_images/estrutura/loader.gif'></center></table>";
			//busco os dados...
			makeRequest('./../componentes/cep.php?cep='+value, 1);
		}		
	}
	
	///MESMA FUNÇÃO QUE A DE CIMA, MAS USADA NA EDIÇÃO, QUANDO O CEP JÁ VEM CARREGADO NO CAMPO///
	var value = $("cep").value;
	
	if(value.length == 8){
		preLoadImg = new Image();
		preLoadImg.src = "./../_images/estrutura/loader.gif";
		$("cid-estado").innerHTML = "<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='/decorcasa/_images/estrutura/loader.gif'></center></table>";
		//busco os dados...
		makeRequest('./../componentes/cep.php?cep='+value, 1);
	}
	
	
}