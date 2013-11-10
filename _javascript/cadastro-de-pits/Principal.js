main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
	//new CompletaData();
}

function Principal()
{	
//--	
	var processaAutoComplete = function(data){
		var perguntasArea = document.getElementsByClassName("caixa-pergunta");
		for(var i = 0; i < perguntasArea.length; i++){
			perguntasArea[i].value = data[i];
		}
	}	
	
/*----------------------------------------------------------------------------------*/


	$("pitDataprazoapresentacao").onblur = function()
	{
		
		var paramDate = this.value.split("/");
		var date = new Date(paramDate[2], paramDate[1], paramDate[0]);
		if(date == "Invalid Date")
		{						
			/*
				Se for uma data inválida, processo para o auto-complete.
			*/
			var dataAtual = new Date();
			
			if(paramDate[0] == "" || paramDate[0] == null) {
				paramDate[0] = dataAtual.getDate();
			}
			
			paramDate[2] = dataAtual.getFullYear();
			
			//se o mês tiver vazio...
			if(paramDate[1] == "" || paramDate[1] == null) {
				if(paramDate[0] < dataAtual.getDate()) { //se o dia for maior que hoje...
					
					paramDate[1] = dataAtual.getMonth() + 2;
				}
				else {
					paramDate[1] = dataAtual.getMonth() + 1;
				}
			}
			else if(paramDate[1] < dataAtual.getMonth()) {
				paramDate[2]++;
			}
			
			//tento simplesmente substituir o ano digitado pelo ano atual
			var tentativa = new Date(paramDate[2], paramDate[1] - 1, paramDate[0]);
			if(tentativa == "Invalid Date") {
				
			}
			else {
				//deu certo!
				autoPreenche(tentativa, this);							
			}
		}
	}			
	/*
		Auto preenche o campo passado com a data passada.
	*/
	var autoPreenche = function(data, campo) {
		campo.value = data.getDate() + "/" + (data.getMonth() + 1) + "/" + data.getFullYear();
	}


/*-----------------------------------------------------------------------------------------------------------*/

	var setorAtual = "null";
	var setoresExcluidos = Array();
	var selectAtual = "null";

/*
		Carregamento das perguntas de outro PIT.		
	*/	
	var http_request = false;	
	function makeRequest(url){
		//alert("carregar");
		//CadastroDePits.loadPerguntasByCodigoPit($("codOutroPit").value, processaAutoComplete);
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
              //  alert(http_request.responseText);
				//var data = http_request.responseText;
				/*for(var i = 0; i < data.length; i++){
					alert(data[i]);
				}*/
			/*	document.getElementById ("caixa-pergunta"). innerHTML = http_request.responseText;
				var perguntasArea = document.getElementsByClassName("caixa-pergunta");
				for(var i = 0; i < perguntasArea.length; i++){
					//perguntasArea[i].value = data[i];
					perguntasArea[i].value = http_request.responseText;
					
				}*/
				//document.getElementById ("setores-dinamicos"). innerHTML = http_request.responseText;
				
				var fSet = document.createElement("fieldset");
				fSet.setAttribute("id", "caixa-setor-" + setorAtual);
				fSet.innerHTML = http_request.responseText;
				
				$("setores-dinamicos").appendChild(fSet);
				/*var bt = document.getElementsByClassName("excluir-setor-dinamico");	
				bt.setAttribute("id","botao-excluir-" + setorAtual);
				$("setores-dinamicos").appendChild(bt);*/
				principal.eventoOnClickExcluir();
				new Validator();
				new CompletaData();
				
				//principal.auto();
				principal.indexaInputsData();
				
				//adicionaSetorDinamico = http_request.responseText;
            } else {
                alert('There was a problem with the request.');
            }
        }

    }

	//$("carregar-bt").onclick = function(){ makeRequest('CadastroDePits.php?cod=5');}
	
	
	
		
		
	
	$("adicionar-setor").onclick = function(){
		var optAtual = $("setor").options[$("setor").selectedIndex];
		setorAtual = optAtual.value;
	
		if(setorAtual == "null"){
			alert("Selecione um setor!");
			return false;
		}
		
		//--
		//CadastroDePits.doCaixaSetor(setorAtual, adicionaSetorDinamico);
		makeRequest('setores.php?cod='+optAtual.value);
		
		setoresExcluidos[setorAtual] = optAtual;
//		$("setor").removeChild(optAtual);
		
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
//				$("caixa-setor-" + valueAux).parentNode.removeChild($("caixa-setor-" + valueAux));

				var parentN = this.parentNode;
				while(parentN.id != ("caixa-setor-" + valueAux)){
					parentN = parentN.parentNode;
				}
				
				parentN.parentNode.removeChild(parentN);
				
//				principal.restauraSetor(valueAux);
				
				return false;
			}
		}
	}
	
	this.eventoOnClickExcluir();
	
	//--
	
	/*
		Ações do botão salvar...
	*/
	$("submit-button").onclick = function(){
		//faço a verificação de se há algum setor escolhido...
		//deverá haver ao menos um
		if(setoresExcluidos.length == 0){
			alert("Você deverá escolher ao menos um setor!");
			$("setor").focus();
			return false;
		}
	}
	
	
	/*function ValidaHorario(){		
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length ; i++) {
			var classes = inputs[i].className.split(" ");
			for(var j = 0; j < classes.length; j++) {
			
				if(classes[j] == "maskhora"){
					inputs[i].onblur = function(){
						
							 	var hrs = this.value.substring(0,2);  
							    var min = this.value.substring(3,5); 
							    var hrs_pit = $("pitHorarioprazoapresentacao").value.substring(0,2);  
							    var min_pit = $("pitHorarioprazoapresentacao").value.substring(3,5);
							    
							    if (hrs > 23 || min > 59)
							    {
							    	alert("Horário invalido!");  
							       	this.value = '';
							       	this.focus();
							     				 			
							 	} 
							 	else if (hrs_pit > 23 || min_pit > 59)
							    {
							    	alert("Horário de apresentação invalido!");  
							       	$("pitHorarioprazoapresentacao").value = '';
							       	$("pitHorarioprazoapresentacao").focus();							     						 			
							 	}							    
							    else if (hrs_pit != ''){ 
							    
								    if ((hrs > hrs_pit) || (hrs >= hrs_pit &&  min > min_pit))
								    {							       	
								       	var horario = '';
								       	if(confirm("O horário desta tarefa é maior ou igual ao horário da apresentação geral!\nDeseja alterar o horário da apresentação geral para após esta tarefa?")) {
										    hrs++;
										    horario = hrs + ":" + min;								    
										    preencheHorario(horario, $("pitHorarioprazoapresentacao"));
										    
										}
										else {
												   alert("O horário desta tarefa foi alterado para antes da apresentação geral.");
												   //muda a data da tarefa pela do PIT
												    hrs_pit--;
												    horario = hrs_pit + ":" + min_pit;								    
										    		preencheHorario(horario, this);
										    									   
										}
								     						 			
								 	} 
							 	 }  
							 	       
					}
				}		 	
			}
		}
		var preencheHorario = function(hora, campo) {
			campo.value = hora;
		}				
	}	*/
	
	/*
		Indexa os campos que contém a data do setor.
	*/
	this.indexaInputsData = function(){
	
		/*
			Auto preenche o campo passado com a data passada.
		*/
		var autoPreenche = function(data, campo) {
			campo.value = data.getDate() + "/" + (data.getMonth() + 1) + "/" + data.getFullYear();		
		}
	
		var inp = document.getElementsByName("prazoData[]");
		for(var i = 0; i < inp.length; i++){
			inp[i].onblur = function(){
				var paramDate = this.value.split("/");
				var date = new Date(paramDate[2], paramDate[1], paramDate[0]);
						
				
				
				if(date == "Invalid Date") {
					
					/*
						Se for uma data inválida, processo para o auto-complete.
					*/
					var dataPrincipa = $("pitDataprazoapresentacao").value.split("/");
					var dataAtual = new Date(dataPrincipa[2], dataPrincipa[1] - 1, dataPrincipa[0]);
					paramDate[2] = dataAtual.getFullYear();
					
					if(paramDate[0] == "" || paramDate[0] == null) {
						paramDate[0] = dataAtual.getDate();
					}
					
					//se o mês tiver vazio...
					if(paramDate[1] == "" || paramDate[1] == null) {
						if(paramDate[0] > dataAtual.getDate()) { //se o dia for maior que hoje...
							paramDate[1] = dataAtual.getMonth();
						}
						else {
							paramDate[1] = dataAtual.getMonth() + 1;
						}
					}
					else if(paramDate[1] < dataAtual.getMonth()) {
						paramDate[2]++;
					}
					
					//tento simplesmente substituir o ano digitado pelo ano atual
					var tentativa = new Date(paramDate[2], paramDate[1] - 1, paramDate[0]);
					
					
					
									
					/*if((tentativa.getDate() == dataAtual.getDate()) && (tentativa.getMonth() == dataAtual.getMonth()) && (tentativa.getFullYear() == dataAtual.getFullYear())){
							//teoricamente deveria entrar aqui só se os horários são iguais...		
							ValidaHorario();
					}*/				
					//FIXME IF YOU CAN! gambiarraaaaaa...
					if(parseInt(tentativa.getFullYear() + "" + tentativa.getMonth() + "" + tentativa.getDate()) > 
							parseInt(dataAtual.getFullYear() + "" + dataAtual.getMonth() + "" + dataAtual.getDate())) {
						tentativa = dataAtual;
					}
					
					
					if(tentativa == "Invalid Date") {
					}
					else {
						//deu certo!
						autoPreenche(tentativa, this);
						
					}
				}
				else{ // se a data não vier em branco...					
					var dataPrincipa = $("pitDataprazoapresentacao").value.split("/");
					var dataAtual = new Date(dataPrincipa[2], dataPrincipa[1] - 1, dataPrincipa[0]);										
					var tentativa = new Date(paramDate[2], paramDate[1]-1, paramDate[0]);	
											
					if(tentativa == "Invalid Date") {
					}
					else {
						/*if((tentativa.getDate() === dataAtual.getDate()) && (tentativa.getMonth() === dataAtual.getMonth()) && (tentativa.getFullYear() === dataAtual.getFullYear())){
							
							ValidaHorario();
						}
						//testa se a data da tarefa é maior que a do prazo geral
						else*/ if((tentativa.getDate() > dataAtual.getDate()) || (tentativa.getMonth() > dataAtual.getMonth()) || (tentativa.getFullYear() > dataAtual.getFullYear())){					
							
							//testa qual campo é maior...						
							if(paramDate[0] > dataAtual.getDate()) {
								paramDate[0] = dataAtual.getDate();
								
							}
							if(paramDate[1] > dataAtual.getMonth()) {
								paramDate[1] = dataAtual.getMonth();
								paramDate[0] = dataAtual.getDate();
								
							}
							if(paramDate[2] > dataAtual.getFullYear()) {
								paramDate[2] = dataAtual.getFullYear();
								paramDate[1] = dataAtual.getMonth();
								paramDate[0] = dataAtual.getDate();
								
							}							
							var tentativa2 = new Date(paramDate[2], paramDate[1], paramDate[0]);															
							
							if(confirm("A data do prazo desta tarefa é maior que a de apresentação geral!\nDeseja alterar o prazo geral para o mesmo desta tarefa?")) {
									    //altera a data geral do PIT pela data da tarefa									    
									    autoPreenche(tentativa, $("pitDataprazoapresentacao"));
									   
									   // ValidaHorario();
							}
							else {
									   alert("O prazo desta tarefa foi alterada para o mesmo de apresentação geral.");
									   //muda a data da tarefa pela do PIT
									    autoPreenche(tentativa2, this);
									    
									    //ValidaHorario();									   
							}
						}
											
							
													
				   }
				}
			}
		}
	}
}



/*tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	language : "pt_br",
	height : "250",
	convert_urls : false,
	relative_urls : false,
	cleanup_on_startup : true,
	cleanup : true,
	verify_html : true,
	apply_source_formatting : true,
	force_p_newlines : true,
	fix_content_duplication : true,
	inline_styles : false,
	convert_fonts_to_spans : true,
	theme_advanced_buttons1 : "bold,italic,underline,separator,formatselect,fontsizeselect,forecolor",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	theme_advanced_resize_horizontal : true,
	theme_advanced_resizing : true,
	valid_elements : "-a[name|href|target|title|onclick],-hr,-ul,-ol,-li,-em,-strong,-b,-u,-sub,-sup,-p"
});*/