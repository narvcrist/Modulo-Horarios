<style>
  .ui-autocomplete {
    max-height: 100px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }
  </style>
<script type="text/javascript">

jQuery(document).ready(function(){
    $("table.formDialog tr th,table.formDialog caption").addClass("ui-widget ui-widget-header");
    $("table.formDialog tr td").addClass("ui-widget ui-widget-content");
    $("table.formDialog tr td.noClass").removeClass("ui-widget ui-widget-content");
    
   var accion='<?php echo $accion;?>';
   var numero='<?php echo !empty($sol->MAT_SECUENCIAL) ? prepCampoMostrar($sol->MAT_SECUENCIAL) : null ; ?>';
   
   //Acciones que se manejan en base a los eventos
   if (accion=='n'){ //nueva
        $('#cabecera :input').attr('disabled', false);
        $('#co_grabar').attr('disabled',false);
    } else {
        if (accion=='e'){ //edicion
            $('#co_grabar').attr('disabled',false);            
        }else{ //ver
          $('#cabecera :input').attr('disabled', true);  
        }
    }
    
	//Botón para guardar
    $("#co_grabar").button({
        icons:{
            primary: ""
        }
    });
	
    //Fecha Actual
var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
			if(dd<10){
				dd='0'+dd
			} 
			if(mm<10){
				mm='0'+mm
			}
		var today = dd+'-'+mm+'-'+yyyy; //variable fecha actual
		
 function rangoFecha(input){
    return {
        maxDate: today
		}
    }


jQuery("#MAT_HORA_INICIO,#MAT_HORA_FIN").datepicker({
        dateFormat: 'dd-mm-yy',
  	beforeShow: rangoFecha
    });
	/*//Funcion para validar correo		
	function validarEmail( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
		$('#PER_EMAIL').val('');
        alert("!!!...Error: La dirección de correo: " + email + ", es incorrecta...!!!");
	}
		}
		
	$("#PER_EMAIL").change(function() {
        validarEmail($('#PER_EMAIL').val());        
    })*/

/*
//FUNCIONES PARA LUGAR ESTUDIOS
	//Funcion para combo de Pais en carga		 
	$('#LOC_PAIS_ESTUDIOS').change(function() {
                    $("#LOC_PROVINCIA_ESTUDIOS").val("");
                    $("#LOC_CIUDAD_ESTUDIOS").val("");
					datos_provincia_estudios($('#LOC_PAIS_ESTUDIOS').val());
            });
			
	//Funcion para combo de Provincia en carga		
	$('#LOC_PROVINCIA_ESTUDIOS').change(function() {
				$("#LOC_CIUDAD_ESTUDIOS").val("");
			    datos_ciudad_estudios($('#LOC_PROVINCIA_ESTUDIOS').val());
            });			
			
		
	//Funcion para tomar datos de provincia a partir del pais
	function datos_provincia_estudios(pais){
        $.post("varios/get_provincia",{pais:pais},
            function(data){
               $("#LOC_PROVINCIA_ESTUDIOS").empty().html(data);
         },"html");                 
    }
	
	//Funcion para tomar datos de ciudad a partir de provincia
	function datos_ciudad_estudios(ciudad){
        $.post("varios/get_ciudad",{ciudad:ciudad},
            function(data){
               $("#LOC_CIUDAD_ESTUDIOS").empty().html(data);
         },"html");                 
    }





//FUNCIONES PARA LUGAR NACIMIENTO
	//Funcion para combo de Pais en carga		 
	$('#LOC_PAIS_NACIMIENTO').change(function() {
                    $("#LOC_PROVINCIA_NACIMIENTO").val("");
                    $("#LOC_CIUDAD_NACIMIENTO").val("");
					datos_provincia_nacimiento($('#LOC_PAIS_NACIMIENTO').val());
            });
			
	//Funcion para combo de Provincia en carga		
	$('#LOC_PROVINCIA_NACIMIENTO').change(function() {
				$("#LOC_CIUDAD_NACIMIENTO").val("");
			    datos_ciudad_nacimiento($('#LOC_PROVINCIA_NACIMIENTO').val());
            });			
			
		
	//Funcion para tomar datos de provincia a partir del pais
	function datos_provincia_nacimiento(pais){
        $.post("varios/get_provincia",{pais:pais},
            function(data){
               $("#LOC_PROVINCIA_NACIMIENTO").empty().html(data);
         },"html");                 
    }
	
	//Funcion para tomar datos de ciudad a partir de provincia
	function datos_ciudad_nacimiento(ciudad){
        $.post("varios/get_ciudad",{ciudad:ciudad},
            function(data){
               $("#LOC_CIUDAD_NACIMIENTO").empty().html(data);
         },"html");                 
    }



//FUNCIONES PARA LUGAR TRABAJO
	//Funcion para combo de Pais en carga		 
	$('#LOC_PAIS_TRABAJO').change(function() {
                    $("#LOC_PROVINCIA_TRABAJO").val("");
                    $("#LOC_CIUDAD_TRABAJO").val("");
					datos_provincia_trabajo($('#LOC_PAIS_TRABAJO').val());
            });
			
	//Funcion para combo de Provincia en carga		
	$('#LOC_PROVINCIA_TRABAJO').change(function() {
				$("#LOC_CIUDAD_TRABAJO").val("");
			    datos_ciudad_trabajo($('#LOC_PROVINCIA_TRABAJO').val());
            });			
			
		
	//Funcion para tomar datos de provincia a partir del pais
	function datos_provincia_trabajo(pais){
        $.post("varios/get_provincia",{pais:pais},
            function(data){
               $("#LOC_PROVINCIA_TRABAJO").empty().html(data);
         },"html");                 
    }
	
	//Funcion para tomar datos de ciudad a partir de provincia
	function datos_ciudad_trabajo(ciudad){
        $.post("varios/get_ciudad",{ciudad:ciudad},
            function(data){
               $("#LOC_CIUDAD_TRABAJO").empty().html(data);
         },"html");                 
    }
*/

//Manejo de los campos tanto para un nuevo como para editar	
$("#fmateria").validate({
       errorClass: "ui-state-error",
       validClass: "ui-state-highlight",
       wrapper: "span class='ui-extra-validation ui-widget ui-container'",

       submitHandler: function(form){
           $.ajax({
               type: "POST",
               url:  "materia/admMateria/"+accion,
               data: $("#fmateria").serialize(),
               dataType:"json",
               success: function(r){
                       if (r.cod>0) {
                           $("#fmateria").jConfirmacion({
                                        titulo:"Materia: "+r.numero,
                                        mensaje: r.mensaje,
                                        tipoMensaje:"highlight",
                                        ancho: 250,
                                        posicion: "center"
                            });
                           $(":input","#cabecera").attr("disabled", true);
                           if (accion=='n'){
                                $("#MAT_SECUENCIAL").val(r.numero);
								}
                                $("#co_grabar").hide();
                       } else {
                           alert("Error no se ha grabado la información");
                       }
               }
           })// ajax
       },  //submit handler
       rules:{
            nivel:{required:true},
            materia:{required:true},

             }
     });     
});
</script>
