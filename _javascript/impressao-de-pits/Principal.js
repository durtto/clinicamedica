main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){
	$("cancelar-impressao").onclick = function(){
		if(confirm("Realmente deseja cancelar a impressão?"))
			window.close();
	}
	
	/*
		Botão de impressão.
	*/
	var imprimirButton = document.getElementsByClassName("bt org-grid");
	imprimirButton = imprimirButton[0];
	imprimirButton.onclick = function(){
		var parentGrid = this.parentNode;
			
		while(parentGrid.nodeName != "FORM"){
			parentGrid = parentGrid.parentNode;
		}
		
		var checkToCheck = parentGrid.getElementsByClassName("to_check_checkAll");
		var contChecked = 0;
		for(var k = 0; k < checkToCheck.length; k++){
			if(checkToCheck[k].checked){
				contChecked++;
			}
		}
		
		if(contChecked < 1){
			alert("Selecione ao menos um setor para ser impresso!");
			return false;
		}
	}
}