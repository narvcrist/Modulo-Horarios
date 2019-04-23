<?php
class Mcronograma extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='CRO_ESTADO<>1';
		$datos->econdicion ='CRO_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');    
            /*  if (!empty($numero)){
                  $datos->econdicion .=" AND CRO_SECUENCIAL=$numero";              
				  }*/
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
											"CRO_SECUENCIAL",
											"(select MAT_NOMBRE from materia where mat_secuencial=CRO_SEC_MATERIA) CRO_SEC_MATERIA",
											"(select ASP_NOMBRE from aspirante where asp_secuencial=CRO_SEC_ASPIRANTE)CRO_SEC_ASPIRANTE",
											"CRO_DESCRIPCION",
											"CRO_FECHAINGRESO",
											"CRO_FECHAINICIO",
											"CRO_FECHAFIN",
											"CRO_OBSERVACIONES",
											"CRO_RESPONSABLE",
											"CRO_ESTADO");
			  $datos->campos = array( "ROWNUM",
										"CRO_SECUENCIAL",
										"CRO_SEC_MATERIA",
										"CRO_SEC_ASPIRANTE",
										"CRO_DESCRIPCION",
										"CRO_FECHAINGRESO",
										"CRO_FECHAINICIO",
										"CRO_FECHAFIN",
										"CRO_OBSERVACIONES",
										"CRO_RESPONSABLE",
										"CRO_ESTADO");
			  $datos->tabla="CRONOGRAMA";
              $datos->debug = false;	
		   return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
		   
   }
   
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
function dataCronograma($numero){
       $sql="select
				CRO_SECUENCIAL,
				CRO_SEC_MATERIA,
				CRO_SEC_ASPIRANTE,
				CRO_DESCRIPCION,
				CRO_FECHAINGRESO,
				CRO_FECHAINICIO,
				CRO_FECHAFIN,
				CRO_OBSERVACIONES,
				CRO_RESPONSABLE,
				CRO_ESTADO
          FROM CRONOGRAMA WHERE CRO_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
							CRO_SECUENCIAL,
							CRO_SEC_MATERIA,
							CRO_SEC_ASPIRANTE,
							CRO_DESCRIPCION,
							CRO_FECHAINGRESO,
							CRO_FECHAINICIO,
							CRO_FECHAFIN,
							CRO_OBSERVACIONES,
							CRO_RESPONSABLE,
							CRO_ESTADO
							
                          FROM CRONOGRAMA WHERE CRO_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}
    	
	//funcion para crear un nuevo reporte o cabecera
    function agrCronograma(){
			$sql="select to_char(SYSDATE,'MM/DD/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);            
			$CRO_FECHAINGRESO="TO_DATE('".$nsol[0]."','MM/DD/YYYY HH24:MI:SS')";
			$CRO_RESPONSABLE=$this->session->userdata('US_CODIGO');
			
			//VARIABLES DE INGRESO
			
			$CRO_SEC_MATERIA=$this->input->post('materia');
			$CRO_SEC_ASPIRANTE=$this->input->post('aspirante');					
			$CRO_OBSERVACIONES=prepCampoAlmacenar($this->input->post('CRO_OBSERVACIONES'));			
			$CRO_DESCRIPCION=prepCampoAlmacenar($this->input->post('CRO_DESCRIPCION'));			

			$FECHA_INICIO=$this->input->post('CRO_FECHAINICIO');
			$FECHA_FIN=$this->input->post('CRO_FECHAFIN');	
			
			if (!empty($FECHA_INICIO) and !empty($FECHA_FIN)){
					$CRO_FECHAINICIO ="TO_DATE('$FECHA_INICIO 00:00:00', 'dd/mm/yy HH24:MI:SS')";
					$CRO_FECHAFIN ="TO_DATE('$FECHA_FIN 23:59:59', 'dd/mm/yy HH24:MI:SS')";              
				}else{
					$CRO_FECHAINICIO =null;
					$CRO_FECHAFIN = null;
				}

			$sqlREPETICION="select count(*) NUM_REPETICION 
							from cronograma 
							where cro_sec_aspirante=$CRO_SEC_ASPIRANTE
							and cro_sec_materia=$CRO_SEC_MATERIA 
							and cro_estado=0";
			$NUM_REPETICION=$this->db->query($sqlREPETICION)->row()->NUM_REPETICION;
			if($NUM_REPETICION==0){
				$sqlINSERT="INSERT INTO CRONOGRAMA (
					CRO_SEC_MATERIA,
					CRO_SEC_ASPIRANTE,
					CRO_DESCRIPCION,
					CRO_FECHAINGRESO,
					CRO_FECHAINICIO,
					CRO_FECHAFIN,
					CRO_OBSERVACIONES,
					CRO_RESPONSABLE,
					CRO_ESTADO) VALUES(
					 $CRO_SEC_MATERIA,
					$CRO_SEC_ASPIRANTE,
					'$CRO_DESCRIPCION',
					$CRO_FECHAINGRESO,
					$CRO_FECHAINICIO,
					$CRO_FECHAFIN,
					'$CRO_OBSERVACIONES',
					'$CRO_RESPONSABLE',
					0)";
			$this->db->query($sqlINSERT);
            //print_r($sqlINSERT);
			$CRO_SECUENCIAL=$this->db->query("select max(CRO_SECUENCIAL) SECUENCIAL from CRONOGRAMA")->row()->SECUENCIAL;
			echo json_encode(array("cod"=>$CRO_SECUENCIAL,"numero"=>$CRO_SECUENCIAL,"mensaje"=>"Cronograma: ".$CRO_SECUENCIAL.", insertado con éxito"));
		}else{
			echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...La Materia Ingresada Ya Se Encuentra En El Aspirante...!!!"));
		}
    }
    
	//funcion para editar un registro selccionado
	
    function editCronograma(){
			$CRO_SECUENCIAL=$this->input->post('CRO_SECUENCIAL');
			
			//VARIABLES DE INGRESO
			
			$CRO_SEC_MATERIA=$this->input->post('materia');
			$CRO_SEC_ASPIRANTE=$this->input->post('aspirante');
			$CRO_DESCRIPCION=prepCampoAlmacenar($this->input->post('CRO_DESCRIPCION')); 
			$CRO_FECHAINICIO=prepCampoAlmacenar($this->input->post('CRO_FECHA_INICIO'));			
			$CRO_FECHAFIN=prepCampoAlmacenar($this->input->post('CRO_FECHA_FIN'));			
			$CRO_OBSERVACIONES=prepCampoAlmacenar($this->input->post('CRO_OBSERVACIONES'));			
					
			$FECHA_INICIO=$this->input->post('CRO_FECHAINICIO');
			$FECHA_FIN=$this->input->post('CRO_FECHAFIN');	
			
			if (!empty($FECHA_INICIO) and !empty($FECHA_FIN)){
					$CRO_FECHAINICIO ="TO_DATE('$FECHA_INICIO 00:00:00', 'dd/mm/yy HH24:MI:SS')";
					$CRO_FECHAFIN ="TO_DATE('$FECHA_FIN 23:59:59', 'dd/mm/yy HH24:MI:SS')";              
				}else{
					$CRO_FECHAINICIO =null;
					$CRO_FECHAFIN = null;
				}

			
				$sqlREPETICION1="select CRO_SECUENCIAL,CRO_SEC_MATERIA 
				from cronograma
				where CRO_SECUENCIAL='{$CRO_SECUENCIAL}'
				and cro_estado=0";
$repe1 =$this->db->query($sqlREPETICION1)->row();

$sqlREPETICION2="select CRO_SECUENCIAL,CRO_SEC_MATERIA
				from cronograma
				where CRO_SEC_MATERIA='{$CRO_SEC_MATERIA}'
				and cro_estado=0";
$repe2 =$this->db->query($sqlREPETICION2)->row();

$sqlREPETICION="select count(*) NUM_REPETICION
				from cronograma
				where CRO_SEC_MATERIA='{$CRO_SEC_MATERIA}'
				and cro_estado=0";
$NUM_REPETICION =$this->db->query($sqlREPETICION)->row()->NUM_REPETICION;

if(($repe1->CRO_SECUENCIAL==$repe2->CRO_SECUENCIAL) or ($NUM_REPETICION==0)){


			$sql="UPDATE CRONOGRAMA SET
			CRO_SEC_MATERIA=$CRO_SEC_MATERIA,
			CRO_SEC_ASPIRANTE=$CRO_SEC_ASPIRANTE,
			CRO_DESCRIPCION='$CRO_DESCRIPCION',
			CRO_FECHAINICIO=$CRO_FECHAINICIO,
			CRO_FECHAFIN=$CRO_FECHAFIN,
			CRO_OBSERVACIONES='$CRO_OBSERVACIONES'
			WHERE CRO_SECUENCIAL=$CRO_SECUENCIAL";
$this->db->query($sql);

$CRO_SECUENCIAL=$this->db->query("select max(CRO_SECUENCIAL) SECUENCIAL from CRONOGRAMA")->row()->SECUENCIAL;

echo json_encode(array("cod"=>1,"numero"=>$CRO_SECUENCIAL,"mensaje"=>"Cronograma: ".$CRO_SECUENCIAL.", editado con éxito"));            
}else{
	echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...La Materia Ingresada Ya Se Encuentra En El Aspirante...!!!"));
}
}
}
?>