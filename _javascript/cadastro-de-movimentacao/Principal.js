main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();	
}

function Principal()
{
	
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
	
	//$("opcao_salario").style.visibility = "hidden";	
	
	this.opcoes_salario = function()
	{		
		var inputs = document.getElementsByName("salariousuario");
		for(var i = 0; i < inputs.length; i++){
			inputs[i].onchange = function(){
				var valorAtual = this.options[this.selectedIndex];		
				
				if(valorAtual.value > 0)
				{
					$("opcao_salario").style.visibility = "visible";
					
				}else{					
					
					$("opcao_salario").style.visibility = "hidden";				
					
				}
				
			}
		}
	}
	//this.opcoes_salario();
	
	var http_request = false;	
	function makeRequest(url){
		
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
				
				
				var subcategorias = xmldoc.getElementsByTagName('subcategoria');
				if(subcategorias.length > 0)
				{					
					var fSet = document.createElement("fieldset");
					fSet.setAttribute("id", "subcategorias");
					var option = "<label id='sub-label'>Subcategorias</label>";
					option += "<select id='subcategorias' name='subcategorias' class='onsubmit:notnull'>";
					option += "<option value='null'>Selecione uma subcategoria</option>";
					for(i=0; i<subcategorias.length; i++)
					{
						
						var codigo = subcategorias[i].getElementsByTagName('codigo').item(0);
						var descricao = subcategorias[i].getElementsByTagName('descricao').item(0);
						
						option += "<option value='"+codigo.firstChild.data+"'>"+descricao.firstChild.data+"</option>";
						
						var newSelect = document.createElement('option');
						//alert(codigo);
				//		perguntasArea[i].value = resposta.firstChild.data;					
						
					}	
					option += "</select>";
					fSet.innerHTML = option;	
					var fieldset = $('subcategorias');
					if(fieldset != null)
					{     					
						fieldset.parentNode.removeChild(fieldset);	
						var label = $('sub-label');
						label.parentNode.removeChild(label);
					}		
					//$("categorias").innerHTML = "";
					
					$("categorias").appendChild(fSet);
				}else{
					var fieldset = $('subcategorias');
					if(fieldset != null)
					{     					
						fieldset.parentNode.removeChild(fieldset);	
						var label = $('sub-label');
						label.parentNode.removeChild(label);
					}		
				}
				
            } else {
                alert('There was a problem with the request.');
            }
        }

    }	
	this.exibeSubcategorias = function(){
		var inputs = document.getElementsByName("categoria");
		
		for(var i = 0; i < inputs.length; i++){
			inputs[i].onchange = function(){
				
				var valorAtual = this.options[this.selectedIndex];
			
				makeRequest('./ajax/verifica-subcategorias.php?cod='+valorAtual.value);
				
			}
		}
	}
	this.exibeSubcategorias();
	
	
	
}