$(document).on("click","#tareas",function(){
	$('#content').load('tareas.php');//cargando la vista de fase.php en el div con el id de content
	$("#tareasLi").addClass("active");
	$("#fasesLi").removeClass("active");
	$("#actividadesLi").removeClass("active");
	$("#modelsLi").removeClass("active");
	pag_act = 'tareas';
});
$(document).on("change","#selectRecurso", function(){
	if($(this).prop("checked")){
		$("#tipo").empty();
		$("#tipo").append("<option>Selecciona una opción</option><option>Externo</option><option>Miembro del equipo</option>");
		$("#descripcionDiv").fadeOut("slow")
		$("#descripcion").val("***")
		$("#typeRecurso").html("Agregar un recurso humano")
		$("#tipo_recurso").val("humano")
	}else{
		$("#tipo").empty();
		$("#tipo").append("<option>Selecciona una opción</option><option>Material</option><option>Instalación</option><option>Equipo</option>")
		$("#typeRecurso").html("Agregar un recurso físico")
		$("#descripcionDiv").fadeIn("slow")
		$("#tipo_recurso").val("fisico")
		$("#descripcion").val("")
	}
});
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
// Recursos
$(document).on("click","#recursos",function(){
	//alert("guias");
	$('#content').load('recursos.php');//cargando la vista de fase.php en el div con el id de content
	$("#recursosLi").addClass("active");
	$("#actividadesLi").removeClass("active");
	$("#modelsLi").removeClass("active");
	$("#fasesLi").removeClass("active");
	$("#activosLi").removeClass("active");
	$("#guiasLi").removeClass("active");
	pag_act = 'recursos'
});
// Confirmación de eliminación de actividad
$(document).on("submit", ".eliminarRecurso", function(){
	id = $(this).attr("id").split("-");
	$("#eliminarRecurso-"+id[1]).find(":input").each(function(){
		element = this;
		switch(element.id){
			case 'idRecurso-'+id[1]:
				$("#idRecursoForm").val(element.value)
			break;
			case 'nombreRecurso-'+id[1]:
				$("#nombreRecursoForm").val(element.value)
				$("#nomRecurso").html("¿Realmente deseas eliminar "+element.value+"?")
			break;
			case 'tipoRecurso-'+id[1]:
				$("#tipo_recursoForm").val(element.value)
			break;
		}
	});
	$("#confirmDeleteRecurso").openModal();
	return false;
});
restaFechas = function(f1,f2){
	var aFecha1 = f1.split('/'); 
	var aFecha2 = f2.split('/'); 
	var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
	var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
	var dif = fFecha2 - fFecha1;
	var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
	return dias;
}
$(document).on("click","a", function(){
	href = $(this).attr("href")
	seccion = $(this).attr("class")
	if(href==="#!"){
		if(seccion.indexOf("miTarea")>=0){
				
			idTarea = $(this).attr('id')
			var auxIdAct = 0;

			$.ajax({
				method: 'GET',
				data: {table : 'tarea' , id : idTarea , idTable : 'idTarea'},
				url: "getByID.php",
			}).done(function(resultado){
				res = JSON.parse(resultado);
				$("#idTarea").val(res.idTarea)//el id para actualizar los datos
				$("#nomTarea").html("Tarea: <b>"+res.nombre+"</b>");
				$("#nombre2").val(res.nombre);
			 	$("#descripcion2").val(res.descripcion);

			 	auxIdModelo = res.Actividad_idActividad;
			 	$.ajax({
					method: 'GET',
					data: {table : 'actividad' , id : auxIdModelo , idTable : 'idActividad'},
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
									if(res[i].idActividad == auxIdModelo)
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
			 	/*
			 	$("#actividadEdit option").each(function(){
			 		element = this;
			 		if(element.value == auxIdModelo){
			 			$(this).attr("selected","true");
			 		}
			 	});
			 	*/
			 	//$('#modelFase').openModal()
			 	$("#nombre2").focus();
		 		$("#descripcion2").focus();
		 		$("#nombre2").focus();
			})
			//$('#modalTarea').openModal();
		}
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
		}else if (seccion.indexOf("miRecurso")>=0) {
			idRecurso = $(this).attr('id')
			$("#idRecursoEdit").val(idRecurso);
			tableRelation = ((seccion.indexOf("miRecursoH")>=0) ? 'actividad_rh' : 'actividad_rf' );
			tableRecurso = ((seccion.indexOf("miRecursoH")>=0) ? 'recursoh' : 'recursof' );
			idRecursoColum = ((seccion.indexOf("miRecursoH")>=0) ? 'RecursoH_idRecursoHumano' : 'RecursoF_idRecursoFisico' );
			idRecursoColumR = ((seccion.indexOf("miRecursoH")>=0) ? 'idRecursoHumano' : 'idRecursoFisico' );
			var idActividad = idFase = idModel = 0;
			$.ajax({
				method: 'GET',
				data: {table : tableRelation , id : idRecurso , idTable : idRecursoColum},
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
							$("#idfasesEdit").empty()
							$("#idfasesEdit").append("Selecciona una fase");
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
									data: {table : tableRecurso , id : idRecurso , idTable : idRecursoColumR},
									url: "getByID.php",
								}).done(function(resultado){
									res = JSON.parse(resultado)
									$("#nombreEdit").val(res.nombre)
									$("#nombreEdit").focus()
									$("#carga_trabajoEdit").val(res.carga_trabajo)
									$("#carga_trabajoEdit").focus()
									if(tableRecurso==="recursoh"){
										$("#tipoEdit").empty();
										$("#tipoEdit").append("<option>Selecciona una opción</option><option>Externo</option><option>Miembro del equipo</option>");
										$("#descripcionDivEdit").fadeOut("slow")
										$("#descripcionEdit").val("***")
										$("#tipo_recursoEdit").val("humano")
									}else{
										$("#tipoEdit").empty();
										$("#tipoEdit").append("<option>Selecciona una opción</option><option>Material</option><option>Instalación</option><option>Equipo</option>")
										$("#descripcionDivEdit").fadeIn("slow")
										$("#tipo_recursoEdit").val("fisico")
										$("#descripcionEdit").val(res.descripcion)
										$("#descripcionEdit").focus()
									}
									$("#tipoEdit option").each(function(){
										element = this
										if(element.value == res.tipo){
											$(this).attr("selected", "true")
										}
									});
									
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
$(document).on('submit','.eliminarTarea',function(){
	id = $(this).attr("id").split("-");
	//alert("id "+id[1])
	$('#eliminarTarea-'+id[1]).find(':input').each(function(){
		element = this;
		//alert(element.id)
		switch(element.id){
			case 'idT-'+id[1]:
				$('#idTareaForm').val(element.value);
				//alert("value "+element.value)
			break;
			case 'nomT-'+id[1]:
				$("#nombreTareaForm").val(element.value);
				$("#nameTarea").html("&iquest;Realmente desea eliminar <b>"+element.value+"</b>?");
			break;
		}
	});
	$("#confirmDeleteTarea").openModal();
	return false;//para no enviar el formulario
});