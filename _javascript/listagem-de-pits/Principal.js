main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();
}

function Principal(){

	/*
		Ações de escolha de situações.
	*/
	$("link-situacoes").onclick = function() {
		$("situacoes-box").style.visibility = "visible";
	}
	
	$("ok-situacoes-box").onclick = function() {
		$("situacoes-box").style.visibility = "hidden";
	}
	var http_request = false;	
	function makeRequest(url, cod){
		
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
				/*if(http_request.responseText != '')
				location.href='../error/error.php';*/
            } else {
                alert('There was a problem with the request.');
            }
        }

    }	
	this.alteraSituacao = function(){
		var inputs = document.getElementsByName("pitSituacao");
		
		for(var i = 0; i < inputs.length; i++){
			inputs[i].onchange = function(){
				
				var valorAtual = this.options[this.selectedIndex];
				if(!confirm("Você tem certeza? "))
				{
					return false;
				}else{
					makeRequest('update-pits-situacao.php?cod='+valorAtual.value);
					/* 
					SE NÃO QUISER UTILIZAR AJAX, USAR A LINHA ABAIXO NO LUGAR DO makeRequest					
					location.href =	'update-pits-situacao.php?cod='+valorAtual.value;		
					*/
				}
			}
		}
	}
	this.alteraSituacao();
	var inputs = document.getElementsByTagName("input");	
	
	for(var i = 0; i < inputs.length; i++)
	{	
		if(inputs[i].id == "imprimir-pauta"){				
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
	/*
		Ações de paginação...
	*/
	/*$("inicioRegistros").onchange = function(){
		$("form-paginacao").submit();
	}
	
	/**
		Reload da listagem a cada 30 segundos...
	*/
	var reloadInterval = 30000;
	this.reloadLista = function() {
		setTimeout(
			function() {
				var start = $("inicioRegistros").options[$("inicioRegistros").selectedIndex].value; //pego de acordo com a página atual...
				start *= 10;
				
				new Ajax.Request(
					'../listagem-pits-ajax/?start=' + start,
					{
						method: 'get',
	
						//quando carregar...
						onSuccess: function(transport){
							var source = transport.responseText;
							$("listagem-de-pits").parentNode.innerHTML = source;
							
							/*
								Preciso processar os scripts onload que agem sobre o código do replace.
							*/
							new AddExcluirConfirmations();
							
							principal.reloadLista();
						},
	
						onFailure: function(){}
					}
				)
			},
			reloadInterval
		);
	}
	
	//this.reloadLista();
	
	
	
}