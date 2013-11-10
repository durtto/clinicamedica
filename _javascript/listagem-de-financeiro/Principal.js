main.addFunction("initPrincipal()");

var principal;
function initPrincipal(){
	principal = new Principal();	
}

function Principal()
{
	
	
	var inputs = document.getElementsByTagName("input");	
	
	for(var i = 0; i < inputs.length; i++)
	{	
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
	}
	
}