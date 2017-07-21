// JavaScript Document
function valida_correo(email){
	regx = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@+([_a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]{2,200}\.[a-zA-Z]{2,6}$/;	
	return regx.test(email);
}	

function validarEntero(valor){
	//intento convertir a entero.
	//si era un entero no le afecta, si no lo era lo intenta convertir
	var valor = parseInt(valor);
	//Compruebo si es un valor numérico
	if (isNaN(valor)) {
		valor="";
		//entonces (no es numero) devuelvo el valor cadena vacia
		return valor;
	}
	else{
		//En caso contrario (Si era un número) devuelvo el valor
		return valor;
	}
}

function caracteres_especiales(texto){
	var texto=texto;
	//texto=sin_caracteres_especiales_mayuscula(texto);
	texto=sin_caracteres_especiales_minuscula(texto);

	texto=texto.replace(/[´`^¨'"!·@#$%?¡¿\/]/gi,'');
	
	return texto;
}

function sin_caracteres_especiales_mayuscula(texto){
	var texto=texto;
	texto=texto.replace(/[Ñ]/gi,'N');
	
	texto=texto.replace(/[ÁÀÂÄ]/gi,'A');
	
	texto=texto.replace(/[ÉÈÊË]/gi,'E');
	
	texto=texto.replace(/[ÍÌÎÏ]/gi,'I');
	
	texto=texto.replace(/[ÓÒÔÖ]/gi,'O');
	
	texto=texto.replace(/[ÚÙÛÜ]/gi,'U');
	
	return texto;
}

function sin_caracteres_especiales_minuscula(texto){
	var texto=texto;
	texto=texto.replace(/[ñ]/gi,'n');
	texto=texto.replace(/[áàâä]/gi,'a');
	texto=texto.replace(/[éêèë]/gi,'e');	
	texto=texto.replace(/[íîìï]/gi,'i');	
	texto=texto.replace(/[óôòöõ]/gi,'o');
	texto=texto.replace(/[úùûü]/gi,'u');

	return texto;
}