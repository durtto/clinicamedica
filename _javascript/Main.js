/**
	Classe principal do sistema.
	Único arquivo contendo um window.onload().
	Deverá ser importando por todas as páginas do sistema.
*/

var main = new Main(); //objeto principal, ao qual deverão ser adicionadas as funções

//objeto principal
function Main(){
	var funcoes; //lista de funções a serem executadas
	var cont;
	
	//"construtor"
	this.init = function(){
		funcoes = Array();
		cont = 0;
	}

	
	//adiciona uma função à lista de execução
	this.addFunction = function(nome){
		funcoes[cont] = nome;
		cont++;
	}
	
	//executa as tarefas
	this.execute = function(){
		for(var i = 0; i < funcoes.length; i++){
//			alert(funcoes[i]);
			eval(funcoes[i]);
		}
	}
	
	//processamento...
	this.init();
}


/**
	 _________________________
	|                         |
	| Método main dos scripts |
	|_________________________|
*/
window.onload = function(){
	main.execute(); //somente chama todas as funções carregadas para execução
}