main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
	//principal.validaHorario();
}

function Principal(){	

	var dom = new DOM();
	
	var saidasetor = "null";
	var setorEnvolvido = "null";
	
	var datasaida = "null";
	var horasaida = "null"; 
	
	
	
	//var situacaoAtual = $("situacaoTrabalho").options[$("situacaoTrabalho").selectedIndex];
	var situacaoAtual = document.getElementsByClassName("situacao");
	
	for(var i = 0; i < situacaoAtual.length; i++)
	{
				
		if(situacaoAtual[i].value == "c"){
			setorEnvolvido = situacaoAtual[i].getAttribute("id").substring("situacaoTrabalhoEdicao_".length);
			saidasetor = "saida_"+setorEnvolvido;			
			$(saidasetor).style.display = "";
		}else{			
			setorEnvolvido = situacaoAtual[i].getAttribute("id").substring("situacaoTrabalhoEdicao_".length);
			saidasetor = "saida_"+setorEnvolvido;
			$(saidasetor).style.display = "none";
		}	
		
		datasaida = "saidaDataEdicao_"+setorEnvolvido;
		horasaida = "saidaHorarioEdicao_"+setorEnvolvido;
		
		if(situacaoAtual[i].value == "c"){			
			dom.addClass($(datasaida), "onsubmit:notnull");
			dom.addClass($(horasaida), "onsubmit:notnull");
		}
		else{			
			dom.removeClass($(datasaida), "onsubmit:notnull");
			dom.removeClass($(horasaida), "onsubmit:notnull");	
		}
		
	}
	
	
	
	
	
	/*if(situacaoAtual.value == "c"){
		$("saida").style.display = ""
	}else{
		$("saida").style.display = "none"
	}	
		
	var dom = new DOM();
	
	if(situacaoAtual == "t"){
		
		dom.addClass($("saidaData"), "onsubmit:notnull");
		dom.addClass($("saidaHorario"), "onsubmit:notnull");
	}
	else{
		
		dom.removeClass($("saidaData"), "onsubmit:notnull");
		dom.removeClass($("saidaHorario"), "onsubmit:notnull");	
	}*/
	
	this.darSaida = function()
	{	
		var inputs = document.getElementsByClassName("situacao");		
		for(var i = 0; i < inputs.length; i++){
			inputs[i].onchange = function(){		
			
				var situacaoNova = this.options[this.selectedIndex];	
				setorEnvolvido = this.getAttribute("id").substring("situacaoTrabalhoEdicao_".length);
				
				saidasetor = "saida_"+setorEnvolvido;			
				
				datasaida = "saidaDataEdicao_"+setorEnvolvido;
				horasaida = "saidaHorarioEdicao_"+setorEnvolvido;
				
				if(situacaoNova.value == "c"){				
						
					$(saidasetor).style.display = "";				
					
					var dataSaida = document.getElementById(datasaida);
					var data = new Date();
					dataSaida.value = data.getDate() + "/" + (data.getMonth() + 1) + "/" + data.getFullYear();
					
					var horarioSaida = document.getElementById(horasaida);
					var hora = data.getHours();
					var minutos = data.getMinutes();
					
					hora = ""+hora+"";
					minutos = ""+minutos+"";
					if(hora.length == 1)
					{
						hora = "0"+hora;
					}					
					if(minutos.length == 1)
					{
						minutos = "0"+minutos;
					}
					horarioSaida.value = hora + ":" + minutos;
					
					var situacaoResponsavel = "situacaoTrabalhoResponsavel_"+setorEnvolvido;
					
					var inp = document.getElementsByClassName(situacaoResponsavel);					
					for(var j = 0; j < inp.length; j++)
					{							
						///MARCO COMO CONCLUÍDO EM TODOS OS RESPONSÁVEIS DESTE TRABALHO///
						inp[j].options["c"].selected = true;
					}
										
					///TORNO OBRIGATÓRIO OS CAMPOS DE SAÍDA///
					dom.addClass($(datasaida), "onsubmit:notnull");
					dom.addClass($(horasaida), "onsubmit:notnull");
					
				}else{
					$(saidasetor).style.display = "none"
					///REMOVO A OBRIGATORIEDADE DESTES CAMPOS///
					dom.removeClass($(datasaida), "onsubmit:notnull");
					dom.removeClass($(horasaida), "onsubmit:notnull");	
				}	
			}
		}
	}
	this.darSaida();
	
	this.adicionarTempo = function()
	{
		var inputs = document.getElementsByClassName("adicionar_tempo");		
		for(var i = 0; i < inputs.length; i++){
			inputs[i].onclick = function()
			{
				setorEnvolvido = this.getAttribute("id").substring("bt_adicionar_tempo_".length);
				
				var nomeTempo = "tempoDesenvolvimentoEdicao_"+setorEnvolvido;
				var nomeTempoTotal = "tempoTotalEdicao_"+setorEnvolvido;
				
				var tempo = document.getElementById(nomeTempo);
				
				tempoadd = tempo.value.split(":");
				
				var hour = tempoadd[0];
				var minute = tempoadd[1];	
				
				var tempoTotal = document.getElementById(nomeTempoTotal);
				
				if(tempo.value != "")///se o tempo a ser adicionado não for vazio
				{
					if(tempoTotal.value != "") ///se o tempo total não for vazio, 
					{
						tempoTT = tempoTotal.value.split(":");
						
						var horasTotal = tempoTT[0];
						var minutosTotal = tempoTT[1];
									
						var horario = parseFloat(hour) + parseFloat(horasTotal);
						var minutos = parseFloat(minute) + parseFloat(minutosTotal);
						
						if(minutos > 59)
						{
							horario = horario + 1;
							minutos = minutos - 60;
						}	
						
						horario = ""+horario+"";
						minutos = ""+minutos+"";
						
						if(horario.length == 1)
						{
							horario =  "0" + horario;			
						}
						if(minutos.length == 1)
						{
							minutos =  "0" + minutos;			
						}
									
					}else{
						horario = hour;
						minutos = minute;
					}
					tempoTotal.value = horario + ":" + minutos;
				}
			}
		}
	}
	this.adicionarTempo();
	
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