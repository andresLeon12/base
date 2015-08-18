$(document).on("click","#rol",function()
{
	//alert("Fases");
	$('#content').load('rol.php');//cargando la vista de fase.php en el div con el id de content
	//$("#fasesLi").addClass("active");
	//$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#modelsLi,#actividadesLi,#entradasLi,#salidasLi").removeClass("active");
	//pag_act = 'rol';
});

$(document).on("click","#personal",function()
{
	$('#content').load('personal.php');//cargando la vista de fase.php en el div con el id de content
	/*

	*/
});

$(document).on('click','a',function()
{
	href = $(this).attr('href');
	seccion = $(this).attr('class');
	
	if(href==="#!")
	{
		if ( seccion.indexOf('miRol') >= 0 ) 
		{
			idRol = $(this).attr('id');
			//alert('idRol '+idRol);
			$.ajax({
				method: 'GET',
				data: {table : 'rol' , id : idRol , idTable : 'idRol'},
				url: "getById.php",
			}).done(function(resultado){
				res = JSON.parse(resultado);
				$("#idRol").val(res.idRol);//el id para actualizar los datos
				$("#nomRol").html("Rol: <b>"+res.nombre+"</b>");
				$("#nombre2").val(res.nombre);
			 	$("#descripcion2").val(res.descripcion);

			 	$("#nombre2").focus();
		 		$("#descripcion2").focus();
		 		$("#nombre2").focus();
			});

		 	$("#modalRol").openModal();

		}
		else
		{
			if ( seccion.indexOf('miPersonal') >= 0 ) 
			{
				//alert("miPersonal")
				idPersonal = $(this).attr('id');
				//alert('idRol '+idRol);
				$.ajax({
					method: 'GET',
					data: {table : 'personal' , id : idPersonal , idTable : 'idPersonal'},
					url: "getById.php",
				}).done(function(resultado){
					res = JSON.parse(resultado);
					nombreCompleto = res.nombre+" "+res.apellidoP+" "+res.apellidoM;

					//alert("nombre "+nombreCompleto)
					
					$("#idPersonal").val(res.idPersonal);//el id para actualizar los datos
					$("#nomPersonal").html("Personal: <b>"+nombreCompleto+"</b>");
					$("#nombre2").val(res.nombre);
					$("#aP2").val(res.apellidoP);
					$("#aM2").val(res.apellidoM);
					$("#email2").val(res.correo_electronico);
					$("#habilidades2").val(res.habilidades);

					auxIdPersonal = res.idPersonal;//el id del personal seleccionado, esto para obtener el rol que le compete
				 	
				 		nulo = 0;
						$.ajax({
							method: 'GET',
							data: {table : 'rol' , id : nulo , idTable : ''},
							url: "getById.php",
						}).done(function(resultado){
							res = JSON.parse(resultado)
							//alert("RES "+res[0].nombre)
							$("#rolOptions2").empty()
							$("#rolOptions2").append("<option value='0'>Seleccione un rol</option>");
							for(i=0;i<res.length;i++){
								$("#rolOptions2").append("<option value='"+res[i].idRol+"'>"+res[i].nombre+"</option>");
							}

						 	$.ajax({
								method: 'GET',
								data: {table : 'personal_rol' , id : auxIdPersonal , idTable : 'Personal_idPersonal'},
								url: "getById.php",
							}).done(function(resultado){
								res = JSON.parse(resultado)
								
								auxIdRol = parseInt(res.Rol_idRol)
								//alert("auxIDRO "+auxIdRol)
								
								nulo = 0;
								$.ajax({
									method: 'GET',
									data: {table : 'rol' , id : nulo , idTable : ''},
									url: "getById.php",
								}).done(function(resultado){
									res = JSON.parse(resultado)
									//alert("RES "+res[0].nombre)
									$("#rolOptions2").empty()
									$("#rolOptions2").append("<option value='0'>Seleccione un rol</option>");
									for(i=0;i<res.length;i++){
										if(res[i].idRol == auxIdRol)
										{
								 			$("#rolOptions2").append("<option selected value='"+res[i].idRol+"'>"+res[i].nombre+"</option>");
										}
								 		else
								 		{
								 			$("#rolOptions2").append("<option value='"+res[i].idRol+"'>"+res[i].nombre+"</option>");
								 		}
									}
								})
								
								/*$("#rolOptions option").each(function(){
									element = this
									if(element.value == auxIdRol){
										$(this).attr("selected", "true")
									}
								});*/
								

							})
						})
				 	
					//alert("auxIdRol Final "+auxIdRol)

				 	$("#nombre2").focus();
			 		$("#aP2").focus();
			 		$("#aM2").focus();
			 		$("#email2").focus();
			 		$("#habilidades2").focus();
			 		$("#nombre2").focus();

				});

			 	$("#modalPersonal").openModal();

			}	
		}
	}

});

$(document).on('submit','.eliminarRol',function(){
	id = $(this).attr("id").split("-");
	//alert("id "+id[1])
	$('#eliminarRol-'+id[1]).find(':input').each(function(){
		element = this
		//alert(element.id)
		switch(element.id){
			case 'idR-'+id[1]:
				$('#idRolForm').val(element.value)
				//alert("value "+element.value)
			break;
			case 'nomR-'+id[1]:
				$("#nombreRolForm").val(element.value)
				//alert("value "+element.value)
				$("#nombreRol").html("&iquest;Realmente desea eliminar <b>"+element.value+"</b>?")
			break;
		}
	});
	$("#confirmDeleteRol").openModal();
	return false;//para no enviar el formulario
});

$(document).on('submit','.eliminarPersonal',function(){
	id = $(this).attr("id").split("-");
	$('#eliminarPersonal-'+id[1]).find(':input').each(function(){
		element = this
		switch(element.id){
			case 'idPer-'+id[1]:
				$('#idPersonalForm').val(element.value)
			break;
			case 'nomPer-'+id[1]:
				nombre = element.value+" ";
				$("#nombrePersonalForm").val(element.value)
				//$("#nombrePersonal").html("&iquest;Realmente desea eliminar <b>"+element.value+"</b>?")
			break;
			case 'aPPer-'+id[1]:
				aP = element.value+" ";
			break;
			case 'aMPer-'+id[1]:
				aM = element.value;
				nombreCompleto = nombre + aP + aM
				$("#nombrePersonal").html("&iquest;Realmente desea eliminar <b>"+nombreCompleto+"</b>?")
			break;
		}
	});
	$("#confirmDeletePersonal").openModal();
	return false;//para no enviar el formulario
});
$(document).on("change","#models", function(){
	idModelo = $(this).val();
	//alert("idModelo "+idModelo)
	if (idModelo == "Selecciona un modelo") {
		$('#nombre').attr('disabled', true);
		$('#nombre').val("");
		$('#id_Act').attr('disabled', true);
		$('#id_Act').val("");
		$('#tipo').attr('disabled', true);
		$('#tipo').val("");
		$('#descripcion').attr('disabled', true);
		$('#descripcion').val("");
		$('#dependencia').attr('disabled', true);
		$('#idMedida').attr('disabled', true);
		$("#ocultoGuia").css("display", "block");
		$("#ocultoActivo").css("display", "block");
	}else{
		$('#idfases').attr('disabled', false);
	}
});

$(document).on("change","#idfases", function(){
	idFase = $(this).val();
	//alert("idFase "+idFase)
	if (idFase == "Selecciona una fase") {
		$('#nombre').attr('disabled', true);
		$('#nombre').val("");
		$('#id_Act').attr('disabled', true);
		$('#id_Act').val("");
		$('#tipo').attr('disabled', true);
		$('#tipo').val("");
		$('#descripcion').attr('disabled', true);
		$('#descripcion').val("");
		$('#dependencia').attr('disabled', true);
		$('#idMedida').attr('disabled', true);
		$("#ocultoGuia").css("display", "none");
		$("#ocultoActivo").css("display", "none");
		//$('#idMedida').append(new Option('Selecciona una medida', 'Selecciona una medida', true, true));
	}else{
		$('#nombre').attr('disabled', false);
		$('#id_Act').attr('disabled', false);
		$('#tipo').attr('disabled', false);
		$('#descripcion').attr('disabled', false);
		$('#dependencia').attr('disabled', false);
		$('#idMedida').attr('disabled', false);
		$("#ocultoGuia").css("display", "block");
		$("#ocultoActivo").css("display", "block");
	}
});

$(document).on("change","#idActividades", function(){
	$('#nombre_Tarea').attr('disabled', false);
	$('#descripcion_Tarea').attr('disabled', false);
});