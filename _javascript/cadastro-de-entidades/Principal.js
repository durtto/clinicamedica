$().ready(function() {		
	
	$("#cpf").css("display", "none");
	$("#cnpj").css("display", "none");
	
	$("#fisica").click(function(){									
        $("#cpf").css("display", "block"),
		$("#cnpj").css("display", "none"),		
		$("#cnpj").rules("remove", "required")		
    });	
	
    $("#juridica").click(function(){	  
         $("#cpf").css("display", "none"),
		 $("#cnpj").css("display", "block"),
		 $("#cpf").rules("remove", "required")
	});
	var boolValid = false;
	$(".radio").each(function() {
		if ( $(this).is(':checked') ) {
			boolValid = true;			
			if($(this).val() == "fisica")
			{				
				$("#cpf").css("display", "block");
				$("#cnpj").css("display", "none");
			}else{			
				$("#cpf").css("display", "none");
				$("#cnpj").css("display", "block");
			}
		}
	});
	/*if($("#fisica").is(':checked')
	{
		alert('teste');
		$("#cpf").css("display", "block");
		$("#cnpj").css("display", "none");
    }
	$("#juridica").is(':checked'){
		alert('teste');
		$("#cpf").css("display", "none");
		$("#cnpj").css("display", "block");
    }*/
	
	
	
	$("#adicionar-contato").click(function()
	{
		$.get('ajax/contatos.php', function(data) {
		  $('#contatos-dinamicos').append(data);	
		  new eventoOnClickExcluir();
		  //new Validator();
		  
		  ///APLICA AS MÁSCARAS PARA OS CAMPOS DINÂMICOS SEPARADAMENTE PARA EVITAR PROBLEMAS COM OS CAMPOS QUE CARREGADOS ANTERIORMENTE///
		  $('.fone').setMask('(99) 9999 9999');
		  
		  return false;
		});
	});
	function eventoOnClickExcluir()
	{
		var bts = document.getElementsByClassName("excluir-contato-dinamico");
		
		for(var i = 0; i < bts.length; i++){
			bts[i].onclick = function(){
				//var valueAux = this.getAttribute("id").substring("botao-excluir-".length);

				var caixas = document.getElementsByClassName("caixa-setor");
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
	
	new eventoOnClickExcluir();
	
	
	
	
	
});
