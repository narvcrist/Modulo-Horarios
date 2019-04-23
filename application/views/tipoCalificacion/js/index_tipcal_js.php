<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evevnto para llegar el Grid de los datos a presentar
    jQuery("#itemtipcal").jqGrid({
          url:"tipoCalificacion/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec.','Matricula','Fecha Ing.','Fecha Ini.','Fecha Fin','Porcentaje','Responsable','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
                    {name:'TIPCAL_SECUENCIAL',index:'TIPCAL_SECUENCIAL',align:"center",width:60},
                    {name:'TIPCAL_SEC_MATRICULA',index:'TIPCAL_SEC_MATRICULA',align:"center", width:300},
					{name:'TIPCAL_FECHAINGRESO',index:'TIPCAL_FECHAINGRESO',align:"center",  width:80},
					{name:'TIPCAL_FECHAINICIO',index:'TIPCAL_FECHAINICIO',align:"center",  width:100},					
					{name:'TIPCAL_FECHAFIN',index:'TIPCAL_FECHAFIN', width:100,align:"center"},
					{name:'TIPCAL_PORCENTAJE',index:'TIPCAL_PORCENTAJE', width:100,align:"center" },
					{name:'TIPCAL_RESPONSABLE',index:'TIPCAL_RESPONSABLE', width:100,align:"center"},
					{name:'TIPCAL_ESTADO',index:'TIPCAL_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
                     rowNum:50,
        rowList : [50,100,200,800],
        pager: '#pitemtipcal',
        sortname: 'TIPCAL_FECHAINICIO,TIPCAL_FECHAFIN',
        viewrecords: true,
        height:350,
        width:1000,
        shrinkToFit:false,
        sortorder: "asc",
        mtype:"POST",
        toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemtipcal").jqGrid('navGrid','#pitemtipcal',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemtipcal").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemtipcal").append("<button title='Nueva Calificacion' id='agr_tipoCalificacion'>Nueva</button>");
    $("#t_itemtipcal").append("<button title='Editar Calificacion' id='edit_tipoCalificacion'>Editar</button>");
    $("#t_itemtipcal").append("<button title='Ver Calificacion' id='ver_tipoCalificacion'>Ver</button>");
    $("#t_itemtipcal").append("<button title='Eliminar Calificacion' id='anular_tipoCalificacion'>Eliminar</button>");  
    $("#t_itemtipcal").append("<button title='Recargar Listado' id='recargar_lista'>Refresh</button>");
    $("#t_itemtipcal").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    		
        $("#itemtipcal").setGridParam({datatype: "json",url:"tipoCalificacion/getdatosItems",postData:{numero:''}});
        $("#itemtipcal").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_tipoCalificacion").jMostrarNoGrid({           
            id:"#t_itemtipcal",
            idButton:"#agr_tipoCalificacion",
            errorMens:"No se puede mostrar el formulario.",
            url: "tipoCalificacion/nuevaTipoCalificacion/",
            titulo: "Agregar un tipoCalificacion",
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
                $("#itemtipcal").setGridParam({datatype: "json",url:"tipoCalificacion/getdatosItems",postData:{numero:$('#TIPCAL_SECUENCIAL').val()}});
                $("#itemtipcal").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_tipoCalificacion").jMostrarNoGrid({
	        id:"#itemtipcal",
	        idButton:"#edit_tipoCalificacion",
	        errorMens:"",
	        url: "tipoCalificacion/verTipoCalificacion/e",
	        titulo: "Editar tipo Calificacion",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemtipcal").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemtipcal").getCell(ids,"TIPCAL_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemtipcal").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion de un tipoCalificacion			
$("#ver_tipoCalificacion").jMostrarNoGrid({
	        id:"#itemtipcal",
	        idButton:"#ver_tipoCalificacion",
	        errorMens:"",
	        url: "tipoCalificacion/verTipoCalificacion/v",
	        titulo: "Ver TipoCalificacion",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemtipcal").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemtipcal").getCell(ids,"TIPCAL_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza la tipoCalificacion
            $("#itemtipcal").jRecargar({
                id:"#itemtipcal",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});            
			
			//Actualiza la tipoCalificacion
            $("#itemtipcal").jRecargar({
                id:"#itemtipcal",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});

//Evento para eliminar una tipoCalificacion
 $("#anular_tipoCalificacion").jMostrarNoGrid({
	        id:"#itemtipcal",
	        idButton:"#anular_tipoCalificacion",
	        errorMens:"",
	        url: "tipoCalificacion/verTipoCalificacion/x",
	        titulo: "Eliminar TipoCalificacion",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemtipcal").getGridParam("selrow");
                    var numero=$("#itemtipcal").getCell(ids,"TIPCAL_SECUENCIAL");
                    $.post("tipoCalificacion/anulartoda", {NUMERO:numero},
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
	                            $("#itemtipcal").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemtipcal").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemtipcal").getCell(ids,"TIPCAL_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
	
});
</script>
