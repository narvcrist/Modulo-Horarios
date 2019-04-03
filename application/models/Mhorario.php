<?php
class Mhorario extends CI_Model {
   
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='HOR_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');
                
            //  if (!empty($numero)){
            //      $datos->econdicion .=" AND HOR_SECUENCIAL=$numero";              
			//  }
              $datos->campoId = "ROWNUM";
			   $datos->camposelect = array("ROWNUM",
											"HOR_SECUENCIAL",
											"HOR_SEC_PERSONA",
											"HOR_SEC_MATRICULA",
											"HOR_FECHAINGRESO",
											"HOR_HORA_INICIO",
											"HOR_HORA_FIN",
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
                HOR_HORA_INICIO,
                HOR_HORA_FIN,
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
            $HOR_RESPONSABLE=$this->session->userdata('US_CODIGO');
            
			
			//VARIABLES DE INGRESO
			
			$HOR_SEC_PERSONA=$this->input->post('HOR_SEC_PERSONA');
            $HOR_SEC_MATRICULA=prepCampoAlmacenar($this->input->post('HOR_SEC_MATRICULA'));
            $HORA_INICIO=prepCampoAlmacenar($this->input->post('HOR_HORA_INICIO'));
            $HOR_HORA_INICIO="TO_DATE('".$HORA_INICIO."','DD/MM/YYYY HH24:MI:SS')";
            $HORA_FIN=prepCampoAlmacenar($this->input->post('HOR_HORA_FIN'));
            $HOR_HORA_FIN="TO_DATE('".$HORA_FIN."','DD/MM/YYYY HH24:MI:SS')";
            $HOR_DIA=prepCampoAlmacenar($this->input->post('HOR_DIA'));	
          
		

			//VARIABLES DE RUTAS
			//$HOR_SEC_MATRICULA=NULL;
			//$HOR_HORA_INICIO=NULL;
			//$HOR_HORA_FIN=NULL;
			//$HOR_DIA=NULL;
			
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
			echo json_encode(array("cod"=>$HOR_SECUENCIAL,"numero"=>$HOR_SECUENCIAL,"mensaje"=>"Horario: ".$HOR_SECUENCIAL.", insertado con éxito"));    
    }
    
	//funcion para editar un registro selccionado
    function editHorario(){
			$HOR_SECUENCIAL=$this->input->post('HOR_SECUENCIAL');
			
			//VARIABLES DE INGRESO
			$HOR_SEC_PERSONA=$this->input->post('HOR_SEC_PERSONA');
            $HOR_SEC_MATRICULA=$this->input->post('HOR_SEC_MATRICULA');	
            $HOR_HORA_INICIO=prepCampoAlmacenar($this->input->post('HOR_HORA_INICIO'));
            //$HOR_HORA_INICIO="TO_DATE('".$HOR_HORA_INICIO."','DD/MM/YYYY HH24:MI:SS')";
            $HOR_HORA_FIN=prepCampoAlmacenar($this->input->post('HOR_HORA_FIN'));	
            //$HOR_HORA_FIN="TO_DATE('".$HOR_HORA_FIN."','DD/MM/YYYY HH24:MI:SS')";			
			$HOR_DIA=prepCampoAlmacenar($this->input->post('HOR_DIA'));					
            
            
           

            $HORA_INICIO=$this->input->post('HOR_HORA_INICIO');
			$HORA_FIN=$this->input->post('HOR_HORA_FIN');	
			
			if (!empty($HORA_INICIO) and !empty($HORA_FIN)){
					$HOR_HORA_INICIO ="TO_DATE('$HORA_INICIO 00:00:00', 'dd/mm/yy HH24:MI:SS')";
					$HOR_HORA_FIN ="TO_DATE('$HORA_FIN 23:59:59', 'dd/mm/yy HH24:MI:SS')";              
				}else{
					$HOR_HORA_INICIO =null;
					$HOR_HORA_FIN = null;
				}

				$sql="UPDATE HORARIO SET
							HOR_SEC_PERSONA=$HOR_SEC_PERSONA,
                            HOR_SEC_MATRICULA=$HOR_SEC_MATRICULA,
							HOR_HORA_INICIO='$HOR_HORA_INICIO',
                            HOR_HORA_FIN='$HOR_HORA_FIN',
							HOR_DIA='$HOR_DIA'
                 WHERE HOR_SECUENCIAL=$HOR_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
         echo json_encode(array("cod"=>1,"numero"=>$HOR_SECUENCIAL,"mensaje"=>"Horario: ".$HOR_SECUENCIAL.", editado con éxito"));            
    }
    

}
?>