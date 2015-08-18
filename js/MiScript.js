





$(document).on("click","a", function(){


	if(href=="#editEntrada"){
		
		idEntrada = $(this).attr("id");
		$("#idActividadEdit").val(idEntrada);
		/******************Traer el id de la actividad a la que pertenece la entrada*******************/
		$.ajax({
			method: 'GET',
			data: {getAct : 'getActividadesFase' ,id:idEntrada},
			url: "entradasMetodos.php",
			}).done(function(resultado){
				res2 = JSON.parse(resultado)
				//alert("este es : "+res2.Actividad_idActividad);
				idActividad  = res2.Actividad_idActividad;
			})
		/***********************************/

		$.ajax({
				method: 'GET',
				data: {type : 'getDatos', id : idEntrada },
				url: "entradasMetodos.php",
				}).done(function(resultado){
					//alert(resultado);
					res = JSON.parse(resultado)
					//alert(res.nombre);
					$("#nombreEntradaEdit").val(res.nombre)
					$("#descripcionEdit").val(res.descripcion)
					$("#titulo").html("Entrada :  "+res.nombre);

///////////////////////////////////////////////////traer la actividad a la que pertenece


					$.ajax({
						method: 'GET',
						data: {getActividad : 'getActividad', id : idEntrada },
						url: "entradasMetodos.php",
						}).done(function(resultado){

			


							res = JSON.parse(resultado)
							idFase  = res.Fase_idFase;
							//alert(idFase);
							////////////////////////////////////////////////////// ajax para traer la fase a la que pertenece
							$.ajax({
								method: 'GET',
								data: {getFase : 'getFase', id : idFase },
								url: "entradasMetodos.php",
							}).done(function(resultado){
								res = JSON.parse(resultado)

								idModelo  = res.Modelo_P_idModelo_P;

								/*------------------------------------------------------------- Modelo al que pertenece la entrada  --------------*/
								$.ajax({
									method: 'GET',
									data: {getModelo : 'getModelo', id : idModelo },
									url: "entradasMetodos.php",
								}).done(function(resultado){
									res = JSON.parse(resultado)


									/*------todos los modelos ----------------*/
									$.ajax({
										method: 'GET',
										data: {getModelos : 'getModelos' },
										url: "entradasMetodos.php",
									}).done(function(resultado){
										res = JSON.parse(resultado)
				
										$("#modelsEdit").empty();
										$("#modelsEdit").append("<option>Seleccione un Modelo de Proceso</option>");
										for(i=0;i<res.length;i++){
											//alert(res[i].idModelo_P);
											if(res[i].idModelo_P == idModelo)
						 						$("#modelsEdit").append("<option selected value='"+res[i].idModelo_P+"'>"+res[i].nombreM+"</option>");
						 					else
						 						$("#modelsEdit").append("<option value='"+res[i].idModelo_P+"'>"+res[i].nombreM+"</option>");
						 				}
						 				

									})
									/*--------fin todos los modelos*/
									

									/*TODAS LAS FASES*/

									$.ajax({
										method: 'GET',
										data: {getFaseModelo : 'getModelos' ,id:idModelo},
										url: "entradasMetodos.php",
									}).done(function(resultado){
										res = JSON.parse(resultado)
				
										$("#idfasesEdit").empty();
										$("#idfasesEdit").append("<option>Selecciona una fase</option>");

										for(i=0;i<res.length;i++){
											//alert(res[i].idFase);
											if(res[i].idFase == idFase)
						 						$("#idfasesEdit").append("<option selected value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 					else
						 						$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 				}
						 				

									})

									/*--------------*/
									

									/* TODAS LAS ACTIVIDADES*/
									$.ajax({
										method: 'GET',
										data: {getActividadesFase : 'getActividadesFase' ,id:idFase},
										url: "entradasMetodos.php",
									}).done(function(resultado){
										res = JSON.parse(resultado)


								
				
										$("#idActividadesEdit").empty();
										//$("#idActividadesEdit").append("<option>Selecciona una actividad</option>");

										for(i=0;i<res.length;i++){
											//alert(res[i].nombre);
											if(res[i].idActividad == idActividad)
						 						$("#idActividadesEdit").append("<option selected value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
						 					else
						 						$("#idActividadesEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
						 				}

						 				
						 				

									})
									/*--------------------------*/
								
								})
								/*--------------------------------------------------------------------*/




							})
							/*-----------------------------------------------------------------------*/
						
						})

				
				})


		
		$("#editarEntrada").openModal()//////////////
		$("#nombreEntradaEdit").focus();
		///////////////////////
		return true;

	}







	/////////////////////////////////SCRIPT PARA EDITAR UNA SALIDA
	if(href=="#editSalida"){
		idSalida = $(this).attr("id");
		$("#idActividadEdit").val(idSalida);
		/******************Traer el id de la actividad a la que pertenece la entrada*******************/
		$.ajax({
			method: 'GET',
			data: {getAct : 'getActividadesFase' ,id:idSalida},
			url: "salidasMetodos.php",
			}).done(function(resultado){
				res2 = JSON.parse(resultado)
				//alert("este es : "+res2.Actividad_idActividad);
				idActividad  = res2.Actividad_idActividad;
			})
		/***********************************/

		$.ajax({
				method: 'GET',
				data: {type : 'getDatos', id : idSalida },
				url: "salidasMetodos.php",
				}).done(function(resultado){
					//alert(resultado);
					res = JSON.parse(resultado)
					//alert(res.nombre);
					$("#nombreSalidaEdit").val(res.nombre)
					$("#descripcionEdit").val(res.descripcion)
					$("#titulo").html("Salida :  "+res.nombre);

///////////////////////////////////////////////////traer la actividad a la que pertenece


					$.ajax({
						method: 'GET',
						data: {getActividad : 'getActividad', id : idSalida },
						url: "salidasMetodos.php",
						}).done(function(resultado){

			


							res = JSON.parse(resultado)
							idFase  = res.Fase_idFase;
							//alert(idFase);
							////////////////////////////////////////////////////// ajax para traer la fase a la que pertenece
							$.ajax({
								method: 'GET',
								data: {getFase : 'getFase', id : idFase },
								url: "salidasMetodos.php",
							}).done(function(resultado){
								res = JSON.parse(resultado)

								idModelo  = res.Modelo_P_idModelo_P;

								/*------------------------------------------------------------- Modelo al que pertenece la entrada  --------------*/
								$.ajax({
									method: 'GET',
									data: {getModelo : 'getModelo', id : idModelo },
									url: "salidasMetodos.php",
								}).done(function(resultado){
									res = JSON.parse(resultado)


									/*------todos los modelos ----------------*/
									$.ajax({
										method: 'GET',
										data: {getModelos : 'getModelos' },
										url: "salidasMetodos.php",
									}).done(function(resultado){
										res = JSON.parse(resultado)
				
										$("#modelsEdit").empty();
										$("#modelsEdit").append("<option>Seleccione un Modelo de Proceso</option>");
										for(i=0;i<res.length;i++){
											//alert(res[i].idModelo_P);
											if(res[i].idModelo_P == idModelo)
						 						$("#modelsEdit").append("<option selected value='"+res[i].idModelo_P+"'>"+res[i].nombreM+"</option>");
						 					else
						 						$("#modelsEdit").append("<option value='"+res[i].idModelo_P+"'>"+res[i].nombreM+"</option>");
						 				}
						 				

									})
									/*--------fin todos los modelos*/
									

									/*TODAS LAS FASES*/

									$.ajax({
										method: 'GET',
										data: {getFaseModelo : 'getModelos' ,id:idModelo},
										url: "salidasMetodos.php",
									}).done(function(resultado){
										res = JSON.parse(resultado)
				
										$("#idfasesEdit").empty();
										$("#idfasesEdit").append("<option>Selecciona una fase</option>");

										for(i=0;i<res.length;i++){
											//alert(res[i].idFase);
											if(res[i].idFase == idFase)
						 						$("#idfasesEdit").append("<option selected value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 					else
						 						$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 				}
						 				

									})

									/*--------------*/
									

									/* TODAS LAS ACTIVIDADES*/
									$.ajax({
										method: 'GET',
										data: {getActividadesFase : 'getActividadesFase' ,id:idFase},
										url: "salidasMetodos.php",
									}).done(function(resultado){
										res = JSON.parse(resultado)


								
				
										$("#idActividadesEdit").empty();
										//$("#idActividadesEdit").append("<option>Selecciona una actividad</option>");

										for(i=0;i<res.length;i++){
											//alert(res[i].nombre);
											if(res[i].idActividad == idActividad)
						 						$("#idActividadesEdit").append("<option selected value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
						 					else
						 						$("#idActividadesEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
						 				}

						 				
						 				

									})
									/*--------------------------*/
								
								})
								/*--------------------------------------------------------------------*/




							})
							/*-----------------------------------------------------------------------*/
						
						})

				
				})


		
		$("#editarSalida").openModal()//////////////
		$("#nombreSalidaEdit").focus();
		///////////////////////
		return true;

	}


	//////////////////////////////FIN DE SCRIT EDITAR SALIDA

//-----------------------------------------------------------------Editar un Producto de Trabajo ----------------------
	if(href=="#editarProducto"){
		idProducto = $(this).attr("id");
		$("#idProductoEdit").val(idProducto);
		//alert(idProducto);
		//-------------------Trae el nombre del producto de trabajo
		$.ajax({
			method: 'GET',
			data: {getNombreProducto : 'getNombreProducto' ,id:idProducto},
			url: "productosMetodos.php",
			}).done(function(resultado){
				//alert(resultado)
				res = JSON.parse(resultado)
				$("#nomProducto").html("Producto de Trabajo : "+res.nombre);
				$("#tipoProductoEdit").val(res.tipo)
				$("#nombreProductoEdit").val(res.nombre)
				$("#versionProductoEdit").val(res.version)
				$("#nombreProductoEdit").focus();
		})
		//--------------------------------------------

		/******************Traer el id de la Tarea  a la que pertenece el producto*******************/
		$.ajax({
			method: 'GET',
			data: {getTareaByProducto : 'getTareaByProducto' ,id:idProducto},
			url: "productosMetodos.php",
			}).done(function(resultado){
		
				res = JSON.parse(resultado)

				
				//alert("nombre de la Tarea ");
				idTarea  = res.idTarea;
			
				idActividad  = res.Actividad_idActividad;
				nombreTarea  = res.nombre;
			
			
				$.ajax({
					method: 'GET',
					data: {getAllTareas : 'getAllTareas' },
					url: "productosMetodos.php",
				}).done(function(resultado){
				
					res = JSON.parse(resultado)
					$("#idTareasEdit").empty();
					$("#idTareasEdit").append("<option value='0'>Selecciona una tarea</option>");
					for (var i = 0; i < res.length; i++) {
						if(res[i].idTarea == idTarea){
					
							$("#idTareasEdit").append("<option selected value='"+res[i].idTarea+"'>"+res[i].nombre+"</option>");
						}else{
							$("#idTareasEdit").append("<option value='"+res[i].idTarea+"'>"+res[i].nombre+"</option>");
						}
					};


				})
				//-----fin todas las tareas

			
				//--------todas las actividades
				
				$.ajax({
					method: 'GET',
					data: {getAllActividades : 'getAllActividades' },
					url: "productosMetodos.php",
				}).done(function(resultado){
					res = JSON.parse(resultado)
					$("#idActividadesEdit").empty();
					$("#idActividadesEdit").append("<option value='0'>Selecciona una actividad</option>");
					for (var i = 0; i < res.length; i++) {
				
						if(res[i].idActividad == idActividad){
							$("#idActividadesEdit").append("<option selected value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
						}else{
							$("#idActividadesEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
						}
					};


				})
				//----------fin de todas las actividades
				
				//alert(idActividad)
				//------------------ ir por el nombre de la actividad y el id de la fase
				
				$.ajax({
					method: 'GET',
					data: {getActividadByTarea : 'getActividadByTarea' ,id:idActividad},
					url: "productosMetodos.php",
				}).done(function(resultado){
					//alert(resultado);
					res = JSON.parse(resultado)
					nombreActividad  = res.nombre;
					idFase  = res.Fase_idFase;

					//--------todas las fases
					$.ajax({
						method: 'GET',
						data: {getAllFases : 'getAllFases' },
						url: "productosMetodos.php",
					}).done(function(resultado){
						//alert(resultado);
						res = JSON.parse(resultado)
						$("#idfasesEdit").empty();
						$("#idfasesEdit").append("<option value='0'>Selecciona una fase</option>");
						for (var i = 0; i < res.length; i++) {
							if(res[i].idFase == idFase){
								$("#idfasesEdit").append("<option selected value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
							}else{
								$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
							}
						};

					})
					//----------------fin de todas las fases
				
					//-------------traer el modelo al que pertenece
					$.ajax({
						method: 'GET',
						data: {getModeloByFase : 'getModeloByFase' ,id:idFase},
						url: "productosMetodos.php",
					}).done(function(resultado){
						//alert(resultado);
						res = JSON.parse(resultado)
						idModelo  = res.Modelo_P_idModelo_P;

						///------------todos los modelos
						$.ajax({
							method: 'GET',
							data: {getAllModelos : 'getAllModelos' },
							url: "productosMetodos.php",
						}).done(function(resultado){
							//alert(resultado);
							res = JSON.parse(resultado)
							$("#modelsEdit").empty();
							$("#modelsEdit").append("<option value='0'>Selecciona una modelo</option>");
							for (var i = 0; i < res.length; i++) {
								if(res[i].idModelo_P == idModelo){
									$("#modelsEdit").append("<option selected value='"+res[i].idModelo_P+"'>"+res[i].nombreM+"</option>");
								}else{
									$("#modelsEdit").append("<option value='"+res[i].idModelo_P+"'>"+res[i].nombreM+"</option>");
								}
							};

						})
						//---end all models

					})
					//-----------------fin de traer el modelo al que pertenece






				})
				//----------------------------------------------------

		})
		/***********************************/
		$("#nombreProductoEdit").focus();
		$("#editarProducto").openModal()//////////////
		
		return;

	}
//------------------------------------------------------------Fin Editar un producto de trabajo

	




});



// Confirmación de eliminación de entrada
$(document).on("submit", ".eliminarEntrada", function(){
	
	id = $(this).attr("id").split("-");
	
	$("#eliminarEntrada-"+id[1]).find(":input").each(function(){
		element = this;

		switch(element.id){
			case 'idEntrada-'+id[1]:
				$("#idEntradaForm").val(element.value)
			break;
			case 'nombreEnt-'+id[1]:
				$("#nombreActForm").val(element.value)
				$("#nomEntrada").html("¿Realmente deseas eliminar la entrada  "+element.value+"?")
			break;
		}
	});

	$("#confirmDeleteEnt").openModal();
	return false;
});

// Confirmación de eliminación de salida
$(document).on("submit", ".eliminarSalida", function(){
	
	id = $(this).attr("id").split("-");
	
	$("#eliminarSalida-"+id[1]).find(":input").each(function(){
		element = this;

		switch(element.id){
			case 'idSalida-'+id[1]:
				$("#idSalidaForm").val(element.value)
			break;
			case 'nombreSal-'+id[1]:
				$("#nombreActForm").val(element.value)
				$("#nomSalida").html("¿Realmente deseas eliminar la salida  "+element.value+"?")
			break;
		}
	});

	$("#confirmDeleteSal").openModal();
	return false;
});


// Confirmación de eliminación de productp
$(document).on("submit", ".eliminarProducto", function(){
	
	id = $(this).attr("id");

	//alert(id);
	
	$(this).find("input:hidden").each( function(){
		nombre =  this.id;
	});

	$("#idProductoForm").val(id);
	$("#nombreActForm").val(nombre);
	$("#nomProductoEliminar").html("¿Realmente deseas eliminar el Producto de Trabajo "+nombre+"  ?");





	$("#confirmDeletePro").openModal();
	return false;
});
/*******************************************************/
	






