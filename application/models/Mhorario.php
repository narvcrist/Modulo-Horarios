<?php
class Mhorario extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero= $this->input->post('numero');
        $datos->econdicion ='HOR_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
                
            //  if (!empty($numero)){
            //      $datos->econdicion .=" AND HOR_SECUENCIAL=$numero";              
			//  }
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
											"HOR_SECUENCIAL",
                                            "(SELECT CONCAT(CONCAT(PER_APELLIDOS,' '), PER_NOMBRES) FROM PERSONA WHERE PER_SECUENCIAL = HOR_SEC_PERSONA)
                                            HOR_SEC_PERSONA",
											"(SELECT CONCAT(CONCAT(CONCAT(CONCAT((CASE (SELECT COUNT(ASP_NOMBRE) FROM ASPIRANTE WHERE ASP_SECUENCIAL=MATR_SEC_ASPIRANTE)
                                            WHEN 0 THEN 'SIN ASIGNACION'
                                            ELSE
                                            (SELECT ASP_NOMBRE FROM ASPIRANTE WHERE ASP_SECUENCIAL=MATR_SEC_ASPIRANTE)
                                            END),'-'),
                                            (SELECT MAT_NOMBRE FROM MATERIA WHERE MAT_SECUENCIAL=MATR_SEC_MATERIA)),'-'),
                                            (SELECT CONCAT(CONCAT(CONCAT(JOR_NOMBRE,'('),JOR_PARALELO),')') JOR_DESCRIPCION FROM JORNADA 
                                            WHERE JOR_SECUENCIAL=MATR_SEC_JORNADA)) ASP_MAT_JOR
                                            FROM MATRICULA WHERE MATR_SECUENCIAL=HOR_SEC_MATRICULA) HOR_SEC_MATRICULA",
											"HOR_FECHAINGRESO",
											"to_char(HOR_HORA_INICIO,'DD-MM-YYY HH24:MI:SS') HOR_HORA_INICIO",
                                            "to_char(HOR_HORA_FIN,'DD-MM-YYY HH24:MI:SS') HOR_HORA_FIN",
											"HOR_DIA",
											"HOR_RESPONSABLE",
											"HOR_ESTADO");
			  $datos->campos = array( "ROWNUM",
                                            "HOR_SECUENCIAL",
                                            "HOR_SEC_PERSONA",
                                            "HOR_SEC_MATRICULA",
                                            "HOR_FECHAINGRESO",
                                            "HOR_HORA_INICIO",
                                            "HOR_HORA_FIN",
                                            "HOR_DIA",
                                            "HOR_RESPONSABLE",
                                            "HOR_ESTADO");
			  $datos->tabla="HORARIO";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataHorario($numero){
       $sql="select
                HOR_SECUENCIAL,
                HOR_SEC_PERSONA,
                HOR_SEC_MATRICULA,
                HOR_FECHAINGRESO,
                to_char(HOR_HORA_INICIO,'DD-MM-YYY HH24:MI:SS') HOR_HORA_INICIO,
                to_char(HOR_HORA_FIN,'DD-MM-YYY HH24:MI:SS') HOR_HORA_FIN,
                HOR_DIA,
                HOR_RESPONSABLE,
                HOR_ESTADO
          FROM HORARIO WHERE HOR_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
                            HOR_SECUENCIAL,
                            HOR_SEC_PERSONA,
                            HOR_SEC_MATRICULA,
                            HOR_FECHAINGRESO,
                            HOR_HORA_INICIO,
                            HOR_HORA_FIN,
                            HOR_DIA,
                            HOR_RESPONSABLE,
                            HOR_ESTADO
                          FROM HORA WHERE HOR_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}	
	//funcion para crear un nuevo reporte o cabecera
    function agrHorario(){
			$sql="select to_char(SYSDATE,'MM/DD/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);            
            $HOR_FECHAINGRESO="TO_DATE('".$nsol[0]."','MM/DD/YYYY HH24:MI:SS')";
            $HOR_RESPONSABLE= $this->session->userdata('US_CODIGO');
            $HOR_HORA_INICIO= "TO_DATE('".$nsol[0]."','DD/MM/YYYY HH24:MI:SS')";
            $HOR_HORA_FIN= "TO_DATE('".$nsol[0]."','DD/MM/YYYY HH24:MI:SS')";
		
			//VARIABLES DE INGRESO
			
			$HOR_SEC_PERSONA=$this->input->post('persona');
            $HOR_SEC_MATRICULA=prepCampoAlmacenar($this->input->post('matricula'));
            $HORA_INICIO=prepCampoAlmacenar($this->input->post('HOR_HORA_INICIO')); 
            $HORA_FIN=prepCampoAlmacenar($this->input->post('HOR_HORA_FIN'));
            $HOR_DIA=prepCampoAlmacenar($this->input->post('HOR_DIA'));	
        
			$sqlHORARIOVALIDA="select count(*) NUM_HORARIO from HORARIO WHERE HOR_SEC_PERSONA='{$HOR_SEC_PERSONA }' and HOR_ESTADO=0";
			$NUM_HORARIO =$this->db->query($sqlHORARIOVALIDA)->row()->NUM_HORARIO ;
			if($NUM_HORARIO ==0){
                $sql="INSERT INTO HORARIO (
                    HOR_SEC_PERSONA,
                    HOR_SEC_MATRICULA,
                    HOR_FECHAINGRESO,
                    HOR_HORA_INICIO,
                    HOR_HORA_FIN,
                    HOR_DIA,
                    HOR_RESPONSABLE,
                    HOR_ESTADO) VALUES (
                    $HOR_SEC_PERSONA,
                    $HOR_SEC_MATRICULA,
                    $HOR_FECHAINGRESO,
                    $HOR_HORA_INICIO,
                    $HOR_HORA_FIN,
                    '$HOR_DIA',
                    '$HOR_RESPONSABLE', 
                    0)";
				$this->db->query($sql);
				//print_r($sql);
				$HOR_SECUENCIAL=$this->db->query("select max(HOR_SECUENCIAL) SECUENCIAL from HORARIO")->row()->SECUENCIAL;
				echo json_encode(array("cod"=>$HOR_SECUENCIAL,"numero"=>$HOR_SECUENCIAL,"mensaje"=>"Junta: ".$HOR_SECUENCIAL.", insertado con éxito"));    
			}else{
				echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...El Horario Ya Existe...!!!"));
			}
			    
    }
	//funcion para editar un registro selccionado
    function editHorario(){
			$HOR_SECUENCIAL=$this->input->post('HOR_SECUENCIAL');
			
            //VARIABLES DE INGRESO
            
			$HOR_SEC_PERSONA=$this->input->post('persona');
            $HOR_SEC_MATRICULA=$this->input->post('matricula');	
            $HORA_INICIO=prepCampoAlmacenar($this->input->post('HOR_HORA_INICIO'));
            $HOR_HORA_INICIO="TO_DATE('".$HORA_INICIO."','DD/MM/YYYY HH24:MI:SS')";
            $HORA_FIN=prepCampoAlmacenar($this->input->post('HOR_HORA_FIN'));	
            $HOR_HORA_FIN="TO_DATE('".$HORA_FIN."','DD/MM/YYYY HH24:MI:SS')";			
			$HOR_DIA=prepCampoAlmacenar($this->input->post('HOR_DIA'));					
    
				$sql="UPDATE HORARIO SET
							HOR_SEC_PERSONA=$HOR_SEC_PERSONA,
                            HOR_SEC_MATRICULA=$HOR_SEC_MATRICULA,
							HOR_HORA_INICIO=$HOR_HORA_INICIO,
                            HOR_HORA_FIN=$HOR_HORA_FIN,
							HOR_DIA='$HOR_DIA'
                            
                 WHERE HOR_SECUENCIAL=$HOR_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$HOR_SECUENCIAL,"mensaje"=>"Horario: ".$HOR_SECUENCIAL.", editado con éxito"));            
    }
}
?>