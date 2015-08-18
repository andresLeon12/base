
function checkDecimals(fieldName, fieldValue) {
 
	decallowed = 2; // how many decimals are allowed?

	if (isNaN(fieldValue)) 
	//if (isNaN(fieldValue) || fieldValue == "") 
	{
		errorVersion.innerHTML = "El dato no es valido.Debe de ser con este formato: x.x (solo numeros)";
		fieldName.select();
		fieldName.focus();
		return false;
	}
	else 
	{
		
		//var contPunto = 0;
		//var a = fieldValue.indexOf('.');
		//alert("a "+a)
		if (fieldValue.indexOf('.') == -1)
		{
			fieldValue += ".";
			errorVersion.innerHTML = "El dato no es valido.Debe de ser con este formato: x.x";
			//alert("No encontro punto, no valido");
			return false;
		}else{

			dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);
	 		//alert("dectext length "+dectext.length)
			if (dectext.length > decallowed)
			{
				errorVersion.innerHTML = "El dato no es valido.Debe de ser con este formato: x.x";
				//alert("Por favor, entra un número con " + decallowed + " números decimales.");
				fieldName.select();
				fieldName.focus();
				return false;
		    }
			else
			{
				if(dectext.length==0){
					errorVersion.innerHTML = "El dato no es valido.Debe de ser con este formato: x.x";
					//alert("debes de introducir minimo un decimal");
					return false;
				}else{
					//alert("Número validado satisfactoriamente.");
					return true;
				}
		    }
		} 
	}
}

function borrarDiv(){
	//alert("apreto");
	errorVersion.innerHTML = "";
}

function concatenarIdActividad(){
	var idFase_Act = $("#idAct").text();
	var idAct = document.getElementById('id_Act').value;
	var valorFinal = idFase_Act+idAct;
	document.getElementById('idActividad').value = valorFinal;
}

function concatenarIdActividad2(){
	var idFase_Act = $("#idAct2").text();
	var idAct = document.getElementById('id_Act2').value;
	var valorFinal = idFase_Act+idAct;
	document.getElementById('identificadorEdit').value = valorFinal;
}
