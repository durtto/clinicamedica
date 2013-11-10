/**
 * Adiciona funcionalidades ao grid.
 * @author Lauro Becker - lauro.becker@gmail.com
 */
var org_grid_checkAll = Array();
function GridComponent(){
	var grids = document.getElementsByClassName("org_grid", document); //todas as grids do documento
	var excluirSubmit;
	
	//-- PASSO TODAS AS GRIDS DO DOCUMENTO
	for(var i = 0; i < grids.length; i++){
		var grid = grids[i];
		
		//-- FUNÇÕES DE SELEÇÃO MÚLTIPLA, POR CHECKALL
		var checkAll = grid.getElementsByTagName("input");
		for(var j = 0; j < checkAll.length; j++){
			if(checkAll[j].getAttribute("type") == "checkbox" && checkAll[j].getAttribute("name") == "checkAll_grid"){
				checkAll = checkAll[j];
				break;
			}
		}
		
		checkAll.onclick = function(){

			org_grid_checkAll[this.getAttribute("value")] = !org_grid_checkAll[this.getAttribute("value")];
			
			var checkAllBool = org_grid_checkAll[this.getAttribute("value")];
			
			var parentGrid = this.parentNode;
			
			while(parentGrid.nodeName != "FORM"){
				parentGrid = parentGrid.parentNode;
			}
			
			var checkToCheck = parentGrid.getElementsByClassName("to_check_checkAll");
		
			for(var k = 0; k < checkToCheck.length; k++){
				checkToCheck[k].checked = checkAllBool;
			}
		}
		
		//-- AÇÕES DE EXCLUIR TODOS
		///DANDO PAU///
		/*excluirSubmit = grid.getElementsByClassName("org_grid_excluir_submit",grid);
		excluirSubmit = excluirSubmit[0];
		alert(excluirSubmit);
		if(excluirSubmit){
			excluirSubmit.onclick = function(){
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
					alert("Selecione ao menos um registro para ser excluído!");
					return false;
				}
				else{
					var mensagem;
					
					if(contChecked == 1){
						mensagem = "Você realmente deseja excluir o registro selecionado?";
					}
					else{
						mensagem = "Você realmente deseja excluir os registros selecionados?";
					}
					
					if(confirm(mensagem)){
						return true; //submete o formulário...
					}
					else{
						return false;
					}
				}
			}
		}*/
		
		//-- SELEÇÃO ÚNICA (quando clicar sobre a linha do registro...) dando pau tb...
		
		/*var tBody = grid.getElementsByTagName("tbody");
		tBody = tBody[0];
		if(tBody){
			var gridRegs = tBody.getElementsByTagName("tr");
			
			for(var l = 0; l < gridRegs.length; l++){
				var reg = gridRegs[l];
				
				reg.onclick = function(){
					
					var checkThisReg = this.getElementsByClassName("to_check_checkAll", this);
					checkThisReg = checkThisReg[0];
					
					if(checkThisReg)
						checkThisReg.checked = !checkThisReg.checked;
				}
			}
			
			//... tenho que remover a ação de check do próprio input... pois o da linha entra em conflito
			var checkToCheck = tBody.getElementsByClassName("to_check_checkAll");
			for(var l = 0; l < checkToCheck.length; l++){
				checkToCheck[l].onclick = function(){
					this.checked = !this.checked;
				}
			}
		}
		
		//-- AÇÕES GERAIS --
		//--	"DELEÇÃO"
		var delActions = tBody.getElementsByClassName("org_action_delete");
		for(var m = 0; m < delActions.length; m++){
			delActions[m].onclick = function(){
				if(!(confirm("Tem certeza que deseja eliminar este registro?"))){
					return false;
				}
			}
		}
		
		*/
		
	}
}