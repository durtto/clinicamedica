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
	
	/*Calendar.setup({
		inputField     :    "datareserva",     // id do campo de texto
		 ifFormat     :     "%d/%m/%Y",     // formato da data que se escreva no campo de texto
		 button     :    "lancador"     // o id do botão que lançará o calendário
	}); 	*/
	var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
    cal.manageFields("lancador", "datareserva", "%d/%m/%Y");
	  
	function updateFields(cal) {
              var date = cal.selection.get();
              if (date) {
                      date = Calendar.intToDate(date);
                      document.getElementById("datareserva").value = Calendar.printDate(date, "%d/%m/%Y");
					  
              }
            
      };
	
      Calendar.setup({
              cont         : "cont",
              showTime     : 0,
              onSelect     : updateFields,
              onTimeChange : updateFields,
			  min		   : new Date(), 
			  disabled: function(date) { // desabilita segundas e domingos
					if (date.getDay() == 0 || date.getDay() == 1) {
						return true;
					} else {
						return false;
					}
				}		  
      });
	  
	$("datareserva").onblur = function()
	{
		
		var paramDate = this.value.split("/");
		var date = new Date(paramDate[2], paramDate[1], paramDate[0]);
		if(date == "Invalid Date")
		{						
			/*
				Se for uma data inválida, processo para o auto-complete.
			*/
			var dataAtual = new Date();
			
			if(paramDate[0] == "" || paramDate[0] == null) {
				paramDate[0] = dataAtual.getDate();
			}
			
			paramDate[2] = dataAtual.getFullYear();
			
			//se o mês tiver vazio...
			if(paramDate[1] == "" || paramDate[1] == null) {
				if(paramDate[0] < dataAtual.getDate()) { //se o dia for maior que hoje...
					
					paramDate[1] = dataAtual.getMonth() + 2;
				}
				else {
					paramDate[1] = dataAtual.getMonth() + 1;
				}
			}
			else if(paramDate[1] < dataAtual.getMonth()) {
				paramDate[2]++;
			}
			
			//tento simplesmente substituir o ano digitado pelo ano atual
			var tentativa = new Date(paramDate[2], paramDate[1] - 1, paramDate[0]);
			if(tentativa == "Invalid Date") {
				
			}
			else {
				//deu certo!
				autoPreenche(tentativa, this);	
				
			}
		}		
	}	
	/*
		Auto preenche o campo passado com a data passada.
	*/
	var autoPreenche = function(data, campo) {
		campo.value = data.getDate() + "/" + (data.getMonth() + 1) + "/" + data.getFullYear();
	}
	
	
	var produtosExcluidos = Array();
	var turnoAtual = "null";
	var disponibilidade = 0;
	var http_request = false;	
	function makeRequest(url)
	{
	    http_request = false;
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');
                // See note below about this line
            }
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        http_request.onreadystatechange = alertContents;
        http_request.open('GET', url, true);
        http_request.send(null);
    }

    function alertContents() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {	
			
				var xmldoc = http_request.responseXML;
				disponibilidade = xmldoc.getElementsByTagName('valor').item(0);
				
				
				var fSet = document.createElement("fieldset");	
				fSet.setAttribute("id", "cepajax");
				
				if(disponibilidade.firstChild.data == 1)
				{
					fSet.innerHTML = "<label>&nbsp;<b>Disponível!</b></label>";
					fSet.innerHTML +="<input type='hidden' name='disponibilidade' value='"+disponibilidade.firstChild.data+"'>";							
					
				}else{
					fSet.innerHTML = "<label>&nbsp;<b>Não disponível!</b></label>";
					fSet.innerHTML +="<input type='hidden' name='disponibilidade' value='"+disponibilidade.firstChild.data+"'>";	
					
				}
				
				var cid = $('cepajax');
				if(cid != null)
				{     					
					//cid.parentNode.removeChild(cid);					
				}		
				$("disponibilidade").innerHTML = "";
				$("disponibilidade").appendChild(fSet);
				
						
            } else {
                alert('There was a problem with the request.');
            }
        }

    }	

	$("datareserva").onchange = function()
	{
		disponibilidade = 0;
	}
	$("turno").onchange = function()
	{
		disponibilidade = 0;
	}
	
		
	$("verificar").onclick = function()		
	{
						
		
		////PEGA O TURNO SELECIONADO ANTES DE ENTRAR NOS IF (SE DEIXAR PRA FAZER ISSO DEPOIS DÁ PAU NO IE)...
		/*var optAtual = $("turno").options[$("turno").selectedIndex];
		turnoAtual = optAtual.value;			
		if(turnoAtual == "null"){
			alert("Selecione um turno!");
			return false;
		}	*/
		
		
		var optAtual=document.getElementById("turno");
		turnoAtual = optAtual.selectedIndex;
		
		var paramDate = $("datareserva").value.split("/");
		var date = new Date(paramDate[2], paramDate[1], paramDate[0]);
		
		
		if($("datareserva").value == "" || $("datareserva").value == "undefined")
		{			
			if($("turno").value == "" || $("turno").value == "null")
			{
				alert("Informe uma data para reserva e selecione um turno!");
				$("datareserva").focus();
			}else{				
				alert("Informe uma data para reserva!");
				$("datareserva").focus();
			}
			
		}else if(paramDate[1] == 12 || paramDate[1] == 1 || paramDate[1] == 7)
		{
			alert("Nos meses de janeiro, julho e dezembro o programa de pacotes para estudantes não funciona.\n Por favor, selecione outro mês.");
			$("datareserva").focus();
		}else if($("turno").value = "" || $("turno").value == "null")
		{
			alert("Selecione um turno!");
			$("turno").focus();
			
		}else{
			
			///CHAMA A FUNÇÃO AJAX Q CHAMA O PHP Q VAI VERIFICAR A DISPONIBILIDADE...
			
			
			preLoadImg = new Image();
			preLoadImg.src = "./../_images/estrutura/loader.gif";
			$("disponibilidade").innerHTML = "<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='./../_images/estrutura/loader.gif'></center></table>";
			optAtual.options[turnoAtual].selected = true;
			//busco os dados...			
			makeRequest('ajax/disponibilidade.php?turno='+turnoAtual+'&data='+$("datareserva").value);		
			produtosExcluidos[turnoAtual] = optAtual;		
			return false;
		
		}
		
	}
	
	
	/*
		Ações do botão salvar...
	*/
	
	
	$("submit-button").onclick = function(){
		//faço a verificação se foi verificado a disponibilidade
		if(disponibilidade == 0){
			alert("Você deverá verificar a disponibilidade antes de registrar a reserva!");
			$("verificar").focus();
			return false;
		}else if(disponibilidade.firstChild.data == 0)
		{
			alert("Selecione uma data com período disponível para concluir sua reserva!");
			$("verificar").focus();
			return false;
			
		}else if($("numpessoas").value < 25 || $("numpessoas").value > 50)
		{
			alert("O número de pessoas não pode ser menor que 25 e maior que 50.");
			$("numpessoas").value = "";			
			$("numpessoas").focus();
			return false;
			
		}
	}

	
	
		
		
	
}// JavaScript Document