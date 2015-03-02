$( document ).ready(function() {
	var serverPers = new Array();

	$('#espacio').on('change',function(){
		serverPers[0] = $(this).val();
	});
	$('#memoria').on('change',function(){
		serverPers[1] = $(this).val();
	});
	$('#anchobanda').on('change',function(){
		serverPers[2] = $(this).val();
	});
	$('#procesamiento').on('change',function(){
		serverPers[3] = $(this).val();
	});
	$('#sistemaoperativo').on('change',function(){
		serverPers[4] = $(this).val();
	});
	$('#configurar').click(function(){
			if(serverPers[0] == undefined){
				console.log("Por favor, seleccionar un espacio");
			}

	});
	
});
