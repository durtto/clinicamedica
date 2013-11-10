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

		
	
	var atracaoAtual = "null";
	var atracoesExcluidas = Array();
	var selectAtual = "null";
	var totalatracoes = 0;
	var http_request = false;	
	function makeRequest(url, cod)
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
		if(cod == 1)
		{
        	http_request.onreadystatechange = alertContents;
		}else{
			http_request.onreadystatechange = descontoGuia;
		}
        http_request.open('GET', url, true);
        http_request.send(null);
    }
	
    function alertContents() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {				
				var xmldoc = http_request.responseXML;
				var cod = xmldoc.getElementsByTagName('cod').item(0);
				var nome = xmldoc.getElementsByTagName('nome').item(0);
				var valor = xmldoc.getElementsByTagName('valor').item(0);
				var subtotal = xmldoc.getElementsByTagName('subtotal').item(0);
				var qtd = xmldoc.getElementsByTagName('qtd').item(0);
				var ehcombo = xmldoc.getElementsByTagName('ehcombo').item(0);
				
				table1 = document.getElementById("tabela");
				var linha = table1.insertRow(1);
				linha.setAttribute("class", "to_check_checkAll");
				//Inserção de Celulas
				var coluna1 = linha.insertCell(-1);
				//Definindo o estilo para a célula
				coluna1.className = "par";
				//Definindo o conteúdo para a célula
				coluna1.innerHTML = "<input name='atracao[]' value='"+cod.firstChild.data+"' class='checkbox to_check_checkAll' type='checkbox'><input name='atracao_[]' value='"+cod.firstChild.data+"' type='hidden'><input name='ehcombo_[]' value='"+ehcombo.firstChild.data+"' type='hidden'>";	
				
				coluna1 = linha.insertCell(-1);
				coluna1.className = "col-1";
				coluna1.innerHTML = nome.firstChild.data;
				
				coluna1 = linha.insertCell(-1);
				coluna1.className = "col-2";
				coluna1.innerHTML = "<input name='valor[]' id='"+cod.firstChild.data+"' value='"+valor.firstChild.data+"' type='text' class='input'>";
				
				coluna1 = linha.insertCell(-1);
				coluna1.className = "col-3";
				coluna1.innerHTML = "<input name='quantidade[]' id='"+cod.firstChild.data+"' value='"+qtd.firstChild.data+"' class='input' type='text'>";
				
				coluna1 = linha.insertCell(-1);
				coluna1.className = "col-4";
				coluna1.innerHTML = "<input name='subtotal[]' id='"+cod.firstChild.data+"' value='"+subtotal.firstChild.data+"' class='input' type='text'>";
				//new subTotal();
				new total();
				new NumberFormat();
				new bloqueiaCamposInput();
				totalatracoes++;
						
            } else {
                alert('There was a problem with the request.');
            }
        }
    }	
	function total()
	{
		var subtotal = document.getElementsByName("subtotal[]");
		var total = 0.00;
		var aux;
		for(var x=0;x<subtotal.length;x++)
		{							
			aux = subtotal[x].value;
			aux = aux.replace(".","");						
			aux = aux.replace(/,/,".");	
			aux = aux*1;
			total = total+aux;
		}
		//alert(total);
		var totalfield = document.getElementById("total-sub");
		total = total.formatMoney();
		totalfield.value = total;
		totalfield.onclick = function()
		{
			totalfield.blur();
		}
		document.getElementById("desconto").value = "0";
		document.getElementById("valordesconto").value = "0,00";
		document.getElementById("total").value = total;
		document.getElementById("total-pagamento").value = total;
		
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
					cod = this.id;
					var qtd = this.value;
					var valor = document.getElementById(cod).value;
					alert(valor);
					valor = valor.replace(".","");						
					valor = valor.replace(/,/,".");					
					
					if(qtd != '')
					{					
						var valornovo = qtd * valor;						
						valornovo = valornovo.formatMoney();
					/*	var subtotal = document.getElementsByName("subtotal[]");
						for(var x=0;x<subtotal.length;x++)
						{							
							if(subtotal[x].id == cod)
							{								
								subtotal[x].value = valornovo;									
							}
						}*/
						//var subtotal = this.next('.col-4',1);
						var campos = this.ancestors();
						var td = campos[0];
						var tdsubtotal = td.next('.col-4');
						var subtotal = tdsubtotal.descendants();
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
					cod = this.id;
					var qtd = document.getElementById(cod).value;
					var valor = this.value;
					
					valor = valor.replace(".","");						
					valor = valor.replace(/,/,".");					
					
					if(qtd != '')
					{					
						var valornovo = qtd * valor;						
						valornovo = valornovo.formatMoney();
						var subtotal = document.getElementsByName("subtotal[]");
						for(var x=0;x<subtotal.length;x++)
						{							
							if(subtotal[x].id == cod)
							{								
								subtotal[x].value = valornovo;									
							}
						}
						new total();
					}
				}
			}
		}
	}
	var exibiupesquisa = false;
	function descontoGuia() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {				
				var xmldoc = http_request.responseXML;
				var percentual = xmldoc.getElementsByTagName('desconto').item(0);
				var situacao = xmldoc.getElementsByTagName('situacao').item(0);
				var guia = xmldoc.getElementsByTagName('codigoguia').item(0);
				var nomeguia = xmldoc.getElementsByTagName('nomeguia').item(0);
				var total = xmldoc.getElementsByTagName('total').item(0);
				var nomeagencia = xmldoc.getElementsByTagName('nomeagencia').item(0);
				var valortotal = total.firstChild.data;
				
				if(situacao.firstChild != null && situacao.firstChild.data == 1)
				{						
					document.getElementById("guia").value = guia.firstChild.data;
					var percentualdesconto = percentual.firstChild.data;

					///SE VIER DESCONTO DO GUIA, DESABILITA O BOTÃO DESCONTO E ALTERA O TOTAL///					
					if(percentualdesconto > 0)
					{
						$("concededesconto").style.display = "none";
						
									
						valortotal = valortotal*1;
						
						var valorsub = document.getElementById("total-sub").value;
						valorsub = valorsub.replace(".","");						
						valorsub = valorsub.replace(/,/,".");								
						var valordiferenca = valorsub - valortotal;
						valordiferenca = valordiferenca.formatMoney();
						
						valortotal = valortotal.formatMoney();
						
						document.getElementById("desconto").value = percentualdesconto;	
						document.getElementById("valordesconto").value = valordiferenca;	
						document.getElementById("total-pagamento").value = valortotal;
						document.getElementById("total").value = valortotal;
						
					}else{
						$("concededesconto").style.display = "";
						document.getElementById("valordesconto").value = "0,00";
						document.getElementById("desconto").value = "0";						
						document.getElementById("total-pagamento").value = document.getElementById("total-sub").value;
						document.getElementById("total").value = document.getElementById("total-sub").value;
					}	
					
					var fSet = document.createElement("p");	
					fSet.setAttribute("id", "guiaajax");

					var newHTML = "Guia: <b>"+nomeguia.firstChild.data+"</b> <br>Agência: <b>"+nomeagencia.firstChild.data+"</b>";
					fSet.innerHTML = newHTML;							
					var cid = $('guiaajax');
					if(cid != null)
					{     					
						cid.parentNode.removeChild(cid);					
					}		
					$("nomeguia").innerHTML = "";
					$("nomeguia").appendChild(fSet);				
					new bloqueiaCamposInput();
					
					document.getElementById("pesquisa").style.display = "none";
					document.getElementById("guia_autocomplete").value = "";
					exibiupesquisa = false;
					
				}else{
					alert("Guia inativo ou não encontrado no sistema!");
				}						
            } else {
                alert('There was a problem with the request.');
            }
        }
    }
	

	function adicionarAtracao()
	{
		
		var inputs = document.getElementsByName("atracao");
		for(var i = 0; i < inputs.length; i++)
		{
			inputs[i].onclick = function()
			{							
				var qtd;
				if(!retornaDisplay())
				{
					qtd = 1;			
				}else{
					qtd = retornaDisplay();
					limpaDisplay();
				}
				if(qtd)
				{
					makeRequest('ajax/atracoes.php?cod='+this.id+'&qtd='+qtd, 1);				
				}
			}
		}		
	}
	new adicionarAtracao();
	
	function adicionarCombos()
	{
		
		var inputs = document.getElementsByClassName("combo");
		for(var i = 0; i < inputs.length; i++)
		{
			inputs[i].onclick = function()
			{	
				var qtd;
				if(!retornaDisplay())
				{
					qtd = 1;			
				}else{
					qtd = retornaDisplay();
					limpaDisplay();
				}				
				
				if(qtd)
				{
					makeRequest('ajax/combos.php?cod='+this.id+'&qtd='+qtd, 1);				
				}
			}
		}		
	}
	new adicionarCombos();
	
	$("excluir-atracao").onclick = function()
	{
		var inputs = document.getElementsByClassName("to_check_checkAll");
		if(confirm("Tem certeza que deseja excluir os itens selecionados?"))
		{
			for(var i = 0; i < inputs.length; i++)
			{					
				if(inputs[i].checked)
				{					
					removerLinha(inputs[i]);
					new total();
					totalatracoes--;						
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
	
	function concederDesconto()
	{
		
		var inputs = document.getElementById("concededesconto");
		inputs.onclick = function()
		{		
			var desconto;
			if(!retornaDisplay())
			{
     			desconto = prompt("Informe o desconto:", "5");			
			}else{
				desconto = retornaDisplay();
				limpaDisplay();
			}
			if(desconto)
			{
				if(desconto >= 1)
				{
					var justificativa = prompt("Informe a justificativa:", "");
					if(justificativa)
					{
						$("justificativa-desconto").value = justificativa;
						desconto = desconto.replace(".","");						
						desconto = desconto.replace(/,/,".");		
						
						var totalfield = document.getElementById("total-sub");																
						var total = totalfield.value;						
						total = total.replace(".","");						
						total = total.replace(/,/,".");									
						var totalcomdesconto = total - (total * (desconto/100));	
						
														
						var valordiferenca = total - totalcomdesconto;
						valordiferenca = valordiferenca.formatMoney();
						
						
						totalcomdesconto = totalcomdesconto.formatMoney();						
						document.getElementById("desconto").value = desconto;
						document.getElementById("valordesconto").value = valordiferenca;
						document.getElementById("total-pagamento").value = totalcomdesconto;
						document.getElementById("total").value = totalcomdesconto;
					}				
				}
			}
		}			
	}
	new concederDesconto();
	
	function vincularGuia()
	{		
		var inputs = document.getElementById("vincularguia");
		inputs.onclick = function()
		{		
			var guia;
			if(!retornaDisplay())
			{
     			guia = prompt("Informe o guia:", "");			
			}else{
				guia = retornaDisplay();
				limpaDisplay();
			}
			if(guia)
			{
				if(guia >= 1)
				{
					guia = guia.replace(".","");						
					guia = guia.replace(/,/,".");		
					var subtotal = document.getElementsByName("subtotal[]");
					var total = 0.00;
					var aux;
					for(var x=0;x<subtotal.length;x++)
					{							
						aux = subtotal[x].value;
						aux = aux.replace(".","");						
						aux = aux.replace(/,/,".");	
						aux = aux*1;
						total = total+aux;
					}
					if(total > 0)
					{
						makeRequest('ajax/desconto-guia.php?cod='+guia+'&total='+total, 2);		
					}else{
						alert("Adicione pelo menos uma atração para vincular um guia.");
					}
				}
			}
		}
	}
	new vincularGuia();
	
	
	document.getElementById("pesquisa").style.display = "none";
	
	function pesquisarGuia()
	{		
		var inputs = document.getElementById("pesquisarguia");
		inputs.onclick = function()
		{	
			if(!exibiupesquisa)
			{
				///EXIBE O CAMPO DE PESQUISA, APAGA O GUIA Q ESTÁ NA TELA SE TIVER, E REMOVE DO CAMPO HIDDEN TB///
				
				document.getElementById("pesquisa").style.display = "";
				document.getElementById("guia_autocomplete").focus();				
				$("nomeguia").innerHTML = "";
				document.getElementById("guia").value = "";
				exibiupesquisa = true;
				
			}else{
				document.getElementById("pesquisa").style.display = "none";
				document.getElementById("guia_autocomplete").value = "";
				exibiupesquisa = false;
			}
		}
	}	
	new pesquisarGuia();
	
	function vinculaGuiaPesquisa()
	{
		var inputs = document.getElementById("ok");
		inputs.onclick = function()
		{	
			var guia = document.getElementById("guia_autocomplete").value;
			var arrayguia = guia.split("|", 2);
			var codguia = arrayguia[0];
							
			var subtotal = document.getElementsByName("subtotal[]");
			var total = 0.00;
			var aux;
			for(var x=0;x<subtotal.length;x++)
			{							
				aux = subtotal[x].value;
				aux = aux.replace(".","");						
				aux = aux.replace(/,/,".");	
				aux = aux*1;
				total = total+aux;
			}
			if(total > 0)
			{
				makeRequest('ajax/desconto-guia.php?cod='+codguia+'&total='+total, 2);
				document.getElementById("pesquisa").style.display = "none";
				document.getElementById("guia_autocomplete").value = "";
				exibiupesquisa = false;
			}else{
				alert("Adicione pelo menos uma atração para vincular um guia.");
			}
		}
	}
    new vinculaGuiaPesquisa();
	
	function exibeDisplay()
	{
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length; i++)
		{	
		    if(inputs[i].name == "teclado")
			{
				inputs[i].onclick = function(){			

					document.getElementById("display").value += this.value;				
				}
			}else  if(inputs[i].name == "apagar")
			{
				inputs[i].onclick = function(){			

					document.getElementById("display").value = "";				
				}
			}
		}		
	}
	new exibeDisplay();
	
	function retornaDisplay()
	{		
		var display = document.getElementById("display").value;
		return display;
	}
	
	function limpaDisplay()
	{
		document.getElementById("display").value = "";
	}
	
	function bloqueiaCamposInput()
	{
		document.getElementById("display").onkeypress = function()
		{	
			return false;
		}
		document.getElementById("desconto").onkeypress = function()
		{	
			return false;
		}
		var inputs = document.getElementsByClassName("input");
		for(var i = 0; i < inputs.length; i++)
		{
			inputs[i].onkeypress = function()
			{		
				return false;				
			}
		}
	}
	new bloqueiaCamposInput();
	
	function exibeFormaPgto()
	{
		var inputs = document.getElementsByTagName("a");
		for(var i = 0; i < inputs.length; i++)
		{	
		
			if(inputs[i].name == "formAba[]")
			{
					
				var nomefield = inputs[i].id+"-field";
				if(inputs[i].className == "selecionada")
				{		
					$(nomefield).style.display = "";
					$("forma-pagamento").value = inputs[i].id;
				}else{
					$(nomefield).style.display = "none";
				}				
			}
		}
	}
	
	
	
	function trocaFormaPgto()
	{
		var inputs = document.getElementsByTagName("a");
		for(var i = 0; i < inputs.length; i++)
		{			
			if(inputs[i].name == "formAba[]")
			{
				inputs[i].onclick = function()
				{
					for(var j=0; j<inputs.length; j++)
					{
						if(inputs[j].name == "formAba[]")
						{
							inputs[j].className = inputs[j].className.substring(0, inputs[j].className.length - " selecionada".length);
							var nomefield = inputs[j].id+"-field";
							$(nomefield).style.display = "none";
						}
					}					
					
					var nomefield = this.id+"-field";	
					this.className += "selecionada"												
					$(nomefield).style.display = "";	
					$("forma-pagamento").value = this.id;
					
					if(this.id != 3)
					{
						$("valorpago").style.display = "none";
						$("saldo").style.display = "none";
					}else{
						$("valorpago").style.display = "";
						$("saldo").style.display = "";
					}
				}
			}
		}
	}
	new trocaFormaPgto();
	$("formaPagamento").style.display = "none";
	$("pagar").style.display = "none";
	
	$("submit-button").onclick = function(){
		
		if(totalatracoes == 0){
			alert("Você deverá inserir ao menos uma atração!");			
			return false;
		}else{
			$("pagar").style.display = "";
			$("formaPagamento").style.display = "";
			new exibeFormaPgto();									
			$("submit-button").style.display = "none";				
			return false;			
		}
	}
	$("pagamento-button").onclick = function()
	{			
		if(totalatracoes == 0){
			alert("Você deverá inserir ao menos uma atração!");			
			return false;
		}else if($("forma-pagamento").value == 3)///SE A FORMA FOR DINHEIRO, VERIFICA O VALOR PAGO///
		{
			var total = $("total-pagamento").value;
			total = total.replace(".","");						
			total = total.replace(/,/,".");		
			total = total*1;
			
			var valorpago = $("valor-pago").value;
			valorpago = valorpago.replace(".","");						
			valorpago = valorpago.replace(",",".");		
			valorpago = valorpago * 1;
			
			if(valorpago < total)
			{
				alert("Atenção!\nValor pago inferior ao valor total da venda.");
				return false;
			}
		}
	}
	$("fechar").onclick = function()
	{
		$("formaPagamento").style.display = "none";
		$("submit-button").style.display = "";
	}
	
	$("pagar").onclick = function(){
		
		if($("forma-pagamento").value == "")
		{
			alert("Clique em Pagamento para selecionar uma forma de pagamento.");
		}else{
			$("formaPagamento").style.display = "";
			///SE FORMA É DINHEIRO, CALCULA O TROCO///
			if($("forma-pagamento").value == 3)
			{
				var total = $("total-pagamento").value;
				total = total.replace(".","");						
				total = total.replace(/,/,".");		
				total = total*1;
				
				var valorpago = retornaDisplay();			
				/*valorpago = valorpago.replace(".","");						
				valorpago = valorpago.replace(",",".");	*/	
				valorpago = valorpago * 1;
				
				if(valorpago < total)
				{
					alert("Atenção!\nValor pago inferior ao valor total da venda.");
					
				}else{
					
					var troco = valorpago - total;					
					troco = troco.formatMoney();
					
					$("valor-pago").value = valorpago.formatMoney();
					$("troco").value = troco;
				}
				
			}
			limpaDisplay();
		}
		
	}
	$("ultimavenda").onclick = function(){
		var win2 = new Window({className: "alphacube", title: ".::Sistema Alpen Park::.", url: "./ajax/ultima-venda.php", 
							width:550, height:400, destroyOnClose: true, recenterAuto:false, top: 100, left: 120, minimizable: false, maximizable: false}); 
		win2.show();	
		
		/*Dialog.alert({url: "./ajax/ultima-venda.php", options: {method: 'get'}}, {className: "alphacube", width:540, height: 550, okLabel: "Fechar"});*/
	}
	
	$("cortesia-button").onclick = function()
	{
		if(totalatracoes == 0){
			alert("Você deverá inserir ao menos uma atração!");			
			return false;
		}else{
			var justificativa = prompt("Informe a justificativa:", "");
			if(justificativa)
			{
				$("justificativa-cortesia").value = justificativa;
				if(confirm("Confirmar o lançamento destes ingressos como cortesia?"))
				{
					document.forms[0].action = "insert-cortesias.php";
					document.forms[0].submit();
				}
			}
		}
	}
	
}// JavaScript Document