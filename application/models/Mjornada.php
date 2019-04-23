<?php
class Mjornada extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='JOR_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
                
              
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
											"JOR_SECUENCIAL",
											"JOR_NOMBRE",
											"JOR_PARALELO",
											"to_char(JOR_HORA_INICIO,'DD-MM-YYYY HH24:MI:SS') JOR_HORA_INICIO",
											"to_char(JOR_HORA_FIN,'DD-MM-YYYY HH24:MI:SS') JOR_HORA_FIN",
											"JOR_ESTADO");
			  $datos->campos = array( "ROWNUM",
											"JOR_SECUENCIAL",
											"JOR_NOMBRE",
											"JOR_PARALELO",
											"JOR_HORA_INICIO",
											"JOR_HORA_FIN",
											"JOR_ESTADO");
			  $datos->tabla="JORNADA";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataJornada($numero){
	   $sql="select 
	   JOR_SECUENCIAL,
	   JOR_NOMBRE,
	   JOR_PARALELO,
	   to_char(JOR_HORA_INICIO,'DD-MM-YYYY HH24:MI:SS') JOR_HORA_INICIO,
	   to_char(JOR_HORA_FIN,'DD-MM-YYYY HH24:MI:SS') JOR_HORA_FIN,
	   JOR_ESTADO
			FROM JORNADA WHERE JOR_SECUENCIAL=$numero";
           
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select 
				JOR_SECUENCIAL,
				JOR_NOMBRE,
				JOR_PARALELO,
				JOR_HORA_INICIO,
				JOR_HORA_FIN,
				JOR_ESTADO
					FROM JORNADA WHERE JOR_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}
    	
	//funcion para crear un nuevo reporte o cabecera
    function agrJornada(){
			$sql="select to_char(SYSDATE,'DD/MM/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);            
			//$MAT_FECHAINGRESO="TO_DATE('".$nsol[0]."','MM/DD/YYYY HH24:MI:SS')";
			$JOR_HORA_INICIO="TO_DATE('".$nsol[0]."','DD/MM/YYYY HH24:MI:SS')";
			$JOR_HORA_FIN="TO_DATE('".$nsol[0]."','DD/MM/YYYY HH24:MI:SS')";

			//$MAT_RESPONSABLE=$this->session->userdata('US_CODIGO');
			
			//VARIABLES DE INGRESO
			
			$JOR_NOMBRE=$this->input->post('jornada');
			$JOR_PARALELO=$this->input->post('paralelo');

			$HORA_INICIO=$this->input->post('JOR_HORA_INICIO');
			$HORA_FIN=$this->input->post('JOR_HORA_FIN');	
			
			if (!empty($HORA_INICIO) and !empty($HORA_FIN)){
					$JOR_HORA_INICIO =" TO_DATE('$HORA_INICIO ', 'dd/mm/yy HH24:MI:SS')";
					$JOR_HORA_FIN ="TO_DATE('$HORA_FIN ', 'dd/mm/yy HH24:MI:SS')";              
				}else{
					$JOR_HORA_INICIO =null;
					$JOR_HORA_FIN = null;
				}

				//Validacion
				$sqlREPETICION="select count(*) NUM_JORNADA 
				from jornada 
				where jor_paralelo='{$JOR_PARALELO}'
				and jor_nombre='{$JOR_NOMBRE}' 
				and jor_estado=0";
			$NUM_JORNADA=$this->db->query($sqlREPETICION)->row()->NUM_JORNADA;
		
		if($NUM_JORNADA==0){	

				$sql="INSERT INTO JORNADA (
							JOR_NOMBRE,
							JOR_PARALELO,
							JOR_HORA_INICIO,
							JOR_HORA_FIN,
							JOR_ESTADO
							)VALUES 
							(
							'$JOR_NOMBRE',
							'$JOR_PARALELO',
							$JOR_HORA_INICIO,
							$JOR_HORA_FIN,
							0)";
            $this->db->query($sql);
            //print_r($sql);
			$JOR_SECUENCIAL=$this->db->query("select max(JOR_SECUENCIAL) SECUENCIAL from JORNADA")->row()->SECUENCIAL;
			echo json_encode(array("cod"=>$JOR_SECUENCIAL,"numero"=>$JOR_SECUENCIAL,"mensaje"=>"Jornada: ".$JOR_SECUENCIAL.", insertado con éxito"));    
		}else{
				echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...El Paralelo Ya Tiene La Jornada Asignada...!!!"));
			}
		}
    
	//funcion para editar un registro selccionado
    function editJornada(){
			$JOR_SECUENCIAL=$this->input->post('JOR_SECUENCIAL');
			
			//VARIABLES DE INGRESO
			$JOR_NOMBRE=$this->input->post('jornada');
			$JOR_PARALELO=$this->input->post('paralelo');
			$JOR_HORA_INICIO=prepCampoAlmacenar($this->input->post('JOR_HORA_INICIO'));
			$JOR_HORA_FIN=prepCampoAlmacenar($this->input->post('JOR_HORA_FIN'));		

			$HORA_INICIO=$this->input->post('JOR_HORA_INICIO');
			$HORA_FIN=$this->input->post('JOR_HORA_FIN');
			
			if (!empty($HORA_INICIO) and !empty($HORA_FIN)){
				$JOR_HORA_INICIO =" TO_DATE('$HORA_INICIO', 'dd/mm/yy HH24:MI:SS')";
				$JOR_HORA_FIN ="TO_DATE('$HORA_FIN', 'dd/mm/yy HH24:MI:SS')";              
			}else{
				$JOR_HORA_INICIO =null;
				$JOR_HORA_FIN = null;
			}


				$sql="UPDATE JORNADA SET
							JOR_NOMBRE='$JOR_NOMBRE',
							JOR_PARALELO='$JOR_PARALELO',
							JOR_HORA_INICIO=$JOR_HORA_INICIO,
							JOR_HORA_FIN=$JOR_HORA_FIN
                		WHERE JOR_SECUENCIAL=$JOR_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$JOR_SECUENCIAL,"mensaje"=>"Jornada: ".$JOR_SECUENCIAL.", editado con éxito"));            
    }

}
?>