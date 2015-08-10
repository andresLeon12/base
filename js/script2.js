$(document).on("click","#guias",function(){
	//alert("guias");
	$('#content').load('guias.php');//cargando la vista de fase.php en el div con el id de content
	$("#guiasLi").addClass("active");
	$("#actividadesLi").removeClass("active");
	$("#modelsLi").removeClass("active");
	$("#fasesLi").removeClass("active");
	$("#activosLi").removeClass("active");
	pag_act = 'guias';
});
// Confirmación de eliminación de actividad
$(document).on("submit", ".eliminarGuia", function(){
	id = $(this).attr("id").split("-");
	$("#eliminarGuia-"+id[1]).find(":input").each(function(){
		element = this;
		switch(element.id){
			case 'idGuia-'+id[1]:
				$("#idGuiaForm").val(element.value)
			break;
			case 'nombreGuia-'+id[1]:
				$("#nombreGuiaForm").val(element.value)
				nom = element.value
				nom = nom.split("/")
				$("#nomGuia").html("¿Realmente deseas eliminar "+nom[1]+"?")
			break;
		}
	});
	$("#confirmDeleteGuia").openModal();
	return false;
});

$(document).on("click","#activos",function(){
	//alert("activos");
	$('#content').load('activos.php');//cargando la vista de fase.php en el div con el id de content
	$("#activosLi").addClass("active");
	$("#actividadesLi").removeClass("active");
	$("#guiasLi").removeClass("active");
	$("#modelsLi").removeClass("active");
	$("#fasesLi").removeClass("active");
	pag_act = 'activos';
});
$(document).on("submit", ".eliminarActivo", function(){
	id = $(this).attr("id").split("-");
	$("#eliminarActivo-"+id[1]).find(":input").each(function(){
		element = this;
		switch(element.id){
			case 'idActivo-'+id[1]:
				$("#idActivoForm").val(element.value)
			break;
			case 'nombreActivo-'+id[1]:
				$("#nombreActivoForm").val(element.value)
				nom = element.value
				nom = nom.split("/")
				$("#nomActivo").html("¿Realmente deseas eliminar "+nom[1]+"?")
			break;
		}
	});
	$("#confirmDeleteActivo").openModal();
	return false;
});

$(document).on("click","a", function(){
	href = $(this).attr("href")
	seccion = $(this).attr("class")
	if(href==="#!"){
		if (seccion.indexOf("miGuia")>=0) {
			idGuia = $(this).attr('id')
			$("#idGuiaEdit").val(idGuia);
			var idActividad = idFase = idModel = 0;
			$.ajax({
				method: 'GET',
				data: {table : 'A_Guia' , id : idGuia , idTable : 'Guia_idGuia'},
				url: "getById.php",
			}).done(function(resultado){
				res = JSON.parse(resultado)
				idActividad = res.Actividad_idActividad
				$.ajax({
					method: 'GET',
					data: {table : 'actividad' , id : idActividad , idTable : 'idActividad'},
					url: "getByID.php",
				}).done(function(resultado){
					res = JSON.parse(resultado)
					idFase = parseInt(res.Fase_idFase)
					//Obtenemos el modelo al que pertenece
					$.ajax({
						method: 'GET',
						data: {table : 'fase' , id : idFase , idTable : 'idFase'},
						url: "getByID.php",
					}).done(function(resultado){
						res = JSON.parse(resultado)
						idModel = res.Modelo_P_idModelo_P
						$("#modelsEdit option").each(function(){
							element = this
							if(element.value == idModel){
								$(this).attr("selected", "true")
							}
						});
						$.ajax({
							method: 'GET',
							data: {getByModel : idModel },
							url: "fasesMetodos.php",
						}).done(function(resultado){
							res = JSON.parse(resultado)
							$("#idFasesEdit").empty()
							$("#idFasesEdit").append("Selecciona una fase");
							for(i=0;i<res.length;i++){
								if(res[i].idFase == idFase)
						 			$("#idfasesEdit").append("<option selected value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 		else
						 			$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 		
						 	}
						 	$.ajax({
								method: 'GET',
								data: {getByFase : idFase },
								url: "actividadesMetodos.php",
							}).done(function(resultado){
								res = JSON.parse(resultado)
								$("#idActividadesEdit").append("Selecciona una actividad");
								for(i=0;i<res.length;i++){
									if(res[i].idActividad == idActividad)
							 			$("#idActividadesEdit").append("<option selected value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
							 		else
							 			$("#idActividadesEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
								}
								$.ajax({
									method: 'GET',
									data: {table : 'guia' , id : idGuia , idTable : 'idGuia'},
									url: "getByID.php",
								}).done(function(resultado){
									res = JSON.parse(resultado)
									$("#tipoEdit").val(res.tipo)
									$("#tipoEdit").focus()
									nombre = res.nombre.split("/")
									$("#linkFileEditGuia").text(nombre[1])
									$("#linkFileEditGuia").attr("href", "../../archivos/"+res.nombre)
									$("#linkOldFile").val(res.nombre)
								})
							})
						})
					})
				})
			})
		}else if (seccion.indexOf("miActivo")>=0) {
			idActivo = $(this).attr('id')
			$("#idActivoEdit").val(idActivo);
			var idActividad = idFase = idModel = 0;
			$.ajax({
				method: 'GET',
				data: {table : 'A_Activo' , id : idActivo , idTable : 'Activo_idActivo'},
				url: "getById.php",
			}).done(function(resultado){
				res = JSON.parse(resultado)
				idActividad = res.Actividad_idActividad
				$.ajax({
					method: 'GET',
					data: {table : 'actividad' , id : idActividad , idTable : 'idActividad'},
					url: "getByID.php",
				}).done(function(resultado){
					res = JSON.parse(resultado)
					idFase = parseInt(res.Fase_idFase)
					//Obtenemos el modelo al que pertenece
					$.ajax({
						method: 'GET',
						data: {table : 'fase' , id : idFase , idTable : 'idFase'},
						url: "getByID.php",
					}).done(function(resultado){
						res = JSON.parse(resultado)
						idModel = res.Modelo_P_idModelo_P
						$("#modelsEdit option").each(function(){
							element = this
							if(element.value == idModel){
								$(this).attr("selected", "true")
							}
						});
						$.ajax({
							method: 'GET',
							data: {getByModel : idModel },
							url: "fasesMetodos.php",
						}).done(function(resultado){
							res = JSON.parse(resultado)
							$("#idFasesEdit").empty()
							$("#idFasesEdit").append("Selecciona una fase");
							for(i=0;i<res.length;i++){
								if(res[i].idFase == idFase)
						 			$("#idfasesEdit").append("<option selected value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 		else
						 			$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 		
						 	}
						 	$.ajax({
								method: 'GET',
								data: {getByFase : idFase },
								url: "actividadesMetodos.php",
							}).done(function(resultado){
								res = JSON.parse(resultado)
								$("#idActividadesEdit").append("Selecciona una actividad");
								for(i=0;i<res.length;i++){
									if(res[i].idActividad == idActividad)
							 			$("#idActividadesEdit").append("<option selected value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
							 		else
							 			$("#idActividadesEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
								}
								$.ajax({
									method: 'GET',
									data: {table : 'activo' , id : idActivo , idTable : 'idActivo'},
									url: "getByID.php",
								}).done(function(resultado){
									res = JSON.parse(resultado)
									$("#descripcion").text(res.descripcion)
									$("#descripcion").focus()
									nombre = res.nombre.split("/")
									$("#linkFileEditActivo").text(nombre[1])
									$("#linkFileEditActivo").attr("href", "../../archivos/"+res.nombre)
									$("#linkOldFile").val(res.nombre)
								})
							})
						})
					})
				})
			})
		}
		$("#editarGuia").openModal()
	}

});