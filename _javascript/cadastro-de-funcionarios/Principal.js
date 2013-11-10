main.addFunction("initPrincipal()");

var principal;
var validator;
function initPrincipal(){
	principal = new Principal();
	//validator = new Validator();
}

function Principal(){
	
	new CombosEnderecoDinamico("endCep", "paiPais", "estEstado", "estNome", "cidCidade");
	new CombosEnderecoDinamico("endCobrancaCep", "paiCobrancaPais", "estCobrancaEstado", "estCobrancaNome", "cidCobrancaCidade");
	
	
	
	$("enderecoPadraoAba").className += " selecionada"; 
	$("enderecoCobranca").style.display = "none";

	//--
	
	$("enderecoPadraoAba").onclick = function(){
		$("enderecoPadrao").style.display = "";
		$("enderecoCobranca").style.display = "none";
		$("enderecoCobrancaAba").className = $("enderecoCobrancaAba").className.substring(0, $("enderecoCobrancaAba").className.length - " selecionada".length);
		this.className += " selecionada";
	}
	
	
	$("enderecoCobrancaAba").onclick = function(){
		$("enderecoPadrao").style.display = "none";
		$("enderecoCobranca").style.display = "";
		$("enderecoPadraoAba").className = $("enderecoPadraoAba").className.substring(0, $("enderecoPadraoAba").className.length - " selecionada".length);
		this.className += " selecionada";
	
}

/* _______________________________________________________________________________*/


	
/// função chamada através de onBLur(), carrega via ajax endereço pelo cep
   function getEndereco() {
			// Se o campo CEP não estiver vazio
			if($.trim($("#endCep").val()) != ""){
				/* 
					Para conectar no serviço e executar o json, precisamos usar a função
					getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
					dataTypes não possibilitam esta interação entre domínios diferentes
					Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
					http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
				*/
				$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
					// o getScript dá um eval no script, então é só ler!
					//Se o resultado for igual a 1
			  		if(resultadoCEP["resultado"]){
						// troca o valor dos elementos
						$("#endLogradouro").val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));
						$("#endBairro").val(unescape(resultadoCEP["bairro"]));
						$("#cidCidade").val(unescape(resultadoCEP["cidade"]));
						$("#estEstado").val(unescape(resultadoCEP["uf"]));
					}else{
						alert("Endereço não encontrado");
					}
				});				
			}			
	}
}