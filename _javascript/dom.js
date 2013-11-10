function DOM(){

	/**
		Remove a classe passada do elemento.
	*/
	this.removeClass = function(element, className){
		var classes = element.className.split(" ");
		
		var nClass = "";
		for(var i = 0; i < classes.length; i++){
			if(classes[i] != className)
				nClass += " " + classes[i];
		}
		
		element.className = nClass;
	}
	
	/**
		Adiciona uma classe ao elemento.
	*/
	this.addClass = function(element, className){
		element.className += " " + className;
	}
}