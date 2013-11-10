main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();	
}

function Principal(){
		
	$("intervalodias").style.display = "none";
	$("dias").style.display = "none";
	$("descontoa").style.display = "none";
	$("nparcelas").style.display = "none";
	$("juros").style.display = "none";
	
	var inputs = document.getElementsByTagName("input");
	var avista, aprazo, cjuros;
	var cont = 0;
	for(var i = 0; i < inputs.length; i++){		
		if(inputs[i].getAttribute("type") == "radio" && inputs[i].getAttribute("name") == "condicao")
		{					
			if(inputs[i].value == 1)
				avista = inputs[i];
			else if(inputs[i].value == 2)
				aprazo = inputs[i];	
			else if(inputs[i].value == 3)
				cjuros = inputs[i];	
		}
	}
	
	var dom = new DOM();
	var condicaoAtual;
	var condicoes = document.getElementsByName("condicao");;
	for(i=0; i<condicoes.length; i++)
	{
		if(condicoes[i].checked)
		{
			condicaoAtual = condicoes[i].value;
		}
	}

	if(condicaoAtual==1)
	{
		$("descontoa").style.display = "";
		$("intervalodias").style.display = "none";
		$("dias").style.display = "none";
		$("nparcelas").style.display = "none";
		$("juros").style.display = "none";
		
		dom.removeClass($("parcelasjuros"), "onsubmit:notnull");
		dom.removeClass($("parcelas"), "onsubmit:notnull");
		dom.removeClass($("intervalo"), "onsubmit:notnull");
		dom.removeClass($("diasparcela"), "onsubmit:notnull");
	}else if(condicaoAtual==2){
		
		$("descontoa").style.display = "none";
		$("intervalodias").style.display = "";
		$("dias").style.display = "";
		$("nparcelas").style.display = "";
		$("juros").style.display = "none";
		
		dom.removeClass($("parcelasjuros"), "onsubmit:notnull");	
		
	}else if(condicaoAtual==3){

		$("juros").style.display = "";
		$("descontoa").style.display = "none";
		$("intervalodias").style.display = "";
		$("dias").style.display = "";
		
		$("nparcelas").style.display = "none";
		
		dom.removeClass($("parcelas"), "onsubmit:notnull");
				
	}
	avista.onclick = function()
	{		
		if(this.checked){
			
			$("descontoa").style.display = "";	
			$("nparcelas").style.display = "none";	
			$("intervalodias").style.display = "none";
			$("dias").style.display = "none";
			$("juros").style.display = "none";
			
			dom.removeClass($("parcelasjuros"), "onsubmit:notnull");
			dom.removeClass($("parcelas"), "onsubmit:notnull");
			dom.removeClass($("intervalo"), "onsubmit:notnull");
			dom.removeClass($("diasparcela"), "onsubmit:notnull");			
			
		}
	}
	
	aprazo.onclick = function()
	{
		if(this.checked)
		{
			$("nparcelas").style.display = "";	
			$("intervalodias").style.display = "";
			$("dias").style.display = "";
			$("descontoa").style.display = "none";
			$("juros").style.display = "none";
			
			dom.removeClass($("parcelasjuros"), "onsubmit:notnull");
			dom.addClass($("parcelas"), "onsubmit:notnull");
			dom.addClass($("intervalo"), "onsubmit:notnull");
			dom.addClass($("diasparcela"), "onsubmit:notnull");			
		}
	}
	cjuros.onclick = function()
	{
		if(this.checked)
		{
			$("juros").style.display = "";				
			$("intervalodias").style.display = "";
			$("dias").style.display = "";
			$("descontoa").style.display = "none";
			$("nparcelas").style.display = "none";	
			
			dom.addClass($("parcelasjuros"), "onsubmit:notnull");
			dom.addClass($("intervalo"), "onsubmit:notnull");
			dom.addClass($("diasparcela"), "onsubmit:notnull");
			dom.removeClass($("parcelas"), "onsubmit:notnull");
		}else{
			$("descontoa").style.display = "";
			$("nparcelas").style.display = "none";
			$("intervalodias").style.display = "none";
			$("dias").style.display = "none";
			
			dom.removeClass($("parcelas"), "onsubmit:notnull");
			dom.removeClass($("intervalo"), "onsubmit:notnull");
			dom.removeClass($("diasparcela"), "onsubmit:notnull");
		}
	}
	$("dataentrada").onclick = function()
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
	
		Calendar.setup({
		inputField     :    "dataentrada",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "lancador"     // o id do botão que lançará o calendário
	}); 
	
}// JavaScript Document