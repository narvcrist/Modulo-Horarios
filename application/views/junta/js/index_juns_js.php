<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evevnto para llegar el Grid de los datos a presentar
    jQuery("#itemjun").jqGrid({
          url:"junta/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec.','Localizacion','Nombre','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
                    {name:'JUN_SECUENCIAL',index:'JUN_SECUENCIAL',align:"center",width:60},
					{name:'JUN_SEC_LOCALIZACION',index:'JUN_SEC_LOCALIZACION',align:"center", width:150},
					{name:'JUN_NOMBRE',index:'JUN_NOMBRE', width:100,align:"center"},
					{name:'JUN_ESTADO',index:'JUN_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
        rowNum:50,
        rowList : [50,100,200,800],
        pager: '#pitemjun',
        sortname: 'JUN_NOMBRE',
        viewrecords: true,
        height:350,
        width:1000,
        shrinkToFit:false,
        sortorder: "asc",
        mtype:"POST",
        toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemjun").jqGrid('navGrid','#pitemjun',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemjun").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemjun").append("<button title='Nueva Junta' id='agr_junta'>Nueva</button>");
    $("#t_itemjun").append("<button title='Editar Junta' id='edit_junta'>Editar</button>");
    $("#t_itemjun").append("<button title='Ver Junta' id='ver_junta'>Ver</button>");
    $("#t_itemjun").append("<button title='Eliminar Junta' id='anular_junta'>Eliminar</button>");  
	$("#t_itemjun").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    $("#t_itemjun").append("<button title='Recargar Listado' id='recargar_lista'>Refresh</button>");
   
    		
        $("#itemjun").setGridParam({datatype: "json",url:"junta/getdatosItems",postData:{numero:''}});
        $("#itemjun").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_junta").jMostrarNoGrid({
            id:"#t_itemjun",
            idButton:"#agr_junta",
            errorMens:"No se puede mostrar el formulario.",
            url: "junta/nuevaJunta/",
            titulo: "Agregar una Junta",
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
                $("#itemjun").setGridParam({datatype: "json",url:"junta/getdatosItems",postData:{numero:$('#JUN_SECUENCIAL').val()}});
                $("#itemjun").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_junta").jMostrarNoGrid({
	        id:"#itemjun",
	        idButton:"#edit_junta",
	        errorMens:"",
	        url: "junta/verJunta/e",
	        titulo: "Editar Junta",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemjun").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemjun").getCell(ids,"JUN_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemjun").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion de un junta		
$("#ver_junta").jMostrarNoGrid({
	        id:"#itemjun",
	        idButton:"#ver_junta",
	        errorMens:"",
	        url: "junta/verJunta/v",
	        titulo: "Ver Junta",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemjun").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemjun").getCell(ids,"JUN_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza la junta
            $("#itemjun").jRecargar({
                id:"#itemjun",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});            
			
			//Actualiza la junta
            $("#itemjun").jRecargar({
                id:"#itemjun",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});

//Evento para eliminar una junta
 $("#anular_junta").jMostrarNoGrid({
	        id:"#itemjun",
	        idButton:"#anular_junta",
	        errorMens:"",
	        url: "junta/verJunta/x",
	        titulo: "Eliminar Junta",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemjun").getGridParam("selrow");
                    var numero=$("#itemjun").getCell(ids,"JUN_SECUENCIAL");
                    $.post("junta/anulartoda", {NUMERO:numero},
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
	                            $("#itemjun").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemjun").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemjun").getCell(ids,"JUN_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
	
});
</script>
