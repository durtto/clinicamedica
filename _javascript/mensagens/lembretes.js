$().ready(function() {		
	
	var cal = Calendar.setup({
        onSelect: function(cal) { cal.hide() }
    });
	cal.manageFields("launch", "datalembrete", "%d/%m/%Y");
	
		
	
	
});
