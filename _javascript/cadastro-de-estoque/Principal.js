main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
	
}

function Principal(){
	
	/////FORMATA O VALOR EM MOEDA//////
	Number.prototype.formatMoney = function(c, d, t){
    var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t)
    + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
	
	var inputs = document.getElementsByTagName("input");	
	
	for(var i = 0; i < inputs.length; i++)
	{	
		if(inputs[i].id == "imprimir-estoque"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:")
					{												
							window.open(classes[j].substring("action:".length));																			
					}
				}				
			}
		}
		if(inputs[i].id == "imprimir-financeiro"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:")
					{												
							window.open(classes[j].substring("action:".length));																			
					}
				}				
			}
		}
		if(inputs[i].id == "imprimir-pedidos"){				
			inputs[i].onclick = function()
			{				
				var classes = this.className.split(" ");
				for(var j = 0; j < classes.length; j++){
					if(classes[j].substring(0, "action:".length) == "action:")
					{												
							window.open(classes[j].substring("action:".length));																			
					}
				}				
			}
		}
	}
	

	function valorVenda()
	{
		for(var i = 0; i < inputs.length; i++)
		{	
		    if(inputs[i].name == "margem")
			{
				inputs[i].onkeyup = function()
				{
					
					var margem = document.getElementById("margem");
					var valorcompra = document.getElementById("vcompra");
					
					
					var aux;
					aux = valorcompra.value;					
					aux = aux.replace(".","");						
					aux = aux.replace(/,/,".");	
					aux = aux*1;
					
					var aux2;
					aux2 = margem.value;
					
					aux2 = aux2.replace(".","");						
					aux2 = aux2.replace(/,/,".");	
					aux2 = aux2*1;
					
					valor = aux + (aux * (aux2/100));					
					
					var valorVenda = document.getElementById("vvenda");
					valor = valor.formatMoney();
					valorVenda.value = valor;
					
				}
			}
			
		}
	}
	
	new valorVenda();
	
	function valorMargem()
	{
		for(var i = 0; i < inputs.length; i++)
		{
			if(inputs[i].name == "vvenda")
			{
				inputs[i].onkeyup = function()
				{
					
					var valorvenda = document.getElementById("vvenda");
					var valorcompra = document.getElementById("vcompra");
					
					
					var aux;
					aux = valorcompra.value;
					aux = aux.replace(".","");						
					aux = aux.replace(/,/,".");	
					aux = aux*1;
					
					var aux2;
					aux2 = valorvenda.value;
					aux2 = aux2.replace(".","");						
					aux2 = aux2.replace(/,/,".");	
					aux2 = aux2*1;
					
					valor = ((aux2 / aux) - 1) * 100;					
					
					var margem = document.getElementById("margem");
					valor = valor.formatMoney();
					margem.value = valor;
					
				}
			}
		}
	}
	new valorMargem();

}// JavaScript Document