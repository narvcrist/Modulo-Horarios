<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evento para llenar el Grid de los datos a presentar
    jQuery("#itemmatr").jqGrid({
          url:"matricula/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec.','Materia','Aspirante','Jornada','Persona','Fecha Ingreso','Responsable','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
                    {name:'MATR_SECUENCIAL',index:'MATR_SECUENCIAL',align:"center",width:150},
                    {name:'MATR_SEC_MATERIA',index:'MATR_SEC_MATERIA',align:"center", width:150},
                    {name:'MATR_SEC_ASPIRANTE',index:'MATR_SEC_ASPIRANTE',align:"center", width:150},
                    {name:'MATR_SEC_JORNADA',index:'MATR_SEC_JORNADA',align:"center", width:150},
                    {name:'MATR_SEC_PERSONA',index:'MATR_PERSONA',align:"center",  width:150},
					{name:'MATR_FECHAINGRESO',index:'MATR_FECHAINGRESO',align:"center",  width:100},										{name:'MATR_RESPONSABLE',index:'MATR_RESPONSABLE', width:100,align:"center"},
					{name:'MATR_ESTADO',index:'MATR_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
        rowNum:50,
        rowList : [50,100,200,800],
        pager: '#mitemmatr',
        sortname: 'MATR_FECHAINGRESO',
        viewrecords: true,
        height:350,
        width:1000,
        shrinkToFit:false,
        sortorder: "asc",
        mtype:"POST",
        toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemmatr").jqGrid('navGrid','#mitemmatr',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemmatr").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemmatr").append("<button title='Nueva Matricula' id='agr_matricula'>Nueva</button>");
    $("#t_itemmatr").append("<button title='Editar Matricula' id='edit_matricula'>Editar</button>");
    $("#t_itemmatr").append("<button title='Ver Matricula' id='ver_matricula'>Ver</button>");
    $("#t_itemmatr").append("<button title='Eliminar Matricula' id='anular_matricula'>Eliminar</button>");  
    $("#t_itemmatr").append("<button title='Recargar Listado' id='recargar_lista'>Refresh</button>");
    $("#t_itemmatr").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    		
        $("#itemmatr").setGridParam({datatype: "json",url:"matricula/getdatosItems",postData:{numero:''}});
        $("#itemmatr").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_matricula").jMostrarNoGrid({           
            id:"#t_itemmatr",
            idButton:"#agr_matricula",
            errorMens:"No se puede mostrar el formulario.",
            url: "matricula/nuevaMatricula/",
            titulo: "Agregar Matricula",
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
                $("#itemmatr").setGridParam({datatype: "json",url:"matricula/getdatosItems",postData:{numero:$('#MATR_SECUENCIAL').val()}});
                $("#itemmatr").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_matricula").jMostrarNoGrid({
	        id:"#itemmatr",
	        idButton:"#edit_matricula",
	        errorMens:"",
	        url: "matricula/verMatricula/e",
	        titulo: "Editar Matricula",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemmatr").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemmatr").getCell(ids,"MATR_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemmatr").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion de un tipoCalificacion			
$("#ver_matricula").jMostrarNoGrid({
	        id:"#itemmatr",
	        idButton:"#ver_matricula",
	        errorMens:"",
	        url: "matricula/verMatricula/v",
	        titulo: "Ver Matricula",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemmatr").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemmatr").getCell(ids,"MATR_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza matricula
            $("#itemmatr").jRecargar({
                id:"#itemmatr",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});   

            	//Actualiza matricula
            $("#itemmatr").jRecargar({
                id:"#itemmatr",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});  

            //Actualiza matricula
            $("#itemmatr").jRecargar({
                id:"#itemmatr",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});          
			
//Evento para eliminar una tipoCalificacion
 $("#anular_matricula").jMostrarNoGrid({
	        id:"#itemmatr",
	        idButton:"#anular_matricula",
	        errorMens:"",
	        url: "matricula/verMatricula/x",
	        titulo: "Eliminar matricula",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemmatr").getGridParam("selrow");
                    var numero=$("#itemmatr").getCell(ids,"MATR_SECUENCIAL");
                    $.post("matricula/anulartoda", {NUMERO:numero},
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
	                            $("#itemmatr").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemmatr").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemmatr").getCell(ids,"MATR_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
});
</script>