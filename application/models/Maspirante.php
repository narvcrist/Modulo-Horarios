<?php
class Maspirante extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='ASP_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
				
				$datos->campoId = "ROWNUM";
			    $datos->camposelect = array("ROWNUM",
											"ASP_SECUENCIAL",
											"ASP_FECHAINGRESO",
											"ASP_NOMBRE",
											"ASP_NUM_TIEMPODURACION",
											"ASP_OBSERVACIONES",
											"ASP_RESPONSABLE",
											"ASP_ESTADO");
			  $datos->campos = array( "ROWNUM",
											"ASP_SECUENCIAL",
											"ASP_FECHAINGRESO",
											"ASP_NOMBRE",
											"ASP_NUM_TIEMPODURACION",
											"ASP_OBSERVACIONES",
											"ASP_RESPONSABLE",
											"ASP_ESTADO");
			  $datos->tabla="ASPIRANTE";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataAspirante($numero){
       $sql="select
				ASP_SECUENCIAL,
				ASP_FECHAINGRESO,
				ASP_NOMBRE,
				ASP_NUM_TIEMPODURACION,
				ASP_OBSERVACIONES,
				ASP_RESPONSABLE,
				ASP_ESTADO
          FROM ASPIRANTE WHERE ASP_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
							ASP_SECUENCIAL,
							ASP_FECHAINGRESO,
							ASP_NOMBRE,
							ASP_NUM_TIEMPODURACION,
							ASP_OBSERVACIONES,
							ASP_RESPONSABLE,
							ASP_ESTADO
                          FROM ASPIRANTE WHERE ASP_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}
    	
	//funcion para crear un nuevo reporte o cabecera
    function agrAspirante(){
			$sql="select to_char(SYSDATE,'MM/DD/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);           
            $ASP_FECHAINGRESO="TO_DATE('".$nsol[0]."','MM/DD/YYYY HH24:MI:SS')";
			$ASP_RESPONSABLE=$this->session->userdata('US_CODIGO');
			
			//VARIABLES DE INGRESO	

			$ASP_NOMBRE=prepCampoAlmacenar($this->input->post('ASP_NOMBRE'));			
			$ASP_NUM_TIEMPODURACION=$this->input->post('ASP_NUM_TIEMPODURACION');			
			$ASP_OBSERVACIONES=prepCampoAlmacenar($this->input->post('ASP_OBSERVACIONES'));						
			

			//validación...
			$sqlREPETICION="select count(*) NUM_ASPIRANTE 
							from aspirante 
							where upper(asp_nombre)=upper('{$ASP_NOMBRE}') 
							and asp_estado=0";
			$NUM_ASPIRANTE=$this->db->query($sqlREPETICION)->row()->NUM_ASPIRANTE;

			if($NUM_ASPIRANTE==0){
			
				$sql="INSERT INTO ASPIRANTE (
							ASP_FECHAINGRESO,
							ASP_NOMBRE,
							ASP_NUM_TIEMPODURACION,
							ASP_OBSERVACIONES,
							ASP_RESPONSABLE,
							ASP_ESTADO) VALUES 
							($ASP_FECHAINGRESO,
							'$ASP_NOMBRE',
							$ASP_NUM_TIEMPODURACION,
							'$ASP_OBSERVACIONES',
							'$ASP_RESPONSABLE',
							0)";
            $this->db->query($sql);
            //print_r($sql);
			$ASP_SECUENCIAL=$this->db->query("select max(ASP_SECUENCIAL) SECUENCIAL from ASPIRANTE")->row()->SECUENCIAL;
			echo json_encode(array("cod"=>$ASP_SECUENCIAL,"numero"=>$ASP_SECUENCIAL,"mensaje"=>"Aspirante: ".$ASP_SECUENCIAL.", insertado con éxito"));    
			} else {
				echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...El Aspirante Ingresado Ya Se Encuentra ingresado...!!!"));
			}
	}
    
	//funcion para editar un registro selccionado
    function editAspirante(){
			$ASP_SECUENCIAL=$this->input->post('ASP_SECUENCIAL');
			
			//VARIABLES DE INGRESO
			
			$ASP_NOMBRE=prepCampoAlmacenar($this->input->post('ASP_NOMBRE'));			
			$ASP_NUM_TIEMPODURACION=$this->input->post('ASP_NUM_TIEMPODURACION');			
			$ASP_OBSERVACIONES=prepCampoAlmacenar($this->input->post('ASP_OBSERVACIONES'));

			
			
				$sql="UPDATE ASPIRANTE SET
							ASP_NOMBRE='$ASP_NOMBRE',
							ASP_NUM_TIEMPODURACION=$ASP_NUM_TIEMPODURACION,
							ASP_OBSERVACIONES='$ASP_OBSERVACIONES'



º
                WHERE ASP_SECUENCIAL=$ASP_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$ASP_SECUENCIAL,"mensaje"=>"Aspirante: ".$ASP_SECUENCIAL.", editado con éxito"));            
    }

}
?>