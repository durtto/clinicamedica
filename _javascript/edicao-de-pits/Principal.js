main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
	//principal.validaHorario();
}

function Principal(){
	
	var btAlteracaoBriefing = $("bt-alteracao-briefing");

	var setorAtual = "null";
	var setoresExcluidos = Array();
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
					fSet.setAttribute("id", "caixa-setor-" + setorAtual);
					fSet.innerHTML = http_request.responseText;
					
					$("setores-dinamicos").appendChild(fSet);
					principal.eventoOnClickExcluir();
					new Validator();
					new CompletaData();
					principal.indexaInputsData();
				

            } else {
                alert('There was a problem with the request.');
            }
        }

    }	
	function teste() {

        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
             	
					var fSet = document.createElement("fieldset");
					fSet.setAttribute("id","perguntas-dinamico");
					fSet.innerHTML = http_request.responseText;
					
					$("adicionar-briefing").appendChild(fSet);
					btAlteracaoBriefing.parentNode.removeChild(btAlteracaoBriefing);
					

            } else {
                alert('There was a problem with the request.');
            }
        }

    }
	$("bt-alteracao-briefing").onclick = function(){
		
		makeRequest('perguntas-dinamico.php', 2);
	}
	$("adicionar-setor").onclick = function(){
		
		var optAtual = $("setor").options[$("setor").selectedIndex];
		setorAtual = optAtual.value;
	
		if(setorAtual == "null"){
			alert("Selecione um setor!");
			return false;
		}
		//${"setores_adicionais"}.value += 1;
		makeRequest('setores.php?cod='+optAtual.value, 1);
		
		setoresExcluidos[setorAtual] = optAtual;
		
		return false;
	}
	
	//--
	//função que restaura o select quando um setor previamente escolhido foi excluído
	this.restauraSetor = function(idSetor){
		var opts = $("setor").options;
		for(var i = 0; i < opts.length; i++){
			var auxSum = opts[i].value == "null" ? 0 : opts[i].value;
			auxSum++;
			
			if(idSetor >= auxSum){
				insertAfter(setoresExcluidos[idSetor], opts[i]);
			}
		}
	}
	
	this.eventoOnClickExcluir = function(){
		var bts = document.getElementsByClassName("excluir-setor-dinamico");
		
		for(var i = 0; i < bts.length; i++){
			bts[i].onclick = function(){
				var valueAux = this.getAttribute("id").substring("botao-excluir-".length);

				var parentN = this.parentNode;
				while(parentN.id != ("caixa-setor-" + valueAux)){
					parentN = parentN.parentNode;
				}
				
				parentN.parentNode.removeChild(parentN);
				
				return false;
			}
		}
	}
	
	this.eventoOnClickExcluir();


	/*
		Indexa os campos que contém a data do setor.
	*/
	this.indexaInputsData = function(){
		var inp = document.getElementsByName("prazoData[]");
		for(var i = 0; i < inp.length; i++){
			inp[i].onblur = function(){
				
//				alert("inicial: " + this.value);
//				alert("final: " + $("pitDataprazoapresentacao").value);
				
				if(Compara_Datas(this.value, $("pitDataprazoapresentacao").value)){
					this.value = $("pitDataprazoapresentacao").value;
				}
				//ValidaHorario();
			}
		}
		
		inp = document.getElementsByName("prazoDataEdicao[]");
		for(var i = 0; i < inp.length; i++){
			inp[i].onblur = function(){
				
//				alert("inicial: " + this.value);
//				alert("final: " + $("pitDataprazoapresentacao").value);
				
				if(Compara_Datas(this.value, $("pitDataprazoapresentacao").value)){
					this.value = $("pitDataprazoapresentacao").value;
				}
				//ValidaHorario();
			}
		}
	}
	
	this.indexaInputsData();
	
/*	function mostraTarefa() {

		if (http_request.readyState == 4) {
			if (http_request.status == 200) {              
				var fSet = document.createElement("fieldset");
				fSet.setAttribute("class", "caixa-tarefa");
				fSet.innerHTML = data;
				
				btClicado.parentNode.insertBefore(fSet, btClicado);
		
				new Validator();
				principal.doExcluirNovaTarefa();				

			} else {
				alert('There was a problem with the request.');
			}
		}
    }
	
	var adicionarTarefas = document.getElementsByClassName("adicionar-tarefa");
	var btClicado = null;
	
	//--
	for(var i = 0; i < adicionarTarefas.length; i++){
		adicionarTarefas[i].onclick = function(){
			alert("clicou");
			btClicado = this;
			
			var fSet = this.parentNode;
			var tiposDeTrabalho = fSet.getElementsByTagName("select"); //.options[fSet.selectedIndex.getElementById("tipoDeTrabalho[]")].value;
			var tipTrab;
			for(var i = 0; i < tiposDeTrabalho.length; i++){
				if(tiposDeTrabalho[i].name == "tipoDeTrabalhoEdicao[]"){
					tipTrab = tiposDeTrabalho[i];
				}
			}
			//makeRequest('caixa-tarefa.php', 2);
			//EdicaoDePits.doCaixaTarefa(this.id.substring("botao-adicionar-tarefa-".length), tipTrab.options[tipTrab.selectedIndex].value, adicionaTarefaDinamico);
		}
	}
	
	//--
	
	this.doExcluirNovaTarefa = function(){
		var bts = document.getElementsByClassName("excluir-nova-tarefa");
		for(var i = 0; i < bts.length; i++){
			bts[i].onclick = function(){
				var parentN = this.parentNode;
				while(parentN.className != "caixa-tarefa"){
					parentN = parentN.parentNode;
				}
				
				parentN.parentNode.removeChild(parentN);
			}
		}
	}	*/
	

}