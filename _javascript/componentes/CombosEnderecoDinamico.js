function CombosEnderecoDinamico(cepCep, paiPais, estEstado, estNome, cidCidade) {
	$(cepCep).maxLength = 8; 


	function doComboPais(data) {
		DWRUtil.removeAllOptions(paiPais);
		DWRUtil.addOptions(paiPais, [{ paiPais:"null", paiNome:"Escolha um país" }], "paiPais", "paiNome");
		
		DWRUtil.addOptions(paiPais, data, "paiPais", "paiNome");
	}
	//..
	function doComboEstado(data) {
	 	DWRUtil.removeAllOptions(estEstado);
	 	DWRUtil.addOptions(estEstado, [{ estEstado:"null", estNome:"Escolha um estado" }], "estEstado", "estNome");
		DWRUtil.addOptions(estEstado, data, "estEstado", "estNome");
	
		
		data = [{ cidNome:"Escolha um estado", cidCidade:"null" }];
		DWRUtil.removeAllOptions(cidCidade);
		DWRUtil.addOptions(cidCidade, data, "cidCidade", "cidNome");
	}
	//..
	function doComboCidade(data) {
		DWRUtil.removeAllOptions(cidCidade);
		DWRUtil.addOptions(cidCidade, [{ cidCidade:"null", cidNome:"Escolha uma cidade" }], "cidCidade", "cidNome");
		DWRUtil.addOptions(cidCidade, data, "cidCidade", "cidNome");
	}
	//..
	function doCombosCep(data) {
		if(data.paisCod != "null"){
			DWRUtil.removeAllOptions(paiPais);
			DWRUtil.addOptions(paiPais, [data], "paisCod", "paisNome");
			
			DWRUtil.removeAllOptions(estEstado);
			DWRUtil.addOptions(estEstado, [data], "estadoCod", "estadoNome");		
			
			DWRUtil.removeAllOptions(cidCidade);
			DWRUtil.addOptions(cidCidade, [data], "cidadeCod", "cidadeNome");
		}
		else{
			Paises.loadAll(doComboPais);
			
			$(paiPais).disabled = false;
			$(estEstado).disabled = false;
			$(cidCidade).disabled = false;
		}
	}
	
	//--
	
	$(cepCep).onkeyup = function() {
		var value = this.value;
		if(value.length == 8){
			//busco os dados...
			$(paiPais).disabled = true;
			$(estEstado).disabled = true;
			$(cidCidade).disabled = true;
			DadosEndereco.loadByCep(value, doCombosCep);
		}
		else{
			$(paiPais).disabled = false;
			$(estEstado).disabled = false;
			$(cidCidade).disabled = false;
			
			Paises.loadAll(doComboPais);
			$(paiPais).onchange();
		}
	}
	
	//--
	
	$(paiPais).onchange = function() {
		if(this.options[this.selectedIndex].value != "null"){
			Estados.loadByPais(this.options[this.selectedIndex].value, doComboEstado);
		}
		else{
			var data = [{ estEstado:"null", estNome:"Escolha um país" }];
			doComboEstado(data);
		}
	}
	
	//--
	
	$(estEstado).onchange = function() {
		if(this.options[this.selectedIndex].value != "null"){
			Cidades.loadByEstado($(paiPais).options[$(paiPais).selectedIndex].value, this.options[this.selectedIndex].value, doComboCidade);
		}
		else{
			var data = [ { estNome:"Escolha um país" }, { estEstado:"null" } ];
			doComboCidade(data);
		}
	}
	
	//--
	
	$(cepCep).onkeyup();
}