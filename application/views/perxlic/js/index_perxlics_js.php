<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evevnto para llegar el Grid de los datos a presentar
    jQuery("#itemperxlic").jqGrid({
          url:"perxlic/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec.','Licencia','Persona','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
                    {name:'PERXLIC_SECUENCIAL',index:'PERXLIC_SECUENCIAL',align:"center",width:60},
                    {name:'PERXLIC_SEC_LICENCIA',index:'PERXLIC_SEC_LICENCIA',align:"center", width:150},
					{name:'PERXLIC_SEC_PERSONA',index:'PERXLIC_SEC_PERSONA',align:"center",  width:200},
					{name:'PERXLIC_ESTADO',index:'PERXLIC_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
        rowNum:50,
        rowList : [50,100,200,800],
        pager: '#pitemperxlic',
        sortname: 'PERXLIC_SECUENCIAL',
        viewrecords: true,
        height:350,
        width:1000,
        shrinkToFit:false,
        sortorder: "asc",
        mtype:"POST",
        toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemperxlic").jqGrid('navGrid','#pitemperxlic',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemperxlic").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemperxlic").append("<button title='Nueva' id='agr_perxlic'>Nueva</button>");
    $("#t_itemperxlic").append("<button title='Editar' id='edit_perxlic'>Editar</button>");
    $("#t_itemperxlic").append("<button title='Ver' id='ver_perxlic'>Ver</button>");
    $("#t_itemperxlic").append("<button title='Eliminar' id='anular_perxlic'>Eliminar</button>");  
    $("#t_itemperxlic").append("<button title='Recargar Listado' id='recargar_perxlic'>Refresh</button>");
    $("#t_itemperxlic").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    		
        $("#itemperxlic").setGridParam({datatype: "json",url:"perxlic/getdatosItems",postData:{numero:''}});
        $("#itemperxlic").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_perxlic").jMostrarNoGrid({
            id:"#t_itemperxlic",
            idButton:"#agr_perxlic",
            errorMens:"No se puede mostrar el formulario.",
            url: "perxlic/nuevaPerxlic/",
            titulo: "Agregar una Licencia para la Persona",
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
                $("#itemperxlic").setGridParam({datatype: "json",url:"perxlic/getdatosItems",postData:{numero:$('#PERXLIC_SECUENCIAL').val()}});
                $("#itemperxlic").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_perxlic").jMostrarNoGrid({
	        id:"#itemperxlic",
	        idButton:"#edit_perxlic",
	        errorMens:"",
	        url: "perxlic/verPerxlic/e",
	        titulo: "Editar perxlic",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemperxlic").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemperxlic").getCell(ids,"PERXLIC_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemperxlic").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion de un persona para la licencia			
$("#ver_perxlic").jMostrarNoGrid({
	        id:"#itemperxlic",
	        idButton:"#ver_perxlic",
	        errorMens:"",
	        url: "perxlic/verPerxlic/v",
	        titulo: "Ver perxlic",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemperxlic").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemperxlic").getCell(ids,"PERXLIC_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza la persona para la licencia
            $("#itemperxlic").jRecargar({
                id:"#itemperxlic",
                showText:true,
                idButton:"#recargar_perxlic",
                icon:"ui-icon-refresh"
			});            
			
			//Actualiza la persona para la licencia
            $("#itemperxlic").jRecargar({
                id:"#itemperxlic",
                showText:true,
                idButton:"#recargar_perxlic",
                icon:"ui-icon-refresh"
			});

//Evento para eliminar una persona para la licencia
 $("#anular_perxlic").jMostrarNoGrid({
	        id:"#itemperxlic",
	        idButton:"#anular_perxlic",
	        errorMens:"",
	        url: "perxlic/verPerxlic/x",
	        titulo: "Eliminar perxlic",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemperxlic").getGridParam("selrow");
                    var numero=$("#itemperxlic").getCell(ids,"PERXLIC_SECUENCIAL");
                    $.post("perxlic/anulartoda", {NUMERO:numero},
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
	                            $("#itemperxlic").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemperxlic").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemperxlic").getCell(ids,"PERXLIC_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
	
});
</script>
