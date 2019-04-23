<?php
class Maporte extends CI_Model {
   //Funcion en la cual muestra cada seleccion que ingresemos
   function getdatosItems(){
        $datos = new stdClass();
        $consulta=$_POST['_search'];
        $numero=  $this->input->post('numero');
        $datos->econdicion ='APO_ESTADO<>1';
		$user=$this->session->userdata('US_CODIGO');    
              /*if (!empty($numero)){
                  $datos->econdicion .=" AND APO_SECUENCIAL=$numero";              
			  }*/
              $datos->campoId = "ROWNUM";
			  	 $datos->camposelect = array("ROWNUM",
										"APO_SECUENCIAL",
										"APO_FECHAINGRESO",
										"(SELECT CONCAT(CONCAT(CONCAT(CONCAT((CASE (SELECT COUNT(ASP_NOMBRE) FROM ASPIRANTE WHERE ASP_SECUENCIAL=MATR_SEC_ASPIRANTE)
										WHEN 0 THEN 'SIN ASIGNACION'
										ELSE
										(SELECT ASP_NOMBRE FROM ASPIRANTE WHERE ASP_SECUENCIAL=MATR_SEC_ASPIRANTE)
										END),'-'),
										(SELECT MAT_NOMBRE FROM MATERIA WHERE MAT_SECUENCIAL=MATR_SEC_MATERIA)),'-'),
										(SELECT CONCAT(CONCAT(CONCAT(JOR_NOMBRE,'('),JOR_PARALELO),')') JOR_DESCRIPCION FROM JORNADA 
										WHERE JOR_SECUENCIAL=MATR_SEC_JORNADA)) ASP_MAT_JOR
										FROM MATRICULA WHERE MATR_SECUENCIAL=APO_SEC_MATRICULA) APO_SEC_MATRICULA",
										"(SELECT CONCAT(CONCAT(PER_NOMBRES,' '),PER_APELLIDOS) FROM PERSONA WHERE PER_SECUENCIAL=APO_SEC_PERSONA)
										 APO_SEC_PERSONA",
										"APO_NOTA1",
										"APO_NOTA2",
										"APO_NOTA3",
										"APO_NOTA4",
										"(apo_nota1+apo_nota2+apo_nota3+apo_nota4) TOTAL",
										"to_char(APO_FECHALIMITE, 'DD-MM-YYY HH24:MI:SS')APO_FECHALIMITE",
										"APO_RESPONSABLE_CREA",
										"APO_RESPONSABLE_EDITA",
										"APO_ESTADO"		   
										);
			  	 $datos->campos = array( "ROWNUM",
										"APO_SECUENCIAL",
										"APO_FECHAINGRESO",
										"APO_SEC_MATRICULA",
										"APO_SEC_PERSONA",
										"APO_NOTA1",
										"APO_NOTA2",
										"APO_NOTA3",
										"APO_NOTA4",
										"TOTAL",
										"APO_FECHALIMITE",
										"APO_RESPONSABLE_CREA",
										"APO_RESPONSABLE_EDITA",
										"APO_ESTADO"
				  						);
			  $datos->tabla="APORTES";
              $datos->debug = false;	
           return $this->jqtabla->finalizarTabla($this->jqtabla->getTabla($datos), $datos);
   }
   //Datos que seran enviados para la edicion o visualizacion de cada registro seleccionado
   function dataAporte($numero){
       			$sql="select
							APO_SECUENCIAL,
							APO_FECHAINGRESO,
							APO_SEC_MATRICULA,
							APO_SEC_PERSONA,
							APO_NOTA1,
							APO_NOTA2,
							APO_NOTA3,
							APO_NOTA4,
							to_char(APO_FECHALIMITE, 'DD-MM-YYY HH24:MI:SS')APO_FECHALIMITE,
							APO_RESPONSABLE_CREA,
							APO_RESPONSABLE_EDITA,
							APO_ESTADO
          FROM APORTES WHERE APO_SECUENCIAL=$numero";
         $sol=$this->db->query($sql)->row();
         if ( count($sol)==0){
                $sql="select
							APO_SECUENCIAL,
							APO_FECHAINGRESO,
							APO_SEC_MATRICULA,
							APO_SEC_PERSONA,
							APO_NOTA1,
							APO_NOTA2,
							APO_NOTA3,
							APO_NOTA4,
							APO_FECHALIMITE,
							APO_RESPONSABLE_CREA,
							APO_RESPONSABLE_EDITA,
							APO_ESTADO
                          FROM APORTE WHERE APO_SECUENCIAL=$numero";
                         $sol=$this->db->query($sql)->row();
						}
          return $sol;
		}
	//funcion para crear un nuevo reporte o cabecera
    function agrAporte(){
			$sql="select to_char(SYSDATE,'MM/DD/YYYY HH24:MI:SS') FECHA from dual";		
			$conn = $this->db->conn_id;
			$stmt = oci_parse($conn,$sql);
			oci_execute($stmt);
			$nsol=oci_fetch_row($stmt);
			oci_free_statement($stmt);            
            $APO_FECHAINGRESO="TO_DATE('".$nsol[0]."','MM/DD/YYYY HH24:MI:SS')";
			//VARIABLES DE INGRESO			
			$APO_SEC_MATRICULA=$this->input->post('matricula');			
			$APO_SEC_PERSONA=$this->input->post('persona');			
			$APO_NOTA1=$this->input->post('APO_NOTA1');			
			$APO_NOTA2=$this->input->post('APO_NOTA2');			
			$APO_NOTA3=$this->input->post('APO_NOTA3');			
			$APO_NOTA4=$this->input->post('APO_NOTA4');			
			$FECHALIMITE=prepCampoAlmacenar($this->input->post('APO_FECHALIMITE'));	
			$APO_FECHALIMITE="TO_DATE('".$FECHALIMITE."','DD/MM/YYYY HH24:MI:SS')";		
			$APO_RESPONSABLE_CREA=$this->session->userdata('US_CODIGO');
			$APO_RESPONSABLE_EDITA=$this->session->userdata('US_CODIGO');

			$sqlAPORTEVALIDA="select count(*) NUM_APORTE from APORTES WHERE APO_SEC_PERSONA='{$APO_SEC_PERSONA}' 
										and APO_SEC_MATRICULA='{$APO_SEC_MATRICULA}' 
										and APO_ESTADO=0";
			$NUM_APORTE=$this->db->query($sqlAPORTEVALIDA)->row()->NUM_APORTE;
			if($NUM_APORTE==0){
					$sql="INSERT INTO APORTES (
						APO_FECHAINGRESO,
						APO_SEC_MATRICULA,
						APO_SEC_PERSONA,
						APO_NOTA1,
						APO_NOTA2,
						APO_NOTA3,
						APO_NOTA4,
						APO_FECHALIMITE,
						APO_RESPONSABLE_CREA,
						APO_RESPONSABLE_EDITA,
						APO_ESTADO) VALUES (
						$APO_FECHAINGRESO,
						$APO_SEC_MATRICULA,
						$APO_SEC_PERSONA,
						$APO_NOTA1,
						$APO_NOTA2,
						$APO_NOTA3,
						$APO_NOTA4,
						$APO_FECHALIMITE,
						'$APO_RESPONSABLE_CREA',
						'$APO_RESPONSABLE_EDITA',
							0)";
				$this->db->query($sql);
				//print_r($sql);
				$APO_SECUENCIAL=$this->db->query("select max(APO_SECUENCIAL) SECUENCIAL from APORTES")->row()->SECUENCIAL;
				echo json_encode(array("cod"=>$APO_SECUENCIAL,"numero"=>$APO_SECUENCIAL,"mensaje"=>"Aporte:".$APO_SECUENCIAL.", insertado con éxito"));    
			}else{
				echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...El aporte Ya Existe...!!!"));
			}
    }
	//funcion para editar un registro selccionado
    function editAporte(){
			$APO_SECUENCIAL=$this->input->post('APO_SECUENCIAL');
			//VARIABLES DE INGRESO
			$APO_SEC_MATRICULA=$this->input->post('matricula');			
			$APO_SEC_PERSONA=$this->input->post('persona');			
			$APO_NOTA1=$this->input->post('APO_NOTA1');			
			$APO_NOTA2=$this->input->post('APO_NOTA2');			
			$APO_NOTA3=$this->input->post('APO_NOTA3');			
			$APO_NOTA4=$this->input->post('APO_NOTA4');			
			$FECHALIMITE=prepCampoAlmacenar($this->input->post('APO_FECHALIMITE'));	
			$APO_FECHALIMITE="TO_DATE('".$FECHALIMITE."','DD/MM/YYYY HH24:MI:SS')";
			$APO_RESPONSABLE_EDITA=$this->session->userdata('US_CODIGO');				
			
			$sqlREPETICION1="select APO_SECUENCIAL,APO_SEC_MATRICULA 
							from aportes
							where APO_SECUENCIAL='{$APO_SECUENCIAL}'
							and apo_estado=0";
			$repe1 =$this->db->query($sqlREPETICION1)->row();
			
			$sqlREPETICION2="select APO_SECUENCIAL,APO_SEC_MATRICULA 
							from aportes
							where APO_SEC_MATRICULA='{$APO_SEC_MATRICULA}'
							and apo_estado=0";
			$repe2 =$this->db->query($sqlREPETICION2)->row();

			$sqlREPETICION="select count(*) NUM_REPETICION
							from aportes
							where APO_SEC_MATRICULA='{$APO_SEC_MATRICULA}'
							and apo_estado=0";
			$NUM_REPETICION =$this->db->query($sqlREPETICION)->row()->NUM_REPETICION;
			
		if(($repe1->APO_SECUENCIAL==$repe2->APO_SECUENCIAL) or ($NUM_REPETICION==0)){
			
				$sql="UPDATE APORTES SET
							APO_SEC_MATRICULA=$APO_SEC_MATRICULA,
							APO_SEC_PERSONA=$APO_SEC_PERSONA,
							APO_NOTA1=$APO_NOTA1,
							APO_NOTA2=$APO_NOTA2,
							APO_NOTA3=$APO_NOTA3,
							APO_NOTA4=$APO_NOTA4,
							APO_FECHALIMITE=$APO_FECHALIMITE,
							APO_RESPONSABLE_EDITA='$APO_RESPONSABLE_EDITA'
                 WHERE APO_SECUENCIAL=$APO_SECUENCIAL";
         $this->db->query($sql);
		 //print_r($sql);
		 $APO_SECUENCIAL=$this->db->query("select max(APO_SECUENCIAL) SECUENCIAL from APORTES")->row()->SECUENCIAL;
		 echo json_encode(array("cod"=>1,"numero"=>$APO_SECUENCIAL,"mensaje"=>"Aporte: ".$APO_SECUENCIAL.", editado con éxito"));
	}else{     
		echo json_encode(array("cod"=>1,"numero"=>1,"mensaje"=>"!!!...El aporte Ya Existe...!!!"));
	}
}

}
?>