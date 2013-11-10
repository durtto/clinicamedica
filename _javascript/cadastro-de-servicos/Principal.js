main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){
	
	//--
	
	var inputs = $("form-servicos").getElementsByTagName("input");
	var tipoDeFornecedor = Array();
	
	var cont = 0;
	
	/*
	alert(inputs[i].value);
	
	tipoDeCliente = tipoDeCliente[0];
	var esconderTipo = "campos-" + tipoDeCliente.value;
		*/
	
	
	
	var dom = new DOM();	
	
	dom.addClass($("tipoNome"), "onsubmit:notnull");
	//dom.addClass($("tipoDescricao"), "onsubmit:notnull");
	dom.addClass($("tipoValor"), "onsubmit:notnull");	
	
	
	
	//--
	
	
	
	
	
}