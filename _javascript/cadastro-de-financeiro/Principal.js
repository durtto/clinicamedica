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
	
	Calendar.setup({
		inputField     :    "datapagamento",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "lancador"     // o id do botão que lançará o calendário
	}); 	
	
	Calendar.setup({
		inputField     :    "datavencimento",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "launcher"     // o id do botão que lançará o calendário
	}); 	
	
	
	function calculaSaldo()
	{
		$("valorparcela").onkeyup = function()
		{			
			var valorpago = $("valorparcela").value;
			valorpago = valorpago.replace(".","");						
			valorpago = valorpago.replace(/,/,".");	
			valorpago = valorpago*1;
			
			var total = $("total").value;
			total = total.replace(".","");						
			total = total.replace(/,/,".");	
			total = total*1;
			
			var saldo = valorpago - total;
			
			$("saldo").value = saldo;
			saldo = saldo.formatMoney();
			$("exibe-saldo").innerHTML = "<h4>Saldo: R$ "+saldo+"</h4>";
			
		}
	}
	
	new calculaSaldo();
}