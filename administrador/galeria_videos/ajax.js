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
	var id_seccion=new Number(id_seccion)*1;
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

function buscar_secciones(id_division,id_idioma,identificador){
	var aleatorio= generar_aleatorio();
	var id_division=new Number(id_division)*1,id_idioma= new Number(id_idioma)*1,identificador=new Number(identificador)*1;
	var contenedor;
	var respuesta,secciones;
	if(identificador>0){
		contenedor=document.getElementById('td_secciones'+identificador);		
	}
	else{
		contenedor=document.getElementById('td_secciones');
	}
	ajax=objetoAjax();
	ajax.open("GET", "../buscar_secciones.php?id_division="+id_division+"&id_idioma="+id_idioma+"&identificador="+identificador+"&aleatorio="+aleatorio);
	contenedor.innerHTML='<img src="http://www.lovelocal.mx/administrador/images/gifs/loading.gif">';
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			respuesta=ajax.responseText.split("|");
			secciones=respuesta[0];
			contenedor.innerHTML=secciones;
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
function cargar_grupos(id_fotografo,id_video){
	var aleatorio= generar_aleatorio();
	var id_fotografo=new Number(id_fotografo)*1;
	var id_video=new Number(id_video)*1;	

	var contenedor;	
	if(id_video>0){
		contenedor=document.getElementById('td_grupos'+id_video);
	}
	else{
		contenedor=document.getElementById('td_grupos');		
	}
		 
	ajax=objetoAjax();
	ajax.open("GET", "../cargar_grupos.php?id_fotografo="+id_fotografo+"&id_video="+id_video+"&aleatorio="+aleatorio);
	contenedor.innerHTML= '<img src="http://www.lovelocal.mx/administrador/images/gifs/loading.gif">';
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4){
			contenedor.innerHTML=ajax.responseText;
		}
	}
	ajax.send(null);
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
