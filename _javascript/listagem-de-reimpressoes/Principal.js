main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();	
}

function Principal()
{
	
	Calendar.setup({
		inputField     :    "data",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "lancador"     // o id do botão que lançará o calendário
	}); 	
}// JavaScript Document