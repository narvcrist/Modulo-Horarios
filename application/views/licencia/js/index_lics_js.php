<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evevnto para llegar el Grid de los datos a presentar
    jQuery("#itemlic").jqGrid({
          url:"licencia/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec.','Nombre','Observacion','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
                    {name:'LIC_SECUENCIAL',index:'LIC_SECUENCIAL',align:"center",width:60},
                    {name:'LIC_NOMBRE',index:'LIC_NOMBRE',align:"center", width:150},
					{name:'LIC_OBSERVACION',index:'LIC_OBERVACION',align:"center",  width:80},
					{name:'LIC_ESTADO',index:'LIC_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
        rowNum:50,
        rowList : [50,100,200,800],
        pager: '#pitemlic',
        sortname: 'LIC_SECUENCIAL',
        viewrecords: true,
        height:350,
        width:1000,
        shrinkToFit:false,
        sortorder: "asc",
        mtype:"POST",
        toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemlic").jqGrid('navGrid','#pitemlic',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemlic").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemlic").append("<button title='Nueva Licencia' id='agr_licencia'>Nueva</button>");
    $("#t_itemlic").append("<button title='Editar Licencia' id='edit_licencia'>Editar</button>");
    $("#t_itemlic").append("<button title='Ver Licencia' id='ver_licencia'>Ver</button>");
    $("#t_itemlic").append("<button title='Eliminar Licencia' id='anular_licencia'>Eliminar</button>");  
    $("#t_itemlic").append("<button title='Recargar Listado' id='recargar_licencia'>Refresh</button>");
    $("#t_itemlic").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    		
        $("#itemlic").setGridParam({datatype: "json",url:"licencia/getdatosItems",postData:{numero:''}});
        $("#itemlic").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_licencia").jMostrarNoGrid({
            id:"#t_itemlic",
            idButton:"#agr_licencia",
            errorMens:"No se puede mostrar el formulario.",
            url: "licencia/nuevaLicencia/",
            titulo: "Agregar una Licencia",
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
                $("#itemlic").setGridParam({datatype: "json",url:"licencia/getdatosItems",postData:{numero:$('#LIC_SECUENCIAL').val()}});
                $("#itemlic").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_licencia").jMostrarNoGrid({
	        id:"#itemlic",
	        idButton:"#edit_licencia",
	        errorMens:"",
	        url: "licencia/verLicencia/e",
	        titulo: "Editar Licencia",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemlic").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemlic").getCell(ids,"LIC_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemlic").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion de un licencia			
$("#ver_licencia").jMostrarNoGrid({
	        id:"#itemlic",
	        idButton:"#ver_licencia",
	        errorMens:"",
	        url: "licencia/verLicencia/v",
	        titulo: "Ver Licencia",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemlic").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemlic").getCell(ids,"LIC_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza la licencia
            $("#itemlic").jRecargar({
                id:"#itemlic",
                showText:true,
                idButton:"#recargar_licencia",
                icon:"ui-icon-refresh"
			});            
			
			//Actualiza la licencia
            $("#itemlic").jRecargar({
                id:"#itemlic",
                showText:true,
                idButton:"#recargar_licencia",
                icon:"ui-icon-refresh"
			});

//Evento para eliminar una licencia
 $("#anular_licencia").jMostrarNoGrid({
	        id:"#itemlic",
	        idButton:"#anular_licencia",
	        errorMens:"",
	        url: "licencia/verLicencia/x",
	        titulo: "Eliminar Licencia",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemlic").getGridParam("selrow");
                    var numero=$("#itemlic").getCell(ids,"LIC_SECUENCIAL");
                    $.post("licencia/anulartoda", {NUMERO:numero},
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
	                            $("#itemlic").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemlic").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemlic").getCell(ids,"LIC_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
	
});
</script>
