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
   var numero='<?php echo !empty($sol->JUN_SECUENCIAL) ? prepCampoMostrar($sol->JUN_SECUENCIAL) : null ; ?>';
   
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
	
	

    //FUNCIONES PARA LUGAR JUNTA
	//Funcion para combo de Pais en carga		 
	$('#LOC_PAIS_JUNTA').change(function() {
                    $("#LOC_PROVINCIA_JUNTA").val("");
                    $("#LOC_CIUDAD_JUNTA").val("");
					datos_provincia_junta($('#LOC_PAIS_JUNTA').val());
            });
			
	//Funcion para combo de Provincia en carga		
	$('#LOC_PROVINCIA_JUNTA').change(function() {
				$("#LOC_CIUDAD_JUNTA").val("");
			    datos_ciudad_junta($('#LOC_PROVINCIA_JUNTA').val());
            });			
			
		
	//Funcion para tomar datos de provincia a partir del pais
	function datos_provincia_junta(pais){
        $.post("varios/get_provincia",{pais:pais},
            function(data){
               $("#LOC_PROVINCIA_JUNTA").empty().html(data);
         },"html");                 
    }
	
	//Funcion para tomar datos de ciudad a partir de provincia
	function datos_ciudad_junta(ciudad){
        $.post("varios/get_ciudad",{ciudad:ciudad},
            function(data){
               $("#LOC_CIUDAD_JUNTA").empty().html(data);
         },"html");                 
    }

//Manejo de los campos tanto para un nuevo como para editar	
$("#fjunta").validate({
       errorClass: "ui-state-error",
       validClass: "ui-state-highlight",
       wrapper: "span class='ui-extra-validation ui-widget ui-container'",

       submitHandler: function(form){
           $.ajax({
               type: "POST",
               url:  "junta/admJunta/"+accion,
               data: $("#fjunta").serialize(),
               dataType:"json",
               success: function(r){
                       if (r.cod>0) {
                           $("#fjunta").jConfirmacion({
                                        titulo:"Junta: "+r.numero,
                                        mensaje: r.mensaje,
                                        tipoMensaje:"highlight",
                                        ancho: 250,
                                        posicion: "center"
                            });
                           $(":input","#cabecera").attr("disabled", true);
                           if (accion=='n'){
                                $("#JUN_SECUENCIAL").val(r.numero);
								}
                                $("#co_grabar").hide();
                       } else {
                           alert("Error no se ha grabado la información");
                       }
               }
           })// ajax
       },  //submit handler
       rules:{
            cudad_junta:{required:true},
			"JUN_NOMBRE":{required:true}
             }
     });     
});
</script>
