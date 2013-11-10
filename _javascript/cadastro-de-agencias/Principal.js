main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){
	
	var contatoAtual = "null";
	var contatoExcluidas = Array();
	var selectAtual = "null";
	
	 
	
	function addContato() {      
				
		table1 = document.getElementById("tabela");
		var linha = table1.insertRow(1);
		//Inserção de Celulas
		var coluna1 = linha.insertCell(-1);
		//Definindo o estilo para a célula
		coluna1.className = "par";
		//Definindo o conteúdo para a célula
		coluna1.innerHTML = "<input name='contato[]' class='checkbox to_check_checkAll' type='checkbox'>";	
		
		coluna1 = linha.insertCell(-1);
		coluna1.className = "col-1";
		coluna1.innerHTML = "<input name='nomecontato[]' class='onsubmit:notnull' type='text'>";
		
		coluna1 = linha.insertCell(-1);
		coluna1.className = "col-2";
		coluna1.innerHTML = "<input name='fonecontato[]' class='onsubmit:notnull telefone-ddd-mask' type='text'>";
		
		coluna1 = linha.insertCell(-1);
		coluna1.className = "col-3";
		coluna1.innerHTML = "<input name='emailcontato[]' class='onsubmit:notnull' type='text'>";

    }	

	
	$("adicionar-contato").onclick = function()
	{
		
		addContato();		
		usuariosExcluidas[usuarioAtual] = optAtual;		
		return false;
	}
	$("excluir-contato").onclick = function()
	{
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length; i++)
		{	
		    if(inputs[i].name == "contato[]")
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