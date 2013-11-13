$().ready(function() {	

	/////FORMATA O VALOR EM MOEDA//////
	Number.prototype.formatMoney = function(c, d, t){
    var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
    + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};
	//_________________________________________________//
	
	var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
    cal.manageFields("dataentrada", "dataentrada", "%d/%m/%Y");
	
	
	
	$("#adicionar-produto").click(function()
	{		
		//alert('teste');
		var produtoAtual = "";
		$("#produtos option:selected").each(function () {
			produtoAtual = $(this).val();
		});
		
		if(produtoAtual != "undefined" && produtoAtual != 'null')
		{
			$.ajax({
				type: "GET",
				url: "ajax/produtos.php",
				data: "cod="+produtoAtual,
				success: function(xml) {
					$(xml).find('produto').each(function(){
						var cod = $(this).find('cod').text();
						var valor = $(this).find('valor').text();
						var nome = $(this).find('nome').text();
						var unidade = $(this).find('unidade').text();
						
						table1 = document.getElementById("tabela");
						var linha = table1.insertRow(1);
						//Inserção de Celulas
						var coluna1 = linha.insertCell(-1);
						//Definindo o estilo para a célula
						coluna1.className = "par";
						//Definindo o conteúdo para a célula
						coluna1.innerHTML = "<input name='produto[]' value='"+cod+"' class='checkbox to_check_checkAll' type='checkbox'><input name='produto_[]' value='"+cod+"' type='hidden'>";	
						
						coluna1 = linha.insertCell(-1);
						coluna1.className = "col-2";							
						coluna1.innerHTML = nome;
						
						coluna1 = linha.insertCell(-1);
						coluna1.className = "col-2";							
						coluna1.innerHTML = "<input name='valor[]' id='valor' value='"+valor+"' class='input decimal' type='text'>/"+unidade;
						
						coluna1 = linha.insertCell(-1);
						coluna1.className = "col-3";
						coluna1.innerHTML = "<input name='quantidade[]' id='"+cod+"' value='1' class='input integer' type='text'>";
						
						coluna1 = linha.insertCell(-1);
						coluna1.className = "col-4";
						coluna1.innerHTML = "<input name='subtotal[]' id='"+cod+"' value='"+valor+"' class='input decimal' type='text'>";
						new subTotal();
						new total();
					});
				}
			});
		}else{
			alert("Nenhuma entidade foi selecionada para ser inserida.");	
		}
	});
	
	$("#excluir-produto").click(function()
	{
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length; i++)
		{	
		    if(inputs[i].name == "produto[]")
			{
				if(inputs[i].checked)
				{	
					if(confirm("Tem certeza que deseja excluir?"))
					{
						removerLinha(inputs[i]);
						new total();
					}
				}
			}
		}
	});
	
	
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

	function total()
	{
		var subtotal = document.getElementsByName("subtotal[]");
		var total = 0.00;
		var aux;
		for(var x=0;x<subtotal.length;x++)
		{							
			aux =subtotal[x].value;
			aux = aux.replace(".","");						
			aux = aux.replace(/,/,".");	
			aux = aux*1;
			total = total+aux;
		}				
		total = total.formatMoney();
		$("#total").val(total);
		$("#total").click(function()
		{
			$(this).blur();
		});
		//alert(totalfield.value)
	}
	
	function subTotal()
	{
		var inputs = document.getElementsByTagName("input");
		var pit;
		var cod;
		for(var i = 0; i < inputs.length; i++)
		{	
			
		    if(inputs[i].name == "quantidade[]")
			{
		    	inputs[i].onkeyup = function()
				{		
		    		
					var qtd = $(this).val();
					var valor = $(this).parent().prev('.col-2').children().val();
					
					valor = valor.replace(".","");						
					valor = valor.replace(/,/,".");					
					
					if(qtd != '')
					{					
						var valornovo = qtd * valor;						
						valornovo = valornovo.formatMoney();
											
						var campos = $(this).parent();
						var td = campos[0];
						var tdsubtotal = $(this).parent().next('.col-4');
						var subtotal = tdsubtotal.children();
						//alert(subtotal[0].value);
						subtotal[0].value = valornovo;
						new total();						
					}
				}
			}
			if(inputs[i].name == "valor[]")
			{
				inputs[i].onkeyup = function()
				{		
					
					var qtd = $(this).parent().next('.col-3').children().val();
					var valor = $(this).val();
					
					valor = valor.replace(".","");						
					valor = valor.replace(/,/,".");					
					
					if(qtd != '')
					{					
						var valornovo = qtd * valor;						
						valornovo = valornovo.formatMoney();
											
						var campos = $(this).parent();
						var td = campos[0];
						var tdsubtotal = $(this).parent().next('.col-4');
						var subtotal = tdsubtotal.children();						
						subtotal[0].value = valornovo;
						new total();						
					}
				}
			}
		}
	}
	
	$("#nparcelas").css("display", "none");
	
	var boolValid = false;
	$(".radio").click(function() {
		if ( $(this).is(':checked') ) {
			boolValid = true;			
			if($(this).val() == "1")
			{				
				$("#nparcelas").css("display", "none");
				
			}else{			
				$("#nparcelas").css("display", "block");
			}
		}
	});
	
});