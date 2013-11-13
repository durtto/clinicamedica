$(function() {
	
	var LEFT_CAL = Calendar.setup({
	     cont: "calendario",
	     weekNumbers: false           
	     // titleFormat: "%B %Y"
	});
	 
	 LEFT_CAL.addEventListener("onSelect", function(){
      
		 new exibeAgenda(LEFT_CAL.selection.print("%d/%m/%Y"), $("#medico option:selected").val());
	 });	
	 
	$( "#dialog-modal" ).dialog({
		height: 140,
		autoOpen: false,
		modal: true,
		 height: 500,
		 width: 650,
		 close: function() {
			 
			 new limpaForm();
			 new exibeAgenda($("#data-hidden").val(), $("#medico option:selected").val());		 
		}
	});
	
	function setaMedicoSelecionado()
	{		
		$("#medico-modal").val($("#medico option:selected").val());
		$("#medico").change(function(){
			$("#medico-modal").val($("#medico option:selected").val());	
			new exibeAgenda($("#data-hidden").val(), $("#medico option:selected").val());
		});		
	}
	new setaMedicoSelecionado();
	
	function limpaForm()
	{
		 $("#paciente").val("");
		 $("#observacoes").val("");
		 $("#valorconsulta").val("");
		 $("#response").html("");
		 
		 
	}
	 
	function exibeAgenda(dataSelecionada, medicoSelecionado)
	{
		$.get("ajax/agenda.php?data-selecionada="+dataSelecionada+"&medico-selecionado="+medicoSelecionado, function(data) {

	    	$('#agenda').html("");
	    	
	    	preLoadImg = new Image();
	  		preLoadImg.src = "../../_images/estrutura/loader.gif";

	  		$("#agenda").html("<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='../../_images/estrutura/loader.gif'></center></table>");
	  		$('#agenda').html("");
	    	
		  	$('#agenda').append(data);

		  	
	      });
	}
	
	$("#submit-button").click(function() {
		
		var action = $("#action").val();
		
	    var url = "ajax/"+action+".php"; // the script where you handle the form input.
		
	    $.ajax({
	           type: "POST",
	           url: url,
	           data: $("#agendar-horario").serialize(), // serializes the form's elements.
	           success: function(data)
	           {
	                // show response from the php script.
	        	   	$('#response').html("");
	   	    	
		   	    	preLoadImg = new Image();
		   	  		preLoadImg.src = "../../_images/estrutura/loader.gif";
		
		   	  		$("#response").html("<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='../../_images/estrutura/loader.gif'></center></table>");
		   	  		$('#response').html("");
		   	    	
		   		  	$('#response').append("<b>"+data+"</b>");
		   		  	
		   		  	new exibeAgenda($("#data-hidden").val(), $("#medico-hidden").val());
	           }, 
	           error: function () {
	               alert("Error");
	           }
	         });

	    return false; // avoid to execute the actual submit of the form.
	});
	

	
	 
});
 
