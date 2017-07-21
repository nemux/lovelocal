// JavaScript Document

function objetoAjax(){

 var xmlhttp=false;

  try{

   xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

  }catch(e){

   try {

    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

   }catch(E){

    xmlhttp = false;

   }

  }

  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {

   xmlhttp = new XMLHttpRequest();

  }

  return xmlhttp;

}



function Pagina(nropagina,cuantos,p_nombre){

	//alert("nombre "+p_nombre);

	var aleatorio= generar_aleatorio();

	var pagina= new Number(nropagina)* 1;

	var cuantos= cuantos;

	var p_nombre= p_nombre;

	

	if(cuantos!="todos"){

		cuantos= new Number(cuantos)* 1;

	}

	

 	//donde se mostrará los registros

	divContenido = document.getElementById('div_contenido');

 

 ajax=objetoAjax();

 //uso del medoto GET

 //indicamos el archivo que realizará el proceso de paginar

 //junto con un valor que representa el nro de pagina

 ajax.open("GET", "contenido.php?pag="+pagina+"&registros="+cuantos+"&p_nombre="+p_nombre+"&aleatorio="+aleatorio);

 divContenido.innerHTML= '<img src="http://www.lovelocal.mx/administrador/images/gifs/loading.gif">';

 ajax.onreadystatechange=function() {

  if (ajax.readyState==4) {

   //mostrar resultados en esta capa

   divContenido.innerHTML= ajax.responseText

  }

 }

 //como hacemos uso del metodo GET

 //colocamos null ya que enviamos 

 //el valor por la url ?pag=nropagina

 ajax.send(null)

}



function actualizar_notas_sistema(){

	var aleatorio= generar_aleatorio();

	var notas_sistema=tinyMCE.get('notas_sistema').getContent();

	var contenedor=document.getElementById('div_respuesta_notas_sistema');

	

	//alert(notas_sistema);

	

	ajax=objetoAjax();

	ajax.open("GET", "actualizar_notas_sistema.php?notas_sistema="+encodeURIComponent(notas_sistema)+"&aleatorio="+aleatorio);

	//ajax.open("GET", "actualizar_notas_sistema.php?notas_sistema="+notas_sistema+"&aleatorio="+aleatorio);

	contenedor.innerHTML='<img src="/administrador/images/gifs/loading.gif">';

	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {

			//alert(ajax.responseText);

			tinyMCE.get('notas_sistema').setContent(ajax.responseText);

			contenedor.innerHTML="Notas del Super Administrador actualizadas exitosamente";

		}

	}

	ajax.send(null)

}



function actualizar_notas_personales(){

	var aleatorio= generar_aleatorio();

	var notas_personales=tinyMCE.get('notas_personales').getContent();

	var contenedor=document.getElementById('div_respuesta_notas_personales');

	ajax=objetoAjax();

	ajax.open("GET", "actualizar_notas_personales.php?notas_personales="+encodeURIComponent(notas_personales)+"&aleatorio="+aleatorio);

	contenedor.innerHTML='<img src="/administrador/images/gifs/loading.gif">';

	ajax.onreadystatechange=function() {

		if(ajax.readyState==4){

			//alert(ajax.responseText);

			tinyMCE.get('notas_personales').setContent(ajax.responseText);

			contenedor.innerHTML="Notas personales actualizadas exitosamente";

		}

	}

	ajax.send(null)

}



function nuevo(){

	var aleatorio= generar_aleatorio();

	

 	//donde se mostrará el formulario	

	divContenido = document.getElementById('div_contenido');

 

	ajax=objetoAjax();

	//uso del medoto GET

	ajax.open("GET", "nuevo/?aleatorio="+aleatorio);

	divContenido.innerHTML= '<img src="http://www.lovelocal.mx/administrador/images/gifs/loading.gif">';

	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {

			//mostrar resultados en esta capa

			divContenido.innerHTML= ajax.responseText

		}

	}

	//como hacemos uso del metodo GET

	//colocamos null ya que enviamos 

	//el valor por la url

	ajax.send(null)

}



function eliminar(){

	var aleatorio= generar_aleatorio();

	var registros= document.getElementsByName("arreglo_registros[]");

	var registros_seleccionados= false;

	var registros_a_eliminar="";

	for (var i= 0; i< registros.length; i++){

		if(registros[i].checked){

			registros_seleccionados= true;

			registros_a_eliminar=registros_a_eliminar+"|"+registros[i].value;

	  	}

	}

	if(!registros_seleccionados){

		alert('Debe seleccionar al menos un registro para eliminar');

		return false;

	}

	else{

		registros_a_eliminar=registros_a_eliminar.substr(1);

		

		if(!confirm("¿Esta seguro de eliminar los registros seleccionados?")){

			return false;

		}

		else{

			divContenido = document.getElementById('div_respuesta');

		 

			ajax=objetoAjax();

			//uso del medoto GET

			//indicamos el archivo que realizará el proceso de paginar

			//junto con un valor que representa el nro de pagina

			ajax.open("GET", "eliminar/?registros="+registros_a_eliminar+"&aleatorio="+aleatorio);

			divContenido.innerHTML= '<img src="http://www.lovelocal.mx/administrador/images/gifs/loading.gif">';

			ajax.onreadystatechange=function() {

				if (ajax.readyState==4) {

					//mostrar resultados en esta capa

					divContenido.innerHTML="";

					alert(ajax.responseText);

					Pagina(1,document.form_contenido.registros.value,document.form_contenido.p_nombre.value);

				}

			}

			//como hacemos uso del metodo GET

			//colocamos null ya que enviamos 

			//el valor por la url ?pag=nropagina

			ajax.send(null)

		}

	}

}



function actualizar(registro){

	var registro=new Number(registro)*1;

	var aleatorio=generar_aleatorio();



	var registros_seleccionados=false;

	var registros_a_actualizar="";

	

	

	if(registro==0){

		var registros=document.getElementsByName("arreglo_registros[]");

		for(var i=0;i<registros.length;i++){

			if(registros[i].checked){

				registros_seleccionados=true;

				registros_a_actualizar=registros[i].value;

			}

			if(registros_seleccionados==true){

				i=registros.length;

			}

		}

	}

	else{

		registros_seleccionados=true;

		registros_a_actualizar=registro;

	}

	

	if(!registros_seleccionados){

		alert('Debe seleccionar al menos un registro para actualizar');

		return false;

	}

	else{

		document.form_contenido.registro.value=registros_a_actualizar;

		document.form_contenido.action="actualizar/";

		document.form_contenido.submit();

	}

	return true;

}



function consultar(registro){

	var registro=new Number(registro)*1;

	var aleatorio=generar_aleatorio();



	var registros_seleccionados=false;

	var registros_a_consultar="";

	

	

	if(registro==0){

		var registros=document.getElementsByName("arreglo_registros[]");

		for(var i=0;i<registros.length;i++){

			if(registros[i].checked){

				registros_seleccionados=true;

				registros_a_consultar=registros[i].value;

			}

			if(registros_seleccionados==true){

				i=registros.length;

			}

		}

	}

	else{

		registros_seleccionados=true;

		registros_a_consultar=registro;

	}

	

	if(!registros_seleccionados){

		alert('Debe seleccionar al menos un registro para consultar');

		return false;

	}

	else{

		document.form_contenido.registro.value=registros_a_consultar;

		document.form_contenido.action="consultar/";

		document.form_contenido.submit();

	}

	return true;

}



function contenido(registro){

	var registro=new Number(registro)*1;

	var aleatorio=generar_aleatorio();



	if(registro>0){

		document.form_contenido.registro.value=registro;

		document.form_contenido.action="contenido/";

		document.form_contenido.submit();

	}

	return true;

}



function topicos(registro){

	var registro=new Number(registro)*1;

	var aleatorio=generar_aleatorio();



	document.form_contenido.registro.value=registro;

	document.form_contenido.action="topicos/";

	document.form_contenido.submit();

	return true;

}



function generar_aleatorio(){

	var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

  	var pass  = "";

	var length= new Number(6) * 1;

  	for(var x=0; x < length; x++){

		var i = Math.floor(Math.random() * 62);

    	pass += chars.charAt(i);

  	}

  	return pass;

}



checked=false;

function seleccionar_todo(id){

   var contenedor=document.getElementById(id);

   if(checked== false){

      checked = true;

   }

   else{

      checked = false;

   }

   for(var i=0;i<contenedor.elements.length;i++){

		contenedor.elements[i].checked=checked;

   }

}

