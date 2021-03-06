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


jQuery("#APO_FECHALIMITE").datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
  	//beforeShow: rangoFecha
    });

jQuery(document).ready(function(){
    $("table.formDialog tr th,table.formDialog caption").addClass("ui-widget ui-widget-header");
    $("table.formDialog tr td").addClass("ui-widget ui-widget-content");
    $("table.formDialog tr td.noClass").removeClass("ui-widget ui-widget-content");
    
   var accion='<?php echo $accion;?>';
   var numero='<?php echo !empty($sol->APO_SECUENCIAL) ? prepCampoMostrar($sol->APO_SECUENCIAL) : null ; ?>';
   
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

    $("#APO_NOTA1").change(function() {
        var matricula=$('#APO_SEC_MATRICULA').val();
        var nota1=$('#APO_NOTA1').val();
        var nota2=$('#APO_NOTA2').val();
        var nota3=$('#APO_NOTA3').val();
        var nota4=$('#APO_NOTA4').val();
        var total=(parseFloat(nota1)+parseFloat(nota2)+parseFloat(nota3)+parseFloat(nota4));
        var valida=valida_total(matricula,total);
    })

    $("#APO_NOTA2").change(function() {
        var matricula=$('#APO_SEC_MATRICULA').val();
        var nota1=$('#APO_NOTA1').val();
        var nota2=$('#APO_NOTA2').val();
        var nota3=$('#APO_NOTA3').val();
        var nota4=$('#APO_NOTA4').val();
        var total=(parseFloat(nota1)+parseFloat(nota2)+parseFloat(nota3)+parseFloat(nota4));
        var valida=valida_total(matricula,total);
    })

    $("#APO_NOTA3").change(function() {
        var matricula=$('#APO_SEC_MATRICULA').val();
        var nota1=$('#APO_NOTA1').val();
        var nota2=$('#APO_NOTA2').val();
        var nota3=$('#APO_NOTA3').val();
        var nota4=$('#APO_NOTA4').val();
        var total=(parseFloat(nota1)+parseFloat(nota2)+parseFloat(nota3)+parseFloat(nota4));
        var valida=valida_total(matricula,total);
    })

    $("#APO_NOTA4").change(function() {
        var matricula=$('#APO_SEC_MATRICULA').val();
        var nota1=$('#APO_NOTA1').val();
        var nota2=$('#APO_NOTA2').val();
        var nota3=$('#APO_NOTA3').val();
        var nota4=$('#APO_NOTA4').val();
        var total=(parseFloat(nota1)+parseFloat(nota2)+parseFloat(nota3)+parseFloat(nota4));
        var valida=valida_total(matricula,total);
    })

    //Funcion para tomar datos de provincia a partir del pais
	function valida_total(matricula,total){
        $.post("varios/get_porcentaje",{MATRICULA:matricula,TOTAL:total},            
            function(data){
               if(data=>0){                    
                    if(total>data){
                        alert("El Total entre las notas: " +total+ " ,es mayor al permitido:"+data);
                        var nota1=$('#APO_NOTA1').val(0);
                        var nota2=$('#APO_NOTA2').val(0);
                        var nota3=$('#APO_NOTA3').val(0);
                        var nota4=$('#APO_NOTA4').val(0); 
                    }
               }else{
                    alert("!!!...Favor Seleccione Matricula...!!!");
                    var nota1=$('#APO_NOTA1').val(0);
                    var nota2=$('#APO_NOTA2').val(0);
                    var nota3=$('#APO_NOTA3').val(0);
                    var nota4=$('#APO_NOTA4').val(0);                    
               }               
         },"html");                 
    }

//Manejo de los campos tanto para un nuevo como para editar	
$("#faporte").validate({
       errorClass: "ui-state-error",
       validClass: "ui-state-highlight",
       wrapper: "span class='ui-extra-validation ui-widget ui-container'",

       submitHandler: function(form){
           $.ajax({
               type: "POST",
               url:  "aporte/admaporte/"+accion,
               data: $("#faporte").serialize(),
               dataType:"json",
               success: function(r){
                       if (r.cod>0) {
                           $("#faporte").jConfirmacion({
                                        titulo:"aporte: "+r.numero,
                                        mensaje: r.mensaje,
                                        tipoMensaje:"highlight",
                                        ancho: 250,
                                        posicion: "center"
                            });
                           $(":input","#cabecera").attr("disabled", true);
                           if (accion=='n'){
                                $("#APO_SECUENCIAL").val(r.numero);
								}
                                $("#co_grabar").hide();
                       } else {
                           alert("Error no se ha grabado la información");
                       }
               }
           })// ajax
       },  //submit handler
       rules:{
            genero:{required:true},
            civil:{required:true},
			"APO_NOTA1":{required:true},
			"APO_NOTA2":{required:true},
			"APO_NOTA3":{required:true},
			"APO_NOTA4":{required:true},
			persona:{required:true},
			matricula:{required:true},
            "APO_FECHALIMITE":{required:true},
            tipocalificacion:{required:true},
			"PER_EMAIL":{required:true},			
            }
     });     
});
</script>
