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

	var inputs = document.getElementsByTagName("input");
	var pit;
	//// PERCORRO O DOCUMENTO PARA PEGAR O CODIGO DO PIT///
	for(var y = 0; y < inputs.length; y++)
	{
		if(inputs[y].id == "cod")
		{
			pit = inputs[y].value;
		}
	}
	
	for(var i = 0; i < inputs.length; i++)
	{		
		if(inputs[i].id == "orcamento-fornecedor"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:"){
						var checkToCheck = document.getElementsByClassName("checkbox");	
						var contChecked = 0;
						for(var k = 0; k < checkToCheck.length; k++)
						{							
							///Se o trabalho está marcado, prossegue...
							if(checkToCheck[k].checked)
							{
								contChecked++;									
								window.location.href = classes[j].substring("action:".length)+pit+"&setor="+checkToCheck[k].value;								
								break;								
							}								
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
		if(inputs[i].id == "orcamento-cliente"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:"){
						var checkToCheck = document.getElementsByClassName("checkbox");	
						var contChecked = 0;
						for(var k = 0; k < checkToCheck.length; k++)
						{							
							///Se o trabalho está marcado, prossegue...
							if(checkToCheck[k].checked)
							{
								contChecked++;									
								window.open(classes[j].substring("action:".length)+pit+"&setor="+checkToCheck[k].value);								
								break;								
							}								
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
		if(inputs[i].id == "autorizacao-fornecedor"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:"){
						var checkToCheck = document.getElementsByClassName("checkbox");	
						var contChecked = 0;
						for(var k = 0; k < checkToCheck.length; k++)
						{							
							///Se o trabalho está marcado, prossegue...
							if(checkToCheck[k].checked)
							{
								contChecked++;									
								window.open(classes[j].substring("action:".length)+pit+"&setor="+checkToCheck[k].value);								
								break;								
							}								
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
		if(inputs[i].id == "cadastrar"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:"){
						var checkToCheck = document.getElementsByClassName("checkbox");	
						var contChecked = 0;
						for(var k = 0; k < checkToCheck.length; k++)
						{							
							///Se o trabalho está marcado, prossegue...
							if(checkToCheck[k].checked)
							{
								contChecked++;								
								window.location.href = classes[j].substring("action:".length)+pit+"&setor="+checkToCheck[k].value;								
								break;								
							}								
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
		if(inputs[i].id == "editar"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:"){
						var checkToCheck = document.getElementsByClassName("checkbox");	
						var contChecked = 0;
						for(var k = 0; k < checkToCheck.length; k++)
						{							
							///Se o trabalho está marcado, prossegue...
							if(checkToCheck[k].checked)
							{
								contChecked++;									
								window.location.href = classes[j].substring("action:".length)+pit+"&setor="+checkToCheck[k].value;								
								break;								
							}								
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
		if(inputs[i].id == "visualizar"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:"){
						var checkToCheck = document.getElementsByClassName("checkbox");	
						var contChecked = 0;
						for(var k = 0; k < checkToCheck.length; k++)
						{							
							///Se o trabalho está marcado, prossegue...
							if(checkToCheck[k].checked)
							{
								contChecked++;									
								window.location.href = classes[j].substring("action:".length)+pit+"&setor="+checkToCheck[k].value;								
								break;								
							}								
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
		else if(inputs[i].id == "aprovar")
		{				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:")
					{			
						var servicoAprovado;
						var quantidadeAprovada;
						var servicos = document.getElementsByName("servico");
						var quantidades = document.getElementsByName("quantidades");
						for(var k = 0; k < servicos.length; k++)
						{							
							if(servicos[k].checked)
							{
								servicoAprovado = servicos[k].value;
							}
						}
						for(var y = 0; y < quantidades.length; y++)
						{							
							if(quantidades[y].checked)
							{
								quantidadeAprovada = quantidades[y].value;
							}
						}
						if(quantidades.length > 0)
						{
							if(servicoAprovado == null || quantidadeAprovada == null)
							{
								alert("Selecione uma opção em serviço e outra em um dos fornecedores para aprovar este orçamento!");	
								return false;
							}
						}
						else{
							if(servicoAprovado == null)
							{
								alert("Selecione uma opção em serviço para aprovar este orçamento!");
								return false;
							}							
						}				
						   var orcamentoAprovado = quantidadeAprovada+"-"+servicoAprovado;
						   //alert(orcamentoAprovado);			
						   window.location.href = classes[j].substring("action:".length)+"&orcamentoAprovado="+orcamentoAprovado;	
						   break;
						
					}
				}				
			}
		}
		else if(inputs[i].id == "abrirpit")
		{				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:")
					{						
						window.location.href = classes[j].substring("action:".length);					
					}
				}				
			}
		}
		else if(inputs[i].id == "comissao")
		{				
			inputs[i].onclick = function()
			{	
				if(this.checked)
				{
					var cod = this.name.substring(18,21);
					var valores = document.getElementsByName("valorOrcamento_"+cod+"[]");
					
					for(x=0;x<valores.length;x++)
					{					
						var valor = valores[x].value;
						valor = valor.replace(".","");						
						valor = valor.replace(/,/,".");	
						valor = valor*1.20;	
						valor = valor.formatMoney();
						valores[x].value = valor;
					}					
				}				
			}
		}
		else if(inputs[i].id == "excluir")
		{				
			inputs[i].onclick = function()
			{						
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:"){
						var checkToCheck = document.getElementsByClassName("checkbox");	
						var contChecked = 0;
						for(var k = 0; k < checkToCheck.length; k++)
						{							
							///Se o trabalho está marcado, prossegue...
							if(checkToCheck[k].checked)
							{
								contChecked++;	
								if(!confirm("Você tem certeza?"))
								return false;
								window.location.href = classes[j].substring("action:".length)+pit+"&setor="+checkToCheck[k].value;								
								break;								
							}								
						}
						if(contChecked < 1 )
						{ 
							alert("Selecione um trabalho para excluir!");
							return false;
						}
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
	

	
	
	
	
	

}// JavaScript Document