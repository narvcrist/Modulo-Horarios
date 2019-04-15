<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evevnto para llegar el Grid de los datos a presentar
    jQuery("#itemasp").jqGrid({
          url:"aspirante/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec.','Fecha Ing.','Nombre','Tiempo Duracion',
					'Observaciones','Responsable','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
                    {name:'ASP_SECUENCIAL',index:'ASP_SECUENCIAL',align:"center",width:60},
                    {name:'ASP_FECHAINGRESO',index:'ASP_FECHAINGRESO',align:"center", width:150},
					{name:'ASP_NOMBRE',index:'ASP_NOMBRE',align:"center",  width:80},
					{name:'ASP_NUM_TIEMPODURACION',index:'ASP_NUM_TIEMPODURACION',align:"center",  width:100},					
					{name:'ASP_OBSERVACIONES',index:'ASP_OBSERVACIONES', width:100,align:"center"},
					{name:'ASP_RESPONSABLE',index:'ASP_RESPONSABLE', width:100,align:"center"},
					{name:'ASP_ESTADO',index:'ASP_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
        rowNum:50,
        rowList : [50,100,200,800],
        pager: '#pitemasp',
        sortname: 'ASP_NOMBRE',
        viewrecords: true,
        height:350,
        width:1000,
        shrinkToFit:false,
        sortorder: "asc",
        mtype:"POST",
        toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemasp").jqGrid('navGrid','#pitemasp',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemasp").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemasp").append("<button title='Nuevo Aspirante' id='agr_aspirante'>Nuevo</button>");
    $("#t_itemasp").append("<button title='Editar Aspirante' id='edit_aspirante'>Editar</button>");
    $("#t_itemasp").append("<button title='Ver Aspirante' id='ver_aspirante'>Ver</button>");
    $("#t_itemasp").append("<button title='Eliminar Aspirante' id='anular_aspirante'>Eliminar</button>");  
    $("#t_itemasp").append("<button title='Recargar Listado' id='recargar_lista'>Refresh</button>");
    $("#t_itemasp").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    		
        $("#itemasp").setGridParam({datatype: "json",url:"aspirante/getdatosItems",postData:{numero:''}});
        $("#itemasp").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_aspirante").jMostrarNoGrid({
            id:"#t_itemasp",
            idButton:"#agr_aspirante",
            errorMens:"No se puede mostrar el formulario.",
            url: "aspirante/nuevaAspirante/",
            titulo: "Agregar un Aspirante",
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
                $("#itemasp").setGridParam({datatype: "json",url:"aspirante/getdatosItems",postData:{numero:$('#ASP_SECUENCIAL').val()}}); 
				$("#itemasp").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_aspirante").jMostrarNoGrid({
	        id:"#itemasp",
	        idButton:"#edit_aspirante",
	        errorMens:"",
	        url: "aspirante/veraspirante/e",
	        titulo: "Editar Aspirante",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemasp").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemasp").getCell(ids, "ASP_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemasp").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion de un aspirante			
$("#ver_aspirante").jMostrarNoGrid({
	        id:"#itemasp",
	        idButton:"#ver_aspirante",
	        errorMens:"",
	        url: "aspirante/verAspirante/v",
	        titulo: "Ver Aspirante",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemasp").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemasp").getCell(ids,"ASP_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza la aspirante
            $("#itemasp").jRecargar({
                id:"#itemasp",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});            
			
			//Actualiza la aspirante
            $("#itemasp").jRecargar({
                id:"#itemasp",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});

//Evento para eliminar una aspirante
 $("#anular_aspirante").jMostrarNoGrid({
	        id:"#itemasp",
	        idButton:"#anular_aspirante",
	        errorMens:"",
	        url: "aspirante/verAspirante/x",
	        titulo: "Eliminar Aspirante",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemasp").getGridParam("selrow");
                    var numero=$("#itemasp").getCell(ids,"ASP_SECUENCIAL");
                    $.post("aspirante/anulartoda", {NUMERO:numero},
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
	                            $("#itemasp").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemasp").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemasp").getCell(ids,"ASP_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
	
});
</script>
