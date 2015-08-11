// Login de usuario
var msj = '';
m = setInterval(titulo, 5000);
$(document).ready(function(){
	
	$('ul.tabs').tabs();
	$('.datepicker').pickadate({
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 15 // Creates a dropdown of 15 years to control year
	  });
	//$("#FormRecurso").hide();
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
		$("#actividadesLi").removeClass("active");
		$("#fasesLi").removeClass("active");
		break;
		case 'fases':
		$('#content').load('fases.php');//cargando la vista de fase.php en el div con el id de content
		$("#fasesLi").addClass("active");
		$("#actividadesLi").removeClass("active");
		$("#modelsLi").removeClass("active");
		break;
		case 'actividades':
		$("#actividadesLi").addClass("active");
		$("#modelsLi").removeClass("active");
		$("#fasesLi").removeClass("active");
		break;
		case 'recursos':
		$("#recursosLi").addClass("active");
		$("#modelsLi").removeClass("active");
		$("#fasesLi").removeClass("active");
		$("#actividadesLi").removeClass("active");
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

/*$(document).on("click","#modelos",function(){
	$("#content").load('printModelos.php');
});*/
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
			  url: "getByID.php",
			}).done(function( resultado ) {
				
			 	res = JSON.parse(resultado)
		
			 	$("#cabecera").html("  Realmente desea eliminar el modelo  "+res.nombreM) //poner el nombre del modelo a eliminar en el modal
			 	
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
			  url: "getByID.php",
			}).done(function( resultado ) {
				
			 	res = JSON.parse(resultado)
			 	
			 	$("#idModelo").val(res.idModelo_P)//el id para actualizar los datos
			 	$("#nomModelo").html(res.nombreM)
			 	$("#nombre2").val(res.nombreM)
			 	$("#desc2").val(res.descripcion)
			 	$("#version2").val(res.version)
			 	$("#nombre2").focus()
			 	$("#desc2").focus()
			 	$("#version2").focus()
			 })
			 $("#model").openModal()

			 return true;

		}

	if(href==="#!"){
		if (seccion.indexOf("miModelo")>=0) {
			idModel = $(this).attr("id")
			//alert("#! -- "+idModel)
			$.ajax({
			  method: "GET",
			  data: { table : 'modelo_p', id : idModel, idTable : 'idModelo_P'},
			  url: "getByID.php",
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
			 	//$("#model").openModal()
			 })
			 $("#model").openModal()
		}else if(seccion.indexOf("miFase")>=0){
				
				idFase = $(this).attr('id')

				var auxIdModelo = 0;

				$.ajax({
					method: 'GET',
					data: {table : 'fase' , id : idFase , idTable : 'idFase'},
					url: "getByID.php",
				}).done(function(resultado){
					res = JSON.parse(resultado)
					$("#idFase").val(res.idFase)//el id para actualizar los datos
				 	$("#nomFase").html(res.nombre)
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

				 	//$('#modelFase').openModal()

				 	$("#nombre2").focus()
			 		$("#orden2").focus()
			 		$("#descripcion2").focus()
			 		$("#nombre2").focus()
				})

				$('#modelFase').openModal()
			}else if(seccion.indexOf("miActividad")>=0){
				idActividad = $(this).attr('id')
				var idFase = idModel = 0;
				$.ajax({
					method: 'GET',
					data: {table : 'actividad' , id : idActividad , idTable : 'idActividad'},
					url: "getByID.php",
				}).done(function(resultado){
					res = JSON.parse(resultado)
					$("#nombreEdit").val(res.nombre)
					
					$("#descripcionEdit").val(res.descripcion)
					
					$("#tipoEdit").val(res.tipo)
					
					$("#idActividadEdit").val(idActividad)
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
							$("#idFasesEdit").append("Selecciona una fase");
							for(i=0;i<res.length;i++){
								if(res[i].idFase == idFase)
						 			$("#idfasesEdit").append("<option selected value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 		else
						 			$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
						 	}
						})
						$("#nombreEdit").focus()
						$("#descripcionEdit").focus()
						$("#tipoEdit").focus()
						$("#idActividadEdit").focus()
						$('#editarActividad').openModal()
					})
				})
			}
	}

});

//cuando da clic en la pestaña de fases
$(document).on("click","#fases",function(){
	//alert("Fases");
	$('#content').load('fases.php');//cargando la vista de fase.php en el div con el id de content
	$("#fasesLi").addClass("active");
	$("#actividadesLi").removeClass("active");
	$("#modelsLi").removeClass("active");
	pag_act = 'fases';
});

$(document).on("click","#modelos",function(){
	$("#content").load('administrador.php');
	$("#modelsLi").addClass("active");
	$("#actividadesLi").removeClass("active");
	$("#fasesLi").removeClass("active");
	pag_act = 'modelos';
});
// Cargamos contenido de actividades
$(document).on("click","#actividades",function(){
	$("#content").load('actividades.php');
	$("#actividadesLi").addClass("active");
	$("#modelsLi").removeClass("active");
	$("#fasesLi").removeClass("active");
	pag_act = 'actividades';
});
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
	$.ajax({
		method: "GET",
		data: { getByModel : id},
		url: "fasesMetodos.php",
	}).done(function( resultado ) {
	 	res = JSON.parse(resultado)
	 	$("#idfasesEdit").empty();
	 	if(res.length > 0)
	 		$("#idfasesEdit").append("<option>Selecciona una fase</option>")
	 	else
	 		$("#idfasesEdit").append("<option>Lo sentimos aun no hay fases</option>")
	 	for(i=0;i<res.length;i++){
	 		$("#idfasesEdit").append("<option value='"+res[i].idFase+"'>"+res[i].nombre+"</option>");
	 	}
	})
});
$(document).on("change","#idfases",function(){
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
	 		$("#idActividades").append("<option>Lo sentimos aun no hay fases</option>")
	 	for(i=0;i<res.length;i++){
	 		$("#idActividades").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
	 	}
	})
});
$(document).on("change","#idfasesEdit",function(){
	id = $(this).val()
	$.ajax({
		method: "GET",
		data: { getByFase : id},
		url: "actividadesMetodos.php",
	}).done(function( resultado ) {
	 	res = JSON.parse(resultado)
	 	$("#idActividadesEdit").empty();
	 	if(res.length > 0)
	 		$("#idActividadesEdit").append("<option>Selecciona una fase</option>")
	 	else
	 		$("#idActividadesEdit").append("<option>Lo sentimos aun no hay fases</option>")
	 	for(i=0;i<res.length;i++){
	 		$("#idActividadesEdit").append("<option value='"+res[i].idActividad+"'>"+res[i].nombre+"</option>");
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
				$("#nomActividad").html("¿Realmente deseas eliminar "+element.value+"?")
			break;
		}
	});
	$("#confirmDeleteAct").openModal();
	return false;
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
				$("#nombreFase").html("Realmente desea eliminar "+element.value+"?")
			break;
		}
	});
	$("#confirmDeleteFase").openModal();
	return false;//para no enviar el formulario
});