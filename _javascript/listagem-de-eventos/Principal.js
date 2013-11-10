$().ready(function() {	
	
	
	var cal = Calendar.setup({
        onSelect: function(cal) { cal.hide() }
    });
	cal.manageFields("inicio", "inicio", "%d/%m/%Y");
	cal.manageFields("fim", "fim", "%d/%m/%Y");
	
});