$(document).on("click","#tareas",function(){
	$('#content').load('tareas.php');//cargando la vista de fase.php en el div con el id de content
	$("#tareasLi").addClass("active");
	$("#fasesLi").removeClass("active");
	$("#actividadesLi").removeClass("active");
	$("#modelsLi").removeClass("active");
	pag_act = 'tareas';
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
//++++++++++++++++++++++++++++++++++++++++++++++++++++
$(document).on('submit','.eliminarMedida',function(){
	id = $(this).attr("id").split("-");
	$('#eliminarMedida-'+id[1]).find(':input').each(function(){
		element = this;
		//alert(element.id)
		switch(element.id){
			case 'idM-'+id[1]:
				$('#idMedidaForm').val(element.value);
				//alert("value "+element.value)
			break;
			case 'nomM-'+id[1]:
				$("#nombreMedidaForm").val(element.value);
				$("#nameMedida").html("&iquest;Realmente desea eliminar <b>"+element.value+"</b>?");
			break;
		}
	});
	$("#confirmDeleteMedida").openModal();
	return false;//para no enviar el formulario
});
// ***************************************************
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
$(document).on("change","#selectContent", function(){
	if($(this).prop("checked")){
		$("#seccion_act").val("resultados")
		$("#Formulario").slideUp("slow");
		$("#resultados").slideDown("slow");
		$("#title").fadeOut("slow");
		$("#titleR").fadeIn("slow");
	}else{
		$("#seccion_act").val("Formulario")
		$("#Formulario").slideDown("slow");
		$("#resultados").slideUp("slow");
		$("#title").show("slow");
		$("#titleR").hide("slow");
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

$(document).on("change","#modeloOptions",function(){
	id = $(this).val()
	//alert("modeloOptions "+id)
		/*$.ajax({
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
	    })*/
});
