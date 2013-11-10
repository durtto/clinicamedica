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
	
	var inputs = $("form-parceiros").getElementsByTagName("input");
	var tipoDeCliente = Array();
	var fisicaRadio, juridicaRadio;
	var cont = 0;
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].getAttribute("type") == "radio" && inputs[i].getAttribute("name") == "tipoDeParceiro"){
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
	var tipoDePessoaAtual = document.getElementsByName("tipoDeParceiro")[0].checked ? "fisica" : "juridica";
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
	var usuarioAtual = "null";
	var usuariosExcluidas = Array();
	var selectAtual = "null";
	
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
	   }else if(cod==2)
	   {
		   http_request.onreadystatechange = addUsuario;
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
	
	function addUsuario() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {				
				var xmldoc = http_request.responseXML;
				var cod = xmldoc.getElementsByTagName('cod').item(0);
				var nome = xmldoc.getElementsByTagName('nome').item(0);
				var login = xmldoc.getElementsByTagName('login').item(0);
				var setor = xmldoc.getElementsByTagName('setor').item(0);
				
				table1 = document.getElementById("tabela");
				var linha = table1.insertRow(1);
				//Inserção de Celulas
				var coluna1 = linha.insertCell(-1);
				//Definindo o estilo para a célula
				coluna1.className = "par";
				//Definindo o conteúdo para a célula
				coluna1.innerHTML = "<input name='usuario[]' value='"+cod.firstChild.data+"' class='checkbox to_check_checkAll' type='checkbox'><input name='usuario_[]' value='"+cod.firstChild.data+"' type='hidden'>";	
				
				coluna1 = linha.insertCell(-1);
				coluna1.className = "col-1";
				coluna1.innerHTML = nome.firstChild.data;
				
				coluna1 = linha.insertCell(-1);
				coluna1.className = "col-2";
				coluna1.innerHTML = login.firstChild.data;
				
				coluna1 = linha.insertCell(-1);
				coluna1.className = "col-3";
				coluna1.innerHTML = setor.firstChild.data;				
						
            } else {
                alert(http_request.status+'There was a problem with the request.');
            }
        }

    }	
	$("cep").onkeyup = function() {		
		var value = this.value;
		if(value.length == 8){			
			$("cep").blur();
			preLoadImg = new Image();
			preLoadImg.src = "../_images/estrutura/loader.gif";
			$("cid-estado").innerHTML = "<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='../_images/estrutura/loader.gif'></center></table>";
			//busco os dados...
			makeRequest('../componentes/cep.php?cep='+value, 1);
		}		
	}
	
	///MESMA FUNÇÃO QUE A DE CIMA, MAS USADA NA EDIÇÃO, QUANDO O CEP JÁ VEM CARREGADO NO CAMPO///
	var value = $("cep").value;
	
	if(value.length == 8){
		preLoadImg = new Image();
		preLoadImg.src = "../_images/estrutura/loader.gif";
		$("cid-estado").innerHTML = "<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='../_images/estrutura/loader.gif'></center></table>";
		//busco os dados...
		makeRequest('../componentes/cep.php?cep='+value, 1);
	}
	
	$("adicionar-usuario").onclick = function()
	{
		var optAtual = $("usuarios_select").options[$("usuarios_select").selectedIndex];
		
		usuarioAtual = optAtual.value;			
		if(usuarioAtual == "null"){
			alert("Selecione um usuário!");
			return false;
		}		
		
		makeRequest('./ajax/verifica-parceiros.php?cod='+optAtual.value, 2);		
		usuariosExcluidas[usuarioAtual] = optAtual;		
		return false;
	}
	$("excluir-usuario").onclick = function()
	{
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length; i++)
		{	
		    if(inputs[i].name == "usuario[]")
			{
				if(inputs[i].checked)
				{	
					if(confirm("Tem certeza que deseja excluir?"))
					{
						removerLinha(inputs[i]);						
					}
				}
			}
		}
	}
	
	
	// Função responsável em receber um objeto e extrair as informações necessárias para a remoção da linha.
	function removerLinha(obj) {			
			// Capturamos a referência da TR (linha) pai do objeto
			var objTR = obj.parentNode.parentNode;
			// Capturamos a referência da TABLE (tabela) pai da linha
			var objTable = objTR.parentNode;
			// Capturamos o índice da linha
			var indexTR = objTR.rowIndex;
			// Chamamos o método de remoção de linha nativo do JavaScript, passando como parâmetro o índice da linha  
			var table1 = document.getElementById("tabela")
			//objTable.deleteRow(indexTR);
			table1.deleteRow(indexTR);		
	 } 
}