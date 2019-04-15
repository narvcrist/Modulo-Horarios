<?php
class Mjunta extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='JUN_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
                
             
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
											  //junta
											  "JUN_SECUENCIAL",
											  "(select LOC_DESCRIPCION 
											from ISTCRE_APLICACIONES.LOCALIZACION
											WHERE LOC_SECUENCIAL=JUN_SEC_LOCALIZACION)
											JUN_SEC_LOCALIZACION",
											  "JUN_NOMBRE",	
											"JUN_ESTADO");
			  $datos->campos = array( "ROWNUM",
											"JUN_SECUENCIAL",
											"JUN_SEC_LOCALIZACION",
											"JUN_NOMBRE",
											"JUN_ESTADO");
			  $datos->tabla="JUNTA";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataJunta($numero){
       $sql="select
				JUN_SECUENCIAL,
			    JUN_SEC_LOCALIZACION,
				JUN_NOMBRE,
				JUN_ESTADO
				
          FROM JUNTA WHERE JUN_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
				JUN_SECUENCIAL,
			    JUN_SEC_LOCALIZACION,
				JUN_NOMBRE,
				JUN_ESTADO
				
          FROM JUNTA WHERE JUN_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}
    	
	//funcion para crear un nuevo reporte o cabecera
    function agrJunta(){
			$sql="select to_char(SYSDATE,'MM/DD/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);            
            $PER_FECHAINGRESO="TO_DATE('".$nsol[0]."','MM/DD/YYYY HH24:MI:SS')";
			$PER_RESPONSABLE=$this->session->userdata('US_CODIGO');
			
			//VARIABLES DE INGRESO
			$JUN_SEC_JUNTA=$this->input->post('ciudad_junta');
			$JUN_NOMBRE=prepCampoAlmacenar($this->input->post('JUN_NOMBRE'));

			$sqlJUNTAVALIDA="select count(*) NUM_JUNTA from JUNTA WHERE UPPER(JUN_NOMBRE)=UPPER('{$JUN_NOMBRE}') and JUN_ESTADO=0";
			$NUM_JUNTA=$this->db->query($sqlJUNTAVALIDA)->row()->NUM_JUNTA;
			if($NUM_JUNTA==0){
					$sql="INSERT INTO JUNTA (
								JUN_SEC_LOCALIZACION,
								JUN_NOMBRE,
								JUN_ESTADO) VALUES 
								($JUN_SEC_JUNTA,
								'$JUN_NOMBRE',
								0)";
				$this->db->query($sql);
				//print_r($sql);
				$JUN_SECUENCIAL=$this->db->query("select max(JUN_SECUENCIAL) SECUENCIAL from JUNTA")->row()->SECUENCIAL;
				echo json_encode(array("cod"=>$JUN_SECUENCIAL,"numero"=>$JUN_SECUENCIAL,"mensaje"=>"Junta: ".$JUN_SECUENCIAL.", insertado con éxito"));    
			}else{
				echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...La Junta Ya Existe...!!!"));
			}
    }
    
	//funcion para editar un registro selccionado
    function editJunta(){
			$JUN_SECUENCIAL=$this->input->post('JUN_SECUENCIAL');
			
			//VARIABLES DE INGRESO
			$JUN_SEC_JUNTA=$this->input->post('ciudad_junta');
			$JUN_NOMBRE=prepCampoAlmacenar($this->input->post('JUN_NOMBRE'));
						
				$sql="UPDATE JUNTA SET
				JUN_SEC_LOCALIZACION='$JUN_SEC_JUNTA',
				JUN_NOMBRE='$JUN_NOMBRE'
				WHERE JUN_SECUENCIAL=$JUN_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$JUN_SECUENCIAL,"mensaje"=>"Junta: ".$JUN_SECUENCIAL.", editado con éxito"));            
    }
}
?>