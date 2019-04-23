<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evento para llenar el Grid de los datos a presentar
    jQuery("#itemast").jqGrid({
          url:"asistencia/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec.','Matricula','Persona','Fecha Ingreso.','Fecha Salida','Responsable','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
                    {name:'AST_SECUENCIAL',index:'AST_SECUENCIAL',align:"center",width:60},
                    {name:'AST_SEC_MATRICULA',index:'AST_SEC_MATRICULA',align:"center", width:200},
					{name:'AST_SEC_PERSONA',index:'AST_PERSONA',align:"center",  width:150},
					{name:'AST_FECHAINGRESO',index:'AST_FECHAINGRESO',align:"center",  width:100},					
					{name:'AST_FECHASALIDA',index:'AST_FECHASALIDA', width:100,align:"center"},
					{name:'AST_RESPONSABLE',index:'AST_RESPONSABLE', width:100,align:"center"},
					{name:'AST_ESTADO',index:'AST_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
                rowNum:50,
        rowList : [50,100,200,800],
        pager: '#aitemast',
        sortname: 'AST_FECHAINGRESO,AST_FECHASALIDA',
        viewrecords: true,
        height:350,
        width:1000,
        shrinkToFit:false,
        sortorder: "asc",
        mtype:"POST",
        toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemast").jqGrid('navGrid','#aitemast',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemast").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemast").append("<button title='Nueva Asistencia' id='agr_asistencia'>Nueva</button>");
    $("#t_itemast").append("<button title='Editar Asistencia' id='edit_asistencia'>Editar</button>");
    $("#t_itemast").append("<button title='Ver Asistencia' id='ver_asistencia'>Ver</button>");
    $("#t_itemast").append("<button title='Eliminar Asistencia' id='anular_asistencia'>Eliminar</button>");  
    $("#t_itemast").append("<button title='Recargar Listado' id='recargar_lista'>Refresh</button>");
    $("#t_items").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    		
        $("#itemast").setGridParam({datatype: "json",url:"asistencia/getdatosItems",postData:{numero:''}});
        $("#itemast").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_asistencia").jMostrarNoGrid({           
            id:"#t_itemast",
            idButton:"#agr_asistencia",
            errorMens:"No se puede mostrar el formulario.",
            url: "asistencia/nuevaAsistencia/",
            titulo: "Agregar Asistencia",
            alto:900,
            ancho: 1024,
            posicion: "top",
            showText:true,
            icon:"ui-icon-circle-plus",
            respuestaTipo:"html",
            values:{
                ids:null
            },
            alCerrar : function() {
                $("#itemast").setGridParam({datatype: "json",url:"asistencia/getdatosItems",postData:{numero:$('#AST_SECUENCIAL').val()}});
                $("#itemast").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_asistencia").jMostrarNoGrid({
	        id:"#itemast",
	        idButton:"#edit_asistencia",
	        errorMens:"",
	        url: "asistencia/verAsistencia/e",
	        titulo: "Editar Asistencia",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemast").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemast").getCell(ids,"AST_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemast").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion de un tipoCalificacion			
$("#ver_asistencia").jMostrarNoGrid({
	        id:"#itemast",
	        idButton:"#ver_asistencia",
	        errorMens:"",
	        url: "asistencia/verAsistencia/v",
	        titulo: "Ver Asistencia",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemast").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemast").getCell(ids,"AST_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza la asistencia
            $("#itemast").jRecargar({
                id:"#itemast",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			}); 

             	//Actualiza asistencia
            $("#itemast").jRecargar({
                id:"#itemast",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});                
			
//Evento para eliminar una tipoCalificacion
 $("#anular_asistencia").jMostrarNoGrid({
	        id:"#itemast",
	        idButton:"#anular_asistencia",
	        errorMens:"",
	        url: "asistencia/verAsistencia/x",
	        titulo: "Eliminar Asistencia",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemast").getGridParam("selrow");
                    var numero=$("#itemast").getCell(ids,"AST_SECUENCIAL");
                    $.post("asistencia/anulartoda", {NUMERO:numero},
	                        function(data){
	                            $(dialogId).html(data.mensaje);
	                            $(dialogId).dialog({
	                            buttons: {
	                                "Cerrar": function(){
	                                    $(this).dialog("destroy");
	                                    $(dialogId).remove();
	                                    }
	                                }
	                            });
	                            $("#itemast").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemast").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemast").getCell(ids,"AST_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
});
</script>