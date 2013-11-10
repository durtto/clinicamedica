/*$.validator.setDefaults({
	submitHandler: function() { alert("submitted!"); }
});*/

(function($){
	// call setMask function on the document.ready event
	  $(function(){
		$('input:text').setMask();		
		}
	);
  })(jQuery);

$().ready(function() {		
	
	// validate signup form on keyup and submit
	$(".form-auto-validated").validate({
		rules: {
			nome: "required",
			pesNome: "required",
			'nome[]': "required",
			//'cargo[]': "required",
			pesjRazaosocial: "required",	
			tipodeentidade: "required",
			logradouro: "required",
			/*bairro: "required",*/
			numero: "required",
			'edicao[]': "required",
			cep: {
				required: true,
				minlength: 8
			},
			///conComercial: "required",
			pesfCpf: {
				required: false,
				minlength: 11
				
			},
			pesCnpj: {
				required: false,
				minlength: 14,
				
			},
			usuario: {
				required: true,
				minlength: 2
			},
			senha: {
				required: true,
				minlength: 5
			},
			confirma_senha: {
				required: true,
				minlength: 5,
				equalTo: "#senha"
			},
			/*email: {								
				email: true
			},
			'emailcontato[]':{
				email: true
			}*/
			/*topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			agree: "required"*/
		},
		messages: {
			nome: "Por favor, insira o nome",
			pesNome: "Por favor, insira o nome",
			//'cargo[]': "Por favor, informe o cargo",
			'nome[]': "Por favor, insira o nome",
			'edicao[]': "Por favor, informe a edição",
			pesjRazaosocial: "Por favor, insira a razão social",
			tipodeentidade: "Por favor, selecione o tipo de entidade",
			//conComercial: "Por favor, informe o telefone",
			logradouro: "Por favor, informe o endereço",		
			/*bairro: "Por favor, informe o bairro",*/		
			numero: "Por favor, informe o número",
			cep: {
				required: "Por favor, informe o CEP",
				minlength: "Insira os 8 dígitos do CEP"
			},
			pesfCpf: {
					required: "Informe o CPF",
					minlength: "Insira os 11 dígitos do CPF"
				},
			pesCnpj: {
					required: "Informe o CNPJ",
					minlength: "Insira os 14 dígitos do CNPJ"
				},
			usuario: {
				required: "Por favor, insira o usuário",
				minlength: "Seu usuário deve conter no mínimo 4 caracteres"
			},
			senha: {
				required: "Por favor, informe a senha",
				minlength: "Sua senha deve conter no mínimo 4 caracteres"
			},
			confirma_senha: {
				required: "Por favor, informe a senha",
				minlength: "Sua senha deve conter no mínimo 4 caracteres",
				equalTo: "Por favor, informe a mesma senha anterior"
			}
			/*,
			email: "Informe um email válido",
			'emailcontato[]': "Informe um email válido"*/
			/*agree: "Please accept our policy"*/
		}
	});

	// propose username by combining first- and lastname
	/*$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});*/

	//code to hide topic selection, disable for demo
	var endereco = $("#cadastrarendereco");
	// newsletter topics are optional, hide at first
	var inital = endereco.is(":checked");
	var topics = $("#topicosendereco")[inital ? "removeClass" : "addClass"]("gray");
	var topicInputs = topics.find("input").attr("disabled", !inital);
	// show when newsletter is checked
	endereco.click(function() {
		topics[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs.attr("disabled", !this.checked);
	});
	
	var realpath = "/clinica-sao-jose/";
	$("#cep").keyup(function(){		
		
		var value = $("#cep").val();
		if(value.length == 8){	
			
			$("#cep").blur();
			preLoadImg = new Image();
			preLoadImg.src = realpath+"_images/estrutura/loader.gif";
			$("#cid-estado").html("<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='./../_images/estrutura/loader.gif'></center></table>");
			//busco os dados...
			//makeRequest('./../componentes/cep.php?cep='+value, 1);
			$.get(realpath+'componentes/cep.php?cep='+value, function(data){
				$('#cid-estado').html("<fieldset id='cepajax'>");
				$('#cid-estado').append(data);	
			});
			
		}		
	});	
	
	
	var value = $("#cep").val();
	if(typeof value !== "undefined")
	{			
		if(value.length == 8){
			preLoadImg = new Image();
			preLoadImg.src = realpath+"_images/estrutura/loader.gif";
			$("#cid-estado").html("<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='./../_images/estrutura/loader.gif'></center></table>)");
			//busco os dados...
			//makeRequest('./../componentes/cep.php?cep='+value, 1);
			$.get(realpath+'componentes/cep.php?cep='+value, function(data){
					$('#cid-estado').html("<fieldset id='cepajax'>");
					$('#cid-estado').append(data);	
			});
		}
	} 
	
});		










