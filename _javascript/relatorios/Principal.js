main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){
	
	/*Calendar.setup({
		inputField     :    "inicio",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "lancador"     // o id do botão que lançará o calendário
	}); */	
	
	/*
		Ações de escolha de situações.
	*/
	$("link-categorias").onclick = function() {
		$("categorias-box").style.visibility = "visible";
	}
	
	$("ok-categorias-box").onclick = function() {
		$("categorias-box").style.visibility = "hidden";
	}
	
}