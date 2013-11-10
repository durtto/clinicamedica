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
	//_________________________________________________//



	
	var inputs = document.getElementsByTagName("input");
	var ehparceiro, naoehparceiro;
	var cont = 0;
	for(var i = 0; i < inputs.length; i++){		
		if(inputs[i].getAttribute("type") == "radio" && inputs[i].getAttribute("name") == "ehparceiro")
		{					
			if(inputs[i].value == "s")	
			
				ehparceiro = inputs[i];
			else if(inputs[i].value == "n")
				naoehparceiro = inputs[i];				
		}
	}
	
	var dom = new DOM();
	var condicaoAtual;
	var condicoes = document.getElementsByName("ehparceiro");;
	for(i=0; i<condicoes.length; i++)
	{
		if(condicoes[i].checked)
		{
			condicaoAtual = condicoes[i].value;
		}
	}

	
	
	ehparceiro.onclick = function()
	{		
		if(this.checked){			
			$("comissao").value= "";			
		}
	}
	
	naoehparceiro.onclick = function()
	{			
		if(this.checked)
		{			
			$("comissao").value = "100,00";
		}
	}
	
		
	
	
}// JavaScript Document