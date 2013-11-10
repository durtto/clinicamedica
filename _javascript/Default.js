main.addFunction("initDefault()");

var def;
function initDefault(){
	def = new Default();
} 

function Default(){
	new GridComponent(); //observa as grids
	new ConfirmacaoResets();
	//new EnterToTab();
	new AddExcluirConfirmations();
	//new Validator();
}

function ConfirmacaoResets(){
	var inputs = document.getElementsByTagName("input");
	var resets = Array();
	
	var contRes = 0;
	for(var i = 0; i < inputs.length; i++){
		if(inputs[i].type == "reset"){
			resets[contRes++] = inputs[i];
			
			inputs[i].onclick = function(){
				if(!confirm("Tem certeza que deseja cancelar?")){
					return false;
				}
				else{
					var classes = this.className.split(" ");
					for(var j = 0; j < classes.length; j++){
						if(classes[j].substring(0, "action:".length) == "action:"){
							window.location.href = classes[j].substring("action:".length);
							break;
						}
					}
				}
			}
		}		
	}
}

function EnterToTab(){
	var inputs = document.getElementsByTagName("input");
	for(var i = 0; i < inputs.length; i++){
		var aux = inputs[i];
		if(aux.type == "text"){
			aux.onkeypress = function(ev){
				if(ev.keyCode == 13 || ev.keyCode == 10){					
					return false;
				}
			}
		}
	}
}

//adiciona confirmações de exclusão a todos os botões com esta finalidade
function AddExcluirConfirmations(){
	var botoes = document.getElementsByClassName("excluir");
	
	for(var i = 0; i < botoes.length; i++){
		botoes[i].onclick = function(){
			if(!confirm("Você tem certeza?"))
				return false;
		}
	}
}