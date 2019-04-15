<script type="text/javascript">
jQuery(document).ready(function(){
    
    //var aprobador="<?php echo $aprobador; ?>";
    
	//Evevnto para llegar el Grid de los datos a presentar
    jQuery("#itemapo").jqGrid({
          url:"aporte/getdatosItems",
          datatype: "json",
          colNames:['Num','Sec','Fecha Ing.','Matricula','Persona','Calificacion','Nota1','Nota2','Nota3','Nota4',
					'Fecha Lim.','Res. Crea','Res. Edita','Estado'],
          colModel:[
					{name:'COLUMNAS',index:'COLUMNAS',align:"center",width:30,hidden:false},
					{name:'APO_SECUENCIAL',index:'APO_SECUENCIAL',align:"center",width:50},					
					{name:'APO_FECHAINGRESO',index:'APO_FECHAINGRESO',align:"center",  width:80},
					{name:'APO_SEC_MATRICULA',index:'APO_SEC_MATRICULA',align:"center", search:false, width:350},
                    {name:'APO_SEC_PERSONA',index:'APO_SEC_PERSONA',align:"center",width:180},
                    {name:'APO_SEC_TIPOCALIFICACION',index:'APO_SEC_TIPOCALIFICACION',align:"center", width:100},
					{name:'APO_NOTA1',index:'APO_NOTA1', width:60,align:"center"},
					{name:'APO_NOTA2',index:'APO_NOTA2', width:60,align:"center"},
					{name:'APO_NOTA3',index:'APO_NOTA3', width:60,align:"center"},
					{name:'APO_NOTA4',index:'APO_NOTA4', width:60,align:"center"},
					{name:'APO_FECHALIMITE',index:'APO_FECHALIMITE',align:"center",  width:150},
					{name:'APO_RESPONSABLE_CREA',index:'APO_RESPONSABLE_CREA', width:100,align:"center"},
					{name:'APO_RESPONSABLE_EDITA',index:'APO_RESPONSABLE_EDITA', width:100,align:"center"},
					{name:'PER_ESTADO',index:'PER_ESTADO',searchable:false, width:40,align:"center", edittype:'select', formatter:'select', editoptions:{value:"0:<span class='ui-icon ui-icon-circle-check ui-icon-extra'>Activo</span>;1:<span class='ui-icon ui-icon-circle-close ui-icon-extra'>Pasivo</span>"}}
                ],
        rowNum:50,
        rowList : [50,100,200,800],
        pager: '#pitemapo',
        sortname: '',
        viewrecords: true,
        height:350,
        width:1000,
        shrinkToFit:false,
        sortorder: "asc",
        mtype:"POST",
        toolbar: [true,"top"]
    });
    
	//Botones que contendran cada evento o acción
    $("#itemapo").jqGrid('navGrid','#pitemapo',{del:false,add:false,edit:false,refresh:true, search: false},{},{},{},{multipleSearch:true,sopt:['cn','eq']});
    $("#itemapo").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : true});
    $("#t_itemapo").append("<button title='Nuevo Aporte' id='agr_aporte'>Nuevo</button>");
    $("#t_itemapo").append("<button title='Editar Aporte' id='edit_aporte'>Editar</button>");
    $("#t_itemapo").append("<button title='Ver Aporte' id='ver_aporte'>Ver</button>");
    $("#t_itemapo").append("<button title='Eliminar Aporte' id='anular_aporte'>Eliminar</button>");  
    $("#t_itemapo").append("<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>"); 
    $("#t_itemapo").append("<button title='Recargar Listado' id='recargar_lista'>Refresh</button>");    
    		
        $("#itemapo").setGridParam({datatype: "json",url:"aporte/getdatosItems",postData:{numero:''}});
        $("#itemapo").trigger('reloadGrid');

//Evento para ingresar un nuevo registro    
$("#agr_aporte").jMostrarNoGrid({
            id:"#t_itemapo",
            idButton:"#agr_aporte",
            errorMens:"No se puede mostrar el formulario.",
            url: "aporte/nuevoAporte/",
            titulo: "Agregar un Aporte",
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
                $("#itemapo").setGridParam({datatype: "json",url:"aporte/getdatosItems",postData:{numero:$('#APO_SECUENCIAL').val()}});
                $("#itemapo").trigger('reloadGrid');
            }
        });

//Evento para editar un registro        
$("#edit_aporte").jMostrarNoGrid({
	        id:"#itemapo",
	        idButton:"#edit_aporte",
	        errorMens:"",
	        url: "aporte/verAporte/e",
	        titulo: "Editar Aporte",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-pencil",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemapo").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemapo").getCell(ids,"APO_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        },
            alCerrar : function() {
                 $("#itemapo").trigger('reloadGrid');
            }
            });

//Evento para ver la informacion de un aporte		
$("#ver_aporte").jMostrarNoGrid({
	        id:"#itemapo",
	        idButton:"#ver_aporte",
	        errorMens:"",
	        url: "aporte/verAporte/v",
	        titulo: "Ver Aporte",
              //  alto:900,
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-document-b",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                values:function (){
                    var ids= $("#itemapo").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemapo").getCell(ids,"APO_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
            //Actualiza el aporte
            $("#itemapo").jRecargar({
                id:"#itemapo",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});            
			
			//Actualiza la aporte
            $("#itemapo").jRecargar({
                id:"#itemapo",
                showText:true,
                idButton:"#recargar_lista",
                icon:"ui-icon-refresh"
			});

//Evento para eliminar un aporte
 $("#anular_aporte").jMostrarNoGrid({
	        id:"#itemapo",
	        idButton:"#anular_aporte",
	        errorMens:"",
	        url: "aporte/verAporte/x",
	        titulo: "Eliminar Aporte",
	        ancho:1024,
	        posicion: "top",
	        showText:true,
	        icon:"ui-icon-closethick",
	        respuestaTipo:"html",
	        valuesIsFunction: true,
                botonSubmit:"Eliminar",
                formAction :function(dialogId){
                    var ids= $("#itemapo").getGridParam("selrow");
                    var numero=$("#itemapo").getCell(ids,"APO_SECUENCIAL");
                    $.post("aporte/anulartoda", {NUMERO:numero},
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
	                            $("#itemapo").trigger("reloadGrid");
	                        }, "json");
                },
                values:function (){
                    var ids= $("#itemapo").getGridParam("selrow");
	            if ($().jEmpty(ids)){
	                return {ids:null};
	            }else{
                        var numero=$("#itemapo").getCell(ids,"APO_SECUENCIAL");
	                return {NUMERO:numero};
	            };
	        }
            });
	
});
</script>
