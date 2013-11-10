$().ready(function() {		
	
		
	$("#cep").keyup(function() {		
		var value = this.val();
		if(value.length == 8){			
			$("#cep").blur();
			preLoadImg = new Image();
			preLoadImg.src = "./../_images/estrutura/loader.gif";
			$("#cid-estado").html("<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='./../_images/estrutura/loader.gif'></center></table>");
			
			$.ajax({
	           
	            type: "get",
	            data:  value,	             
	            url: "./../componentes/cep.php?cep=",
	            dataType: "html",
	            success: function(result){
	                $("#cid-estado").html('');
	                $("#cid-estado").append(result);
	            }
	            /*,
	            beforeSend: function(){
	                $('#loading').css({display:"block"});
	            },
	            complete: function(msg){
	                $('#loading').css({display:"none"});
	            }*/
	        });			
		}		
	});
		
	var tipoCliente = $(".tipoDeCliente:checked").val();
	if(tipoCliente == "fisica")
	{
		$("#campos-fisica").show();
		$("#campos-juridica").hide();
	}else{
		$("#campos-fisica").hide();
		$("#campos-juridica").show();
	}
	

	$(".tipoDeCliente").click(function(){
		
		var value = $(this).val();
		if(value == "fisica")
		{
			$("#campos-fisica").show();
			$("#campos-juridica").hide();
		}else{
			$("#campos-fisica").hide();
			$("#campos-juridica").show();
		}
	});
	
	
	
	
});