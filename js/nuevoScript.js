// Mostrar activos de una actividad
$(document).on("submit", ".showMyActivos", function(){
	id = $(this).attr("id").split("-");
	// Obtenemos los datos para la consulta
	idActividad = 0;
	nomActividad = '';
	$("#showMyActivos-"+id[1]).find(":input").each(function(){
		element = this;
		switch(element.id){
			case 'idActividadF1-'+id[1]:
				idActividad = element.value;
			break;
			case 'nombreActF1-'+id[1]:
				nomActividad = element.value;
			break;
		}
	});
	// Obtenemos todos los activos en base al id de la actividad
	$("#resultadosTable").empty();
	$.ajax({
		method: "GET",
		data: { table : 'a_activo', id : idActividad, idTable : "Actividad_idActividad", array : 'array'},
		url: "getById.php",
	}).done(function( resultado ) {			
		res = JSON.parse(resultado)
		// Lenamos la tabla con la informacion de cada uno de los activos
		if(res.length <=0 ){
			$("#resultadosTable").append("<tr><td colspan='4'>No hay activos en esta actividad</td></tr>")
		}else{
			for(i=0; i<res.length;i++){
				// Obtenemos la informacion del activo
				$.ajax({
					method: "GET",
					data: { table : 'activo', id : res[i].Activo_idActivo, idTable : "idActivo"},
					url: "getById.php",
				}).done(function( resultado2 ) {			
					res2 = JSON.parse(resultado2)
					$("#resultadosTable").append("<tr>")
					$("#resultadosTable").append("<td><a target='blank' href='../../archivos/"+res2.nombre+"'>"+res2.nombre+"</a></td>");
					$("#resultadosTable").append("<td>"+res2.descripcion+"</td>");
					$("#resultadosTable").append("<td><a href='#!' id='"+res2.idActivo+"' class='miActivo btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-settings'>Editar</i></a></td>");
					$("#resultadosTable").append("<td><form class='eliminarActivo' id='eliminarActivo-"+res2.idActivo+"' method='POST'><input type='hidden' id='idActivo-"+res2.idActivo+"' value='"+res2.idActivo+"'/><input type='hidden'  id='nombreActivo-"+res2.idActivo+"' value='"+res2.nombre+"'/><button type='submit' name='eliminar' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button></form></td>");
					$("#resultadosTable").append("</tr>")
				})
			}
		}
	})
	$("#resultadosActivos").openModal();
	return false;
});
// Mostrar guias de una actividad
$(document).on("submit", ".showMyGuias", function(){
	id = $(this).attr("id").split("-");
	// Obtenemos los datos para la consulta
	idActividad = 0;
	nomActividad = '';
	$("#showMyGuias-"+id[1]).find(":input").each(function(){
		element = this;
		switch(element.id){
			case 'idActividadF2-'+id[1]:
				idActividad = element.value;
			break;
			case 'nombreActF2-'+id[1]:
				nomActividad = element.value;
			break;
		}
	});
	// Obtenemos todos los activos en base al id de la actividad
	$("#resultadosTable2").empty();
	$.ajax({
		method: "GET",
		data: { table : 'a_guia', id : idActividad, idTable : "Actividad_idActividad", array : 'array'},
		url: "getById.php",
	}).done(function( resultado ) {			
		res = JSON.parse(resultado)
		// Lenamos la tabla con la informacion de cada uno de los activos
		if(res.length <=0 ){
			$("#resultadosTable2").append("<tr><td colspan='4'>No hay guías en esta actividad</td></tr>")
		}else{
			for(i=0; i<res.length;i++){
				// Obtenemos la informacion del activo
				$.ajax({
					method: "GET",
					data: { table : 'guia', id : res[i].Guia_idGuia, idTable : "idGuia"},
					url: "getById.php",
				}).done(function( resultado2 ) {			
					res2 = JSON.parse(resultado2)
					$("#resultadosTable2").append("<tr>")
					$("#resultadosTable2").append("<td><a target='blank' href='../../archivos/"+res2.nombre+"'>"+res2.nombre+"</a></td>");
					$("#resultadosTable2").append("<td>"+res2.tipo+"</td>");
					$("#resultadosTable2").append("<td><a href='#!' id='"+res2.idGuia+"' class='miGuia btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-settings'>Editar</i></a></td>");
					$("#resultadosTable2").append("<td><form class='eliminarGuia' id='eliminarGuia-"+res2.idGuia+"' method='POST'><input type='hidden' id='idGuia-"+res2.idGuia+"' value='"+res2.idGuia+"'/><input type='hidden'  id='nombreGuia-"+res2.idGuia+"' value='"+res2.nombre+"'/><button type='submit' name='eliminar' class='btn-floating btn-large waves-effect waves-light red'><i class='mdi-action-delete'></i></button></form></td>");
					$("#resultadosTable2").append("</tr>")
				})
			}
		}
	})
	$("#resultadosGuias").openModal();
	return false;
});
// funcion para mostrar formulario  de crear un nuevo activo
function nuevoActivo(idA, idM){
	$("#descripcionActivo3").val("")
	$("#previewActivo3").val("")
	$("#idActividadNuevoActivo").val(idA);
	$("#idModelNuevoActivo").val(idM);
	$("#nuevoActivo").openModal();
}
// funcion para mostrar formulario  de crear un nuevo guia
function nuevaGuia(idA, idM){
	$("#descripcionGuia3").val("")
	$("#previewGuia3").val("")
	$("#idActividadNuevaGuia").val(idA);
	$("#idModelNuevaGuia").val(idM);
	$("#nuevaGuia").openModal();
}