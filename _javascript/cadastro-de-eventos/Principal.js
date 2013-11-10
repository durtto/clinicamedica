$().ready(function() {	
	
//	function fancy()
//	{
//		var inputs = document.getElementsByClassName("visualizar");
//		for(var i = 0; i < inputs.length; i++){
//			inputs[i].click(function(){
//				$(".fancyAjax"+i).fancybox();
//			});
//		}
//	}
//	new fancy();
	/*$(".fancyAjax").fancybox({
		'autoScale' :false 
	});*/
	
	var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
    cal.manageFields("datainicio", "datainicio", "%d/%m/%Y");
	
	cal.manageFields("launchmontagem", "datamontagem", "%d/%m/%Y");
	
	cal.manageFields("launchdesmontagem", "datadesmontagem", "%d/%m/%Y");
	
	cal.manageFields("datatermino", "datatermino", "%d/%m/%Y");
	
	cal.manageFields("dataconfirmacaocaptacao", "dataconfirmacaocaptacao", "%d/%m/%Y");
	
	cal.manageFields("launchpesquisa", "datapesquisa", "%d/%m/%Y");
	
	
	
	$("#adicionar-ultimaedicao").click(function()
	{
		$.get('ajax/ultimas-edicoes.php', function(data) {
		  $('#edicoes-dinamicos').append(data);	
		  new edicoesOnClickExcluir();
		  //new Validator();
		  ///APLICA AS MÁSCARAS PARA OS CAMPOS DINÂMICOS SEPARADAMENTE PARA EVITAR PROBLEMAS COM OS CAMPOS QUE CARREGADOS ANTERIORMENTE///
		  $('.fone').setMask('(99) 9999 9999');
		  $('.data-mask').setMask('99/99/9999');
		});
	});
	function edicoesOnClickExcluir()
	{
		var bts = document.getElementsByClassName("excluir-edicao-dinamico");
		
		for(var i = 0; i < bts.length; i++){
			
			bts[i].onclick = function(){
				//var valueAux = this.getAttribute("id").substring("botao-excluir-".length);

				var caixas = document.getElementsByClassName("caixa-edicao");
				
				var parentN = caixas[i];				
				parentN = this.parentNode;
				parentN = parentN.parentNode;
				/*while(parentN.class != ("caixa-setor-" + valueAux)){
					parentN = parentN.parentNode;
				}*/
				//alert(parentN);
				parentN.parentNode.removeChild(parentN);
				return false;
			}
		}
	}
	
	new edicoesOnClickExcluir();
	
	$("#adicionar-eventosparalelos").click(function()
	{
		$.get('ajax/eventos-paralelos.php', function(data) {
		  $('#eventos-dinamicos').append(data);	
		  new eventosOnClickExcluir();
		  //new Validator();
		  ///APLICA AS MÁSCARAS PARA OS CAMPOS DINÂMICOS SEPARADAMENTE PARA EVITAR PROBLEMAS COM OS CAMPOS QUE CARREGADOS ANTERIORMENTE///
		  $('.fone').setMask('(99) 9999 9999');
		  $('.data-mask').setMask('99/99/9999');
		});
	});
	function eventosOnClickExcluir()
	{
		var bts = document.getElementsByClassName("excluir-evento-dinamico");
		
		for(var i = 0; i < bts.length; i++){
			bts[i].onclick = function(){
				//var valueAux = this.getAttribute("id").substring("botao-excluir-".length);

				var caixas = document.getElementsByClassName("caixa-eventosparalelos");
				var parentN = caixas[i];				
				parentN = this.parentNode;
				parentN = parentN.parentNode;
				/*while(parentN.class != ("caixa-setor-" + valueAux)){
					parentN = parentN.parentNode;
				}*/
				//alert(parentN);
				parentN.parentNode.removeChild(parentN);
				return false;
			}
		}
	}
	
	new eventosOnClickExcluir();
	
	
	$("#adicionar-reuniao").click(function()
	{		
		$.get('ajax/reunioes.php', function(data) {
		  $('#reunioes-dinamicos').append(data);	
		  new reunioesOnClickExcluir();
		  //new Validator();
		  ///APLICA AS MÁSCARAS PARA OS CAMPOS DINÂMICOS SEPARADAMENTE PARA EVITAR PROBLEMAS COM OS CAMPOS QUE CARREGADOS ANTERIORMENTE///
		  $('.fone').setMask('(99) 9999 9999');
		  $('.data-mask').setMask('99/99/9999');
		});
	});
	
	function reunioesOnClickExcluir()
	{
		var bts = document.getElementsByClassName("excluir-reuniao-dinamico");
		
		for(var i = 0; i < bts.length; i++){
			bts[i].onclick = function(){
				//var valueAux = this.getAttribute("id").substring("botao-excluir-".length);

				var caixas = document.getElementsByClassName("caixa-reuniao");
				var parentN = caixas[i];				
				parentN = this.parentNode;
				parentN = parentN.parentNode;
				/*while(parentN.class != ("caixa-setor-" + valueAux)){
					parentN = parentN.parentNode;
				}*/
				//alert(parentN);
				parentN.parentNode.removeChild(parentN);
				return false;
			}
		}
	}	
	new reunioesOnClickExcluir();
	
	
	$("#adicionar-visitas").click(function()
	{
		$.get('ajax/visitas-inspecao.php', function(data) {
		  $('#visitas-dinamicos').append(data);	
		  new visitasOnClickExcluir();
		  //new Validator();
		  ///APLICA AS MÁSCARAS PARA OS CAMPOS DINÂMICOS SEPARADAMENTE PARA EVITAR PROBLEMAS COM OS CAMPOS QUE CARREGADOS ANTERIORMENTE///
		  $('.fone').setMask('(99) 9999 9999');
		  $('.data-mask').setMask('99/99/9999');
		});
	});
	function visitasOnClickExcluir()
	{
		var bts = document.getElementsByClassName("excluir-visita-dinamico");
		
		for(var i = 0; i < bts.length; i++){
			bts[i].onclick = function(){
				//var valueAux = this.getAttribute("id").substring("botao-excluir-".length);

				var caixas = document.getElementsByClassName("caixa-visita");
				var parentN = caixas[i];				
				parentN = this.parentNode;
				parentN = parentN.parentNode;
				/*while(parentN.class != ("caixa-setor-" + valueAux)){
					parentN = parentN.parentNode;
				}*/
				//alert(parentN);
				parentN.parentNode.removeChild(parentN);
				return false;
			}
		}
	}
	
	new visitasOnClickExcluir();
	
	$("#tipodeentidade-promotora").change(function()
	{
		 var optAtual = "";
          $("#tipodeentidade-promotora option:selected").each(function () {
                optAtual = $(this).val();
          });
		
		preLoadImg = new Image();
		preLoadImg.src = "../_images/estrutura/loader.gif";
		$("#entidades-promotoras").html("<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='../_images/estrutura/loader.gif'></center></table>");
		//busco os dados...
		$.get('ajax/tipo-entidades.php?entidade=promotora&tipoentidade='+optAtual, function(data) {
	     	$('#entidades-promotoras').html("");
			$('#entidades-promotoras').append(data);			
	  });
		
	});	
		
	$("#adicionar-entidade").click(function()
	{		
		//alert('teste');
		var entidadeAtual = "";
		$("#entidadepromotora option:selected").each(function () {
			entidadeAtual = $(this).val();
		});

		if(entidadeAtual != "undefined" && entidadeAtual != 'null')
		{
			$.ajax({
				type: "GET",
				url: "ajax/entidades.php",
				data: "cod="+entidadeAtual,
				success: function(xml) {
					$(xml).find('entidade').each(function(){
						var cod = $(this).find('cod').text();
						var razaosocial = $(this).find('razaosocial').text();
						var nome = $(this).find('nome').text();
						var tipoentidade = $(this).find('tipoentidade').text();
						//$('<div class="items" id="link_'+id+'"></div>').html('<a href="'+url+'">'+title+'</a>').appendTo('#page-wrap');	
						
						table1 = document.getElementById("tabela");
						var linha = table1.insertRow(1);
						//Inserção de Celulas
						var coluna1 = linha.insertCell(-1);
						//Definindo o estilo para a célula
						coluna1.className = "par";
						//Definindo o conteúdo para a célula
						coluna1.innerHTML = "<input name='entidade[]' value='"+cod+"' class='checkbox to_check_checkAll' type='checkbox'><input name='entidade_[]' value='"+cod+"' type='hidden'>";	
						
						coluna1 = linha.insertCell(-1);
						coluna1.className = "col-2";							
						coluna1.innerHTML = nome;
						
						coluna1 = linha.insertCell(-1);
						coluna1.className = "col-2";							
						coluna1.innerHTML = tipoentidade;	
						
						coluna1 = linha.insertCell(-1);
						coluna1.className = "grid-action";
						coluna1.innerHTML = "<a class='ajax/exibir-dados-entidade.php?cod="+cod+"' id='visualizar' title='visualizar dados'></a>";
						//alert(nome);
						new visualizar();
					});
				}
			});
		}else{
			alert("Nenhuma entidade foi selecionada para ser inserida.");	
		}
	});
	
	
	///FUNÇÃO DANDO PAU////
	function visualizar()	
	{
		
		var inputs = document.getElementsByTagName("a");
		for(var i = 0; i < inputs.length; i++)
		{	
		    if(inputs[i].id == "visualizar")
			{		    	
				inputs[i].onclick = function() {					
					
					//$.colorbox({href:this.className});
					window.open(this.className, "_blank", "location=no, menubar=no, scrollbars=yes, width=1024");
				}
			}
		}
	}
	new visualizar();
	
	$("#excluir-entidade").click(function()
	{
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length; i++)
		{	
		    if(inputs[i].name == "entidade[]")
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
			var table1 = document.getElementById("tabela");
			//objTable.deleteRow(indexTR);
			table1.deleteRow(indexTR);		
	 } 
	
	
	$(".delete").click(function()
	{		
		if(confirm("Você tem certeza?"))
		{	
			document.getElementById("deletar").value = $(this).attr("id");
			document.forms[0].submit();
		}				
	});
	
	$(".bloquear").click(function()
	{		
		preLoadImg = new Image();
		preLoadImg.src = "../_images/estrutura/loader.gif";
		$("#bloqueio").html("<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='../_images/estrutura/loader.gif'></center></table>");
		
		var action = $(this).attr("id");
		
		//busco os dados...
		$.ajax({
			type: "GET",
			url: "ajax/bloquear-eventos.php",
			data: "action="+action+"&cod="+$("#cod").val(),
			success: function(xml) {
				$(xml).find('bloqueio').each(function(){
					var valor = $(this).find('valor').text();
					var mensagem = $(this).find('retorno').text();
					$('#bloqueio').html("");
					
					if(valor == '1')
					{
						$('.bloquear').val("Bloqueado: Liberar Evento");
						$('.bloquear').attr("id", '0');
					}else if(valor == '0'){
						$('.bloquear').val("Liberado: Bloquear Evento");
						$('.bloquear').attr("id", '1');
					}
					alert(mensagem);
					//alert(valor);
				});
			}
		});
	});
	

});