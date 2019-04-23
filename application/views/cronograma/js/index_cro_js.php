<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evevnto para llegar el Grid de los datos a presentar
    jQuery("#itemcro").jqGrid({
          url:"cronograma/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec.','Materia','Aspirante.','Descripción','Fecha Ing.','Fecha Ini.','Fecha Fin','Observaciones',
					'Responsable','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
                    {name:'CRO_SECUENCIAL',index:'CRO_SECUENCIAL',align:"center",width:60},
                    {name:'CRO_SEC_MATERIA',index:'CRO_SEC_MATERIA',align:"center", width:150},
                    {name:'CRO_SEC_ASPIRANTE',index:'CRO_SEC_ASPIRANTE',align:"center", width:150},
                    {name:'CRO_DESCRIPCION',index:'CRO_DESCRIPCION',align:"center", width:150},
					{name:'CRO_FECHAINGRESO',index:'CRO_FECHAINGRESO',align:"center",  width:80},
					{name:'CRO_FECHAINICIO',index:'CRO_FECHAINICIO',align:"center",  width:100},					
					{name:'CRO_FECHAFIN',index:'CRO_FECHAFIN', width:100,align:"center"},
					{name:'CRO_OBSERVACIONES',index:'CRO_OBSERVACIONES', width:200
                    ,align:"center"},
					{name:'CRO_RESPONSABLE',index:'CRO_RESPONSABLE', width:200,align:"center"},					
					{name:'CRO_ESTADO',index:'CRO_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
          rowNum:50,
          rowList : [50,100,200,800],
          pager: '#pitemcro',
          sortname: 'CRO_SECUENCIAL',
          viewrecords: true,
          height:350,
          width:1000,
          shrinkToFit:false,
          sortorder: "asc",
          mtype:"POST",
          toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemcro").jqGrid('navGrid','#pitemcro',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemcro").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemcro").append("<button title='Nuevo Cronograma' id='agr_cronograma'>Nueva</button>");
    $("#t_itemcro").append("<button title='Editar Cronograma' id='edit_cronograma'>Editar</button>");
    $("#t_itemcro").append("<button title='Ver cronograma' id='ver_cronograma'>Ver</button>");
    $("#t_itemcro").append("<button title='Eliminar cronograma' id='anular_cronograma'>Eliminar</button>");  
    $("#t_itemcro").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    $("#t_itemcro").append("<button title='Recargar Listado' id='recargar_lista'>Refresh</button>");    
    		
        $("#itemcro").setGridParam({datatype: "json",url:"cronograma/getdatosItems",postData:{numero:''}});
        $("#itemcro").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_cronograma").jMostrarNoGrid({
            id:"#t_itemcro",
            idButton:"#agr_cronograma",
            errorMens:"No se puede mostrar el formulario.",
            url: "cronograma/nuevoCronograma/",
            titulo: "Agregar un Cronograma",
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
                $("#itemcro").setGridParam({datatype: "json",url:"cronograma/getdatosItems",postData:{numero:$('#CRO_SECUENCIAL').val()}});
                $("#itemcro").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_cronograma").jMostrarNoGrid({
	        id:"#itemcro",
	        idButton:"#edit_cronograma",
	        errorMens:"",
	        url: "cronograma/verCronograma/e",
	        titulo: "Editar Cronograma",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemcro").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemcro").getCell(ids,"CRO_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemcro").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion del un Cronograma			
$("#ver_cronograma").jMostrarNoGrid({
	        id:"#itemcro",
	        idButton:"#ver_cronograma",
	        errorMens:"",
	        url: "cronograma/verCronograma/v",
	        titulo: "Ver Cronograma",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemcro").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemcro").getCell(ids,"CRO_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza el Cronograma
            $("#itemcro").jRecargar({
                id:"#itemcro",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});            
			
	
//Evento para eliminar un Cronograma
 $("#anular_cronograma").jMostrarNoGrid({
	        id:"#itemcro",
	        idButton:"#anular_cronograma",
	        errorMens:"",
	        url: "cronograma/verCronograma/x",
	        titulo: "Eliminar Cronograma",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemcro").getGridParam("selrow");
                    var numero=$("#itemcro").getCell(ids,"CRO_SECUENCIAL");
                    $.post("cronograma/anulartoda", {NUMERO:numero},
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
	                            $("#itemcro").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemcro").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemcro").getCell(ids,"CRO_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
	
});
</script>
