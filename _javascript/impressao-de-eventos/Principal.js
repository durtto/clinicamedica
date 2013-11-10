$().ready(function() {

	$("#cancelar-impressao").click(function(){
		if(confirm("Realmente deseja cancelar a impressão?"))
			window.close();
	});

});