
function checkDecimals(fieldName, fieldValue) {
 
	decallowed = 2; // how many decimals are allowed?

	if (isNaN(fieldValue) || fieldValue == "") 
	{
		errorVersion.innerHTML = "La version no es valida";
		//alert("El número no es válido. Prueba de nuevo.");
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
			errorVersion.innerHTML = "La version no es valida";
			//alert("No encontro punto, no valido");
			return false;
		}else{

			dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);
	 		//alert("dectext length "+dectext.length)
			if (dectext.length > decallowed)
			{
				errorVersion.innerHTML = "La version no es valida";
				//alert("Por favor, entra un número con " + decallowed + " números decimales.");
				fieldName.select();
				fieldName.focus();
				return false;
		    }
			else
			{
				if(dectext.length==0){
					errorVersion.innerHTML = "La version no es valida";
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

function borrarDiv(fieldName){
	document.getElementById('errorVersion').value = "";
}