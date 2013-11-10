main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){

	
	var inputs = document.getElementsByTagName("input");
	var pit;
	for(var i = 0; i < inputs.length; i++)
	{
		if(inputs[i].id == "cadastrar"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:"){
						var checkToCheck = document.getElementsByClassName("to_check_checkAll");	
						var contChecked = 0;
						for(var k = 0; k < checkToCheck.length; k++){
							///Se o trabalho está marcado, prossegue...
							if(checkToCheck[k].checked)
							{
								contChecked++;	
								///Percorro o documento para pegar o codigo do pit///
								for(var y = 0; y < inputs.length; y++)
								{
									if(inputs[y].id == "cod")
									{
										pit = inputs[y].value;
									}
								}	
								window.location.href = classes[j].substring("action:".length)+pit+"&setor="+checkToCheck[k].value;								
								break;								
							}
							if(contChecked < 1 )
							{ 
								alert("Selecione um trabalho para prosseguir!");
								return false;
							}
						}						
					}
				}				
			}
		}
		else if(inputs[i].id == "aprovar")
		{				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:")
					{						
						window.location.href = classes[j].substring("action:".length)+"?estahAprovado=s";					
					}
				}				
			}
		}
	}
	
	var fornecedorAtual = "null";
	var fornecedoresExcluidos = Array();
	var selectAtual = "null";

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
				var xmldoc = http_request.responseXML;
				var cod = xmldoc.getElementsByTagName('cod').item(0);
				var nome = xmldoc.getElementsByTagName('nome').item(0);
				
				table1 = document.getElementById("tabela");
				var linha = table1.insertRow(1);
				//Inserção de Celulas
				var coluna1 = linha.insertCell(-1);
				//Definindo o estilo para a célula
				coluna1.className = "par";
				//Definindo o conteúdo para a célula
				coluna1.innerHTML ="<input name='fornecedores[]' value='"+cod.firstChild.data+"' class='checkbox to_check_checkAll' type='checkbox'>";
				
				var coluna1 = linha.insertCell(-1);
				coluna1.className = "col-1";
				coluna1.innerHTML = nome.firstChild.data;				
						
            } else {
                alert('There was a problem with the request.');
            }
        }

    }	
	$("adicionar-fornecedor").onclick = function()
	{
		var optAtual = $("fornecedores").options[$("fornecedores").selectedIndex];
		fornecedorAtual = optAtual.value;	
		if(fornecedorAtual == "null"){
			alert("Selecione um fornecedor!");
			return false;
		}		
		makeRequest('ajax/fornecedores.php?cod='+optAtual.value);		
		fornecedoresExcluidos[fornecedorAtual] = optAtual;		
		return false;
	}
	$("excluir-fornecedor").onclick = function()
	{
		var table1 = document.getElementById("tabela");
		//Removendo as linhas da tabela
		totLinhas = table1.rows.length - 1;
		for(i=1;i<totLinhas;i++){
			//Seleciona a segunda linha para ser excluida 
			// para que não seja removido o cabeçalho
			table1.deleteRow(1);
		}	
	}
	
	var avista, entradatrinta, outros;
	var cont = 0;
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].getAttribute("type") == "radio" && inputs[i].getAttribute("name") == "condPagamento")
		{			
			if(inputs[i].value == "avista")
				avista = inputs[i];
			else if(inputs[i].value == "entradatrinta")
				entradatrinta = inputs[i];
			else if(inputs[i].value == "outros")
				outros = inputs[i];
		}
	}
	$("descontoa").style.display = "none";	
	$("condPagamentoE").style.display = "none";	
	avista.onclick = function(){
		if(this.checked){
			$("descontoa").style.display = "";	
			$("condPagamentoE").style.display = "none";				
		}
	}
	
	entradatrinta.onclick = function()
	{
		if(this.checked)
		{
			$("condPagamentoE").style.display = "none";		
			$("descontoa").style.display = "none";	
		}
	}
	outros.onclick = function()
	{
		if(this.checked)
		{
			$("condPagamentoE").style.display = "";		
			$("descontoa").style.display = "none";	
		}
	}
	
	
	

}// JavaScript Document// JavaScript Document