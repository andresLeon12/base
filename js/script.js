// Login de usuario
var msj = '';
m = setInterval(titulo, 5000);
$(document).ready(function(){
	
	$('ul.tabs').tabs();
	$(".button-collapse").sideNav();
	$('.dropdown-button').dropdown({
      inDuration: 600,
      outDuration: 225,
      constrain_width: true, // Does not change width of dropdown to that of the activator
      hover: true, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: true // Displays dropdown below the button
    }
  );
	$("#login").submit(function(){
		user = $("#user").val()
		pass = $("#pass").val()
		if (user == "admin" && pass == 'admin') {//Si es admin redirecciona a la pagina de amdin
			//$("#error").text("Es Administrador")
			//window.location.href = "php/administrador.php";
		}else{
			if (user == 'jefe' && pass == 'jefe') {//si no es admin entonces se verifica si es jefe, si es, se le muestra la pagina del jefe
				//$("#error").text("Es Jefe")
				//window.location.href = "php/jefe.php";
			}else{//si no es un error de usuario
				$("#error").text("Error aun no estas registrado!")
				return false;
			}
		}
		
	});
	$("#adminLog").click(function(){
		$("#jefeLog").removeClass("active z-depth-2");
		$("#adminLog").addClass("active z-depth-2");
	});
	$("#jefeLog").click(function(){
		$("#adminLog").removeClass("active z-depth-2");
		$("#jefeLog").addClass("active z-depth-2");
	});
	switch($("#pag_act").val()){
		case 'modelos':
		$("#modelsLi").addClass("active");
		$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#fasesLi,#actividadesLi,#salidasLi,entradasLi").removeClass("active");
		break;
		case 'fases':
		$('#content').load('fases.php');//cargando la vista de fase.php en el div con el id de content
		$("#fasesLi").addClass("active");
		$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#modelsLi,#actividadesLi,#salidasLi,entradasLi").removeClass("active");
		break;
		case 'actividades':
		$("#actividadesLi").addClass("active");
		$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#fasesLi,#modelsLi,#salidasLi,entradasLi").removeClass("active");
		break;
		case 'recursos':
		$("#recursosLi").addClass("active");
		$("#guiasLi,#activosLi,#modelsLi,#tareasLi,#fasesLi,#actividadesLi,#salidasLi,#entradasLi,#medidasLi").removeClass("active");
		break;
		case 'guias':
		$("#guiasLi").addClass("active");
		$("#modelsLi,#activosLi,#modelsLi,#tareasLi,#fasesLi,#actividadesLi,#salidasLi,#entradasLi,#medidasLi").removeClass("active");
		break;
		case 'activos':
		$("#activosLi").addClass("active");
		$("#guiasLi,#recursosLi,#modelsLi,#tareasLi,#fasesLi,#actividadesLi,#salidasLi,#entradasLi,#medidasLi").removeClass("active");
		break;
		case 'tareas':
		$("#tareasLi").addClass("active");
		$("#guiasLi,#activosLi,#modelsLi,#recursosLi,#fasesLi,#actividadesLi,#salidasLi,#entradasLi,#medidasLi").removeClass("active");
		break;
		case 'entradas':
		$("#entradasLi").addClass("active");
		$("#guiasLi,#activosLi,#modelsLi,#recursosLi,#fasesLi,#actividadesLi,#salidasLi,#tareasLi,medidasLi").removeClass("active");
		break;
		case 'salidas':
		$("#salidasLi").addClass("active");
		$("#guiasLi,#activosLi,#modelsLi,#recursosLi,#fasesLi,#actividadesLi,#tareasLi,#entradasLi,#medidasLi").removeClass("active");
		break;
		case 'medidas':
		$("#medidasLi").addClass("active");
		$("#guiasLi,#activosLi,#modelsLi,#recursosLi,#fasesLi,#actividadesLi,#tareasLi,#entradasLi").removeClass("active");
		break;
	}
});

function titulo(){
	//alert($("#errores").text())
	if($("#errores").text() != ""){
		$("#errores").fadeOut(6000)
		$("#errores").html("")
	}
}

$(document).on('submit', "#submitAct", function(){
	$.ajax({
		method: "GET",
		data: { type : 'combo'},
		url: "nuevoModelo.php",
	}).done(function( resultado ) {
	 	res = JSON.parse(resultado)
		if(res.length <= 0){
		 	$("#msj").html("Es necesario agregar modelos para continuar.")
		 	return false;
		}
	})
	//return false;
});

$(document).on('submit', "#submitFases", function(){
	$.ajax({
		method: "GET",
		data: { type : 'combo'},
		url: "nuevoModelo.php",
	}).done(function( resultado ) {
	 	res = JSON.parse(resultado)
		if(res.length <= 0){
		 	$("#msj").html("Es necesario agregar modelos para continuar.")
		 	return false;
		}
	})
	//return false;
});

$(document).on("click","a", function(){
	href = $(this).attr("href")

	seccion = $(this).attr("class")

	if(href  == "#eli"){////////////////
		var  idModel = $(this).attr("id");/////////////
		$("#idEliminar").val(idModel)  //////////

		
		/*traer el nombre de el modelo a eliminar*/
		$.ajax({
			  method: "GET",
			  data: { table : 'modelo_p', id : idModel,idTable : "idModelo_P"},
			  url: "getById.php",
			  //url: "getByID.php",
			}).done(function( resultado ) {
				
			 	res = JSON.parse(resultado)
		
			 	$("#cabecera").html(" &iquest;Realmente desea eliminar el modelo  <b>"+res.nombreM+"</b> ?") //poner el nombre del modelo a eliminar en el modal
			 	
			 });
		/***************************/
		$("#modalx").openModal()//////////////
		///////////////////////
		return true;
	}

	if(href==="#act"){
			idModel = $(this).attr("id")
			$.ajax({
			  method: "GET",
			  data: { table : 'modelo_p', id : idModel,idTable : "idModelo_P"},
			  url: "getById.php",
			  //url: "getByID.php",
			}).done(function( resultado ) {
				
			 	res = JSON.parse(resultado)
			 	
			 	$("#idModelo").val(res.idModelo_P)//el id para actualizar los datos
			 	$("#nomModelo").html("Modelo de proceso: <b>"+res.nombreM+"<b>")
			 	$("#nombre2").val(res.nombreM)
			 	$("#desc2").val(res.descripcion)
			 	$("#version2").val(res.version)
			 	$("#nombre2").focus()
			 	$("#desc2").focus()
			 	$("#version2").focus()
			 	$("#nombre2").focus()

			 })
			 $("#model").openModal()

			 return true;

		}

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
								$("#idActividadesEdit").empty()
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
			 	$("#nombre2").focus();
		 		$("#descripcion2").focus();
		 		$("#nombre2").focus();
			})
			$("#editarGuia").openModal();
		}
		if (seccion.indexOf("miModelo")>=0) {
			idModel = $(this).attr("id")
			//alert("#! -- "+idModel)
			$.ajax({
			  method: "GET",
			  data: { table : 'modelo_p', id : idModel, idTable : 'idModelo_P'},
			  url: "getById.php",
			  //url: "getByID.php",
			}).done(function( resultado ) {
				//alert("resultado "+resultado)
			 	res = JSON.parse(resultado)
			 	//alert("res "+res.idModelo_P)
			 	$("#idModelo").val(res.idModelo_P)//el id para actualizar los datos
			 	$("#nomModelo").html(res.nombreM)
			 	$("#nombre2").val(res.nombreM)
			 	$("#desc2").val(res.descripcion)
			 	$("#version2").val(res.version)
			 	$("#nombre2").focus()
			 	$("#desc2").focus()
			 	$("#version2").focus()
			 	$("#nombre2").focus()
			 	$("#model").openModal()
			 })
			// $("#model").openModal()
		}else{
			if(seccion.indexOf("miFase")>=0){
				
				idFase = $(this).attr('id')

				var auxIdModelo = 0;

				$.ajax({
					method: 'GET',
					data: {table : 'fase' , id : idFase , idTable : 'idFase'},
					url: "getById.php",
					//url: "getByID.php",
				}).done(function(resultado){
					res = JSON.parse(resultado)
					$("#idFase").val(res.idFase)//el id para actualizar los datos
				 	$("#nomFase").html("Fase: <b>"+res.nombre+"</b>")
				 	$("#nombre2").val(res.nombre)
				 	$("#orden2").val(res.orden)
				 	$("#descripcion2").val(res.descripcion)

				 	auxIdModelo = res.Modelo_P_idModelo_P
				 	$("#modeloEdit option").each(function(){
				 		element = this
				 		if(element.value == auxIdModelo){
				 			$(this).attr("selected","true")
				 		}
				 	});

				 	$('#modelFase').openModal()

				 	$("#nombre2").focus()
			 		$("#orden2").focus()
			 		$("#descripcion2").focus()
			 		$("#nombre2").focus()
				})

				//$('#modelFase').openModal()
			}else if(seccion.indexOf("miActividad")>=0){
				idActividad = $(this).attr('id')
				var idFase = idModel = 0;
				
				$.ajax({
					method: 'GET',
					data: {table : 'actividad' , id : idActividad , idTable : 'idActividad'},
					url: "getById.php",
					//url: "getByID.php",
				}).done(function(resultado){
					
					res = JSON.parse(resultado)
					$("#nomActivity").html("Actividad: <b>"+res.nombre+"</b>")
					$("#nombreEdit").val(res.nombre)					
					$("#descripcionEdit").val(res.descripcion)
					$("#tipoEdit").val(res.tipo)
					$("#idActividadEdit").val(idActividad)
					
					idFase = parseInt(res.Fase_idFase)
					//Obtenemos el modelo al que pertenece
					$.ajax({
						method: 'GET',
						data: {table : 'fase' , id : idFase , idTable : 'idFase'},
						url: "getById.php",
						//url: "getByID.php",
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
							//alert("fase")
							$("#idfasesEdit").empty()
							$("#idfasesEdit").append("<option value='0'>Selecciona una fase</option>");
							for(i=0;i<res.length;i++){
								if(res[i].idFase == idFase)
						 			$("#idfasesEdit").append("<option selected value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 		else
						 			$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 	}
						 	
						 	nulo = 0;

						 	$.ajax({
						 		method: 'GET',
						 		data: {getByFase : idFase },
								url: "actividadesMetodos.php",
						 		//data: {table: 'actividad' , id: nulo , idTable: ''},
						 		//url: 'getById.php',
						 	}).done(function(resultado){
						 		res = JSON.parse(resultado)
						 		//alert("res "+res)
								$("#dependenciaEdit").empty()
								$("#dependenciaEdit").append("<option selected value='0'>Seleccione una dependencia</option>");
								for(i=0;i<res.length;i++){
									$("#dependenciaEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
							 	}

							 	$('#dependenciaEdit > option[value="0"]').attr('selected', 'true');
							 	//$('#dependenciaEdit > option[value="'+idActividad+'"]').remove();
							 	$('#dependenciaEdit > option[value="'+idActividad+'"]').attr('disabled','disabled');
							 	
							 	$.ajax({
									method: 'GET',
									data: {table : 'dependencia' , id : idActividad , idTable : 'Actividad_idActividad'},
									url: "getById.php",
									//url: "getByID.php",
								}).done(function(resultado){
									res = JSON.parse(resultado);
									depende_De = res.depende_De;

									$("#dependenciaEdit option").each(function(){
								 		element = this
								 		if(element.value == depende_De){
								 			//alert(element.value +" "+depende_De)
								 			$(this).attr("selected","true")
								 		}
								 	});
								})

						 	})

							$("#nombreEdit").focus()
							$("#descripcionEdit").focus()
							$("#tipoEdit").focus()
							$("#nombreEdit").focus()

						})
						$('#editarActividad').openModal()
					})
				})
			}else if (seccion.indexOf("miGuia")>=0) {
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
			
			$("#editarGuia").openModal()

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

			$("#editarGuia").openModal()

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

			$("#editarGuia").openModal()

		}else if(seccion.indexOf("miMedida")>=0){
				
			idMedida = $(this).attr('id')
			$.ajax({
				method: 'GET',
				data: {table : 'medida' , id : idMedida , idTable : 'idMedida'},
				url: "getByID.php",
			}).done(function(resultado){
				res = JSON.parse(resultado);
				$("#idMedida").val(res.idMedida)//el id para actualizar los datos
				$("#nomMedida").html("Medida: <b>"+res.nombre+"</b>");
				$("#nombre2").val(res.nombre);
				$("#nombre2").focus()
			 	$("#descripcion2").val(res.descripcion);
			 	$("#descripcion2").focus()
			 	$("#unidad_medida2").val(res.unidad_medida);
			 	$("#unidad_medida2").focus()
			 	$("#nombre2").focus()
			})
			$("#editarGuia").openModal()
		}
		//$("#editarGuia").openModal()
		}
	}

});

//cuando da clic en la pestaña de fases
$(document).on("click","#fases",function(){
	//alert("Fases");
	$('#content').load('fases.php');//cargando la vista de fase.php en el div con el id de content
	$("#fasesLi").addClass("active");
	$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#modelsLi,#actividadesLi,#entradasLi,#salidasLi,#medidasLi").removeClass("active");
	pag_act = 'fases';
});

$(document).on("click","#modelos",function(){
	$("#content").load('administrador.php');
	$("#modelsLi").addClass("active");
	$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#fasesLi,#actividadesLi,#entradasLi,#salidasLi,#medidasLi").removeClass("active");
	pag_act = 'modelos';
});
// Cargamos contenido de actividades
$(document).on("click","#actividades",function(){
	$("#content").load('actividades.php');
	$("#actividadesLi").addClass("active");
	$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#fasesLi,#modelsLi,#entradasLi,#salidasLi,#medidasLi").removeClass("active");
	pag_act = 'actividades';
});

/********************ediel  *************************/
$(document).on("click","#entradas",function(){
	$("#content").load('entradas.php');
	$("#entradasLi").addClass("active");
	$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#fasesLi,#modelsLi,#salidasLi,#actividadesLi,#medidasLi").removeClass("active");

	pag_act = 'entradas';
});

$(document).on("click","#salidas",function(){
	$("#content").load('salidas.php');
	$("#salidasLi").addClass("active");
	$("#guiasLi,#activosLi,#recursosLi,#tareasLi,#fasesLi,#modelsLi,#entradasLi,#actividadesLi,#medidasLi").removeClass("active");
	pag_act = 'salidas';
});
/*********************************/
$(document).on("click","#guias",function(){
	//alert("guias");
	$('#content').load('guias.php');//cargando la vista de fase.php en el div con el id de content
	$("#guiasLi").addClass("active");
	$("#modelsLi,#activosLi,#tareasLi,#fasesLi,#actividadesLi,#entradasLi,#salidasLi,#medidasLi,#recursosLi").removeClass("active");
	pag_act = 'guias';
});
// 
$(document).on("click","#tareas",function(){
	$('#content').load('tareas.php');//cargando la vista de fase.php en el div con el id de content
	$("#tareasLi").addClass("active");
	$("#guiasLi,#activosLi,#modelsLi,#recursosLi,#fasesLi,#actividadesLi,#entradasLi,#salidasLi,#medidasLi").removeClass("active");
	pag_act = 'tareas';
});
$(document).on("click","#recursos",function(){
	//alert("guias");
	$('#content').load('recursos.php');//cargando la vista de fase.php en el div con el id de content
	$("#recursosLi").addClass("active");
	$("#guiasLi,#activosLi,#actividadesLi,#tareasLi,#fasesLi,#modelsLi,#entradasLi,#salidasLi,#medidasLi").removeClass("active");
	pag_act = 'recursos'
});
$(document).on("click","#activos",function(){
	//alert("guias");
	$('#content').load('recursos.php');//cargando la vista de fase.php en el div con el id de content
	$("#activosLi").addClass("active");
	$("#guiasLi,#actividadesLi,#tareasLi,#fasesLi,#modelsLi,#entradasLi,#salidasLi,#medidasLi,#recursosLi").removeClass("active");
	pag_act = 'recursos'
});
// Medidas
$(document).on("click","#medidas",function(){
	//alert("guias");
	$('#content').load('medidas.php');//cargando la vista de fase.php en el div con el id de content
	$("#medidasLi").addClass("active");
	$("#guiasLi,#recursosLi,#actividadesLi,#tareasLi,#fasesLi,#modelsLi,#entradasLi,#salidasLi").removeClass("active");
	pag_act = 'medidas'
});

/*--------------------------------------EDIEL---------------------*/
$(document).on("change","#idfases",function(){
	id = $(this).val()
		$.ajax({
			method: "GET",
			data: { getByModel : id},
			url: "actividadesMetodos.php",
			}).done(function( resultado ) {
			 	res = JSON.parse(resultado)
			 	//alert(res[0].);
			 	$("#idActividades").empty();
			 	if(res.length > 0){
			 		$("#idfases").append("<option>Selecciona una fase</option>")
			 		$("#idActividades").empty("<option>Selecciona una actividad</option>");
			 	}else{
			 		$("#idActividades").append("<option>Lo sentimos aun no hay Actividades</option>")

			 	}
			 	for(i=0;i<res.length;i++){
			 		$("#idActividades").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
			 	}
	    })
});

$(document).on("change","#idfasesEdit",function(){
	    id = $(this).val()

		//alert(id);	
		$.ajax({
			method: "GET",
			data: { getActividadesChange : id},
			url: "actividadesMetodos.php",
			}).done(function( resultado ) {
			
			 	res = JSON.parse(resultado)
			 	//alert(res[0].);
			 	$("#idActividadesf").empty();
			 	if(res.length > 0)
			 		$("#idActividadesf").append("<option>Selecciona una Actividad</option>")
			 	else
			 		$("#idActividadesf").append("<option>Lo sentimos aun no hay Actividades</option>")

			 	for(i=0;i<res.length;i++){
			 		$("#idActividadesf").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
			 	}
	    })
});

/*-----------------------------------------------------------*/

$(document).on("change","#models",function(){
	id = $(this).val()
		$.ajax({
			method: "GET",
			data: { getByModel : id},
			url: "fasesMetodos.php",
			}).done(function( resultado ) {
			 	res = JSON.parse(resultado)
			 	$("#idfases").empty();
			 	if(res.length > 0)
			 		$("#idfases").append("<option>Selecciona una fase</option>")
			 	else
			 		$("#idfases").append("<option>Lo sentimos aun no hay fases</option>")
			 	for(i=0;i<res.length;i++){
			 		$("#idfases").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
			 	}
	    })
});
$(document).on("change","#modelsEdit",function(){
	id = $(this).val()
	//alert("change"+id)
	$.ajax({
		method: "GET",
		data: { getByModel : id},
		url: "fasesMetodos.php",
	}).done(function( resultado ) {
	 	res = JSON.parse(resultado)
	 	$("#idfasesEdit").empty();
	 	//$("#idfasesEdit").append("<option>Selecciona una fase</option>")
	 	//if(res.length == 0)
	 	if(res.length > 0)
	 		$("#idfasesEdit").append("<option>Selecciona una fase</option>")
	 	else
	 		$("#idfasesEdit").append("<option>Lo sentimos aun no hay fases</option>")
	 	for(i=0;i<res.length;i++){
	 		$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
	 	}
	})
});

// Confirmación de eliminación de actividad
$(document).on("submit", ".eliminarActividad", function(){
	id = $(this).attr("id").split("-");
	$("#eliminarActividad-"+id[1]).find(":input").each(function(){
		element = this;
		switch(element.id){
			case 'idActividad-'+id[1]:
				$("#idActividadForm").val(element.value)
			break;
			case 'nombreAct-'+id[1]:
				$("#nombreActForm").val(element.value)
				$("#nomActividad").html("&iquest;Realmente deseas eliminar <b>"+element.value+"</b>?")
			break;
		}
	});
	$("#confirmDeleteAct").openModal();
	return false;
});
$(document).on("change","#idfases",function(){

	seccion = $(this).attr("class")
	if (seccion.indexOf("fasesOptions")>=0) {
		id = $(this).val()
		$.ajax({
			method: "GET",
			data: { getByFase : id},
			url: "actividadesMetodos.php",
		}).done(function( resultado ) {
		 	res = JSON.parse(resultado)
		 	$("#dependencia").empty();
		 	if(res.length > 0)
		 		$("#dependencia").append("<option value='0'>Selecciona una dependencia</option>")
		 	else
		 		$("#dependencia").append("<option value='0'>Lo sentimos no hay dependencias</option>")
		 	for(i=0;i<res.length;i++){
		 		$("#dependencia").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
		 	}
		})
	}else{	
		id = $(this).val()
		$.ajax({
			method: "GET",
			data: { getByFase : id},
			url: "actividadesMetodos.php",
		}).done(function( resultado ) {
		 	res = JSON.parse(resultado)
		 	$("#idActividades").empty();
		 	if(res.length > 0)
		 		$("#idActividades").append("<option>Selecciona una actividad</option>")
		 	else
		 		$("#idActividades").append("<option>Lo sentimos aun no hay actividades</option>")
		 	for(i=0;i<res.length;i++){
		 		$("#idActividades").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
		 	}
		})
	}

});
$(document).on("change","#idfasesEdit",function(){

	seccion = $(this).attr('class')

	if (seccion.indexOf("fasesEditOptions")>=0) {
		id = $(this).val()
		$.ajax({
			method: "GET",
			data: { getByFase : id},
			url: "actividadesMetodos.php",
		}).done(function( resultado ) {
		 	res = JSON.parse(resultado)
		 	$("#dependenciaEdit").empty();
		 	if(res.length > 0)
		 		$("#dependenciaEdit").append("<option value='0'>Selecciona una dependencia</option>")
		 	else
		 		$("#dependenciaEdit").append("<option value='0'>Lo sentimos no hay dependencias</option>")
		 	for(i=0;i<res.length;i++){
		 		$("#dependenciaEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
		 	}
		})
	}else{
		id = $(this).val()
		$.ajax({
			method: "GET",
			data: { getByFase : id},
			url: "actividadesMetodos.php",
		}).done(function( resultado ) {
		 	res = JSON.parse(resultado)
		 	$("#idActividadesEdit").empty();
		 	//$("#idActividadesEdit").append("<option>Selecciona una fase</option>")
		 	if(res.length > 0)
		 		$("#idActividadesEdit").append("<option>Selecciona una fase</option>")
		 	else
		 		$("#idActividadesEdit").append("<option>Lo sentimos aun no hay fases</option>")
		 	for(i=0;i<res.length;i++){
		 		$("#idActividadesEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
		 	}
		})
	}	
});
$(document).on('submit','.eliminarFase',function(){
	id = $(this).attr("id").split("-");
	//alert("id "+id[1])
	$('#eliminarFase-'+id[1]).find(':input').each(function(){
		element = this
		//alert(element.id)
		switch(element.id){
			case 'idF-'+id[1]:
				$('#idFaseForm').val(element.value)
				//alert("value "+element.value)
			break;
			case 'nomF-'+id[1]:
				$("#nombreFaseForm").val(element.value)
				//alert("value "+element.value)
				$("#nombreFase").html("&iquest;Realmente desea eliminar <b>"+element.value+"</b>?")
			break;
		}
	});
	$("#confirmDeleteFase").openModal();
	return false;//para no enviar el formulario
});
