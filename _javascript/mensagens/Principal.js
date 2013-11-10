main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){

	
	///MÉTODO QUE CHAMA O PHP POR AJAX E EXIBE AS MENSAGENS ENTRE OS USUÁRIOS///
	exibeMensagens = function(){			
		//alert('teste');
		//busco os dados...
		var to = "";
        $("#user option:selected").each(function () {
              to = $(this).val();
        });
		if(to == "null")
		{
			//makeRequest('ajax/view-all-msgs.php', 2);
			/*$('#entidades-promotoras').html("");
			$('#entidades-promotoras').append(data);*/	
			$.get('ajax/view-all-msgs.php', function(data) {			
				///LIMPA O CAMPO DAS MENSAGENS E EXIBE O RETORNO DO AJAX COM AS MENSAGENS ATUAIS///
				$("#mensagens").html("");
				$("#mensagens").append(data);	
		  });
			
			
		}else{
			//makeRequest('ajax/view-msgs.php?tofrom='+to.value, 2);
			$.get('ajax/view-msgs.php?tofrom='+to, function(data) {			
				///LIMPA O CAMPO DAS MENSAGENS E EXIBE O RETORNO DO AJAX COM AS MENSAGENS ATUAIS///
				$("#mensagens").html("");
				$("#mensagens").append(data);
		  });
		}
			
	}
	
	
	
	///ENVIA UMA MENSAGEM POR AJAX AO CLICAR NO BOTÃO ENVIAR///
	this.enviaMensagem = function(){
		var inputs = document.getElementsByTagName("input");
		
		for(var i = 0; i < inputs.length; i++){
			if(inputs[i].id == "enviar")
			{				
				inputs[i].onclick = function(){
					
					var to = "";
			        $("#user option:selected").each(function () {
			              to = $(this).val();
			        });
					var from = document.getElementById("from");
					var msg = document.getElementById("mensagem");
					if(to.value != "null" && msg.value != "")
					{
						//makeRequest('ajax/insert-msg.php?to='+to.value+'&from='+from.value+'&msg='+msg.value, 1);		
						$.get('ajax/insert-msg.php?to='+to+'&from='+from.value+'&msg='+msg.value, function(data) {
							///TODA VEZ QUE INSERE MENSAGEM CHAMA MÉTODO EXIBE MENSAGENS///
							exibeMensagens();	
						});						
						
						///limpa o campo das mensagens
						document.getElementById("mensagem").value = "";
					}					
				}
			}
		}
	}
	this.enviaMensagem();
	
	
	var localizacao = location.href.slice(-8);
	
	//alert(localizacao);
	function Timer() {    
		setInterval("exibeMensagens()", 300000);    
	}
	
	Timer();		
	exibeMensagens();
	this.enterParaEnviar = function()
	{		
		var inputs = document.getElementsByTagName("textarea");
		for(var i = 0; i < inputs.length; i++){
			if(inputs[i].id == "mensagem")
			{				
				inputs[i].onkeypress = function(e)
				{
					
					if(e.keyCode ==13)
					{						
						var to = "";
				        $("#user option:selected").each(function () {
				              to = $(this).val();
				        });
						var from = document.getElementById("from");
						var msg = document.getElementById("mensagem");
						//alert(msg.value);
						if(to.value != "null" && msg.value != "")
						{							
							//makeRequest('ajax/insert-msg.php?to='+to.value+'&from='+from.value+'&msg='+msg.value, 1);
							$.get('ajax/insert-msg.php?to='+to+'&from='+from.value+'&msg='+msg.value, function(data) {			
								exibeMensagens();
							});
							///TODA VEZ QUE INSERE MENSAGEM CHAMA MÉTODO EXIBE MENSAGENS///							
							
							///limpa o campo das mensagens
							document.getElementById("mensagem").value = "";
						}
					}					
				}
			}
		}
	}
	this.enterParaEnviar();
	
	$(".excluir-mensagem").click(function()
	{		
		var inputs = document.getElementsByTagName("input");
		for(var i = 0; i < inputs.length; i++)
		{	
		    if(inputs[i].name == "codigo[]")
			{
				if(inputs[i].checked)
				{
					var codigo = inputs[i].value;
					
					if(confirm("Você tem certeza?"))
					{	
						$.get('ajax/delete-msg.php?cod='+codigo, function(data) {			
							exibeMensagens();							
						});
						
					}	
				}
			}
		}
	});
	$("#user").change(function()
	{
		exibeMensagens();		
	});
	$("#atualizar").click(function()
	{
		exibeMensagens();		
	});
	
}